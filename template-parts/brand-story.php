<?php
/**
 * تمپلیت‌پارت داستان برند
 *
 * بخشی روایی و تصویری درباره برند BajiStyle، با محتوای قابل
 * شخصی‌سازی از طریق Customizer.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$story_title = get_theme_mod( 'bajistyle_brand_story_title', __( 'داستان BajiStyle', 'bajistyle' ) );
$story_text  = get_theme_mod( 'bajistyle_brand_story_text', __( 'BajiStyle با عشق به زیبایی و توجه به جزئیات متولد شد تا لحظات شما را خاص‌تر کند. هر قطعه از مجموعه ما با دقت و وسواس طراحان ما خلق می‌شود؛ ترکیبی از پارچه‌های باکیفیت، دوخت ظریف و الهام از مد روز جهان. ما باور داریم که استایل شخصی هر زن، روایتی از هویت اوست و BajiStyle همراه این روایت است.', 'bajistyle' ) );
$story_image = get_theme_mod( 'bajistyle_brand_story_image', '' );
?>

<section class="baji-brand-story py-10 md:py-10" aria-label="<?php esc_attr_e( 'داستان برند', 'bajistyle' ); ?>">
	<div class="max-w-[1400px] mx-auto px-4 md:px-8">
		<div class="block lg:grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

			<div class="baji-brand-story-image-wrapper order-2 lg:order-1 hidden lg:block">
				<?php if ( $story_image ) : ?>
					<img src="<?php echo esc_url( $story_image ); ?>" alt="<?php echo esc_attr( $story_title ); ?>"
						class="w-full aspect-[4/5] object-cover rounded-lg" loading="lazy" />
				<?php else : ?>
					<div class="w-full aspect-[4/5] bg-baji-cream flex items-center justify-center rounded-lg">
						<span class="text-baji-gold text-sm tracking-widest uppercase"><?php bloginfo( 'name' ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<div class="baji-brand-story-content order-1 lg:order-2 text-center lg:text-right">
				<span class="text-baji-gold text-xs tracking-[0.3em] uppercase">
					<?php esc_html_e( 'درباره برند', 'bajistyle' ); ?>
				</span>
				<h2 class="text-3xl md:text-4xl font-light mt-3 mb-6">
					<?php echo esc_html( $story_title ); ?>
				</h2>
				<p class="text-gray-600 leading-8 mb-8">
					<?php echo esc_html( $story_text ); ?>
				</p>
				<?php
				$about_page = get_page_by_path( 'about' );
				$about_url  = $about_page ? get_permalink( $about_page ) : home_url( '/' );
				?>
				<a href="<?php echo esc_url( $about_url ); ?>"
					class="baji-btn-secondary inline-block px-8 py-3 border border-baji-black text-sm tracking-widest uppercase hover:border-baji-gold hover:text-baji-gold transition-colors duration-300">
					<?php esc_html_e( 'بیشتر بدانید', 'bajistyle' ); ?>
				</a>
			</div>

		</div>
	</div>
</section>