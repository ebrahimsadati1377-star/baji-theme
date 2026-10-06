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
$hero_image = 'https://bajistyle.ir/wp-content/uploads/2026/10/baji-browncoat-4695-final-01.jpg';
?>
<style id="baji-editorial-hero-style">
.baji-editorial-hero{max-width:1400px;margin:14px auto 20px;padding:0 16px}
.baji-editorial-hero__frame{position:relative;min-height:520px;overflow:hidden;border-radius:28px;background:#eee4dc;isolation:isolate;box-shadow:0 20px 60px rgba(64,43,35,.09)}
.baji-editorial-hero__media{position:absolute;inset:0;z-index:-3}
.baji-editorial-hero__media img{width:100%;height:100%;display:block;object-fit:cover;object-position:center 32%}
.baji-editorial-hero__wash{position:absolute;inset:0;z-index:-2;background:linear-gradient(90deg,rgba(255,249,244,.97) 0%,rgba(255,249,244,.9) 30%,rgba(255,249,244,.28) 60%,rgba(48,31,26,.08) 100%)}
.baji-editorial-hero__glow{position:absolute;left:-80px;top:-110px;width:360px;height:360px;border-radius:50%;background:rgba(213,171,113,.16);filter:blur(4px);z-index:-1}
.baji-editorial-hero__content{width:min(48%,560px);min-height:520px;display:flex;flex-direction:column;justify-content:center;align-items:flex-start;text-align:right;padding:58px 56px 58px 64px;margin-left:auto}
.baji-editorial-hero__eyebrow{display:flex;align-items:center;gap:10px;color:#9a6a45;font-size:11px;font-weight:800;letter-spacing:.18em;margin-bottom:14px}
.baji-editorial-hero__eyebrow:before{content:"";width:34px;height:1px;background:#b99168}
.baji-editorial-hero__title{margin:0;color:#4f1623;font-size:clamp(34px,4vw,58px);font-weight:950;line-height:1.35;letter-spacing:-.035em}
.baji-editorial-hero__subtitle{max-width:430px;margin:16px 0 0;color:#62534c;font-size:14px;line-height:2.05;font-weight:600}
.baji-editorial-hero__actions{display:flex;align-items:center;gap:12px;margin-top:24px}
.baji-editorial-hero__cta{display:inline-flex;align-items:center;justify-content:center;gap:10px;min-height:48px;padding:0 24px;border-radius:15px;background:#7b1327;color:#fff!important;text-decoration:none;font-size:13px;font-weight:900;box-shadow:0 12px 28px rgba(123,19,39,.2);transition:transform .2s ease,box-shadow .2s ease,background .2s ease}
.baji-editorial-hero__cta:hover{background:#67101f;box-shadow:0 15px 34px rgba(123,19,39,.25);transform:translateY(-1px)}
.baji-editorial-hero__note{display:flex;align-items:center;gap:7px;color:#6c5b54;font-size:11px;font-weight:750}
.baji-editorial-hero__note i{color:#b58a5e}
.baji-editorial-hero__seal{position:absolute;left:28px;bottom:24px;display:flex;flex-direction:column;align-items:center;justify-content:center;width:92px;height:92px;border:1px solid rgba(255,255,255,.64);border-radius:50%;background:rgba(52,33,29,.28);backdrop-filter:blur(10px);color:#fff;text-align:center;letter-spacing:.12em}
.baji-editorial-hero__seal strong{font-family:serif;font-size:18px;letter-spacing:.22em;font-weight:500}.baji-editorial-hero__seal small{font-size:7px;margin-top:4px;color:#f2dfce}
@media(max-width:767px){
  .baji-editorial-hero{margin:10px auto 16px;padding:0 12px}
  .baji-editorial-hero__frame{min-height:500px;border-radius:24px}
  .baji-editorial-hero__media img{object-position:center 18%}
  .baji-editorial-hero__wash{background:linear-gradient(180deg,rgba(33,20,18,.02) 18%,rgba(38,20,22,.12) 48%,rgba(42,21,25,.82) 100%)}
  .baji-editorial-hero__content{position:absolute;left:0;right:0;bottom:0;width:100%;min-height:auto;padding:30px 24px 26px;align-items:flex-start;color:#fff}
  .baji-editorial-hero__eyebrow{color:#f0d1aa;font-size:9px;margin-bottom:8px}.baji-editorial-hero__eyebrow:before{background:#e9c89f;width:26px}
  .baji-editorial-hero__title{color:#fff;font-size:32px;line-height:1.35;text-shadow:0 2px 16px rgba(0,0,0,.18)}
  .baji-editorial-hero__subtitle{color:#f8eee8;font-size:12px;line-height:1.9;margin-top:8px;max-width:320px}
  .baji-editorial-hero__actions{margin-top:15px;gap:10px;flex-wrap:wrap}
  .baji-editorial-hero__cta{min-height:44px;padding:0 18px;font-size:12px;background:#fff;color:#5d1725!important;box-shadow:0 10px 28px rgba(0,0,0,.18)}
  .baji-editorial-hero__note{color:#f5e6dd;font-size:10px}.baji-editorial-hero__note i{color:#f0d1aa}
  .baji-editorial-hero__seal{top:16px;left:16px;bottom:auto;width:72px;height:72px;background:rgba(53,31,25,.24)}.baji-editorial-hero__seal strong{font-size:14px}.baji-editorial-hero__seal small{font-size:6px}
}
</style>

<section class="baji-editorial-hero" aria-label="<?php esc_attr_e( 'معرفی باجی', 'bajistyle' ); ?>">
	<div class="baji-editorial-hero__frame">
		<div class="baji-editorial-hero__media">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="استایل پاییزی زنانه باجی" fetchpriority="high" loading="eager" decoding="async">
		</div>
		<div class="baji-editorial-hero__wash" aria-hidden="true"></div>
		<div class="baji-editorial-hero__glow" aria-hidden="true"></div>

		<div class="baji-editorial-hero__content">
			<div class="baji-editorial-hero__eyebrow">BAJI · BE YOUR BEST</div>
			<h1 class="baji-editorial-hero__title">سبک زندگی<br>با امضای تو</h1>
			<p class="baji-editorial-hero__subtitle">انتخاب‌هایی برای استایل روزمره و خاص؛ با تمرکز روی کیفیت، فرم زیبا و جزئیاتی که تفاوت را می‌سازند.</p>
			<div class="baji-editorial-hero__actions">
				<a class="baji-editorial-hero__cta" href="<?php echo esc_url( $shop_url ); ?>">
					<span>مشاهده محصولات</span>
					<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
				</a>
				<span class="baji-editorial-hero__note"><i class="fa-regular fa-gem" aria-hidden="true"></i> انتخاب‌های تازه BAJI</span>
			</div>
		</div>

		<div class="baji-editorial-hero__seal" aria-hidden="true">
			<strong>BAJI</strong>
			<small>BE YOUR BEST</small>
		</div>
	</div>
</section>
