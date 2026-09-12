<?php
/**
 * تمپلیت‌پارت بخش هیرو صفحه اصلی (اسلایدر استاندارد Swiper)
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'BAJISTYLE_HERO_MOBILE_BREAKPOINT' ) ) {
	define( 'BAJISTYLE_HERO_MOBILE_BREAKPOINT', '767px' );
}

$slider_query = new WP_Query(
	array(
		'post_type'      => 'baji_slider',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

$has_slides = $slider_query->have_posts();
?>

<!-- استایل اختصاصی برای تضمین نسبت ابعاد دقیق تصویر بدون نیاز به کامپایلر CSS -->
<style>
	.baji-hero-frame {
		aspect-ratio: 1672 / 941;
	}
	@media (min-width: 768px) {
		.baji-hero-frame {
			aspect-ratio: 3488 / 921;
		}
	}
</style>

<section class="baji-hero relative w-full max-w-[1400px] mx-auto my-4 " aria-label="<?php esc_attr_e( 'بخش معرفی اصلی', 'bajistyle' ); ?>">
	<?php if ( $has_slides ) : ?>

		<!-- کانتینر اصلی اسلایدر با نسبت ابعاد متناظر عکس‌ها -->
		<div class="swiper baji-hero-swiper baji-hero-frame w-full rounded-2xl overflow-hidden  relative" dir="rtl">
            
            <div class="swiper-wrapper">
                <?php
                $slide_index = 0;
                while ( $slider_query->have_posts() ) :
                    $slider_query->the_post();

                    $slide_id        = get_the_ID();
                    $button_text     = get_post_meta( $slide_id, '_bajistyle_button_text', true );
                    $button_url      = get_post_meta( $slide_id, '_bajistyle_button_url', true );
                    $mobile_image_id = get_post_meta( $slide_id, '_bajistyle_mobile_image_id', true );
                    $overlay_opacity = get_post_meta( $slide_id, '_bajistyle_overlay_opacity', true );
                    $text_position   = get_post_meta( $slide_id, '_bajistyle_text_position', true );
                    $text_theme      = get_post_meta( $slide_id, '_bajistyle_text_theme', true );

                    $overlay_opacity = ( '' === $overlay_opacity ) ? '30' : $overlay_opacity;
                    $text_position   = $text_position ? $text_position : 'center';
                    $text_theme      = $text_theme ? $text_theme : 'light';

                    $position_classes = bajistyle_hero_position_classes( $text_position );
                    $theme_classes    = bajistyle_hero_theme_classes( $text_theme );

                    $desktop_image_url = has_post_thumbnail( $slide_id ) ? get_the_post_thumbnail_url( $slide_id, 'full' ) : '';
                    $mobile_image_url  = $mobile_image_id ? wp_get_attachment_image_url( $mobile_image_id, 'full' ) : '';

                    if ( 0 === $slide_index ) {
                        $desktop_image_url = 'https://bajistyle.ir/wp-content/uploads/2026/09/baji-installment-slider-reference-face.png?v=2766';
                        $mobile_image_url  = $desktop_image_url;
                        $overlay_opacity   = '0';
                        $button_text       = '';
                        $button_url        = '';
                    }
                    ?>
                    
                    <!-- اسلاید -->
                    <div class="swiper-slide relative w-full h-full overflow-hidden">
                        <?php if ( $desktop_image_url ) : ?>
                            <picture class="absolute inset-0 block w-full h-full">
                                <?php if ( $mobile_image_url ) : ?>
                                    <source media="(max-width: <?php echo esc_attr( BAJISTYLE_HERO_MOBILE_BREAKPOINT ); ?>)" srcset="<?php echo esc_url( $mobile_image_url ); ?>" />
                                <?php endif; ?>
                                <img src="<?php echo esc_url( $desktop_image_url ); ?>"
                                    alt="<?php echo esc_attr( get_the_title( $slide_id ) ); ?>"
                                    class="w-full h-full <?php echo 0 === $slide_index ? 'object-fill' : 'object-cover'; ?> object-center"
                                    loading="<?php echo 0 === $slide_index ? 'eager' : 'lazy'; ?>" />
                            </picture>
                        <?php endif; ?>

                        <!-- لایه تاریک‌کننده روی عکس (Overlay) -->
                        <?php if ( absint( $overlay_opacity ) > 0 ) : ?>
                            <div class="absolute inset-0 bg-black" style="<?php echo esc_attr( bajistyle_hero_overlay_style( $overlay_opacity ) ); ?>"></div>
                        <?php endif; ?>

                        <!-- محتوای متنی -->
                        <div class="relative z-20 h-full flex flex-col justify-center px-6 md:px-16 pointer-events-none <?php echo esc_attr( $position_classes . ' ' . $theme_classes['text'] ); ?>">
                            

                            
                            <?php if ( get_the_excerpt( $slide_id ) ) : ?>
                                <p class="text-xs md:text-sm opacity-90 mb-4 max-w-2xl drop-shadow pointer-events-auto">
                                    <?php echo esc_html( get_the_excerpt( $slide_id ) ); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ( $button_text && $button_url ) : ?>
                                <div class="pointer-events-auto">
                                    <a href="<?php echo esc_url( $button_url ); ?>"
                                        class="baji-btn-primary inline-block px-5 py-2 md:px-6 md:py-2.5 rounded-xl font-bold text-xs md:text-sm transition-all duration-300 transform hover:scale-105 <?php echo esc_attr( $theme_classes['button'] ); ?>">
                                        <?php echo esc_html( $button_text ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    ++$slide_index;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

                        <!-- دکمه‌های فلش چپ و راست -->
            <!-- دکمه‌های فلش چپ و راست با پس‌زمینه دایره‌ای شفاف -->
<!-- دکمه‌های فلش چپ و راست (دایره سفید نیمه‌شفاف + آیکون سفید) -->
<?php if ( $slide_index > 1 ) : ?>
    <button class="baji-hero-next absolute left-3 md:left-5 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/40 text-white backdrop-blur-md rounded-full shadow-lg z-30 transition-all duration-300 cursor-pointer  hover:scale-110" style="color: #ffffff "  aria-label="اسلاید بعدی">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
    </button>
    <button class="baji-hero-prev absolute right-3 md:right-5 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/40 text-white backdrop-blur-md rounded-full shadow-lg z-30 transition-all duration-300 cursor-pointer hover:scale-110" style="color: #ffffff "  aria-label="اسلاید قبلی">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 drop-shadow-md" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
     </button>
<?php endif; ?>

            <!-- نقطه‌های پایین اسلایدر -->
            <div class="swiper-pagination baji-hero-pagination !bottom-3 z-30"></div>
		</div>

	<?php else : ?>
        <!-- در صورت عدم وجود اسلاید -->
	<?php endif; ?>
</section>