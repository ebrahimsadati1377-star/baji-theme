<?php
/** Premium BAJI brand banner. @package BajiStyle */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$story_image = get_theme_mod( 'bajistyle_brand_story_image', '' );
if ( ! $story_image ) {
	$story_image = get_template_directory_uri() . '/assets/images/about-story.webp';
}
$shop_url = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>
<style id="baji-brand-banner-style">
.baji-brand-banner{padding:24px 16px;background:#fffaf8}
.baji-brand-banner__card{position:relative;max-width:1360px;min-height:520px;margin:auto;overflow:hidden;border-radius:24px;background:#171312;box-shadow:0 18px 55px rgba(54,28,28,.12)}
.baji-brand-banner__image{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 38%}
.baji-brand-banner__shade{position:absolute;inset:0;background:linear-gradient(90deg,rgba(18,12,12,.82) 0%,rgba(18,12,12,.58) 38%,rgba(18,12,12,.16) 72%,rgba(18,12,12,.06) 100%)}
.baji-brand-banner__content{position:relative;z-index:2;min-height:520px;width:min(620px,55%);display:flex;flex-direction:column;justify-content:center;padding:64px 70px;color:#fff}
.baji-brand-banner__eyebrow{display:flex;align-items:center;gap:12px;font-size:12px;letter-spacing:.24em;color:#e7b58a;margin-bottom:18px}
.baji-brand-banner__eyebrow:before{content:'';width:38px;height:2px;border-radius:9px;background:linear-gradient(90deg,#a84d62,#e4ad75)}
.baji-brand-banner__logo{font-family:Arial,sans-serif;font-size:46px;line-height:1;letter-spacing:.24em;font-weight:500;margin:0 0 20px}
.baji-brand-banner__title{font-size:30px;line-height:1.75;font-weight:800;margin:0 0 12px;max-width:520px}
.baji-brand-banner__sub{font-size:14px;line-height:2;color:rgba(255,255,255,.78);margin:0 0 28px;max-width:460px}
.baji-brand-banner__cta{display:inline-flex;align-items:center;justify-content:center;gap:10px;width:max-content;min-width:165px;padding:13px 22px;border-radius:999px;background:#fff;color:#171312!important;text-decoration:none!important;font-size:13px;font-weight:800;transition:.25s ease}
.baji-brand-banner__cta:hover{transform:translateY(-2px);background:#f2d4bb}
@media(max-width:767px){.baji-brand-banner{padding:16px 12px}.baji-brand-banner__card{min-height:440px;border-radius:18px}.baji-brand-banner__image{object-position:center top}.baji-brand-banner__shade{background:linear-gradient(0deg,rgba(17,11,11,.90) 0%,rgba(17,11,11,.66) 48%,rgba(17,11,11,.12) 100%)}.baji-brand-banner__content{min-height:440px;width:100%;justify-content:flex-end;padding:30px 24px}.baji-brand-banner__eyebrow{font-size:10px;margin-bottom:10px}.baji-brand-banner__logo{font-size:32px;margin-bottom:12px}.baji-brand-banner__title{font-size:21px;line-height:1.7;margin-bottom:6px}.baji-brand-banner__sub{font-size:12px;line-height:1.8;margin-bottom:18px;max-width:310px}.baji-brand-banner__cta{padding:11px 18px;min-width:145px;font-size:12px}}
</style>
<section class="baji-brand-banner" aria-label="معرفی برند باجی">
	<div class="baji-brand-banner__card">
		<img class="baji-brand-banner__image" src="<?php echo esc_url( $story_image ); ?>" alt="استایل زنانه باجی" loading="lazy" decoding="async">
		<div class="baji-brand-banner__shade" aria-hidden="true"></div>
		<div class="baji-brand-banner__content">
			<span class="baji-brand-banner__eyebrow">BAJI — BE YOUR BEST</span>
			<div class="baji-brand-banner__logo">BAJI</div>
			<h2 class="baji-brand-banner__title">کیفیتی که با اولین پوشیدن حسش می‌کنی</h2>
			<p class="baji-brand-banner__sub">انتخابی برای استایل‌های ساده، شیک و ماندگار؛ با تمرکز روی کیفیت پارچه، دوخت و جزئیاتی که تفاوت را می‌سازند.</p>
			<a class="baji-brand-banner__cta" href="<?php echo esc_url( $shop_url ); ?>"><span>مشاهده محصولات</span><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></a>
		</div>
	</div>
</section>