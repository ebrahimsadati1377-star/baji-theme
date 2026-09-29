<?php
/** BAJI: require a mobile for BWDK's independent AJAX checkout path. */
defined( 'ABSPATH' ) || exit;

// BWDK uses its own bwdk_get_cart AJAX flow, outside WooCommerce's form validation.
function baji_guard_bwdk_ajax_mobile() {
    $raw = isset( $_POST['billing_phone'] ) && is_scalar( $_POST['billing_phone'] )
        ? wp_unslash( $_POST['billing_phone'] ) : '';
    $phone = baji_checkout_normalize_mobile( $raw );
    if ( $phone === '' ) {
        wp_send_json_error( array(
            'code' => 'billing_phone_required',
            'message' => 'برای ادامه خرید با دیجی‌کالا، شماره موبایل معتبر را در تسویه‌حساب وارد کنید.',
        ), 400 );
    }
    $_POST['billing_phone'] = $phone;
    if ( function_exists( 'WC' ) && WC()->customer ) {
        WC()->customer->set_billing_phone( $phone );
    }
    if ( function_exists( 'WC' ) && WC()->session ) {
        WC()->session->set( 'baji_bwdk_mobile', $phone );
    }
}
add_action( 'wp_ajax_bwdk_get_cart', 'baji_guard_bwdk_ajax_mobile', -1000 );
add_action( 'wp_ajax_nopriv_bwdk_get_cart', 'baji_guard_bwdk_ajax_mobile', -1000 );

// Persist the validated phone before the quick-checkout order's first or later save.
add_action( 'woocommerce_before_order_object_save', 'baji_bwdk_save_order_mobile', 8, 1 );
function baji_bwdk_save_order_mobile( $order ) {
    if ( ! ( $order instanceof WC_Order ) || $order->get_type() !== 'shop_order'
        || ! wp_doing_ajax() || ( $_REQUEST['action'] ?? '' ) !== 'bwdk_get_cart' ) {
        return;
    }
    $raw = isset( $_POST['billing_phone'] ) && is_scalar( $_POST['billing_phone'] )
        ? wp_unslash( $_POST['billing_phone'] ) : '';
    $phone = baji_checkout_normalize_mobile( $raw );
    if ( $phone !== '' ) {
        $order->set_billing_phone( $phone );
    }
}

// The BWDK client must forward the checkout phone with its AJAX request.
add_action( 'wp_enqueue_scripts', 'baji_enqueue_bwdk_mobile_guard', 100 );
function baji_enqueue_bwdk_mobile_guard() {
    if ( wp_script_is( 'bwdk-front-script', 'registered' ) ) {
        wp_enqueue_script( 'baji-bwdk-mobile-guard',
            BAJISTYLE_URI . '/assets/js/bwdk-mobile-guard.js',
            array( 'bwdk-front-script' ), BAJISTYLE_VERSION, true );
    }
}
