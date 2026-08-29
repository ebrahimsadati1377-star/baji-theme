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

	<?php get_template_part( 'template-parts/hero-section' ); ?>

	<?php get_template_part( 'template-parts/category-showcase' ); ?>

	<!-- =================== بخش اول: جدیدترین محصولات =================== -->
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

	<!-- =================== بخش سوم: آخرین مقالات و مجله =================== -->
	<section class="baji-blog-posts py-12 md:py-16 bg-baji-cream">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="flex flex-row items-end justify-between gap-4 mb-8 md:mb-12">
				<div class="max-w-2xl">
					<div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3">
						<span class="w-6 md:w-10 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-[10px] md:text-sm font-bold tracking-[0.15em] md:tracking-[0.2em] uppercase"><?php esc_html_e( 'مجله باجی‌استایل', 'bajistyle' ); ?></span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight mb-2"><?php esc_html_e( 'استایل را بهتر بشناس', 'bajistyle' ); ?></h2>
					<p class="hidden md:block text-sm md:text-base text-gray-500 leading-relaxed"><?php esc_html_e( 'راهنمای انتخاب، ست‌کردن و شناخت ترندها برای خریدی مطمئن‌تر و استایلی شخصی‌تر.', 'bajistyle' ); ?></p>
				</div>

				<?php
				$blog_page_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
				?>
				<a href="<?php echo esc_url( $blog_page_url ); ?>" class="group flex items-center gap-2 text-xs md:text-sm font-bold text-gray-700 hover:text-baji-gold transition-colors duration-300 shrink-0">
					<span><?php esc_html_e( 'مشاهده همه', 'bajistyle' ); ?></span>
					<span class="w-8 h-8 md:w-10 md:h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center group-hover:border-baji-gold transition-colors duration-300">
						<i class="fa-solid fa-arrow-left text-[10px] md:text-xs transform group-hover:-translate-x-1 transition-transform duration-300"></i>
					</span>
				</a>
			</div>

			<div class="swiper baji-products-slider overflow-hidden relative pb-12">
				<div class="swiper-wrapper">
					<?php
					$blog_args = array(
						'post_type'           => 'post',
						'posts_per_page'      => 6,
						'post_status'         => 'publish',
						'orderby'             => 'date',
						'order'               => 'DESC',
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					);
					$blog_query = new WP_Query( $blog_args );

					if ( $blog_query->have_posts() ) :
						while ( $blog_query->have_posts() ) :
							$blog_query->the_post();
							$categories = get_the_category();
							?>
							<div class="swiper-slide h-auto">
								<article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full border border-gray-100">
									<a href="<?php the_permalink(); ?>" class="block relative aspect-[16/10] overflow-hidden bg-gray-100">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500', 'loading' => 'lazy' ) ); ?>
										<?php else : ?>
											<div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
												<div class="text-center">
													<i class="fa-regular fa-image text-2xl mb-2"></i>
													<span class="block text-xs font-bold"><?php esc_html_e( 'مجله باجی‌استایل', 'bajistyle' ); ?></span>
												</div>
											</div>
										<?php endif; ?>

										<div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-70 group-hover:opacity-90 transition-opacity duration-300"></div>

										<?php if ( ! empty( $categories ) ) : ?>
											<span class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] md:text-[11px] font-bold text-gray-800 shadow-sm"><?php echo esc_html( $categories[0]->name ); ?></span>
										<?php endif; ?>

										<span class="absolute bottom-3 right-3 text-[10px] md:text-[11px] font-medium text-white flex items-center gap-1.5">
											<i class="fa-regular fa-calendar"></i>
											<?php echo esc_html( get_the_date( 'j F Y' ) ); ?>
										</span>
									</a>

									<div class="p-4 md:p-5 flex flex-col flex-grow">
										<h3 class="text-base md:text-lg font-black text-gray-900 group-hover:text-baji-gold transition-colors duration-300 line-clamp-2 mb-3 leading-snug">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<p class="text-xs md:text-sm text-gray-500 line-clamp-2 leading-relaxed mb-5"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?></p>
										<a href="<?php the_permalink(); ?>" class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-gray-700 group-hover:text-baji-gold transition-colors duration-300">
											<span><?php esc_html_e( 'مطالعه مقاله', 'bajistyle' ); ?></span>
											<span class="w-7 h-7 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-baji-gold group-hover:text-white transition-all duration-300">
												<i class="fa-solid fa-arrow-left text-[9px] transform group-hover:-translate-x-0.5 transition-transform duration-300"></i>
											</span>
										</a>
									</div>
								</article>
							</div>
						<?php
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<div class="w-full text-center text-gray-500 py-10">
							<i class="fa-regular fa-file-lines text-2xl mb-3"></i>
							<p><?php esc_html_e( 'هنوز مقاله‌ای منتشر نشده است.', 'bajistyle' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				<div class="swiper-pagination !bottom-0"></div>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/testimonial' ); ?>

</div><!-- .baji-front-page -->

<?php
get_footer();