<?php
/**
 * فایل سایدبار قالب BajiStyle
 *
 * این سایدبار فقط در صفحات وبلاگ (آرشیو نوشته‌ها و تک‌نوشته‌ها)
 * نمایش داده می‌شود. صفحات فروشگاه ووکامرس از سیستم فیلتر اختصاصی
 * خود در archive-product.php استفاده می‌کنند و این فایل را فراخوانی نمی‌کنند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// اگر هیچ ابزارکی در سایدبار وبلاگ فعال نباشد، چیزی نمایش داده نمی‌شود.
if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
	return;
}
?>

<aside id="secondary" class="baji-sidebar w-full lg:w-80 shrink-0" role="complementary" aria-label="<?php esc_attr_e( 'سایدبار', 'bajistyle' ); ?>">
	<div class="baji-sidebar-inner space-y-10 lg:sticky lg:top-32">
		<?php dynamic_sidebar( 'sidebar-blog' ); ?>
	</div>
</aside>
