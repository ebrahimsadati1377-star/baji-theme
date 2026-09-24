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


/**
 * Authenticated live visitor report for BAJI.
 * Reads WP Statistics online visitor data for managers only.
 */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'baji/v1',
			'/online-visitors',
			array(
				'methods'             => 'GET',
				'permission_callback' => function () {
					return current_user_can( 'manage_woocommerce' ) || current_user_can( 'manage_options' );
				},
				'callback'            => function () {
					if ( ! class_exists( '\\WP_Statistics\\Models\\OnlineModel' ) ) {
						return new WP_Error( 'wp_statistics_unavailable', 'WP Statistics online model is unavailable.', array( 'status' => 503 ) );
					}

					$online_model = new \WP_Statistics\Models\OnlineModel();
					$rows         = $online_model->getOnlineVisitors(
						array(
							'page'     => 1,
							'per_page' => 20,
							'order_by' => 'last_view',
							'order'    => 'DESC',
							'decorate' => true,
						)
					);

					$visitors_model = class_exists( '\\WP_Statistics\\Models\\VisitorsModel' )
						? new \WP_Statistics\Models\VisitorsModel()
						: null;
					$out = array();

					foreach ( $rows as $visitor ) {
						$referral = method_exists( $visitor, 'getReferral' ) ? $visitor->getReferral() : null;
						$location = method_exists( $visitor, 'getLocation' ) ? $visitor->getLocation() : null;
						$browser  = method_exists( $visitor, 'getBrowser' ) ? $visitor->getBrowser() : null;
						$os       = method_exists( $visitor, 'getOs' ) ? $visitor->getOs() : null;
						$device   = method_exists( $visitor, 'getDevice' ) ? $visitor->getDevice() : null;
						$id       = method_exists( $visitor, 'getId' ) ? (int) $visitor->getId() : 0;
						$journey  = array();

						if ( $visitors_model && $id > 0 && method_exists( $visitors_model, 'getVisitorJourney' ) ) {
							$raw_journey = $visitors_model->getVisitorJourney( array( 'visitor_id' => $id ) );
							$raw_journey = is_array( $raw_journey ) ? array_slice( $raw_journey, -12 ) : array();

							foreach ( $raw_journey as $step ) {
								$page_id = isset( $step->page_id ) ? (int) $step->page_id : 0;
								$page    = null;
								if ( $page_id && class_exists( '\\WP_STATISTICS\\Visitor' ) && method_exists( '\\WP_STATISTICS\\Visitor', 'get_page_by_id' ) ) {
									$page = \WP_STATISTICS\Visitor::get_page_by_id( $page_id );
								}
								$journey[] = array(
									'date' => isset( $step->date ) ? $step->date : null,
									'page' => $page,
								);
							}
						}

						$out[] = array(
							'id'             => $id,
							'first_view'     => method_exists( $visitor, 'getFirstView' ) ? $visitor->getFirstView( true ) : null,
							'last_view'      => method_exists( $visitor, 'getLastView' ) ? $visitor->getLastView( true ) : null,
							'hits'           => method_exists( $visitor, 'getHits' ) ? $visitor->getHits( true ) : null,
							'first_page'     => method_exists( $visitor, 'getFirstPage' ) ? $visitor->getFirstPage() : null,
							'last_page'      => method_exists( $visitor, 'getLastPage' ) ? $visitor->getLastPage() : null,
							'referrer'       => $referral && method_exists( $referral, 'getRawReferrer' ) ? $referral->getRawReferrer() : null,
							'source_channel' => $referral && method_exists( $referral, 'getSourceChannel' ) ? $referral->getSourceChannel() : null,
							'source_name'    => $referral && method_exists( $referral, 'getSourceName' ) ? $referral->getSourceName() : null,
							'country'        => $location && method_exists( $location, 'getCountryName' ) ? $location->getCountryName() : null,
							'country_code'   => $location && method_exists( $location, 'getCountryCode' ) ? $location->getCountryCode() : null,
							'region'         => $location && method_exists( $location, 'getRegion' ) ? $location->getRegion() : null,
							'city'           => $location && method_exists( $location, 'getCity' ) ? $location->getCity() : null,
							'browser'        => $browser && method_exists( $browser, 'getName' ) ? $browser->getName() : null,
							'browser_ver'    => $browser && method_exists( $browser, 'getVersion' ) ? $browser->getVersion() : null,
							'os'             => $os && method_exists( $os, 'getName' ) ? $os->getName() : null,
							'device'         => $device && method_exists( $device, 'getType' ) ? $device->getType() : null,
							'device_model'   => $device && method_exists( $device, 'getModel' ) ? $device->getModel() : null,
							'journey'        => $journey,
						);
					}

					return rest_ensure_response(
						array(
							'generated_at' => current_time( 'mysql' ),
							'total'        => count( $out ),
							'visitors'     => $out,
						)
					);
				},
			)
		);
	}
);


/**
 * Authenticated daily traffic-source summary for BAJI managers.
 */
