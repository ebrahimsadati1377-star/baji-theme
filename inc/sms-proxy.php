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


function baji_sms_proxy_find_message_id( $value ) {
    if ( is_array( $value ) ) {
        foreach ( array( 'message_id', 'messageId', 'id' ) as $key ) {
            if ( isset( $value[ $key ] ) && is_numeric( $value[ $key ] ) ) {
                return (int) $value[ $key ];
            }
        }
        foreach ( $value as $item ) {
            $found = baji_sms_proxy_find_message_id( $item );
            if ( $found > 0 ) {
                return $found;
            }
        }
    }
    return 0;
}

function baji_sms_proxy_legacy_message_status( $message_id ) {
    $message_id = (int) $message_id;
    if ( $message_id <= 0 ) {
        return new WP_Error( 'baji_sms_message_id', 'Invalid message id.', array( 'status' => 400 ) );
    }

    $api_key = trim( (string) get_option( 'custom_otp_apikey', '' ) );
    $url = 'https://api2.ippanel.com/api/v1/sms/message/all?message_id=' . rawurlencode( (string) $message_id );

    $response = wp_remote_get(
        $url,
        array(
            'timeout'     => 20,
            'redirection' => 0,
            'headers'     => array(
                'Apikey' => $api_key,
                'Accept' => 'application/json',
            ),
        )
    );

    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'baji_sms_report_transport', 'SMS report transport error.', array( 'status' => 502 ) );
    }

    $status = (int) wp_remote_retrieve_response_code( $response );
    $json   = json_decode( (string) wp_remote_retrieve_body( $response ), true );

    if ( $status < 200 || $status >= 300 || ! is_array( $json ) ) {
        return new WP_Error( 'baji_sms_report_provider', 'SMS report provider error.', array( 'status' => 502, 'provider_http' => $status ) );
    }

    $rows = array();
    if ( isset( $json['data'] ) && is_array( $json['data'] ) ) {
        $rows = $json['data'];
    }

    $row = ! empty( $rows ) && is_array( $rows[0] ) ? $rows[0] : array();
    if ( empty( $row ) ) {
        return array(
            'message_id'       => $message_id,
            'final_status'     => 'report_pending',
            'confirmed_sent'   => false,
            'delivery_confirmed' => false,
            'provider_http'    => $status,
        );
    }

    $valid          = (string) ( $row['valid'] ?? '' );
    $exit_count     = (int) ( $row['exit_count'] ?? 0 );
    $delivery_state = $row['delivery_state'] ?? null;

    if ( 'reject' === $valid ) {
        $final_status = 'rejected';
    } elseif ( 'notconfirm' === $valid ) {
        $final_status = 'pending_approval';
    } elseif ( 'approve' === $valid && $exit_count <= 0 ) {
        $final_status = 'approved_pending_dispatch';
    } elseif ( 'approve' === $valid && $exit_count > 0 ) {
        $final_status = 'sent_to_operator';
    } else {
        $final_status = 'pending';
    }

    return array(
        'message_id'         => $message_id,
        'final_status'       => $final_status,
        'confirmed_sent'     => ( 'approve' === $valid && $exit_count > 0 ),
        'delivery_confirmed' => null !== $delivery_state && '' !== (string) $delivery_state,
        'valid'              => $valid,
        'exit_count'         => $exit_count,
        'delivery_state'     => $delivery_state,
        'cost'               => isset( $row['cost'] ) ? (float) $row['cost'] : null,
        'last_change'        => (string) ( $row['last_change_delivery'] ?? '' ),
        'provider_http'      => $status,
    );
}

