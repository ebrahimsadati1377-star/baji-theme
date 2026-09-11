<?php
/** Homepage sale products section. @package BajiStyle */
if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) { return; }
$sale_ids = wc_get_product_ids_on_sale();
if ( empty( $sale_ids ) ) { return; }
$shop_url = wc_get_page_permalink( 'shop' );
$sale_url = add_query_arg( 'orderby', 'price', $shop_url );
?>
<section class="baji-sale-products py-12 md:py-16 bg-white" aria-labelledby="baji-sale-title">
<style>
.baji-sale-products .baji-sale-kicker{color:#9a455b}.baji-sale-products .baji-sale-line{background:linear-gradient(90deg,#9a455b,#d9a36a)}
.baji-sale-products .baji-sale-badge{display:inline-flex;align-items:center;gap:7px;padding:7px 12px;border-radius:999px;background:#fff4f3;color:#8f3f55;font-size:12px;font-weight:700;border:1px solid #f0d9d8}
.baji-sale-products .baji-sale-all{border:1px solid #e7d8d6;border-radius:999px;padding:9px 15px;background:#fff;transition:.2s}.baji-sale-products .baji-sale-all:hover{border-color:#9a455b;color:#9a455b}
</style>
<div class="max-w-[1400px] mx-auto px-4 md:px-8">
<div class="flex items-end justify-between gap-4 mb-8 md:mb-12">
<div>
<div class="flex items-center gap-2 md:gap-3 mb-2"><span class="baji-sale-line w-7 md:w-10 h-[3px] rounded-full"></span><span class="baji-sale-kicker text-[10px] md:text-sm font-bold tracking-[.15em]"><?php esc_html_e('پیشنهادهای ویژه','bajistyle'); ?></span></div>
<h2 id="baji-sale-title" class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight"><?php esc_html_e('تخفیف‌های BAJI','bajistyle'); ?></h2>
<div class="mt-3"><span class="baji-sale-badge"><i class="fa-solid fa-tag" aria-hidden="true"></i><?php esc_html_e('فرصت خرید با قیمت ویژه','bajistyle'); ?></span></div>
</div>
<a href="<?php echo esc_url($shop_url); ?>" class="baji-sale-all group flex items-center gap-2 text-xs md:text-sm font-bold text-gray-700 shrink-0"><span><?php esc_html_e('مشاهده همه','bajistyle'); ?></span><i class="fa-solid fa-arrow-left text-[10px] transition-transform group-hover:-translate-x-1"></i></a>
</div>
<div class="swiper baji-products-slider overflow-hidden relative pb-12">
<?php get_template_part('template-parts/product-grid',null,array('query_type'=>'on_sale','limit'=>12,'is_slider'=>true)); ?>
<div class="swiper-pagination !bottom-0"></div>
</div>
</div>
</section>