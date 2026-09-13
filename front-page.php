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

<div class="baji-front-page">

	<?php get_template_part( 'template-parts/product-stories' ); ?>

	<?php get_template_part( 'template-parts/hero-section' ); ?>

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

	<!-- =================== بخش سوم: مجله باجی =================== -->
<section class="baji-blog-posts baji-mag-home py-10 md:py-16">
  <div class="max-w-[1400px] mx-auto px-4 md:px-8">
    <div class="baji-mag-head text-center mb-7 md:mb-10">
      <div class="text-[11px] md:text-sm font-bold tracking-[.32em] text-[#a9826e] mb-2">BAJI MAG</div>
      <h2 class="text-3xl md:text-5xl font-black text-[#2b1717] leading-tight">مجله باجی</h2>
      <p class="text-sm md:text-lg text-[#706663] mt-2">مقالات، راهنمای استایل و نکات کاربردی برای داشتن استایلی بهتر</p>
    </div>

    <div class="baji-mag-strip grid grid-cols-4 gap-2 md:gap-8 mb-7 md:mb-10 max-w-[900px] mx-auto">
      <a href="<?php echo esc_url(home_url('/category/%d8%b1%d8%a7%d9%87%d9%86%d9%85%d8%a7%db%8c-%d8%a7%d8%b3%d8%aa%d8%a7%db%8c%d9%84/')); ?>" class="baji-mag-topic"><span><i class="fa-solid fa-shirt"></i></span>راهنمای استایل</a>
      <a href="<?php echo esc_url(home_url('/mag/')); ?>" class="baji-mag-topic"><span><i class="fa-regular fa-gem"></i></span>معرفی ترندها</a>
      <a href="<?php echo esc_url(home_url('/mag/')); ?>" class="baji-mag-topic"><span><i class="fa-regular fa-lightbulb"></i></span>نکات کاربردی</a>
      <a href="<?php echo esc_url(home_url('/mag/')); ?>" class="baji-mag-topic"><span><i class="fa-solid fa-book-open"></i></span>راهنمای خرید</a>
    </div>

    <div class="baji-mag-grid grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-7">
      <?php
      $blog_query=new WP_Query(array('post_type'=>'post','posts_per_page'=>2,'post_status'=>'publish','orderby'=>'date','order'=>'DESC','ignore_sticky_posts'=>true,'no_found_rows'=>true));
      if($blog_query->have_posts()):
        while($blog_query->have_posts()): $blog_query->the_post();
          $categories=get_the_category();
      ?>
      <article class="baji-mag-card group flex flex-col">
        <a href="<?php the_permalink(); ?>" class="baji-mag-image block relative aspect-[16/9] overflow-hidden">
          <?php if(has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium_large',array('class'=>'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]','loading'=>'lazy')); ?>
          <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-[#b7a69d]"><i class="fa-regular fa-image text-3xl"></i></div>
          <?php endif; ?>
          <?php if(!empty($categories)): ?><span class="baji-mag-tag"><?php echo esc_html($categories[0]->name); ?></span><?php endif; ?>
        </a>
        <div class="baji-mag-body p-4 md:p-6 flex flex-col flex-1">
          <h3 class="text-base md:text-xl font-black leading-[1.8] md:leading-[1.7] mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="text-xs md:text-sm leading-7 md:leading-8 line-clamp-2 mb-4"><?php echo esc_html(wp_trim_words(get_the_excerpt(),28,'...')); ?></p>
          <div class="baji-mag-meta mt-auto flex items-center justify-between pt-3 text-[10px] md:text-xs">
            <a href="<?php the_permalink(); ?>" class="font-black flex items-center gap-2"><i class="fa-solid fa-arrow-left text-[9px]"></i>مطالعه مقاله</a>
            <span class="flex items-center gap-2"><?php echo esc_html(get_the_date('Y/m/d')); ?><i class="fa-regular fa-calendar text-sm"></i></span>
          </div>
        </div>
      </article>
      <?php endwhile; else: ?>
        <div class="md:col-span-2 rounded-2xl p-8 text-center text-sm">هنوز مقاله‌ای منتشر نشده است.</div>
      <?php endif; wp_reset_postdata(); ?>
    </div>

    <div class="mt-7 md:mt-10 text-center">
      <a href="<?php echo esc_url(home_url('/mag/')); ?>" class="baji-mag-all inline-flex items-center justify-center gap-5 rounded-full px-8 md:px-12 py-3.5 md:py-4 text-sm md:text-base font-black">مشاهده همه مقالات <i class="fa-solid fa-arrow-left text-xs"></i></a>
    </div>
  </div>
</section>

<style id="baji-mag-reference-theme">
.baji-mag-home{background:#fbf3ee!important;position:relative;overflow:hidden}
.baji-mag-home:before,.baji-mag-home:after{content:"";position:absolute;border-radius:50%;background:rgba(211,166,166,.10);filter:blur(2px);pointer-events:none}
.baji-mag-home:before{width:300px;height:300px;right:-150px;top:-120px}.baji-mag-home:after{width:340px;height:180px;left:-100px;bottom:-100px}
.baji-mag-home>div{position:relative;z-index:1}
.baji-mag-topic{display:flex;flex-direction:column;align-items:center;gap:8px;color:#625654;font-weight:700;font-size:12px}
.baji-mag-topic span{width:58px;height:58px;border-radius:50%;background:#f4e8e1;color:#9b725e;display:flex;align-items:center;justify-content:center;font-size:23px}
.baji-mag-card{background:#fffaf8!important;border:1px solid #eaded8!important;border-radius:20px!important;overflow:hidden!important;box-shadow:0 8px 24px rgba(79,47,42,.07)!important}
.baji-mag-image{background:#efe3dc!important}.baji-mag-tag{position:absolute;top:14px;right:14px;background:rgba(255,248,244,.94);color:#4b302d;border:1px solid rgba(225,207,198,.8);border-radius:999px;padding:7px 14px;font-size:11px;font-weight:800}
.baji-mag-body{background:#fffaf8!important}.baji-mag-body h3{color:#321d1c!important}.baji-mag-body p{color:#756a66!important}.baji-mag-meta{border-top:1px solid #eee1dc!important;color:#76645f!important}.baji-mag-meta a{color:#4d2928!important}
.baji-mag-all{background:#d1a09d!important;color:#432522!important;box-shadow:0 7px 18px rgba(122,72,68,.10)}.baji-mag-all:hover{background:#c58f8d!important}
@media(max-width:767px){.baji-mag-home{padding-top:34px!important;padding-bottom:38px!important}.baji-mag-topic{font-size:9px;gap:6px}.baji-mag-topic span{width:45px;height:45px;font-size:18px}.baji-mag-card{border-radius:17px!important}.baji-mag-tag{top:10px;right:10px;padding:5px 10px;font-size:9px}.baji-mag-body p{display:none}.baji-mag-meta{padding-top:10px}.baji-mag-all{width:80%;max-width:330px}}
</style>
</div>

<?php
get_footer();
