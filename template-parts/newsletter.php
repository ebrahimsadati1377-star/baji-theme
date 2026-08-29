<?php
/**
 * تمپلیت‌پارت بخش خبرنامه - Minimal Modern Style
 *
 * فرم عضویت در خبرنامه که با AJAX (از طریق main.js) ارسال می‌شود.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="baji-newsletter py-10 md:py-12 bg-white border-t border-gray-100" aria-label="<?php esc_attr_e( 'عضویت در خبرنامه', 'bajistyle' ); ?>">
	<div class="max-w-[1280px] mx-auto px-5 md:px-10">
		<div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-8 md:gap-12">

			<!-- متن سمت چپ -->
			<div class="text-center md:text-right flex-1">
				<h2 class="text-xl md:text-2xl font-light tracking-tight text-baji-black mb-2">
					<?php esc_html_e( 'در تماس بمانید', 'bajistyle' ); ?>
				</h2>
				<p class="text-sm text-gray-500 font-light leading-7 max-w-md mx-auto md:mx-0">
					<?php esc_html_e( 'جدیدترین مجموعه‌ها، تخفیف‌های اختصاصی و اخبار را اولین‌ها باشید که می‌شنوید.', 'bajistyle' ); ?>
				</p>
			</div>

			<!-- فرم سمت راست -->
			<div class="w-full md:w-[380px] flex-shrink-0">
				<form id="baji-newsletter-form" class="baji-newsletter-form flex flex-col sm:flex-row items-stretch gap-2" novalidate>
					<?php wp_nonce_field( 'bajistyle_general_nonce', 'baji_newsletter_nonce' ); ?>
					<label for="baji-newsletter-email" class="sr-only">
						<?php esc_html_e( 'آدرس ایمیل شما', 'bajistyle' ); ?>
					</label>
					<input type="email" id="baji-newsletter-email" name="newsletter_email" required
						class="flex-1 border border-gray-200 focus:border-baji-gold focus:ring-2 focus:ring-baji-gold/20 px-4 py-3.5 text-sm bg-white text-gray-900 placeholder-gray-400 transition-all duration-200 rounded-lg"
						placeholder="<?php echo esc_attr_x( 'آدرس ایمیل', 'placeholder', 'bajistyle' ); ?>" />
					<button type="submit"
						class="baji-btn-primary px-7 py-3.5 bg-baji-black text-white text-xs font-medium tracking-[0.15em] uppercase hover:bg-baji-gold hover:text-baji-black hover:-translate-y-0.5 transition-all duration-300 whitespace-nowrap rounded-lg flex items-center justify-center gap-2">
						<?php esc_html_e( 'عضویت', 'bajistyle' ); ?>
						<i class="far fa-arrow-left text-xs"></i>
					</button>
				</form>

				<p class="baji-newsletter-message text-xs mt-3 text-center hidden" role="status" aria-live="polite"></p>

				<!-- متن حریم خصوصی -->
				<p class="text-[11px] text-gray-400 text-center mt-4 font-light">
					<?php echo wp_kses_post( sprintf( __( '<a href="%s" class="underline hover:text-baji-gold transition-colors">حریم خصوصی</a> | <a href="%s" class="underline hover:text-baji-gold transition-colors">لغو اشتراک</a>', 'bajistyle' ), home_url( '/privacy-policy' ), home_url( '/unsubscribe' ) ) ); ?>
				</p>
			</div>

		</div>
	</div>
</section>