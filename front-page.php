<?php
/**
 * فایل صفحه اصلی (Front Page) قالب BajiStyle
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- =================== پاپ‌آپ اولین خرید BAJI =================== -->
	<div id="baji-first-order-popup" class="baji-first-order-popup" aria-hidden="true">
		<div class="baji-first-order-backdrop" data-baji-popup-close></div>
		<div class="baji-first-order-dialog" role="dialog" aria-modal="true" aria-labelledby="baji-first-order-title">
			<button type="button" class="baji-first-order-close" data-baji-popup-close aria-label="بستن">
				<i class="fa-solid fa-xmark"></i>
			</button>

			<div class="baji-first-order-visual">
				<div class="baji-first-order-gift"><i class="fa-solid fa-gift"></i></div>
				<div class="baji-first-order-brand">BAJI</div>
			</div>

			<div class="baji-first-order-content">
				<div class="baji-first-order-kicker">اولین خریدت از باجی؟</div>
				<h2 id="baji-first-order-title">۱۰٪ تخفیف اولین خرید 🤍</h2>
				<p>برای اولین خریدت از BAJI کد <strong>OFF10</strong> رو موقع تسویه حساب وارد کن و ۱۰٪ تخفیف بگیر.</p>
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="baji-first-order-cta">مشاهده محصولات</a>
			</div>
		</div>
	</div>

	<style id="baji-first-order-popup-style">
	.baji-first-order-popup{position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;padding:18px}
	.baji-first-order-popup.is-open{display:flex}
	.baji-first-order-backdrop{position:absolute;inset:0;background:rgba(18,18,18,.62);backdrop-filter:blur(2px)}
	.baji-first-order-dialog{position:relative;z-index:1;width:min(92vw,430px);background:#fff9f7;border-radius:24px;overflow:hidden;box-shadow:0 24px 70px rgba(0,0,0,.28);border:1px solid rgba(123,19,39,.08);direction:rtl}
	.baji-first-order-close{position:absolute;top:12px;left:12px;width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.92);display:flex;align-items:center;justify-content:center;color:#3f2b2a;font-size:18px;z-index:2;box-shadow:0 4px 14px rgba(0,0,0,.09)}
	.baji-first-order-visual{height:180px;background:linear-gradient(135deg,#f6d9dd 0%,#f8eee8 100%);display:flex;align-items:center;justify-content:center;position:relative}
	.baji-first-order-visual:before,.baji-first-order-visual:after{content:"";position:absolute;border-radius:50%;background:rgba(255,255,255,.45)}
	.baji-first-order-visual:before{width:120px;height:120px;right:-35px;top:-25px}.baji-first-order-visual:after{width:95px;height:95px;left:-20px;bottom:-20px}
	.baji-first-order-gift{width:84px;height:84px;border-radius:24px;background:#7b1327;color:#fff;display:flex;align-items:center;justify-content:center;font-size:38px;box-shadow:0 12px 30px rgba(123,19,39,.24);transform:rotate(-4deg)}
	.baji-first-order-brand{position:absolute;bottom:14px;right:18px;font-family:serif;font-size:20px;letter-spacing:.22em;color:#6a4c49}
	.baji-first-order-content{padding:22px 24px 24px;text-align:center}
	.baji-first-order-kicker{font-size:12px;font-weight:800;color:#9c6f68;margin-bottom:6px}
	.baji-first-order-content h2{font-size:28px;line-height:1.35;font-weight:900;color:#2d1e1d;margin:0 0 10px}
	.baji-first-order-content p{font-size:13px;line-height:2;color:#71615d;margin:0 auto 18px;max-width:320px}
	.baji-first-order-cta{display:flex;align-items:center;justify-content:center;width:100%;min-height:48px;border-radius:14px;background:#7b1327;color:#fff!important;font-size:14px;font-weight:900;text-decoration:none;box-shadow:0 8px 20px rgba(123,19,39,.16)}
	@media(max-width:767px){.baji-first-order-dialog{width:min(92vw,390px);border-radius:22px}.baji-first-order-visual{height:160px}.baji-first-order-content h2{font-size:25px}.baji-first-order-content{padding:20px}}
	</style>

	<script>
	document.addEventListener('DOMContentLoaded',function(){
		const popup=document.getElementById('baji-first-order-popup');
		if(!popup) return;
		if(popup.parentElement!==document.body){document.body.appendChild(popup);}
		const open=()=>{popup.classList.add('is-open');popup.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';};
		const close=()=>{popup.classList.remove('is-open');popup.setAttribute('aria-hidden','true');document.body.style.overflow='';};
		setTimeout(open,500);
		popup.querySelectorAll('[data-baji-popup-close]').forEach(el=>el.addEventListener('click',close));
		document.addEventListener('keydown',e=>{if(e.key==='Escape'&&popup.classList.contains('is-open')) close();});
	});
	</script>

<div class="baji-front-page">

	<?php get_template_part( 'template-parts/product-stories' ); ?>

	<?php get_template_part( 'template-parts/hero-section' ); ?>

	<section class="baji-quick-products py-5 md:py-8 bg-[#fffaf8]">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="flex items-center justify-between gap-4 mb-4">
				<div>
					<div class="text-[10px] md:text-xs font-bold tracking-[.16em] text-[#b28a72] mb-1">BAJI PICKS</div>
					<h2 class="text-lg md:text-2xl font-black text-[#2d211e]">پرفروش‌های باجی</h2>
				</div>
				<a href="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', wc_get_page_permalink( 'shop' ) ) ); ?>" class="text-[11px] md:text-sm font-bold text-[#7b1327]">مشاهده همه ←</a>
			</div>
			<div class="baji-quick-products-grid">
				<?php
				get_template_part(
					'template-parts/product-grid',
					null,
					array(
						'query_type' => 'best_selling',
						'limit'      => 4,
						'is_slider'  => false,
					)
				);
				?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/category-showcase' ); ?>

	<!-- =================== اعتمادسازی خرید =================== -->
	<section class="baji-trust-strip py-5 md:py-7 bg-[#fffaf7]">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-5">

				<div class="bg-white border border-[#eadfd8] rounded-2xl px-4 py-4 md:px-5 md:py-5 flex items-center gap-3 shadow-[0_6px_20px_rgba(80,55,45,.06)]">
					<div class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-[#f7e7ea] text-[#7b1327] flex items-center justify-center shrink-0">
						<i class="fa-regular fa-credit-card text-lg"></i>
					</div>
					<div>
						<div class="text-sm md:text-base font-black text-[#2d211e] mb-1">خرید اقساطی</div>
						<div class="text-[11px] md:text-sm text-[#7c6f69] leading-6">با دیجی‌پی، اسنپ‌پی و ترب‌پی</div>
					</div>
				</div>

				<div class="bg-white border border-[#eadfd8] rounded-2xl px-4 py-4 md:px-5 md:py-5 flex items-center gap-3 shadow-[0_6px_20px_rgba(80,55,45,.06)]">
					<div class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-[#f5eee8] text-[#9b6b52] flex items-center justify-center shrink-0">
						<i class="fa-solid fa-truck-fast text-lg"></i>
					</div>
					<div>
						<div class="text-sm md:text-base font-black text-[#2d211e] mb-1">ارسال رایگان</div>
						<div class="text-[11px] md:text-sm text-[#7c6f69] leading-6">برای سفارش‌های بالای ۳ میلیون تومان</div>
					</div>
				</div>

				<div class="bg-white border border-[#eadfd8] rounded-2xl px-4 py-4 md:px-5 md:py-5 flex items-center gap-3 shadow-[0_6px_20px_rgba(80,55,45,.06)]">
					<div class="w-11 h-11 md:w-12 md:h-12 rounded-full bg-[#f7e7ea] text-[#7b1327] flex items-center justify-center shrink-0">
						<i class="fa-solid fa-shield-heart text-lg"></i>
					</div>
					<div>
						<div class="text-sm md:text-base font-black text-[#2d211e] mb-1">تضمین کیفیت BAJI</div>
						<div class="text-[11px] md:text-sm text-[#7c6f69] leading-6">کیفیتی که با اولین پوشیدن حسش می‌کنی</div>
					</div>
				</div>

			</div>
		</div>
	</section>
<style id="baji-force-mobile-category-layout">
@media (max-width: 767px) {
  .baji-front-page .baji-category-showcase .baji-category-grid {
    display: flex !important;
    flex-direction: column !important;
    grid-template-columns: none !important;
    gap: 12px !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card {
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    flex: 0 0 auto !important;
    aspect-ratio: 3.8 / 1 !important;
    height: auto !important;
    grid-column: auto !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--overall,
  .baji-front-page .baji-category-showcase .baji-category-card--overshirt {
    aspect-ratio: 969 / 153 !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--set,
  .baji-front-page .baji-category-showcase .baji-category-card--pants,
  .baji-front-page .baji-category-showcase .baji-category-card--blouse {
    aspect-ratio: 969 / 155 !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--crop {
    aspect-ratio: 969 / 152 !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--tshirt {
    aspect-ratio: 969 / 155 !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--crop {
    aspect-ratio: 969 / 152 !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--overall .baji-category-card__image,
  .baji-front-page .baji-category-showcase .baji-category-card--overshirt .baji-category-card__image,
  .baji-front-page .baji-category-showcase .baji-category-card--set .baji-category-card__image,
  .baji-front-page .baji-category-showcase .baji-category-card--pants .baji-category-card__image,
  .baji-front-page .baji-category-showcase .baji-category-card--blouse .baji-category-card__image {
    width: 100% !important;
    height: 100% !important;
    object-fit: fill !important;
    object-position: center !important;
    transform: none !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--tshirt .baji-category-card__image {
    width: 100% !important;
    height: 100% !important;
    object-fit: fill !important;
    object-position: center !important;
    transform: none !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--overall .baji-category-card__shade,
  .baji-front-page .baji-category-showcase .baji-category-card--overall .baji-category-card__content,
  .baji-front-page .baji-category-showcase .baji-category-card--overshirt .baji-category-card__shade,
  .baji-front-page .baji-category-showcase .baji-category-card--overshirt .baji-category-card__content,
  .baji-front-page .baji-category-showcase .baji-category-card--set .baji-category-card__shade,
  .baji-front-page .baji-category-showcase .baji-category-card--set .baji-category-card__content,
  .baji-front-page .baji-category-showcase .baji-category-card--pants .baji-category-card__shade,
  .baji-front-page .baji-category-showcase .baji-category-card--pants .baji-category-card__content,
  .baji-front-page .baji-category-showcase .baji-category-card--blouse .baji-category-card__shade,
  .baji-front-page .baji-category-showcase .baji-category-card--blouse .baji-category-card__content {
    display: none !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--skirt {
    aspect-ratio: 969 / 153 !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--skirt .baji-category-card__image {
    width: 100% !important;
    height: 100% !important;
    object-fit: fill !important;
    object-position: center !important;
    transform: none !important;
  }
  .baji-front-page .baji-category-showcase .baji-category-card--skirt .baji-category-card__shade,
  .baji-front-page .baji-category-showcase .baji-category-card--skirt .baji-category-card__content {
    display: none !important;
  }
}
.baji-front-page .baji-category-showcase .baji-category-card__arrow,
.baji-front-page .baji-category-showcase .fa-arrow-left,
.baji-front-page .baji-category-showcase a > i.fa-solid,
.baji-front-page .baji-category-showcase a > i.fas {display:none!important;visibility:hidden!important;opacity:0!important;width:0!important;height:0!important;margin:0!important;padding:0!important;}
</style>

	<!-- =================== بخش اول: جدیدترین محصولات — BAJI refreshed =================== -->
	<section class="baji-new-arrivals py-12 md:py-16 bg-baji-cream">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="flex flex-row items-center justify-between gap-4 mb-8 md:mb-12">
				<div>
					<div class="flex items-center gap-2 md:gap-3 mb-1 md:mb-3">
						<span class="w-6 md:w-10 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-[10px] md:text-sm font-bold tracking-[0.15em] md:tracking-[0.2em] uppercase"><?php esc_html_e( 'تازه‌های فروشگاه', 'bajistyle' ); ?></span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight"><?php esc_html_e( 'جدید های باجی', 'bajistyle' ); ?></h2>
				</div>
				<a href="https://bajistyle.ir/new-products/" class="group flex items-center gap-1.5 md:gap-2 text-xs md:text-base font-medium text-gray-600 hover:text-gray-900 transition-colors duration-300 shrink-0">
					<span><?php esc_html_e( 'همه', 'bajistyle' ); ?></span>
					<i class="fa-solid fa-arrow-left text-xs md:text-sm transform group-hover:-translate-x-1.5 transition-transform duration-300"></i>
				</a>
			</div>

			<div class="swiper baji-products-slider overflow-hidden relative pb-12">
				<?php
				get_template_part(
					'template-parts/product-grid',
					null,
					array(
						'query_type' => 'latest',
						'limit'      => 12,
						'is_slider'  => true,
					)
				);
				?>
				<div class="swiper-pagination !bottom-0"></div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/home-category-products' ); ?>
	<?php get_template_part( 'template-parts/brand-story' ); ?>
	<?php get_template_part( 'template-parts/sale-products' ); ?>

	<!-- =================== بنرهای شبکه اجتماعی (اینستاگرام و بله) =================== -->
	<section class="baji-social-banners py-6 bg-baji-cream">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
				<a href="https://instagram.com/baji.style" target="_blank" rel="noopener noreferrer" class="group relative overflow-hidden rounded-2xl block shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-instagram2.webp" alt="اینستاگرام باجی استایل" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500" style="border-radius: 20px !important;">
					<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-4 md:p-6 opacity-90 group-hover:opacity-100 transition-opacity">
						<div class="flex items-center justify-between w-full text-white"><i class="fa-solid fa-arrow-left text-sm md:text-base transform group-hover:-translate-x-2 transition-transform duration-300"></i></div>
					</div>
				</a>
				<a href="https://ble.ir/bajistyle" target="_blank" rel="noopener noreferrer" class="group relative overflow-hidden rounded-2xl block shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-bale2.webp" alt="کانال باجی استایل" class="rounded-2xl w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500" style="border-radius: 20px !important;">
					<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-4 md:p-6 opacity-90 group-hover:opacity-100 transition-opacity">
						<div class="flex items-center justify-between w-full text-white"><i class="fa-solid fa-arrow-left text-sm md:text-base transform group-hover:-translate-x-2 transition-transform duration-300"></i></div>
					</div>
				</a>
			</div>
		</div>
	</section>

	<!-- =================== بخش دوم: پرفروش‌ترین محصولات =================== -->
	<section class="baji-best-sellers py-12 md:py-16 bg-baji-cream">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="flex flex-row items-center justify-between gap-4 mb-8 md:mb-12">
				<div>
					<div class="flex items-center gap-2 md:gap-3 mb-1 md:mb-3">
						<span class="w-6 md:w-10 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-[10px] md:text-sm font-bold tracking-[0.15em] md:tracking-[0.2em] uppercase"><?php esc_html_e( 'محبوب‌ترین‌ها', 'bajistyle' ); ?></span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight"><?php esc_html_e( 'پرفروش‌ترین محصولات', 'bajistyle' ); ?></h2>
				</div>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="group flex items-center gap-1.5 md:gap-2 text-xs md:text-base font-medium text-gray-600 hover:text-gray-900 transition-colors duration-300 shrink-0">
					<span><?php esc_html_e( 'همه', 'bajistyle' ); ?></span>
					<i class="fa-solid fa-arrow-left text-xs md:text-sm transform group-hover:-translate-x-1.5 transition-transform duration-300"></i>
				</a>
			</div>

			<div class="swiper baji-products-slider overflow-hidden relative pb-12">
				<?php
				get_template_part(
					'template-parts/product-grid',
					null,
					array(
						'query_type' => 'best_selling',
						'limit'      => 12,
						'is_slider'  => true,
					)
				);
				?>
				<div class="swiper-pagination !bottom-0"></div>
			</div>
		</div>
	</section>

	<!-- =================== استایل باجی — Editorial Shop the Look V2 =================== -->
<section class="baji-style-shop baji-style-shop--v2" aria-labelledby="baji-style-shop-title">
  <div class="baji-style-shop__shell">

    <article class="baji-style-shop__visual">
      <img
        src="<?php echo esc_url( wp_get_attachment_image_url( 3238, 'large' ) ); ?>"
        alt="استایل شهری زنانه با مانتو کلاه‌دار کتان ضد آب کرم باجی"
        loading="lazy"
        class="baji-style-shop__hero-img"
      >
      <div class="baji-style-shop__overlay">
        <span class="baji-style-shop__kicker">BAJI EDIT</span>
        <h2 id="baji-style-shop-title">استایل باجی</h2>
        <p>یک انتخاب مینیمال و کاربردی برای استایل روزمره؛ راحت، شیک و قابل خرید.</p>
        <a href="<?php echo esc_url( get_permalink( 3114 ) ); ?>" class="baji-style-shop__hero-cta">
          <span>مشاهده این استایل</span>
          <i class="fa-solid fa-arrow-left"></i>
        </a>
      </div>
    </article>

    <div class="baji-style-shop__products">
      <div class="baji-style-shop__head">
        <div>
          <span>SHOP THE EDIT</span>
          <h3>پیشنهادهای مکمل</h3>
          <p>سه انتخاب هماهنگ برای کامل‌تر کردن استایل روزمره.</p>
        </div>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="baji-style-shop__all">
          مشاهده همه محصولات <i class="fa-solid fa-arrow-left"></i>
        </a>
      </div>

      <div class="baji-style-shop__cards">
        <?php
        $baji_style_product_ids = array( 3138, 1225, 2316 );
        foreach ( $baji_style_product_ids as $baji_style_product_id ) :
          $baji_style_product = wc_get_product( $baji_style_product_id );
          if ( ! $baji_style_product || 'publish' !== get_post_status( $baji_style_product_id ) || ! $baji_style_product->is_in_stock() ) {
            continue;
          }

          $baji_style_image_id = $baji_style_product->get_image_id();
          $baji_regular = (float) $baji_style_product->get_regular_price();
          $baji_sale    = (float) $baji_style_product->get_sale_price();
          $baji_discount = ( $baji_regular > 0 && $baji_sale > 0 && $baji_sale < $baji_regular )
            ? (int) round( ( ( $baji_regular - $baji_sale ) / $baji_regular ) * 100 )
            : 0;

          $baji_terms = get_the_terms( $baji_style_product_id, 'product_cat' );
          $baji_cat_name = ( ! is_wp_error( $baji_terms ) && ! empty( $baji_terms ) )
            ? $baji_terms[0]->name
            : '';
        ?>
          <article class="baji-style-shop__card">
            <a class="baji-style-shop__card-image" href="<?php echo esc_url( get_permalink( $baji_style_product_id ) ); ?>">
              <?php
              echo wp_get_attachment_image(
                $baji_style_image_id,
                'medium_large',
                false,
                array(
                  'loading' => 'lazy',
                  'alt'     => esc_attr( $baji_style_product->get_name() ),
                )
              );
              ?>
              <?php if ( $baji_discount > 0 ) : ?>
                <span class="baji-style-shop__discount"><?php echo esc_html( $baji_discount ); ?>٪ تخفیف</span>
              <?php endif; ?>
            </a>

            <div class="baji-style-shop__card-body">
              <?php if ( $baji_cat_name ) : ?>
                <span class="baji-style-shop__category"><?php echo esc_html( $baji_cat_name ); ?></span>
              <?php endif; ?>

              <a class="baji-style-shop__name" href="<?php echo esc_url( get_permalink( $baji_style_product_id ) ); ?>">
                <?php echo esc_html( $baji_style_product->get_name() ); ?>
              </a>

              <div class="baji-style-shop__price">
                <?php echo wp_kses_post( $baji_style_product->get_price_html() ); ?>
              </div>

              <a class="baji-style-shop__buy" href="<?php echo esc_url( get_permalink( $baji_style_product_id ) ); ?>">
                <span>مشاهده و خرید</span>
                <i class="fa-solid fa-arrow-left"></i>
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<style id="baji-style-shop-v2-style">
.baji-style-shop--v2{
  --bss-ink:#2f2420;
  --bss-muted:#7b6d66;
  --bss-line:#eadfd9;
  --bss-wine:#7b1327;
  --bss-blush:#fff8f5;
  background:linear-gradient(180deg,#fbf8f4 0%,#f7f1eb 100%);
  padding:48px 0;
  direction:rtl;
}
.baji-style-shop--v2 .baji-style-shop__shell{
  width:min(calc(100% - 40px),1400px);
  margin:0 auto;
  display:grid;
  grid-template-columns:minmax(0,1.16fr) minmax(420px,.84fr);
  gap:22px;
  align-items:stretch;
}
.baji-style-shop--v2 .baji-style-shop__visual{
  position:relative;
  min-height:520px;
  overflow:hidden;
  border-radius:28px;
  background:#e8dfd8;
  box-shadow:0 18px 44px rgba(59,44,37,.11);
}
.baji-style-shop--v2 .baji-style-shop__hero-img{
  display:block;
  width:100%;
  height:100%;
  object-fit:cover;
  object-position:center 43%;
  transition:transform .55s ease;
}
.baji-style-shop--v2 .baji-style-shop__visual:hover .baji-style-shop__hero-img{transform:scale(1.018)}
.baji-style-shop--v2 .baji-style-shop__visual:after{
  content:"";
  position:absolute;
  inset:0;
  background:
    linear-gradient(180deg,rgba(24,18,15,.02) 26%,rgba(24,18,15,.14) 55%,rgba(24,18,15,.82) 100%);
  pointer-events:none;
}
.baji-style-shop--v2 .baji-style-shop__overlay{
  position:absolute;
  z-index:2;
  right:30px;
  left:30px;
  bottom:28px;
  color:#fff;
}
.baji-style-shop--v2 .baji-style-shop__kicker{
  display:inline-flex;
  align-items:center;
  min-height:28px;
  padding:0 10px;
  margin-bottom:8px;
  border:1px solid rgba(255,255,255,.28);
  border-radius:999px;
  background:rgba(255,255,255,.11);
  backdrop-filter:blur(8px);
  font-size:10px;
  font-weight:900;
  letter-spacing:.18em;
  color:#fff;
}
.baji-style-shop--v2 .baji-style-shop__overlay h2{
  margin:0 0 7px;
  color:#fff!important;
  font-size:38px;
  line-height:1.2;
  font-weight:950;
}
.baji-style-shop--v2 .baji-style-shop__overlay p{
  max-width:580px;
  margin:0 0 17px;
  color:#f7efeb;
  font-size:13px;
  line-height:1.95;
}
.baji-style-shop--v2 .baji-style-shop__hero-cta{
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:9px;
  min-height:44px;
  padding:0 18px;
  border-radius:999px;
  background:#fff;
  color:#30231f!important;
  text-decoration:none!important;
  font-size:11.5px;
  font-weight:950;
  box-shadow:0 8px 20px rgba(0,0,0,.12);
}
.baji-style-shop--v2 .baji-style-shop__hero-cta i{font-size:9px}

.baji-style-shop--v2 .baji-style-shop__products{
  display:flex;
  flex-direction:column;
  min-width:0;
  padding:22px;
  border:1px solid var(--bss-line);
  border-radius:28px;
  background:rgba(255,255,255,.92);
  box-shadow:0 13px 34px rgba(62,47,40,.07);
}
.baji-style-shop--v2 .baji-style-shop__head{
  display:flex;
  align-items:flex-end;
  justify-content:space-between;
  gap:16px;
  margin-bottom:18px;
}
.baji-style-shop--v2 .baji-style-shop__head>div>span{
  display:block;
  margin-bottom:4px;
  color:#ad8576;
  font-size:10px;
  font-weight:950;
  letter-spacing:.18em;
}
.baji-style-shop--v2 .baji-style-shop__head h3{
  margin:0;
  color:var(--bss-ink);
  font-size:25px;
  line-height:1.35;
  font-weight:950;
}
.baji-style-shop--v2 .baji-style-shop__head p{
  margin:5px 0 0;
  color:var(--bss-muted);
  font-size:11px;
  line-height:1.8;
}
.baji-style-shop--v2 .baji-style-shop__all{
  flex:0 0 auto;
  display:inline-flex;
  align-items:center;
  gap:6px;
  color:var(--bss-wine)!important;
  text-decoration:none!important;
  font-size:10.5px;
  font-weight:900;
}
.baji-style-shop--v2 .baji-style-shop__all i{font-size:8px}

.baji-style-shop--v2 .baji-style-shop__cards{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:11px;
  min-width:0;
  margin-top:auto;
}
.baji-style-shop--v2 .baji-style-shop__card{
  position:relative;
  display:flex;
  flex-direction:column;
  min-width:0;
  overflow:hidden;
  border:1px solid #eee4df;
  border-radius:19px;
  background:#fff;
  box-shadow:0 7px 20px rgba(57,43,36,.045);
}
.baji-style-shop--v2 .baji-style-shop__card-image{
  position:relative;
  display:block;
  aspect-ratio:3/4;
  overflow:hidden;
  background:#f2ebe7;
}
.baji-style-shop--v2 .baji-style-shop__card-image img{
  display:block;
  width:100%;
  height:100%;
  object-fit:cover;
  transition:transform .35s ease;
}
.baji-style-shop--v2 .baji-style-shop__card:hover .baji-style-shop__card-image img{transform:scale(1.025)}
.baji-style-shop--v2 .baji-style-shop__discount{
  position:absolute;
  top:9px;
  right:9px;
  z-index:2;
  min-height:25px;
  display:inline-flex;
  align-items:center;
  padding:0 8px;
  border-radius:999px;
  background:#fff;
  color:var(--bss-wine);
  box-shadow:0 4px 12px rgba(54,37,31,.10);
  font-size:8.5px;
  font-weight:950;
}
.baji-style-shop--v2 .baji-style-shop__card-body{
  display:flex;
  flex-direction:column;
  flex:1;
  padding:11px;
}
.baji-style-shop--v2 .baji-style-shop__category{
  display:block;
  margin-bottom:4px;
  color:#a18e85;
  font-size:8.5px;
  font-weight:800;
}
.baji-style-shop--v2 .baji-style-shop__name{
  min-height:42px;
  color:var(--bss-ink)!important;
  text-decoration:none!important;
  font-size:11.5px;
  font-weight:950;
  line-height:1.75;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}
.baji-style-shop--v2 .baji-style-shop__price{
  min-height:38px;
  display:flex;
  align-items:center;
  flex-wrap:wrap;
  gap:3px 5px;
  margin-top:6px;
  color:#e83f5b;
  font-size:11px;
  line-height:1.6;
  font-weight:950;
}
.baji-style-shop--v2 .baji-style-shop__price del{
  color:#a19a96;
  font-size:8.5px;
  font-weight:500;
  opacity:.78;
}
.baji-style-shop--v2 .baji-style-shop__price ins{text-decoration:none}
.baji-style-shop--v2 .baji-style-shop__buy{
  min-height:38px;
  margin-top:auto;
  display:flex;
  align-items:center;
  justify-content:center;
  gap:6px;
  padding:8px;
  border-radius:11px;
  background:#f9f1ee;
  color:var(--bss-wine)!important;
  border:1px solid #eeddda;
  text-decoration:none!important;
  font-size:10px;
  font-weight:950;
}
.baji-style-shop--v2 .baji-style-shop__buy i{font-size:8px}

@media(max-width:980px){
  .baji-style-shop--v2 .baji-style-shop__shell{grid-template-columns:1fr}
  .baji-style-shop--v2 .baji-style-shop__visual{min-height:440px}
}
@media(max-width:767px){
  .baji-style-shop--v2{
    padding:26px 0 32px;
  }
  .baji-style-shop--v2 .baji-style-shop__shell{
    width:calc(100% - 28px);
    gap:13px;
  }
  .baji-style-shop--v2 .baji-style-shop__visual{
    min-height:0;
    aspect-ratio:4/3;
    border-radius:21px;
    box-shadow:0 11px 28px rgba(59,44,37,.10);
  }
  .baji-style-shop--v2 .baji-style-shop__hero-img{
    object-position:center 38%;
  }
  .baji-style-shop--v2 .baji-style-shop__overlay{
    right:16px;
    left:16px;
    bottom:15px;
  }
  .baji-style-shop--v2 .baji-style-shop__kicker{
    min-height:24px;
    padding:0 8px;
    margin-bottom:5px;
    font-size:8px;
  }
  .baji-style-shop--v2 .baji-style-shop__overlay h2{
    margin-bottom:4px;
    font-size:27px;
  }
  .baji-style-shop--v2 .baji-style-shop__overlay p{
    max-width:92%;
    margin-bottom:10px;
    font-size:10.5px;
    line-height:1.75;
  }
  .baji-style-shop--v2 .baji-style-shop__hero-cta{
    min-height:37px;
    padding:0 14px;
    font-size:10px;
  }

  .baji-style-shop--v2 .baji-style-shop__products{
    padding:15px;
    border-radius:21px;
  }
  .baji-style-shop--v2 .baji-style-shop__head{
    align-items:flex-start;
    margin-bottom:13px;
  }
  .baji-style-shop--v2 .baji-style-shop__head h3{
    font-size:19px;
  }
  .baji-style-shop--v2 .baji-style-shop__head p{
    max-width:230px;
    margin-top:3px;
    font-size:9.5px;
  }
  .baji-style-shop--v2 .baji-style-shop__all{
    padding-top:20px;
    font-size:9px;
    white-space:nowrap;
  }

  .baji-style-shop--v2 .baji-style-shop__cards{
    display:flex;
    gap:10px;
    overflow-x:auto;
    max-width:100%;
    padding:1px 2px 5px;
    scroll-snap-type:x mandatory;
    overscroll-behavior-x:contain;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:none;
  }
  .baji-style-shop--v2 .baji-style-shop__cards::-webkit-scrollbar{display:none}
  .baji-style-shop--v2 .baji-style-shop__card{
    flex:0 0 82%;
    width:82%;
    scroll-snap-align:start;
    border-radius:17px;
  }
  .baji-style-shop--v2 .baji-style-shop__card-image{
    aspect-ratio:4/4.7;
  }
  .baji-style-shop--v2 .baji-style-shop__card-body{
    padding:12px;
  }
  .baji-style-shop--v2 .baji-style-shop__name{
    min-height:0;
    font-size:13px;
  }
  .baji-style-shop--v2 .baji-style-shop__price{
    min-height:34px;
    font-size:12px;
  }
  .baji-style-shop--v2 .baji-style-shop__buy{
    min-height:40px;
    margin-top:8px;
    font-size:10.5px;
  }
}
</style>

<!-- =================== مجله باجی — Mobile-first V2 =================== -->
<section class="baji-blog-posts baji-mag-v2" aria-labelledby="baji-mag-title">
  <div class="baji-mag-v2__shell">

    <header class="baji-mag-v2__head">
      <div class="baji-mag-v2__eyebrow">BAJI MAG</div>
      <h2 id="baji-mag-title">مجله باجی</h2>
      <p>ایده‌های کاربردی برای انتخاب لباس، استایل و خرید بهتر</p>
    </header>

    <nav class="baji-mag-v2__chips" aria-label="دسته‌های مجله">
      <a href="<?php echo esc_url( home_url('/category/%d8%b1%d8%a7%d9%87%d9%86%d9%85%d8%a7%db%8c-%d8%a7%d8%b3%d8%aa%d8%a7%db%8c%d9%84/') ); ?>"><i class="fa-solid fa-shirt"></i><span>راهنمای استایل</span></a>
      <a href="<?php echo esc_url( home_url('/mag/') ); ?>"><i class="fa-regular fa-lightbulb"></i><span>نکات کاربردی</span></a>
      <a href="<?php echo esc_url( home_url('/mag/') ); ?>"><i class="fa-regular fa-gem"></i><span>ترندها</span></a>
      <a href="<?php echo esc_url( home_url('/mag/') ); ?>"><i class="fa-solid fa-book-open"></i><span>راهنمای خرید</span></a>
    </nav>

    <div class="baji-mag-v2__grid">
      <?php
      $blog_query = new WP_Query(array(
        'post_type'           => 'post',
        'posts_per_page'      => 3,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
      ));
      $baji_mag_index = 0;
      if ($blog_query->have_posts()):
        while ($blog_query->have_posts()): $blog_query->the_post();
          $baji_mag_index++;
          $categories = get_the_category();
          $is_featured = (1 === $baji_mag_index);
      ?>
      <article class="baji-mag-v2__card <?php echo $is_featured ? 'is-featured' : 'is-compact'; ?>">
        <a href="<?php the_permalink(); ?>" class="baji-mag-v2__image">
          <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail(
              $is_featured ? 'large' : 'medium_large',
              array(
                'class'   => 'baji-mag-v2__img',
                'loading' => 'lazy',
                'alt'     => the_title_attribute(array('echo' => false)),
              )
            ); ?>
          <?php else: ?>
            <div class="baji-mag-v2__placeholder"><i class="fa-regular fa-image"></i></div>
          <?php endif; ?>

          <?php if (!empty($categories)): ?>
            <span class="baji-mag-v2__category"><?php echo esc_html($categories[0]->name); ?></span>
          <?php endif; ?>
        </a>

        <div class="baji-mag-v2__content">
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

          <p class="baji-mag-v2__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), $is_featured ? 20 : 14, '...')); ?></p>

          <div class="baji-mag-v2__meta">
            <span><i class="fa-regular fa-calendar"></i><?php echo esc_html(get_the_date('Y/m/d')); ?></span>
            <a href="<?php the_permalink(); ?>">مطالعه <i class="fa-solid fa-arrow-left"></i></a>
          </div>
        </div>
      </article>
      <?php endwhile; else: ?>
        <div class="baji-mag-v2__empty">هنوز مقاله‌ای منتشر نشده است.</div>
      <?php endif; wp_reset_postdata(); ?>
    </div>

    <a href="<?php echo esc_url(home_url('/mag/')); ?>" class="baji-mag-v2__all">
      <span>مشاهده همه مطالب مجله باجی</span>
      <i class="fa-solid fa-arrow-left"></i>
    </a>
  </div>
</section>

<style id="baji-mag-v2-style">
.baji-mag-v2{background:#fff7f5;padding:34px 0 38px;direction:rtl}
.baji-mag-v2__shell{width:min(100% - 28px,1400px);margin:0 auto}
.baji-mag-v2__head{text-align:right;margin-bottom:18px}
.baji-mag-v2__eyebrow{font-size:11px;font-weight:900;letter-spacing:.2em;color:#b78c7d;margin-bottom:5px}
.baji-mag-v2__head h2{margin:0;color:#2e211e;font-size:28px;line-height:1.35;font-weight:950}
.baji-mag-v2__head p{margin:5px 0 0;color:#7d6d67;font-size:13px;line-height:1.9}
.baji-mag-v2__chips{display:flex;gap:8px;overflow-x:auto;padding:1px 0 12px;margin-bottom:10px;scrollbar-width:none;-webkit-overflow-scrolling:touch}
.baji-mag-v2__chips::-webkit-scrollbar{display:none}
.baji-mag-v2__chips a{flex:0 0 auto;display:inline-flex;align-items:center;gap:7px;min-height:38px;padding:0 13px;background:#fff;border:1px solid #eaded8;border-radius:999px;color:#5f504a;text-decoration:none!important;font-size:11px;font-weight:850;white-space:nowrap}
.baji-mag-v2__chips i{color:#9b6a61;font-size:13px}
.baji-mag-v2__grid{display:grid;gap:12px}
.baji-mag-v2__card{background:#fff;border:1px solid #eee2dd;border-radius:20px;overflow:hidden;box-shadow:0 7px 22px rgba(73,50,42,.06)}
.baji-mag-v2__image{position:relative;display:block;overflow:hidden;background:#efe5e0}
.baji-mag-v2__img{display:block;width:100%;height:100%;object-fit:cover;transition:transform .35s ease}
.baji-mag-v2__card:hover .baji-mag-v2__img{transform:scale(1.025)}
.baji-mag-v2__category{position:absolute;top:10px;right:10px;background:rgba(255,255,255,.92);backdrop-filter:blur(4px);padding:5px 9px;border-radius:999px;color:#65524b;font-size:9px;font-weight:900}
.baji-mag-v2__content{padding:14px}
.baji-mag-v2__content h3{margin:0;color:#2f201d;font-size:16px;line-height:1.75;font-weight:950}
.baji-mag-v2__content h3 a{color:inherit;text-decoration:none!important}
.baji-mag-v2__excerpt{margin:7px 0 0;color:#7a6b65;font-size:12px;line-height:1.9}
.baji-mag-v2__meta{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:12px;padding-top:11px;border-top:1px solid #f0e6e2;color:#8b7b74;font-size:10px}
.baji-mag-v2__meta span,.baji-mag-v2__meta a{display:inline-flex;align-items:center;gap:5px}
.baji-mag-v2__meta a{color:#7b1327;text-decoration:none!important;font-weight:900}
.baji-mag-v2__meta a i{font-size:8px}
.baji-mag-v2__card.is-featured .baji-mag-v2__image{aspect-ratio:16/10}
.baji-mag-v2__card.is-compact{display:grid;grid-template-columns:40% 1fr;min-height:132px}
.baji-mag-v2__card.is-compact .baji-mag-v2__image{height:100%;min-height:132px}
.baji-mag-v2__card.is-compact .baji-mag-v2__content{padding:12px;display:flex;flex-direction:column;justify-content:center}
.baji-mag-v2__card.is-compact .baji-mag-v2__content h3{font-size:13px;line-height:1.75;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.baji-mag-v2__card.is-compact .baji-mag-v2__excerpt{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin:5px 0 0;font-size:10.5px;line-height:1.8;color:#81716a}
.baji-mag-v2__card.is-compact .baji-mag-v2__meta{margin-top:auto;padding-top:8px;font-size:9px}
.baji-mag-v2__card.is-compact .baji-mag-v2__category{font-size:8px;padding:4px 7px;top:7px;right:7px}
.baji-mag-v2__all{margin-top:16px;min-height:48px;border-radius:14px;background:#7b1327;color:#fff!important;display:flex;align-items:center;justify-content:center;gap:10px;text-decoration:none!important;font-size:12px;font-weight:950;box-shadow:0 8px 18px rgba(123,19,39,.14)}
.baji-mag-v2__empty{background:#fff;border-radius:18px;padding:28px;text-align:center;color:#7f716b;font-size:13px}
@media(min-width:768px){
  .baji-mag-v2{padding:58px 0 64px}
  .baji-mag-v2__shell{width:min(100% - 64px,1400px)}
  .baji-mag-v2__head{margin-bottom:24px}
  .baji-mag-v2__head h2{font-size:42px}
  .baji-mag-v2__head p{font-size:15px}
  .baji-mag-v2__chips{gap:12px;margin-bottom:20px;overflow:visible}
  .baji-mag-v2__chips a{min-height:44px;padding:0 17px;font-size:13px}
  .baji-mag-v2__grid{grid-template-columns:minmax(0,1.5fr) minmax(330px,.72fr);grid-template-rows:1fr 1fr;gap:18px}
  .baji-mag-v2__card.is-featured{grid-row:1/3}
  .baji-mag-v2__card.is-featured .baji-mag-v2__image{aspect-ratio:16/9}
  .baji-mag-v2__card.is-featured .baji-mag-v2__content{padding:20px 22px}
  .baji-mag-v2__card.is-featured .baji-mag-v2__content h3{font-size:22px}
  .baji-mag-v2__card.is-featured .baji-mag-v2__excerpt{font-size:14px}
  .baji-mag-v2__card.is-compact{grid-template-columns:42% 1fr;min-height:0}
  .baji-mag-v2__card.is-compact .baji-mag-v2__image{min-height:0}
  .baji-mag-v2__card.is-compact .baji-mag-v2__content h3{font-size:16px}
  .baji-mag-v2__all{width:max-content;min-width:310px;margin:24px auto 0;padding:0 24px;font-size:14px;border-radius:999px}
}
</style>

	<!-- BAJI Basalam credit banner -->
	<section class="baji-basalam-credit" aria-label="خرید با اعتبار باسلام">
		<div class="baji-basalam-credit__wrap">
			<a class="baji-basalam-credit__card" href="https://basalam.com/user/xYZL2l?utm_source=share&utm_medium=copy&user_hash_id=xYZL2l&from_component=profile-app" target="_blank" rel="noopener noreferrer sponsored">
				<div class="baji-basalam-credit__brand">
					<strong>BAJI</strong>
					<span>WOMEN'S FASHION</span>
				</div>
				<div class="baji-basalam-credit__copy">
					<strong>اعتبار باسلام داری؟</strong>
					<span>با اعتبارت از باجی خرید کن!</span>
				</div>
				<span class="baji-basalam-credit__cta">مشاهده غرفه در باسلام</span>
			</a>
		</div>
	</section>
	<style id="baji-basalam-credit-style">
	.baji-basalam-credit{background:#fffaf8;padding:14px 0 18px;direction:rtl}
	.baji-basalam-credit__wrap{width:min(100% - 32px,1400px);margin:0 auto}
	.baji-basalam-credit__card{position:relative;min-height:118px;display:grid;grid-template-columns:150px 1fr auto;align-items:center;gap:22px;padding:22px 30px;border-radius:18px;overflow:hidden;background:linear-gradient(110deg,#174b3d 0%,#24614f 54%,#2d6b58 100%);box-shadow:0 10px 28px rgba(23,75,61,.18);text-decoration:none!important;color:#fff!important}
	.baji-basalam-credit__card:before,.baji-basalam-credit__card:after{content:"";position:absolute;border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none}
	.baji-basalam-credit__card:before{width:180px;height:180px;right:-65px;top:-85px}.baji-basalam-credit__card:after{width:150px;height:150px;left:18%;bottom:-110px}
	.baji-basalam-credit__brand,.baji-basalam-credit__copy,.baji-basalam-credit__cta{position:relative;z-index:1}
	.baji-basalam-credit__brand{direction:ltr;text-align:center;border-left:1px solid rgba(255,255,255,.25);padding-left:22px}
	.baji-basalam-credit__brand strong{display:block;font-family:serif;font-size:31px;letter-spacing:.16em;line-height:1;color:#fff}
	.baji-basalam-credit__brand span{display:block;margin-top:7px;font-size:7px;letter-spacing:.17em;color:#e9d9c5}
	.baji-basalam-credit__copy{text-align:right}
	.baji-basalam-credit__copy strong{display:block;font-size:25px;font-weight:900;line-height:1.45;color:#fff}
	.baji-basalam-credit__copy span{display:block;margin-top:4px;font-size:15px;font-weight:800;color:#f5e7d5}
	.baji-basalam-credit__cta{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 22px;border-radius:999px;background:#fff;color:#1c5545;font-size:12px;font-weight:900;white-space:nowrap;box-shadow:0 7px 18px rgba(0,0,0,.12)}
	@media(max-width:767px){.baji-basalam-credit{padding:10px 0 14px}.baji-basalam-credit__wrap{width:calc(100% - 24px)}.baji-basalam-credit__card{min-height:102px;grid-template-columns:78px 1fr;gap:12px;padding:14px 14px;border-radius:14px}.baji-basalam-credit__brand{padding-left:12px}.baji-basalam-credit__brand strong{font-size:20px}.baji-basalam-credit__brand span{font-size:5px;margin-top:4px}.baji-basalam-credit__copy strong{font-size:17px}.baji-basalam-credit__copy span{font-size:11px;margin-top:2px}.baji-basalam-credit__cta{grid-column:1/-1;min-height:34px;padding:0 15px;font-size:10px;justify-self:center;margin-top:-2px}}
	</style>

</div>

<?php
get_footer();
