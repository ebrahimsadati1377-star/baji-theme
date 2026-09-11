<?php
/** BAJI installment shopping banner. @package BajiStyle */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>
<section class="baji-installment-banner" aria-label="خرید اقساطی باجی">
<style>
.baji-installment-banner{background:#f7f2ed;padding:20px 0 28px}.baji-installment-banner__inner{max-width:1400px;margin:0 auto;padding:0 16px}.baji-installment-banner__link{display:block;position:relative;overflow:hidden;border-radius:22px;box-shadow:0 10px 30px rgba(84,27,37,.10);background:#efe7e0}.baji-installment-banner__img{display:block;width:100%;height:auto;aspect-ratio:3/1;object-fit:cover}.baji-installment-banner__link:after{content:'';position:absolute;inset:0;border:1px solid rgba(104,38,49,.10);border-radius:22px;pointer-events:none}.baji-installment-banner__link{transition:transform .25s ease,box-shadow .25s ease}.baji-installment-banner__link:hover{transform:translateY(-2px);box-shadow:0 14px 38px rgba(84,27,37,.14)}
@media(max-width:767px){.baji-installment-banner{padding:14px 0 22px}.baji-installment-banner__inner{padding:0 12px}.baji-installment-banner__link,.baji-installment-banner__link:after{border-radius:14px}.baji-installment-banner__img{aspect-ratio:3/1;object-fit:cover}}
</style>
<div class="baji-installment-banner__inner">
<a class="baji-installment-banner__link" href="<?php echo esc_url( $shop_url ); ?>" aria-label="مشاهده محصولات و خرید اقساطی از باجی">
<img class="baji-installment-banner__img" src="https://bajistyle.ir/wp-content/uploads/2026/09/baji-installment-banner.png" alt="خرید اقساطی BAJI با اسنپ‌پی، دیجی‌پی و ترب‌پی" width="2172" height="724" loading="lazy" decoding="async">
</a>
</div>
</section>
