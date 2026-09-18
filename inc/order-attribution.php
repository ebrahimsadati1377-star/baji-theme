<?php
/**
 * BAJI first/last touch attribution for WooCommerce orders.
 *
 * Captures UTM parameters and external referrer in a first-party cookie,
 * then writes the attribution snapshot into order meta at checkout.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function baji_attribution_source_label( $raw_source, $referrer = '' ) {
	$raw  = strtolower( trim( (string) $raw_source ) );
	$host = '';

	if ( $referrer ) {
		$host = strtolower( (string) wp_parse_url( $referrer, PHP_URL_HOST ) );
		$host = preg_replace( '/^www\./', '', $host );
	}

	$haystack = $raw . ' ' . $host;

	$map = array(
		'google'      => 'Google',
		'instagram'   => 'Instagram',
		'instagr.am'  => 'Instagram',
		'torob'       => 'Torob',
		'basalam'     => 'Basalam',
		'digikala'    => 'Digikala',
		'chatgpt'     => 'ChatGPT',
		'openai'      => 'ChatGPT',
		'telegram'    => 'Telegram',
		't.me'        => 'Telegram',
		'facebook'    => 'Facebook',
		'fb.com'      => 'Facebook',
		'bing'        => 'Bing',
		'yahoo'       => 'Yahoo',
		'threads'     => 'Threads',
		'pinterest'   => 'Pinterest',
	);

	foreach ( $map as $needle => $label ) {
		if ( false !== strpos( $haystack, $needle ) ) {
			return $label;
		}
	}

	if ( $raw ) {
		return sanitize_text_field( $raw_source );
	}

	if ( $host ) {
		return $host;
	}

	return 'Direct';
}

function baji_attribution_current_url() {
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	return esc_url_raw( home_url( $uri ) );
}

function baji_attribution_read_cookie() {
	if ( empty( $_COOKIE['baji_attribution'] ) ) {
		return array();
	}

	$decoded = rawurldecode( wp_unslash( $_COOKIE['baji_attribution'] ) );
	$data    = json_decode( $decoded, true );

	return is_array( $data ) ? $data : array();
}

function baji_attribution_write_cookie( $data ) {
	$value  = rawurlencode( wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
	$expire = time() + ( 90 * DAY_IN_SECONDS );
	$path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
	$domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';

	setcookie(
		'baji_attribution',
		$value,
		array(
			'expires'  => $expire,
			'path'     => $path,
			'domain'   => $domain,
			'secure'   => is_ssl(),
			'httponly' => true,
			'samesite' => 'Lax',
		)
	);

	$_COOKIE['baji_attribution'] = $value;
}

/**
 * Capture attribution on normal frontend requests.
 */
function baji_capture_attribution() {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$utm_source   = isset( $_GET['utm_source'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_source'] ) ) : '';
	$utm_medium   = isset( $_GET['utm_medium'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_medium'] ) ) : '';
	$utm_campaign = isset( $_GET['utm_campaign'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_campaign'] ) ) : '';
	$utm_content  = isset( $_GET['utm_content'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_content'] ) ) : '';
	$utm_term     = isset( $_GET['utm_term'] ) ? sanitize_text_field( wp_unslash( $_GET['utm_term'] ) ) : '';
	$gclid        = isset( $_GET['gclid'] ) ? sanitize_text_field( wp_unslash( $_GET['gclid'] ) ) : '';
	$referrer     = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';

	$site_host     = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$referrer_host = strtolower( (string) wp_parse_url( $referrer, PHP_URL_HOST ) );
	$is_external   = $referrer_host && $site_host && $referrer_host !== $site_host && substr( $referrer_host, -strlen( '.' . $site_host ) ) !== '.' . $site_host;
	$has_campaign  = (bool) ( $utm_source || $utm_medium || $utm_campaign || $gclid );

	$existing = baji_attribution_read_cookie();

	// Direct internal pageviews must not overwrite an earlier acquisition source.
	if ( $existing && ! $has_campaign && ! $is_external ) {
		return;
	}

	$now = current_time( 'mysql' );

	$touch = array(
		'source'       => baji_attribution_source_label( $utm_source, $is_external ? $referrer : '' ),
		'source_type'  => $has_campaign ? 'campaign' : ( $is_external ? 'referral' : 'direct' ),
		'utm_source'   => $utm_source,
		'utm_medium'   => $utm_medium,
		'utm_campaign' => $utm_campaign,
		'utm_content'  => $utm_content,
		'utm_term'     => $utm_term,
		'gclid'        => $gclid,
		'referrer'     => $is_external ? $referrer : '',
		'landing_page' => baji_attribution_current_url(),
		'seen_at'      => $now,
	);

	if ( empty( $existing['first'] ) ) {
		$existing['first'] = $touch;
	}

	$existing['last'] = $touch;

	baji_attribution_write_cookie( $existing );
}
add_action( 'template_redirect', 'baji_capture_attribution', 1 );

/**
 * Write attribution into a WooCommerce order.
 */
function baji_apply_attribution_to_order( $order ) {
	if ( ! $order || ! is_a( $order, 'WC_Order' ) ) {
		return;
	}

	$data = baji_attribution_read_cookie();

	if ( empty( $data['first'] ) || ! is_array( $data['first'] ) ) {
		return;
	}

	$first = $data['first'];
	$last  = ! empty( $data['last'] ) && is_array( $data['last'] ) ? $data['last'] : $first;

	$fields = array(
		'_baji_source'             => isset( $first['source'] ) ? $first['source'] : 'Direct',
		'_baji_source_type'        => isset( $first['source_type'] ) ? $first['source_type'] : '',
		'_baji_referrer'           => isset( $first['referrer'] ) ? $first['referrer'] : '',
		'_baji_landing_page'       => isset( $first['landing_page'] ) ? $first['landing_page'] : '',
		'_baji_utm_source'         => isset( $first['utm_source'] ) ? $first['utm_source'] : '',
		'_baji_utm_medium'         => isset( $first['utm_medium'] ) ? $first['utm_medium'] : '',
		'_baji_utm_campaign'       => isset( $first['utm_campaign'] ) ? $first['utm_campaign'] : '',
		'_baji_utm_content'        => isset( $first['utm_content'] ) ? $first['utm_content'] : '',
		'_baji_utm_term'           => isset( $first['utm_term'] ) ? $first['utm_term'] : '',
		'_baji_gclid'              => isset( $first['gclid'] ) ? $first['gclid'] : '',
		'_baji_first_seen_at'      => isset( $first['seen_at'] ) ? $first['seen_at'] : '',
		'_baji_last_source'        => isset( $last['source'] ) ? $last['source'] : '',
		'_baji_last_referrer'      => isset( $last['referrer'] ) ? $last['referrer'] : '',
		'_baji_last_landing_page'  => isset( $last['landing_page'] ) ? $last['landing_page'] : '',
		'_baji_last_seen_at'       => isset( $last['seen_at'] ) ? $last['seen_at'] : '',
	);

	foreach ( $fields as $key => $value ) {
		if ( '' !== $value && null !== $value ) {
			$order->update_meta_data( $key, $value );
		}
	}
}
add_action( 'woocommerce_checkout_create_order', 'baji_apply_attribution_to_order', 20, 1 );

// WooCommerce Checkout Blocks / Store API compatibility.
add_action(
	'woocommerce_store_api_checkout_update_order_from_request',
	function ( $order ) {
		baji_apply_attribution_to_order( $order );
	},
	20,
	1
);
