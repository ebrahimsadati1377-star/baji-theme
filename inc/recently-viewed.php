<?php
/**
 * سیستم «آخرین محصولات بازدید شده» قالب BajiStyle
 *
 * شناسه محصولات بازدیدشده توسط هر کاربر در یک کوکی سبک ذخیره می‌شود
 * تا بدون بار اضافه بر پایگاه داده، تجربه شخصی‌سازی‌شده ارائه شود.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ثبت محصول فعلی در لیست بازدیدهای اخیر هنگام بازدید از صفحه تکی محصول.
 *
 * @since 1.0.0
 */
function bajistyle_track_recently_viewed() {
	if ( ! is_singular( 'product' ) ) {
		return;
	}

	global $post;
	$product_id = $post->ID;

	$viewed = array();
	if ( isset( $_COOKIE['bajistyle_recently_viewed'] ) ) {
		$raw    = sanitize_text_field( wp_unslash( $_COOKIE['bajistyle_recently_viewed'] ) );
		$viewed = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
	}

	// حذف محصول فعلی در صورت تکرار، سپس افزودن آن به ابتدای لیست.
	$viewed = array_diff( $viewed, array( $product_id ) );
	array_unshift( $viewed, $product_id );

	// محدودسازی به حداکثر ۱۲ محصول اخیر.
	$viewed = array_slice( $viewed, 0, 12 );

	setcookie(
		'bajistyle_recently_viewed',
		implode( ',', $viewed ),
		time() + ( 30 * DAY_IN_SECONDS ),
		COOKIEPATH ? COOKIEPATH : '/',
		COOKIE_DOMAIN,
		is_ssl(),
		true
	);
}
add_action( 'template_redirect', 'bajistyle_track_recently_viewed' );

/**
 * دریافت شناسه محصولات بازدیدشده اخیر، به استثنای محصول فعلی.
 *
 * @param int $exclude_id شناسه محصولی که باید از لیست حذف شود.
 * @param int $limit      حداکثر تعداد نتایج.
 * @return int[] آرایه‌ای از شناسه محصولات.
 * @since 1.0.0
 */
function bajistyle_get_recently_viewed_products( $exclude_id = 0, $limit = 4 ) {
	if ( ! isset( $_COOKIE['bajistyle_recently_viewed'] ) ) {
		return array();
	}

	$raw    = sanitize_text_field( wp_unslash( $_COOKIE['bajistyle_recently_viewed'] ) );
	$viewed = array_filter( array_map( 'absint', explode( ',', $raw ) ) );

	if ( $exclude_id ) {
		$viewed = array_diff( $viewed, array( absint( $exclude_id ) ) );
	}

	return array_slice( array_values( $viewed ), 0, absint( $limit ) );
}
