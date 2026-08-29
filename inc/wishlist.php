<?php
/**
 * سیستم علاقه‌مندی‌ها (Wishlist) قالب BajiStyle
 *
 * پیاده‌سازی wishlist بدون نیاز به افزونه اضافی. برای کاربران مهمان
 * از کوکی و برای کاربران لاگین‌شده از user meta استفاده می‌شود.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * دریافت لیست شناسه محصولات علاقه‌مندی کاربر فعلی.
 *
 * @return int[] آرایه‌ای از شناسه محصولات.
 * @since 1.0.0
 */
function bajistyle_get_wishlist_items() {
	if ( is_user_logged_in() ) {
		$items = get_user_meta( get_current_user_id(), '_bajistyle_wishlist', true );
		return is_array( $items ) ? array_map( 'absint', $items ) : array();
	}

	if ( isset( $_COOKIE['bajistyle_wishlist'] ) ) {
		$raw   = sanitize_text_field( wp_unslash( $_COOKIE['bajistyle_wishlist'] ) );
		$items = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
		return $items;
	}

	return array();
}

/**
 * بررسی می‌کند آیا یک محصول در لیست علاقه‌مندی‌ها وجود دارد یا خیر.
 *
 * @param int $product_id شناسه محصول.
 * @return bool نتیجه بررسی.
 * @since 1.0.0
 */
function bajistyle_is_in_wishlist( $product_id ) {
	$items = bajistyle_get_wishlist_items();
	return in_array( absint( $product_id ), $items, true );
}

/**
 * پردازش درخواست AJAX برای افزودن/حذف محصول از علاقه‌مندی‌ها.
 *
 * @since 1.0.0
 */
function bajistyle_toggle_wishlist_ajax() {
	check_ajax_referer( 'bajistyle_wc_nonce', 'nonce' );

	if ( ! isset( $_POST['product_id'] ) ) {
		wp_send_json_error( array( 'message' => __( 'شناسه محصول ارسال نشده است.', 'bajistyle' ) ) );
	}

	$product_id = absint( $_POST['product_id'] );

	if ( ! $product_id || ! get_post( $product_id ) ) {
		wp_send_json_error( array( 'message' => __( 'محصول معتبر نیست.', 'bajistyle' ) ) );
	}

	$items   = bajistyle_get_wishlist_items();
	$in_list = in_array( $product_id, $items, true );

	if ( $in_list ) {
		$items = array_diff( $items, array( $product_id ) );
		$added = false;
	} else {
		$items[] = $product_id;
		$added   = true;
	}

	$items = array_values( array_unique( array_map( 'absint', $items ) ) );

	if ( is_user_logged_in() ) {
		update_user_meta( get_current_user_id(), '_bajistyle_wishlist', $items );
	} else {
		// کوکی به مدت ۳۰ روز برای کاربران مهمان معتبر است.
		setcookie(
			'bajistyle_wishlist',
			implode( ',', $items ),
			time() + ( 30 * DAY_IN_SECONDS ),
			COOKIEPATH ? COOKIEPATH : '/',
			COOKIE_DOMAIN,
			is_ssl(),
			true
		);
	}

	wp_send_json_success(
		array(
			'added'     => $added,
			'count'     => count( $items ),
			'productId' => $product_id,
		)
	);
}
add_action( 'wp_ajax_bajistyle_toggle_wishlist', 'bajistyle_toggle_wishlist_ajax' );
add_action( 'wp_ajax_nopriv_bajistyle_toggle_wishlist', 'bajistyle_toggle_wishlist_ajax' );

/**
 * شمارش تعداد آیتم‌های علاقه‌مندی برای نمایش در هدر.
 *
 * @return int تعداد آیتم‌ها.
 * @since 1.0.0
 */
function bajistyle_get_wishlist_count() {
	return count( bajistyle_get_wishlist_items() );
}
