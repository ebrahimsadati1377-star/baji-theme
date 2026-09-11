<?php
/**
 * Product category showcase.
 *
 * @package BajiStyle
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'WooCommerce' ) ) return;

$categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true,
    'parent' => 0,
    'number' => 8,
    'exclude' => array(get_option('default_product_cat', 0)),
));
if ( is_wp_error($categories) || empty($categories) ) return;
?>
<section class="baji-category-showcase" style="padding-top:15px">
<div class="max-w-[1400px] mx-auto px-4 md:px-8">
<div class="swiper baji-category-slider"><div class="swiper-wrapper">
<?php foreach ($categories as $category) :
$thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
$image_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'full') : '';
$category_link = get_term_link($category); ?>
<div class="swiper-slide"><a href="<?php echo esc_url($category_link); ?>" class="block group baji-category-card">
<div class="baji-category-thumb"><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>" loading="lazy"></div>
<div class="text-center"><h3 class="text-base md:text-lg font-medium text-gray-800 group-hover:text-baji-gold transition-colors duration-300"><?php echo esc_html($category->name); ?></h3><div class="w-8 h-[2px] bg-gray-200 mx-auto mt-2 group-hover:bg-baji-gold transition-colors duration-300"></div></div>
</a></div>
<?php endforeach; ?>
</div></div></div></section>
<style id="baji-category-uniform-size">
.baji-category-slider .swiper-slide{height:auto!important}.baji-category-card{width:100%!important}.baji-category-thumb{position:relative!important;width:100%!important;aspect-ratio:1/1!important;height:auto!important;overflow:hidden!important;border-radius:1rem!important;box-shadow:0 1px 3px rgba(0,0,0,.08)!important}.baji-category-thumb img{position:absolute!important;inset:0!important;width:100%!important;height:100%!important;min-width:100%!important;min-height:100%!important;max-width:none!important;object-fit:cover!important;object-position:center!important;display:block!important;margin:0!important;padding:0!important;border-radius:0!important}.baji-category-card h3{margin-top:8px!important}
</style>
<script>
document.addEventListener('DOMContentLoaded',function(){new Swiper('.baji-category-slider',{slidesPerView:3,spaceBetween:20,breakpoints:{768:{slidesPerView:3},1024:{slidesPerView:4}}});});
</script>