add_action(
    'rest_api_init',
    function () {
        register_rest_route(
            'baji/v1',
            '/traffic-sources',
            array(
                'methods'             => 'GET',
                'permission_callback' => function () {
                    return current_user_can( 'manage_woocommerce' ) || current_user_can( 'manage_options' );
                },
                'callback'            => function () {
                    if ( ! class_exists( '\\WP_Statistics\\Models\\VisitorsModel' ) ) {
                        return new WP_Error( 'wp_statistics_unavailable', 'WP Statistics visitors model is unavailable.', array( 'status' => 503 ) );
                    }

                    $today = current_time( 'Y-m-d' );
                    $model = new \WP_Statistics\Models\VisitorsModel();
                    $rows  = $model->getVisitorsData(
                        array(
                            'date'     => array( 'from' => $today, 'to' => $today ),
                            'page'     => 1,
                            'per_page' => 5000,
                            'order_by' => 'visitor.last_view',
                            'order'    => 'DESC',
                            'decorate' => true,
                        )
                    );

                    $groups  = array();
                    $details = array();
                    foreach ( $rows as $visitor ) {
                        $referral       = method_exists( $visitor, 'getReferral' ) ? $visitor->getReferral() : null;
                        $raw_referrer   = $referral && method_exists( $referral, 'getRawReferrer' ) ? (string) $referral->getRawReferrer() : '';
                        $source_channel = $referral && method_exists( $referral, 'getSourceChannel' ) ? (string) $referral->getSourceChannel() : '';
                        $source_name    = $referral && method_exists( $referral, 'getSourceName' ) ? (string) $referral->getSourceName() : '';
                        $first_page     = method_exists( $visitor, 'getFirstPage' ) ? $visitor->getFirstPage() : array();
                        $query          = is_array( $first_page ) ? (string) ( $first_page['query'] ?? '' ) : '';
                        $params         = array();
                        parse_str( html_entity_decode( $query, ENT_QUOTES | ENT_HTML5, 'UTF-8' ), $params );
                        $utm_source = strtolower( trim( (string) ( $params['utm_source'] ?? '' ) ) );
                        $utm_medium = strtolower( trim( (string) ( $params['utm_medium'] ?? '' ) ) );
                        $haystack   = strtolower( implode( ' ', array( $utm_source, $utm_medium, $raw_referrer, $source_name ) ) );

                        if ( false !== strpos( $haystack, 'torobpay' ) ) {
                            $label = 'ترب‌پی';
                        } elseif ( false !== strpos( $haystack, 'torob' ) ) {
                            $label = 'ترب';
                        } elseif ( false !== strpos( $haystack, 'bazaar' ) ) {
                            $label = 'بازار';
                        } elseif ( false !== strpos( $haystack, 'instagram' ) ) {
                            $label = 'اینستاگرام';
                        } elseif ( false !== strpos( $haystack, 'snapp' ) ) {
                            $label = 'اسنپ';
                        } elseif ( false !== strpos( $haystack, 'digipay' ) || false !== strpos( $haystack, 'digikala' ) ) {
                            $label = 'دیجی‌پی / دیجی‌کالا';
                        } elseif ( false !== strpos( $haystack, 'telegram' ) || false !== strpos( $haystack, 't.me' ) ) {
                            $label = 'تلگرام';
                        } elseif ( false !== strpos( $haystack, 'ble.ir' ) || false !== strpos( $haystack, 'bale' ) ) {
                            $label = 'بله';
                        } elseif ( false !== strpos( $haystack, 'rubika' ) ) {
                            $label = 'روبیکا';
                        } elseif ( false !== strpos( $haystack, 'google' ) ) {
                            $label = 'گوگل';
                        } elseif ( 'search' === $source_channel || 'paid_search' === $source_channel ) {
                            $label = $source_name !== '' ? $source_name : 'موتور جستجو';
                        } elseif ( 'social' === $source_channel || 'paid_social' === $source_channel ) {
                            $label = $source_name !== '' ? $source_name : 'شبکه اجتماعی';
                        } elseif ( 'direct' === $source_channel || ( '' === $raw_referrer && '' === $utm_source && '' === $source_name ) ) {
                            $label = 'مستقیم';
                        } elseif ( '' !== $source_name ) {
                            $label = $source_name;
                        } elseif ( '' !== $raw_referrer ) {
                            $label = $raw_referrer;
                        } else {
                            $label = 'نامشخص';
                        }

                        if ( ! isset( $groups[ $label ] ) ) {
                            $groups[ $label ] = 0;
                        }
                        $groups[ $label ]++;
                        $details[] = array(
                            'id'             => method_exists( $visitor, 'getId' ) ? (int) $visitor->getId() : 0,
                            'source'         => $label,
                            'utm_source'     => $utm_source ?: null,
                            'utm_medium'     => $utm_medium ?: null,
                            'referrer'       => $raw_referrer ?: null,
                            'source_channel' => $source_channel ?: null,
                            'source_name'    => $source_name ?: null,
                            'first_page'     => is_array( $first_page ) ? ( $first_page['title'] ?? null ) : null,
                            'last_view'      => method_exists( $visitor, 'getLastView' ) ? $visitor->getLastView( true ) : null,
                        );
                    }
                    arsort( $groups );

                    return rest_ensure_response(
                        array(
                            'generated_at'   => current_time( 'mysql' ),
                            'date'           => $today,
                            'visitors_total' => count( $rows ),
                            'sources'        => $groups,
                            'visitors'       => $details,
                        )
                    );
                },
            )
        );
    }
);