function baji_sms_proxy_message_status( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $data       = $request->get_json_params();
    $message_id = (int) ( $data['message_id'] ?? 0 );
    $report     = baji_sms_proxy_legacy_message_status( $message_id );

    if ( is_wp_error( $report ) ) {
        return $report;
    }

    return rest_ensure_response(
        array(
            'success' => true,
            'route'   => 'wordpress-relay-report',
            'report'  => $report,
        )
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

    $provider_response = $provider['response'];
    $message_id        = baji_sms_proxy_find_message_id( $provider_response );
    $report            = $message_id > 0 ? baji_sms_proxy_legacy_message_status( $message_id ) : null;

    if ( is_wp_error( $report ) ) {
        $report = null;
    }

    return rest_ensure_response(
        array(
            'success'          => true,
            'accepted'         => true,
            'provider'         => 'ippanel',
            'route'            => 'wordpress-relay',
            'provider_http'    => $provider['provider_http'],
            'message_id'       => $message_id > 0 ? $message_id : null,
            'final_status'     => is_array( $report ) ? ( $report['final_status'] ?? 'accepted_pending_report' ) : 'accepted_pending_report',
            'confirmed_sent'   => is_array( $report ) ? (bool) ( $report['confirmed_sent'] ?? false ) : false,
            'delivery_confirmed' => is_array( $report ) ? (bool) ( $report['delivery_confirmed'] ?? false ) : false,
            'report'           => $report,
            'response'         => $provider_response,
        )
    );
}







function baji_sms_proxy_send_legacy( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $data      = $request->get_json_params();
    $recipient = trim( (string) ( $data['recipient'] ?? '' ) );
    $message   = trim( (string) ( $data['message'] ?? '' ) );

    $digits = preg_replace( '/\D+/', '', $recipient );
    if ( 12 === strlen( $digits ) && 0 === strpos( $digits, '98' ) ) {
        $digits = '0' . substr( $digits, 2 );
    } elseif ( 10 === strlen( $digits ) && 0 === strpos( $digits, '9' ) ) {
        $digits = '0' . $digits;
    }
    if ( ! preg_match( '/^09\d{9}$/', $digits ) ) {
        return new WP_Error( 'baji_sms_mobile', 'Invalid Iranian mobile number.', array( 'status' => 400 ) );
    }
    if ( '' === $message ) {
        return new WP_Error( 'baji_sms_message', 'Invalid SMS message.', array( 'status' => 400 ) );
    }

    $api_key = trim( (string) get_option( 'custom_otp_apikey', '' ) );
    $sender  = trim( (string) get_option( 'custom_otp_sender', '' ) );

    $response = wp_remote_post(
        'https://api2.ippanel.com/api/v1/sms/send/webservice/single',
        array(
            'timeout'     => 20,
            'redirection' => 0,
            'headers'     => array(
                'Apikey'       => $api_key,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ),
            'body'        => wp_json_encode(
                array(
                    'sender'      => $sender,
                    'recipient'   => array( $digits ),
                    'message'     => $message,
                    'description' => array(
                        'summary'         => 'BAJI legacy route test',
                        'count_recipient' => '1',
                    ),
                ),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            ),
        )
    );

    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'baji_sms_legacy_transport', 'Legacy provider transport error.', array( 'status' => 502 ) );
    }

    $status = (int) wp_remote_retrieve_response_code( $response );
    $json   = json_decode( (string) wp_remote_retrieve_body( $response ), true );

    return rest_ensure_response(
        array(
            'success'       => $status >= 200 && $status < 300,
            'route'         => 'wordpress-legacy-api2',
            'provider_http' => $status,
            'response'      => is_array( $json ) ? $json : array(),
        )
    );
}

function baji_sms_proxy_send_peer( WP_REST_Request $request ) {
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
            'sending_type' => 'peer_to_peer',
            'from_number'  => $sender,
            'params'       => array(
                array(
                    'recipients' => array( $recipient ),
                    'message'    => $message,
                ),
            ),
        )
    );

    if ( is_wp_error( $provider ) ) {
        return $provider;
    }

    $provider_response = $provider['response'];
    $message_id        = baji_sms_proxy_find_message_id( $provider_response );

    return rest_ensure_response(
        array(
            'success'       => true,
            'accepted'      => true,
            'provider'      => 'ippanel',
            'route'         => 'wordpress-relay-peer-to-peer',
            'provider_http' => $provider['provider_http'],
            'message_id'    => $message_id > 0 ? $message_id : null,
            'response'      => $provider_response,
        )
    );
}

