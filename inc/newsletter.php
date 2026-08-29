<?php
/**
 * پردازش عضویت در خبرنامه قالب BajiStyle
 *
 * این فایل یک endpoint AJAX پایه برای ذخیره ایمیل مشترکین خبرنامه
 * در دیتابیس وردپرس (به‌عنوان Option) فراهم می‌کند. برای اتصال به
 * سرویس‌های حرفه‌ای ایمیل مارکتینگ (Mailchimp و مشابه آن)، می‌توان
 * این تابع را گسترش داد یا با یک افزونه اختصاصی جایگزین کرد.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * پردازش درخواست AJAX عضویت در خبرنامه.
 *
 * @since 1.0.0
 */
function bajistyle_newsletter_subscribe_ajax() {
	check_ajax_referer( 'bajistyle_general_nonce', 'nonce' );

	if ( ! isset( $_POST['email'] ) ) {
		wp_send_json_error( array( 'message' => __( 'لطفاً آدرس ایمیل خود را وارد کنید.', 'bajistyle' ) ) );
	}

	$email = sanitize_email( wp_unslash( $_POST['email'] ) );

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'آدرس ایمیل واردشده معتبر نیست.', 'bajistyle' ) ) );
	}

	$subscribers = get_option( 'bajistyle_newsletter_subscribers', array() );

	if ( ! is_array( $subscribers ) ) {
		$subscribers = array();
	}

	if ( in_array( $email, $subscribers, true ) ) {
		wp_send_json_success( array( 'message' => __( 'شما قبلاً در خبرنامه عضو شده‌اید.', 'bajistyle' ) ) );
	}

	$subscribers[] = $email;
	update_option( 'bajistyle_newsletter_subscribers', $subscribers, false );

	/**
	 * هوک پس از عضویت موفق در خبرنامه؛ برای اتصال به سرویس‌های
	 * شخص ثالث ایمیل مارکتینگ از طریق افزونه‌های اضافی قابل استفاده است.
	 *
	 * @param string $email ایمیل عضوشده.
	 */
	do_action( 'bajistyle_newsletter_subscribed', $email );

	wp_send_json_success( array( 'message' => __( 'با موفقیت در خبرنامه عضو شدید. سپاسگزاریم!', 'bajistyle' ) ) );
}
add_action( 'wp_ajax_bajistyle_newsletter_subscribe', 'bajistyle_newsletter_subscribe_ajax' );
add_action( 'wp_ajax_nopriv_bajistyle_newsletter_subscribe', 'bajistyle_newsletter_subscribe_ajax' );
