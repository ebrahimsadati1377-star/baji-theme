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
			
			<!-- هدر مدرن - هماهنگ در موبایل و دسکتاپ -->
			<div class="flex flex-row items-center justify-between gap-4 mb-8 md:mb-12">
				<!-- سمت راست: عناوین -->
				<div>
					<div class="flex items-center gap-2 md:gap-3 mb-1 md:mb-3">
						<span class="w-6 md:w-10 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-[10px] md:text-sm font-bold tracking-[0.15em] md:tracking-[0.2em] uppercase">
							<?php esc_html_e( 'تازه‌های فروشگاه', 'bajistyle' ); ?>
						</span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight">
						<?php esc_html_e( 'جدید های باجی', 'bajistyle' ); ?>
					</h2>
				</div>

				<!-- سمت چپ: لینک همه روبروی عنوان -->
				<a href="https://bajistyle.ir/new-products/" 
				   class="group flex items-center gap-1.5 md:gap-2 text-xs md:text-base font-medium text-gray-600 hover:text-gray-900 transition-colors duration-300 shrink-0">
					<span><?php esc_html_e( 'همه', 'bajistyle' ); ?></span>
					<i class="fa-solid fa-arrow-left text-xs md:text-sm transform group-hover:-translate-x-1.5 transition-transform duration-300"></i>
				</a>
			</div>

			<!-- کانتینر اصلی سوایپر -->
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
				<!-- نقاط پایین اسلایدر -->
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
				
				<!-- بنر اینستاگرام -->
				<a href="https://instagram.com/baji.style" target="_blank" rel="noopener noreferrer" 
				   class="group relative overflow-hidden rounded-2xl block shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-instagram2.webp" 
						 alt="اینستاگرام باجی استایل" 
						 class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500" style="border-radius: 20px !important;">
					
					<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-4 md:p-6 opacity-90 group-hover:opacity-100 transition-opacity">
						<div class="flex items-center justify-between w-full text-white">
							<i class="fa-solid fa-arrow-left text-sm md:text-base transform group-hover:-translate-x-2 transition-transform duration-300"></i>
						</div>
					</div>
				</a> 

				<!-- بنر بله / تلگرام -->
				<a href="https://ble.ir/bajistyle" target="_blank" rel="noopener noreferrer" 
				   class="group relative overflow-hidden rounded-2xl block shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-bale2.webp" 
						 alt="کانال باجی استایل" 
						 class="rounded-2xl w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500" style="border-radius: 20px !important;">
					
					<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-4 md:p-6 opacity-90 group-hover:opacity-100 transition-opacity">
						<div class="flex items-center justify-between w-full text-white">
							<i class="fa-solid fa-arrow-left text-sm md:text-base transform group-hover:-translate-x-2 transition-transform duration-300"></i>
						</div>
					</div>
				</a>

			</div>
		</div>
	</section>


	<!-- =================== بخش دوم: پرفروش‌ترین محصولات =================== -->
	<section class="baji-best-sellers py-12 md:py-16 bg-baji-cream">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			
			<!-- هدر مدرن -->
			<div class="flex flex-row items-center justify-between gap-4 mb-8 md:mb-12">
				<div>
					<div class="flex items-center gap-2 md:gap-3 mb-1 md:mb-3">
						<span class="w-6 md:w-10 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-[10px] md:text-sm font-bold tracking-[0.15em] md:tracking-[0.2em] uppercase">
							<?php esc_html_e( 'محبوب‌ترین‌ها', 'bajistyle' ); ?>
						</span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight">
						<?php esc_html_e( 'پرفروش‌ترین محصولات', 'bajistyle' ); ?>
					</h2>
				</div>

				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" 
				   class="group flex items-center gap-1.5 md:gap-2 text-xs md:text-base font-medium text-gray-600 hover:text-gray-900 transition-colors duration-300 shrink-0">
					<span><?php esc_html_e( 'همه', 'bajistyle' ); ?></span>
					<i class="fa-solid fa-arrow-left text-xs md:text-sm transform group-hover:-translate-x-1.5 transition-transform duration-300"></i>
				</a>
			</div>

			<!-- کانتینر اصلی سوایپر -->
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
			
			<!-- هدر مدرن مقالات -->
			<div class="flex flex-row items-center justify-between gap-4 mb-8 md:mb-12">
				<div>
					<div class="flex items-center gap-2 md:gap-3 mb-1 md:mb-3">
						<span class="w-6 md:w-10 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-[10px] md:text-sm font-bold tracking-[0.15em] md:tracking-[0.2em] uppercase">
							<?php esc_html_e( 'مجله باجی‌استایل', 'bajistyle' ); ?>
						</span>
					</div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight">
						<?php esc_html_e( 'آخرین خواندنی‌ها', 'bajistyle' ); ?>
					</h2>
				</div>

				<?php 
				$blog_page_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' ); 
				?>
				<a href="<?php echo esc_url( $blog_page_url ); ?>" 
				   class="group flex items-center gap-1.5 md:gap-2 text-xs md:text-base font-medium text-gray-600 hover:text-gray-900 transition-colors duration-300 shrink-0">
					<span><?php esc_html_e( 'همه مقالات', 'bajistyle' ); ?></span>
					<i class="fa-solid fa-arrow-left text-xs md:text-sm transform group-hover:-translate-x-1.5 transition-transform duration-300"></i>
				</a>
			</div>

			<!-- اسلایدر/گرید مقالات -->
			<div class="swiper baji-products-slider overflow-hidden relative pb-12">
				<div class="swiper-wrapper">
					<?php
					$blog_args = array(
						'post_type'      => 'post',
						'posts_per_page' => 6,
						'post_status'    => 'publish',
					);
					$blog_query = new WP_Query( $blog_args );

					if ( $blog_query->have_posts() ) :
						while ( $blog_query->have_posts() ) : $blog_query->the_post();
							?>
							<div class="swiper-slide h-auto">
								<article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full border border-gray-100/80">
									
									<!-- تصویر مقاله -->
									<a href="<?php the_permalink(); ?>" class="block relative aspect-[16/10] overflow-hidden bg-gray-100">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
										<?php else : ?>
											<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
										<?php endif; ?>
										
										<!-- تاریخ انتشار روی عکس -->
										<div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-gray-700 shadow-sm">
											<?php echo get_the_date( 'j F Y' ); ?>
										</div>
									</a>

									<!-- اطلاعات و خلاصه مقاله -->
									<div class="p-5 flex flex-col flex-grow justify-between">
										<div>
											<?php
											$categories = get_the_category();
											if ( ! empty( $categories ) ) :
												?>
												<span class="text-baji-gold text-[11px] font-bold mb-2 inline-block">
													<?php echo esc_html( $categories[0]->name ); ?>
												</span>
											<?php endif; ?>

											<h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-baji-gold transition-colors duration-300 line-clamp-2 mb-2 leading-snug">
												<a href="<?php the_permalink(); ?>">
													<?php the_title(); ?>
												</a>
											</h3>

											<p class="text-xs md:text-sm text-gray-500 line-clamp-2 leading-relaxed mb-4">
												<?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
											</p>
										</div>

										<div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-semibold text-gray-700 group-hover:text-baji-gold transition-colors">
											<span><?php esc_html_e( 'ادامه مطلب', 'bajistyle' ); ?></span>
											<i class="fa-solid fa-arrow-left text-[10px] transform group-hover:-translate-x-1 transition-transform"></i>
										</div>
									</div>

								</article>
							</div>
						<?php
						endwhile;
						wp_reset_postdata();
					else :
						?>
						<div class="col-span-full text-center text-gray-500 py-8">
							<?php esc_html_e( 'هنوز مقاله‌ای منتشر نشده است.', 'bajistyle' ); ?>
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
