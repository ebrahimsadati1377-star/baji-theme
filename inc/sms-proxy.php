<?php
/**
 * Secure BAJI SMS relay.
 *
 * The relay is used only as a network fallback when the management server
 * cannot reach IPPanel directly. No credential is stored in the theme:
 * the existing WordPress IPPanel option is used as both provider credential
 * and HMAC secret. Requests are timestamped and single-use.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function baji_sms_proxy_authenticate( WP_REST_Request $request ) {
    $api_key = trim( (string) get_option( 'custom_otp_apikey', '' ) );
    if ( '' === $api_key ) {
        return new WP_Error( 'baji_sms_not_configured', 'SMS provider is not configured.', array( 'status' => 503 ) );
    }

    $timestamp = (string) $request->get_header( 'x-baji-timestamp' );
    $nonce     = strtolower( trim( (string) $request->get_header( 'x-baji-nonce' ) ) );
    $signature = strtolower( trim( (string) $request->get_header( 'x-baji-signature' ) ) );

    if ( ! ctype_digit( $timestamp ) || abs( time() - (int) $timestamp ) > 180 ) {
        return new WP_Error( 'baji_sms_auth_time', 'Expired request.', array( 'status' => 401 ) );
    }
    if ( ! preg_match( '/^[a-f0-9]{32}$/', $nonce ) || ! preg_match( '/^[a-f0-9]{64}$/', $signature ) ) {
        return new WP_Error( 'baji_sms_auth_header', 'Invalid authentication headers.', array( 'status' => 401 ) );
    }

    $raw      = (string) $request->get_body();
    $expected = hash_hmac( 'sha256', $timestamp . "\n" . $nonce . "\n" . $raw, $api_key );
    if ( ! hash_equals( $expected, $signature ) ) {
        return new WP_Error( 'baji_sms_auth_signature', 'Invalid signature.', array( 'status' => 401 ) );
    }

    $nonce_key = 'baji_sms_nonce_' . hash( 'sha256', $nonce );
    if ( false !== get_transient( $nonce_key ) ) {
        return new WP_Error( 'baji_sms_replay', 'Duplicate request.', array( 'status' => 409 ) );
    }
    set_transient( $nonce_key, '1', 10 * MINUTE_IN_SECONDS );

    return true;
}

function baji_sms_proxy_normalize_mobile( $mobile ) {
    $mobile = preg_replace( '/\D+/', '', trim( (string) $mobile ) );

    if ( 0 === strpos( $mobile, '0098' ) ) {
        $mobile = substr( $mobile, 2 );
    } elseif ( 11 === strlen( $mobile ) && 0 === strpos( $mobile, '09' ) ) {
        $mobile = '98' . substr( $mobile, 1 );
    } elseif ( 10 === strlen( $mobile ) && 0 === strpos( $mobile, '9' ) ) {
        $mobile = '98' . $mobile;
    }

    if ( ! preg_match( '/^989\d{9}$/', $mobile ) ) {
        return new WP_Error( 'baji_sms_mobile', 'Invalid Iranian mobile number.', array( 'status' => 400 ) );
    }

    return '+' . $mobile;
}

function baji_sms_proxy_provider_request( $method, $path, $payload = null ) {
    $api_key = trim( (string) get_option( 'custom_otp_apikey', '' ) );
    $url     = 'https://edge.ippanel.com/v1' . $path;
    $args    = array(
        'method'      => $method,
        'timeout'     => 20,
        'redirection' => 0,
        'headers'     => array(
            'Authorization' => $api_key,
            'Accept'        => 'application/json',
        ),
    );

    if ( null !== $payload ) {
        $args['headers']['Content-Type'] = 'application/json';
        $args['body']                    = wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    }

    $response = wp_remote_request( $url, $args );
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'baji_sms_transport', 'Provider transport error.', array( 'status' => 502 ) );
    }

    $status = (int) wp_remote_retrieve_response_code( $response );
    $body   = (string) wp_remote_retrieve_body( $response );
    $json   = json_decode( $body, true );

    if ( $status < 200 || $status >= 300 ) {
        $message = is_array( $json ) ? (string) ( $json['message'] ?? $json['error'] ?? 'Provider error' ) : 'Provider error';
        return new WP_Error(
            'baji_sms_provider',
            $message,
            array(
                'status'        => 502,
                'provider_http' => $status,
            )
        );
    }

    return array(
        'success'       => true,
        'provider_http' => $status,
        'response'      => is_array( $json ) ? $json : array(),
    );
}

function baji_sms_proxy_status( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $provider = baji_sms_proxy_provider_request( 'GET', '/api/send/banks/provinces' );
    if ( is_wp_error( $provider ) ) {
        return $provider;
    }

    return rest_ensure_response(
        array(
            'success'       => true,
            'route'         => 'wordpress-relay',
            'provider_http' => $provider['provider_http'],
        )
    );
}

function baji_sms_proxy_send( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $data      = $request->get_json_params();
    $recipient = baji_sms_proxy_normalize_mobile( isset( $data['recipient'] ) ? $data['recipient'] : '' );
    if ( is_wp_error( $recipient ) ) {
        return $recipient;
    }

    $message = trim( (string) ( $data['message'] ?? '' ) );
    if ( '' === $message || mb_strlen( $message ) > 1000 ) {
        return new WP_Error( 'baji_sms_message', 'Invalid SMS message.', array( 'status' => 400 ) );
    }

    $sender = trim( (string) get_option( 'custom_otp_sender', '' ) );
    if ( '' === $sender ) {
        return new WP_Error( 'baji_sms_sender', 'SMS sender is not configured.', array( 'status' => 503 ) );
    }

    $provider = baji_sms_proxy_provider_request(
        'POST',
        '/api/send',
        array(
            'sending_type' => 'webservice',
            'from_number'  => $sender,
            'message'      => $message,
            'params'       => array(
                'recipients' => array( $recipient ),
            ),
        )
    );
    if ( is_wp_error( $provider ) ) {
        return $provider;
    }

    return rest_ensure_response(
        array(
            'success'       => true,
            'provider'      => 'ippanel',
            'route'         => 'wordpress-relay',
            'provider_http' => $provider['provider_http'],
            'response'      => $provider['response'],
        )
    );
}


function baji_sms_proxy_report( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $data    = $request->get_json_params();
    $message = trim( (string) ( $data['message'] ?? '' ) );
    $limit   = max( 1, min( 20, (int) ( $data['limit'] ?? 10 ) ) );

    $filters = array();
    if ( '' !== $message ) {
        $filters['message'] = $message;
    }

    $provider = baji_sms_proxy_provider_request(
        'POST',
        '/api/report/new_list',
        array(
            'page'    => 1,
            'limit'   => $limit,
            'filters' => $filters,
        )
    );

    if ( is_wp_error( $provider ) ) {
        return $provider;
    }

    return rest_ensure_response(
        array(
            'success'       => true,
            'route'         => 'wordpress-relay',
            'provider_http' => $provider['provider_http'],
            'response'      => $provider['response'],
        )
    );
}

add_action(
    'rest_api_init',
    function () {
        register_rest_route(
            'baji/v1',
            '/sms-proxy/status',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_status',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/send',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_send',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/report',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_report',
                'permission_callback' => '__return_true',
            )
        );
    }
);
