<?php
/**
 * تنظیمات امنیتی تکمیلی قالب BajiStyle
 *
 * این فایل تنظیمات امنیتی پایه‌ای که در سطح قالب قابل اعمال هستند را
 * فراهم می‌کند. توجه: این موارد جایگزین افزونه‌های امنیتی یا تنظیمات
 * سطح سرور نیستند و صرفاً مکمل امنیت در محدوده قالب محسوب می‌شوند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * غیرفعال‌سازی ویرایشگر فایل تم/افزونه از داخل پنل مدیریت.
 * (در صورت نیاز، این مقدار را می‌توان در wp-config.php نیز تنظیم کرد.)
 *
 * @since 1.0.0
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * حذف اطلاعات حساس نسخه از منابع استایل و اسکریپت برای کاهش سطح حمله.
 * (تابع bajistyle_remove_version_query_string در functions.php این کار را انجام می‌دهد.)
 */

/**
 * اعتبارسنجی و پاک‌سازی ورودی فرم جستجوی سفارشی قالب.
 *
 * @param string $query عبارت جستجو.
 * @return string عبارت پاک‌سازی‌شده.
 * @since 1.0.0
 */
function bajistyle_sanitize_search_query( $query ) {
	return sanitize_text_field( wp_unslash( $query ) );
}

/**
 * افزودن هدرهای امنیتی پایه برای پاسخ‌های HTTP قالب.
 * (پیشنهاد می‌شود تنظیمات کامل‌تر در سطح وب‌سرور یا CDN انجام شود.)
 *
 * @since 1.0.0
 */
function bajistyle_security_headers() {
	if ( ! is_admin() && ! headers_sent() ) {
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}
}
add_action( 'send_headers', 'bajistyle_security_headers' );

/**
 * غیرفعال‌سازی XML-RPC در صورت عدم نیاز (کاهش سطح حمله Brute Force).
 * در صورت استفاده از اپلیکیشن موبایل یا سرویس‌هایی که به XML-RPC نیاز دارند،
 * این فیلتر را غیرفعال کنید.
 *
 * @return bool
 * @since 1.0.0
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * جلوگیری از نمایش خطاهای لاگین دقیق (برای جلوگیری از User Enumeration).
 *
 * @return string پیام خطای عمومی.
 * @since 1.0.0
 */
function bajistyle_generic_login_error() {
	return __( 'نام کاربری یا رمز عبور نادرست است.', 'bajistyle' );
}
add_filter( 'login_errors', 'bajistyle_generic_login_error' );

/**
 * اطمینان از escape شدن خروجی ویجت‌های جستجو با nonce در فرم‌های AJAX.
 * این تابع یک نمونه nonce عمومی برای فرم‌های جاوااسکریپتی قالب فراهم می‌کند.
 *
 * @return string مقدار nonce.
 * @since 1.0.0
 */
function bajistyle_get_general_nonce() {
	return wp_create_nonce( 'bajistyle_general_nonce' );
}
