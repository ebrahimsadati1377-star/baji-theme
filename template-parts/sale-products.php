<?php
/** Homepage sale products section. @package BajiStyle */
if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) { return; }
$sale_ids = wc_get_product_ids_on_sale();
if ( empty( $sale_ids ) ) { return; }
$shop_url = wc_get_page_permalink( 'shop' );
$sale_url = add_query_arg( 'orderby', 'price', $shop_url );
?>
<section class="baji-sale-products py-12 md:py-16 bg-white" aria-labelledby="baji-sale-title">
<div class="max-w-[1400px] mx-auto px-4 md:px-8">
<div class="baji-section-head">
<div class="baji-section-head__copy">
<span class="baji-section-head__eyebrow"><?php esc_html_e('پیشنهاد ویژه','bajistyle'); ?></span>
<h2 id="baji-sale-title" class="baji-section-head__title"><?php esc_html_e('تخفیف‌های BAJI','bajistyle'); ?></h2>
</div>
<a href="<?php echo esc_url($shop_url); ?>" class="baji-section-head__link"><span><?php esc_html_e('مشاهده همه','bajistyle'); ?></span><i class="fa-solid fa-arrow-left"></i></a>
</div>
<div class="swiper baji-products-slider overflow-hidden relative pb-12">
<?php get_template_part('template-parts/product-grid',null,array('query_type'=>'on_sale','limit'=>12,'is_slider'=>true)); ?>
<div class="swiper-pagination !bottom-0"></div>
</div>
</div>
</section>