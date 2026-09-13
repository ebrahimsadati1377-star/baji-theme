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
<section class="baji-blog-posts baji-mag-home py-10 md:py-16 bg-[#fbe4e6]">
  <div class="max-w-[1400px] mx-auto px-4 md:px-8">

    <div class="baji-mag-head flex items-center justify-between gap-4 mb-6 md:mb-8">
      <div>
        <div class="text-[11px] md:text-sm font-bold text-[#b28a72] tracking-[.18em] mb-1">BAJI MAG</div>
        <h2 class="text-2xl md:text-4xl font-black text-[#2d211e] leading-tight">مجله باجی</h2>
        <p class="text-xs md:text-base text-[#7f716b] mt-1">قصه‌ی استایل، کیفیت و الهام برای تو</p>
      </div>
      <a href="<?php echo esc_url( home_url( '/mag/' ) ); ?>" class="inline-flex items-center gap-2 border border-[#dfd4ce] rounded-full px-4 py-2.5 bg-white text-xs md:text-sm font-bold text-[#3f3531] hover:border-[#7b1327] hover:text-[#7b1327] transition-colors">
        <span>مشاهده همه مقالات</span><i class="fa-solid fa-arrow-left text-[10px]"></i>
      </a>
    </div>

    <div class="baji-mag-strip grid grid-cols-4 gap-2 md:gap-4 mb-6 md:mb-8">
      <a href="<?php echo esc_url( home_url('/category/%d8%b1%d8%a7%d9%87%d9%86%d9%85%d8%a7%db%8c-%d8%a7%d8%b3%d8%aa%d8%a7%db%8c%d9%84/') ); ?>" class="bg-[#f7eee8] rounded-2xl py-3 px-2 text-center text-[10px] md:text-sm font-bold text-[#65534c]"><i class="fa-solid fa-shirt block text-lg mb-1"></i>راهنمای استایل</a>
      <a href="<?php echo esc_url( home_url('/mag/') ); ?>" class="bg-[#f7eee8] rounded-2xl py-3 px-2 text-center text-[10px] md:text-sm font-bold text-[#65534c]"><i class="fa-regular fa-lightbulb block text-lg mb-1"></i>نکات کاربردی</a>
      <a href="<?php echo esc_url( home_url('/mag/') ); ?>" class="bg-[#f7eee8] rounded-2xl py-3 px-2 text-center text-[10px] md:text-sm font-bold text-[#65534c]"><i class="fa-regular fa-gem block text-lg mb-1"></i>ترندها</a>
      <a href="<?php echo esc_url( home_url('/mag/') ); ?>" class="bg-[#f7eee8] rounded-2xl py-3 px-2 text-center text-[10px] md:text-sm font-bold text-[#65534c]"><i class="fa-solid fa-book-open block text-lg mb-1"></i>راهنمای خرید</a>
    </div>

    <div class="baji-mag-grid grid grid-cols-2 gap-3 md:gap-6">
      <?php
      $blog_query = new WP_Query(array(
        'post_type'=>'post','posts_per_page'=>2,'post_status'=>'publish',
        'orderby'=>'date','order'=>'DESC','ignore_sticky_posts'=>true,'no_found_rows'=>true,
      ));
      if($blog_query->have_posts()):
        while($blog_query->have_posts()): $blog_query->the_post();
          $categories=get_the_category();
      ?>
      <article class="group bg-[#fffaf8] rounded-[22px] overflow-hidden border border-[#eaded8] shadow-[0_8px_24px_rgba(79,47,42,.07)] flex flex-col">
        <a href="<?php the_permalink(); ?>" class="block relative aspect-[4/3] md:aspect-[16/9] overflow-hidden bg-[#efe3dc]">
          <?php if(has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium_large',array('class'=>'w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]','loading'=>'lazy')); ?>
          <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-[#b7a69d]"><i class="fa-regular fa-image text-3xl"></i></div>
          <?php endif; ?>
          <?php if(!empty($categories)): ?>
          <span class="absolute top-3 right-3 bg-[#fff8f4]/95 backdrop-blur px-3 py-1 rounded-full text-[9px] md:text-xs font-bold text-[#4b302d] border border-[#e1cfc6]"><?php echo esc_html($categories[0]->name); ?></span>
          <?php endif; ?>
        </a>
        <div class="p-3.5 md:p-5 flex flex-col flex-1">
          <h3 class="text-sm md:text-xl font-black text-[#321d1c] leading-[1.75] md:leading-[1.6] line-clamp-2 mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="hidden md:block text-sm text-[#756a66] leading-7 line-clamp-2 mb-4"><?php echo esc_html(wp_trim_words(get_the_excerpt(),24,'...')); ?></p>
          <div class="mt-auto flex items-center justify-between pt-3 border-t border-[#eee1dc] text-[10px] md:text-xs text-[#76645f]">
            <span class="flex items-center gap-1"><i class="fa-regular fa-calendar"></i><?php echo esc_html(get_the_date('Y/m/d')); ?></span>
            <a href="<?php the_permalink(); ?>" class="font-bold text-[#7b1327] flex items-center gap-1">مطالعه مقاله <i class="fa-solid fa-arrow-left text-[9px]"></i></a>
          </div>
        </div>
      </article>
      <?php endwhile; else: ?>
        <div class="col-span-2 bg-white rounded-2xl p-8 text-center text-sm text-gray-500">هنوز مقاله‌ای منتشر نشده است.</div>
      <?php endif; wp_reset_postdata(); ?>
    </div>

    <div class="mt-6 md:mt-8">
      <a href="<?php echo esc_url(home_url('/mag/')); ?>" class="w-full md:w-auto md:min-w-[340px] mx-auto flex items-center justify-between gap-5 rounded-full bg-[#c79494] hover:bg-[#b98282] text-white px-6 py-4 text-sm md:text-base font-black transition-colors">
        <span>باجی مگ</span><span>مشاهده همه ←</span>
      </a>
    </div>
  </div>
</section>

</div>

<?php
get_footer();
