<?php
/**
 * Authenticated live visitor report for BAJI.
 *
 * Exposes WP Statistics' online visitors only to authenticated managers.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

						$journey = array();
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
