<?php
/**
 * تمپلیت‌پارت بخش هیرو صفحه اصلی (اسلایدر استاندارد Swiper)
 * @package BajiStyle
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! defined( 'BAJISTYLE_HERO_MOBILE_BREAKPOINT' ) ) { define( 'BAJISTYLE_HERO_MOBILE_BREAKPOINT', '767px' ); }
$slider_query = new WP_Query(array('post_type'=>'baji_slider','posts_per_page'=>6,'orderby'=>'menu_order','order'=>'ASC'));
$has_slides = $slider_query->have_posts();
$autumn_banner_url = 'https://bajistyle.ir/wp-content/uploads/2026/09/baji-autumn-slider-standing.png';
?>
<style>
.baji-hero-frame{aspect-ratio:2/1;touch-action:pan-y}
@media(min-width:768px){.baji-hero-frame{aspect-ratio:3488/921}}
</style>
<section class="baji-hero relative w-full max-w-[1400px] mx-auto my-4" aria-label="<?php esc_attr_e('بخش معرفی اصلی','bajistyle'); ?>">
<?php if($has_slides): ?>
<div class="swiper baji-hero-swiper baji-hero-frame w-full rounded-2xl overflow-hidden relative" dir="rtl">
<div class="swiper-wrapper">
<?php
$slide_index=0;
$render_autumn_slide=function() use ($autumn_banner_url){ ?>
<div class="swiper-slide relative w-full h-full overflow-hidden baji-autumn-added-slide"><picture class="absolute inset-0 block w-full h-full"><img src="<?php echo esc_url($autumn_banner_url); ?>" alt="استایل پاییزی با باجی و خرید اقساطی" class="w-full h-full object-fill object-center" loading="lazy" /></picture></div>
<?php };
while($slider_query->have_posts()):
 $slider_query->the_post();
 if(3===$slide_index){$render_autumn_slide();}
 $slide_id=get_the_ID();
 $button_text=get_post_meta($slide_id,'_bajistyle_button_text',true);
 $button_url=get_post_meta($slide_id,'_bajistyle_button_url',true);
 $mobile_image_id=get_post_meta($slide_id,'_bajistyle_mobile_image_id',true);
 $overlay_opacity=get_post_meta($slide_id,'_bajistyle_overlay_opacity',true);
 $text_position=get_post_meta($slide_id,'_bajistyle_text_position',true);
 $text_theme=get_post_meta($slide_id,'_bajistyle_text_theme',true);
 $overlay_opacity=(''===$overlay_opacity)?'30':$overlay_opacity;
 $text_position=$text_position?$text_position:'center';
 $text_theme=$text_theme?$text_theme:'light';
 $position_classes=bajistyle_hero_position_classes($text_position);
 $theme_classes=bajistyle_hero_theme_classes($text_theme);
 $desktop_image_url=has_post_thumbnail($slide_id)?get_the_post_thumbnail_url($slide_id,'full'):'';
 $mobile_image_url=$mobile_image_id?wp_get_attachment_image_url($mobile_image_id,'full'):'';
 if(0===$slide_index){$desktop_image_url='https://bajistyle.ir/wp-content/uploads/2026/09/baji-installment-slider-reference-face.png?v=2766';$mobile_image_url=$desktop_image_url;$overlay_opacity='0';$button_text='';$button_url='';}
?>
<div class="swiper-slide relative w-full h-full overflow-hidden">
<?php if($desktop_image_url): ?><picture class="absolute inset-0 block w-full h-full"><?php if($mobile_image_url): ?><source media="(max-width: <?php echo esc_attr(BAJISTYLE_HERO_MOBILE_BREAKPOINT); ?>)" srcset="<?php echo esc_url($mobile_image_url); ?>" /><?php endif; ?><img src="<?php echo esc_url($desktop_image_url); ?>" alt="<?php echo esc_attr(get_the_title($slide_id)); ?>" class="w-full h-full <?php echo 0===$slide_index?'object-fill':'object-cover'; ?> object-center" loading="<?php echo 0===$slide_index?'eager':'lazy'; ?>" /></picture><?php endif; ?>
<?php if(absint($overlay_opacity)>0): ?><div class="absolute inset-0 bg-black" style="<?php echo esc_attr(bajistyle_hero_overlay_style($overlay_opacity)); ?>"></div><?php endif; ?>
<div class="relative z-20 h-full flex flex-col justify-center px-6 md:px-16 pointer-events-none <?php echo esc_attr($position_classes.' '.$theme_classes['text']); ?>"><?php if(get_the_excerpt($slide_id)): ?><p class="text-xs md:text-sm opacity-90 mb-4 max-w-2xl drop-shadow pointer-events-auto"><?php echo esc_html(get_the_excerpt($slide_id)); ?></p><?php endif; ?><?php if($button_text&&$button_url): ?><div class="pointer-events-auto"><a href="<?php echo esc_url($button_url); ?>" class="baji-btn-primary inline-block px-5 py-2 md:px-6 md:py-2.5 rounded-xl font-bold text-xs md:text-sm transition-all duration-300 transform hover:scale-105 <?php echo esc_attr($theme_classes['button']); ?>"><?php echo esc_html($button_text); ?></a></div><?php endif; ?></div>
</div>
<?php ++$slide_index; endwhile; if($slide_index<=3){$render_autumn_slide();} wp_reset_postdata(); $total_slides=$slide_index+1; ?>
</div>
<div class="swiper-pagination baji-hero-pagination !bottom-3 z-30"></div>
</div>
<?php endif; ?>
</section>