<?php
/**
 * تمپلیت‌پارت نمایش پیام «محتوایی یافت نشد»
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="baji-no-content text-center py-24">
	<h2 class="text-2xl font-light mb-4">
		<?php esc_html_e( 'محتوایی یافت نشد', 'bajistyle' ); ?>
	</h2>

	<?php if ( is_search() ) : ?>
		<p class="text-gray-500 mb-8">
			<?php esc_html_e( 'متأسفانه نتیجه‌ای برای عبارت جستجوی شما پیدا نشد. لطفاً عبارت دیگری را امتحان کنید.', 'bajistyle' ); ?>
		</p>
		<?php get_search_form(); ?>
	<?php else : ?>
		<p class="text-gray-500 mb-8">
			<?php esc_html_e( 'در حال حاضر محتوایی برای نمایش وجود ندارد.', 'bajistyle' ); ?>
		</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="baji-btn-primary inline-block px-8 py-3 bg-baji-black text-baji-white text-sm tracking-widest uppercase hover:bg-baji-gold hover:text-baji-black transition-colors duration-300">
			<?php esc_html_e( 'بازگشت به خانه', 'bajistyle' ); ?>
		</a>
	<?php endif; ?>
</div>
