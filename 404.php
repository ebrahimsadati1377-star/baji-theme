<?php
/**
 * فایل صفحه ۴۰۴ (یافت نشد) قالب BajiStyle
 *
 * صفحه‌ای شیک و برندمحور برای زمانی که آدرس درخواستی کاربر یافت
 * نمی‌شود، همراه با فرم جستجو و لینک بازگشت به فروشگاه.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="baji-404-wrapper max-w-2xl mx-auto px-4 md:px-8 py-24 md:py-32 text-center">

	<span class="baji-404-number block text-baji-gold text-7xl md:text-9xl font-light tracking-widest mb-6">
		۴۰۴
	</span>

	<h1 class="text-2xl md:text-3xl font-light mb-4">
		<?php esc_html_e( 'صفحه مورد نظر یافت نشد', 'bajistyle' ); ?>
	</h1>

	<p class="text-gray-500 mb-10 leading-7">
		<?php esc_html_e( 'متأسفانه صفحه‌ای که به دنبال آن بودید وجود ندارد یا جابه‌جا شده است. می‌توانید از طریق جستجو یا لینک‌های زیر، مسیر خود را پیدا کنید.', 'bajistyle' ); ?>
	</p>

	<div class="baji-404-search mb-10 max-w-md mx-auto">
		<?php
		if ( class_exists( 'WooCommerce' ) ) {
			get_product_search_form();
		} else {
			get_search_form();
		}
		?>
	</div>

	<div class="baji-404-actions flex flex-col sm:flex-row items-center justify-center gap-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
			class="baji-btn-primary inline-block px-8 py-3 bg-baji-black text-baji-white text-sm tracking-widest uppercase hover:bg-baji-gold hover:text-baji-black transition-colors duration-300">
			<?php esc_html_e( 'بازگشت به خانه', 'bajistyle' ); ?>
		</a>

		<?php if ( class_exists( 'WooCommerce' ) && wc_get_page_id( 'shop' ) > 0 ) : ?>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"
				class="baji-btn-secondary inline-block px-8 py-3 border border-baji-black text-sm tracking-widest uppercase hover:border-baji-gold hover:text-baji-gold transition-colors duration-300">
				<?php esc_html_e( 'مشاهده فروشگاه', 'bajistyle' ); ?>
			</a>
		<?php endif; ?>
	</div>

</div>

<?php
get_footer();