function baji_sms_proxy_send_pattern( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $data      = $request->get_json_params();
    $recipient = baji_sms_proxy_normalize_mobile( isset( $data['recipient'] ) ? $data['recipient'] : '' );
    if ( is_wp_error( $recipient ) ) {
        return $recipient;
    }

    $code   = trim( (string) ( $data['code'] ?? '' ) );
    $params = isset( $data['params'] ) && is_array( $data['params'] ) ? $data['params'] : array();

    if ( '' === $code ) {
        return new WP_Error( 'baji_sms_pattern_code', 'Pattern code is required.', array( 'status' => 400 ) );
    }

    $sender = trim( (string) get_option( 'custom_otp_sender', '' ) );
    if ( '' === $sender ) {
        return new WP_Error( 'baji_sms_sender', 'SMS sender is not configured.', array( 'status' => 503 ) );
    }

    $provider = baji_sms_proxy_provider_request(
        'POST',
        '/api/send',
        array(
            'sending_type' => 'pattern',
            'from_number'  => $sender,
            'code'         => $code,
            'recipients'   => array( $recipient ),
            'params'       => $params,
        )
    );

    if ( is_wp_error( $provider ) ) {
        return $provider;
    }

    $provider_response = $provider['response'];
    $message_id        = baji_sms_proxy_find_message_id( $provider_response );
    $report            = $message_id > 0 ? baji_sms_proxy_legacy_message_status( $message_id ) : null;

    if ( is_wp_error( $report ) ) {
        $report = null;
    }

    return rest_ensure_response(
        array(
            'success'            => true,
            'accepted'           => true,
            'provider'           => 'ippanel',
            'route'              => 'wordpress-relay-pattern',
            'provider_http'      => $provider['provider_http'],
            'message_id'         => $message_id > 0 ? $message_id : null,
            'final_status'       => is_array( $report ) ? ( $report['final_status'] ?? 'accepted_pending_report' ) : 'accepted_pending_report',
            'confirmed_sent'     => is_array( $report ) ? (bool) ( $report['confirmed_sent'] ?? false ) : false,
            'delivery_confirmed' => is_array( $report ) ? (bool) ( $report['delivery_confirmed'] ?? false ) : false,
            'report'             => $report,
            'response'           => $provider_response,
        )
    );
}

function baji_sms_proxy_create_pattern( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $data        = $request->get_json_params();
    $title       = trim( (string) ( $data['title'] ?? '' ) );
    $description = trim( (string) ( $data['description'] ?? '' ) );
    $message     = trim( (string) ( $data['message'] ?? '' ) );
    $website     = trim( (string) ( $data['website'] ?? 'https://bajistyle.ir' ) );
    $variables   = isset( $data['variable'] ) && is_array( $data['variable'] ) ? $data['variable'] : array();

    if ( '' === $description || '' === $message ) {
        return new WP_Error( 'baji_sms_pattern_fields', 'Pattern description and message are required.', array( 'status' => 400 ) );
    }

    $payload = array(
        'title'       => $title,
        'description' => $description,
        'is_share'    => false,
        'message'     => $message,
        'website'     => $website,
        'variable'    => $variables,
    );

    $provider = baji_sms_proxy_provider_request( 'POST', '/api/patterns/normal', $payload );
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

function baji_sms_proxy_patterns( WP_REST_Request $request ) {
    $auth = baji_sms_proxy_authenticate( $request );
    if ( is_wp_error( $auth ) ) {
        return $auth;
    }

    $provider = baji_sms_proxy_provider_request( 'GET', '/api/patterns?page=1&per_page=100' );
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
        $api_key = trim( (string) get_option( 'custom_otp_apikey', '' ) );
        $legacy  = wp_remote_get(
            'https://api2.ippanel.com/api/v1/sms/message/all?page=1&per_page=' . $limit,
            array(
                'timeout'     => 20,
                'redirection' => 0,
                'headers'     => array(
                    'Apikey' => $api_key,
                    'Accept' => 'application/json',
                ),
            )
        );

        if ( is_wp_error( $legacy ) ) {
            return $provider;
        }

        $legacy_status = (int) wp_remote_retrieve_response_code( $legacy );
        $legacy_body   = json_decode( (string) wp_remote_retrieve_body( $legacy ), true );

        if ( $legacy_status >= 200 && $legacy_status < 300 && is_array( $legacy_body ) ) {
            return rest_ensure_response(
                array(
                    'success'       => true,
                    'route'         => 'wordpress-relay-legacy-report',
                    'provider_http' => $legacy_status,
                    'response'      => $legacy_body,
                )
            );
        }

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
            '/sms-proxy/message-status',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_message_status',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/send-legacy',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_send_legacy',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/send-peer',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_send_peer',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/send-pattern',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_send_pattern',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/create-pattern',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_create_pattern',
                'permission_callback' => '__return_true',
            )
        );
        register_rest_route(
            'baji/v1',
            '/sms-proxy/patterns',
            array(
                'methods'             => 'POST',
                'callback'            => 'baji_sms_proxy_patterns',
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
