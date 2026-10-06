<?php
/**
 * Premium editorial hero for the BAJI homepage.
 *
 * @package BajiStyle
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$hero_image = 'https://bajistyle.ir/wp-content/uploads/2026/09/baji-installment-slider-reference-face.png?v=2766';
?>
<style id="baji-editorial-hero-style">
.baji-editorial-hero{max-width:1400px;margin:14px auto 20px;padding:0 16px}
.baji-editorial-hero__frame{direction:ltr;display:grid;grid-template-columns:minmax(360px,44%) 1fr;grid-template-areas:"content media";min-height:500px;overflow:hidden;border:1px solid rgba(123,19,39,.06);border-radius:28px;background:linear-gradient(135deg,#fffaf6 0%,#f8eee7 100%);box-shadow:0 20px 60px rgba(64,43,35,.08)}
.baji-editorial-hero__content{grid-area:content;direction:rtl;display:flex;flex-direction:column;justify-content:center;align-items:flex-start;text-align:right;padding:58px 46px 58px 54px;position:relative;z-index:2}
.baji-editorial-hero__content:after{content:"";position:absolute;left:-60px;top:-70px;width:230px;height:230px;border-radius:50%;background:rgba(193,145,91,.09);z-index:-1}
.baji-editorial-hero__media{grid-area:media;position:relative;min-height:500px;overflow:hidden;background:#d8c7b9}
.baji-editorial-hero__media:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(255,250,246,.12),transparent 28%)}
.baji-editorial-hero__media img{position:absolute;inset:0;width:100%;height:100%;display:block;object-fit:cover;object-position:72% center;transform:scale(1.01)}
.baji-editorial-hero__eyebrow{display:flex;align-items:center;gap:10px;color:#9a6a45;font-size:11px;font-weight:800;letter-spacing:.18em;margin-bottom:14px}
.baji-editorial-hero__eyebrow:before{content:"";width:34px;height:1px;background:#b99168}
.baji-editorial-hero__title{margin:0;color:#511625;font-size:clamp(34px,4vw,56px);font-weight:950;line-height:1.36;letter-spacing:-.035em}
.baji-editorial-hero__subtitle{max-width:430px;margin:16px 0 0;color:#66564f;font-size:14px;line-height:2.05;font-weight:600}
.baji-editorial-hero__actions{display:flex;align-items:center;gap:13px;margin-top:24px;flex-wrap:wrap}
.baji-editorial-hero__cta{display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:48px;padding:0 24px;border-radius:15px;background:#7b1327;color:#fff!important;text-decoration:none;font-size:13px;font-weight:900;box-shadow:0 12px 28px rgba(123,19,39,.19);transition:transform .2s ease,box-shadow .2s ease,background .2s ease}
.baji-editorial-hero__cta:hover{background:#68101f;box-shadow:0 15px 34px rgba(123,19,39,.25);transform:translateY(-1px)}
.baji-editorial-hero__note{display:flex;align-items:center;gap:7px;color:#6d5c55;font-size:11px;font-weight:750}
.baji-editorial-hero__note i{color:#b58a5e}
.baji-editorial-hero__mini{margin-top:20px;display:flex;align-items:center;gap:8px;color:#8b7469;font-size:10px;font-weight:750}
.baji-editorial-hero__mini span{display:inline-flex;align-items:center;gap:5px}.baji-editorial-hero__mini i{color:#7b1327;font-size:9px}
@media(max-width:767px){
  .baji-editorial-hero{margin:10px auto 16px;padding:0 12px}
  .baji-editorial-hero__frame{display:grid;grid-template-columns:1fr;grid-template-rows:305px auto;grid-template-areas:"media" "content";min-height:0;border-radius:24px}
  .baji-editorial-hero__media{min-height:305px}
  .baji-editorial-hero__media img{object-position:74% center;transform:scale(1.02)}
  .baji-editorial-hero__media:after{background:linear-gradient(180deg,transparent 70%,rgba(255,250,246,.18) 100%)}
  .baji-editorial-hero__content{padding:22px 22px 24px;align-items:flex-start;background:linear-gradient(180deg,#fffaf6 0%,#f9efe8 100%)}
  .baji-editorial-hero__content:after{display:none}
  .baji-editorial-hero__eyebrow{font-size:9px;margin-bottom:8px}.baji-editorial-hero__eyebrow:before{width:26px}
  .baji-editorial-hero__title{font-size:31px;line-height:1.35}
  .baji-editorial-hero__subtitle{font-size:12px;line-height:1.9;margin-top:8px;max-width:310px}
  .baji-editorial-hero__actions{margin-top:15px;gap:10px}
  .baji-editorial-hero__cta{min-height:44px;padding:0 18px;font-size:12px}
  .baji-editorial-hero__note{font-size:10px}
  .baji-editorial-hero__mini{margin-top:14px;font-size:9px;gap:7px}
}
</style>

<section class="baji-editorial-hero" aria-label="<?php esc_attr_e( 'معرفی باجی', 'bajistyle' ); ?>">
	<div class="baji-editorial-hero__frame">
		<div class="baji-editorial-hero__content">
			<div class="baji-editorial-hero__eyebrow">BAJI · BE YOUR BEST</div>
			<h1 class="baji-editorial-hero__title">سبک زندگی<br>با امضای تو</h1>
			<p class="baji-editorial-hero__subtitle">لباس‌هایی برای نسخه بهترِ خودت؛ انتخاب‌شده با تمرکز روی کیفیت، فرم زیبا و جزئیاتی که تفاوت را می‌سازند.</p>
			<div class="baji-editorial-hero__actions">
				<a class="baji-editorial-hero__cta" href="<?php echo esc_url( $shop_url ); ?>">
					<span>مشاهده محصولات</span>
					<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
				</a>
				<span class="baji-editorial-hero__note"><i class="fa-regular fa-gem" aria-hidden="true"></i> انتخاب‌های تازه BAJI</span>
			</div>
			<div class="baji-editorial-hero__mini" aria-label="مزیت‌های خرید">
				<span><i class="fa-solid fa-circle-check"></i> خرید اقساطی</span>
				<span>•</span>
				<span><i class="fa-solid fa-circle-check"></i> ارسال سریع</span>
			</div>
		</div>
		<div class="baji-editorial-hero__media">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="استایل زنانه باجی" fetchpriority="high" loading="eager" decoding="async">
		</div>
	</div>
</section>
