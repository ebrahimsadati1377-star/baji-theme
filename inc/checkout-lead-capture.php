<?php
/**
 * BAJI pre-order checkout capture. Does not collect payment card data.
 * Sends only a session marker, billing phone and first name to BAJI's server.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function bajistyle_checkout_lead_enqueue() {
    if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() || is_wc_endpoint_url( 'order-pay' ) ) { return; }
    wp_enqueue_script(
        'bajistyle-checkout-lead',
        BAJISTYLE_URI . '/assets/js/checkout-lead-capture.js',
        array(),
        BAJISTYLE_VERSION,
        true
    );
    wp_add_inline_script(
        'bajistyle-checkout-lead',
        'window.bajiCheckoutLead=' . wp_json_encode( array(
            'endpoint' => 'https://manage.bajistyle.ir/webhooks/checkout-lead.php',
        ) ) . ';',
        'before'
    );
}
add_action( 'wp_enqueue_scripts', 'bajistyle_checkout_lead_enqueue', 30 );
