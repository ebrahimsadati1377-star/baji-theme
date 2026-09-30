<?php
/**
 * Restrict BAJI's one-use birthday coupons to the customer's registered
 * mobile number. Manager stores _baji_birthday_phone on each Woo coupon.
 */
defined( 'ABSPATH' ) || exit;

function baji_birthday_coupon_phone( $input ) {
    $number = baji_birthday_ascii( (string) $input );
    $number = preg_replace( '/[\s().-]+/', '', $number );
    if ( str_starts_with( $number, '+98' ) ) $number = '0' . substr( $number, 3 );
    elseif ( str_starts_with( $number, '0098' ) ) $number = '0' . substr( $number, 4 );
    elseif ( str_starts_with( $number, '98' ) && strlen( $number ) === 12 ) $number = '0' . substr( $number, 2 );
    elseif ( strlen( $number ) === 10 && str_starts_with( $number, '9' ) ) $number = '0' . $number;
    return preg_match( '/^09\d{9}$/D', $number ) ? $number : '';
}

function baji_birthday_coupon_current_phone() {
    // The actual checkout field takes priority over cached account/customer
    // values, preventing someone from changing the shipping/billing mobile
    // after applying another person's coupon.
    if ( isset( $_POST['post_data'] ) && ! is_array( $_POST['post_data'] ) ) {
        parse_str( wp_unslash( $_POST['post_data'] ), $fields );
        if ( isset( $fields['billing_phone'] ) && ! is_array( $fields['billing_phone'] ) ) {
            return baji_birthday_coupon_phone( sanitize_text_field( $fields['billing_phone'] ) );
        }
    }
    if ( isset( $_POST['billing_phone'] ) && ! is_array( $_POST['billing_phone'] ) ) {
        return baji_birthday_coupon_phone( sanitize_text_field( wp_unslash( $_POST['billing_phone'] ) ) );
    }
    if ( function_exists( 'WC' ) && WC() && WC()->customer ) {
        $phone = WC()->customer->get_billing_phone();
        if ( $phone !== '' ) return baji_birthday_coupon_phone( $phone );
    }
    if ( is_user_logged_in() ) {
        return baji_birthday_coupon_phone( get_user_meta( get_current_user_id(), 'billing_phone', true ) );
    }
    return '';
}

add_filter( 'woocommerce_coupon_is_valid', function( $valid, $coupon ) {
    if ( ! $valid || ! $coupon instanceof WC_Coupon ) return $valid;
    $owner_phone = baji_birthday_coupon_phone( $coupon->get_meta( '_baji_birthday_phone', true ) );
    if ( $owner_phone === '' ) return $valid;
    $submitted_phone = baji_birthday_coupon_current_phone();
    // AJAX coupon application may precede checkout-address submission;
    // final checkout validation below always enforces the exact phone.
    return $submitted_phone === '' || hash_equals( $owner_phone, $submitted_phone );
}, 25, 2 );

add_filter( 'woocommerce_coupon_error', function( $error, $code, $coupon ) {
    if ( ! defined( 'WC_Coupon::E_WC_COUPON_INVALID_FILTERED' ) || $code !== WC_Coupon::E_WC_COUPON_INVALID_FILTERED || ! $coupon instanceof WC_Coupon ) return $error;
    $owner_phone = baji_birthday_coupon_phone( $coupon->get_meta( '_baji_birthday_phone', true ) );
    if ( $owner_phone !== '' && baji_birthday_coupon_current_phone() !== '' && ! hash_equals( $owner_phone, baji_birthday_coupon_current_phone() ) ) {
        return 'کد هدیه تولد فقط با شماره موبایلی که برای آن صادر شده قابل استفاده است. شماره صورتحساب را بررسی کنید.';
    }
    return $error;
}, 25, 3 );

add_action( 'woocommerce_after_checkout_validation', function( $data, $errors ) {
    if ( ! function_exists( 'WC' ) || ! WC() || ! WC()->cart ) return;
    $checkout_phone = baji_birthday_coupon_phone( $data['billing_phone'] ?? '' );
    foreach ( WC()->cart->get_applied_coupons() as $code ) {
        $coupon = new WC_Coupon( $code );
        $owner_phone = baji_birthday_coupon_phone( $coupon->get_meta( '_baji_birthday_phone', true ) );
        if ( $owner_phone !== '' && ! hash_equals( $owner_phone, $checkout_phone ) ) {
            $errors->add( 'baji_birthday_coupon_phone_mismatch',
                'کد هدیه تولد با شماره موبایل صورتحساب این سفارش مطابقت ندارد.' );
            break;
        }
    }
}, 25, 2 );
