<?php
/**
 * فایل تک‌نوشته (Single Post) قالب BajiStyle
 *
 * توجه: این فایل برای نمایش نوشته‌های وبلاگ (post type: post) استفاده
 * می‌شود. صفحه تکی محصول ووکامرس از فایل اختصاصی
 * woocommerce/single-product.php استفاده می‌کند که در سلسله‌مراتب
 * قالب ووکامرس اولویت بالاتری دارد.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<!-- استایل اختصاصی برای انیمیشن باز شدن صفحه -->
<style>
@keyframes bajiFadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-baji-fade-up {
    animation: bajiFadeUp 0.8s ease-out forwards;
}
</style>

<div class="baji-content-wrapper max-w-[1400px] mx-auto px-4 md:px-8 py-8 md:py-12 animate-baji-fade-up">

	<?php bajistyle_breadcrumb(); ?>

	<?php
	while ( have_posts() ) :
		the_post();

		// محتوای اصلی نوشته
		get_template_part( 'template-parts/content', 'single' );

		// بیوگرافی نویسنده
		get_template_part( 'template-parts/author-bio' );

		// نمایش نوشته‌های مرتبط بر اساس دسته‌بندی مشترک
		$related_categories = wp_get_post_categories( get_the_ID() );
		if ( ! empty( $related_categories ) ) :
			$related_query = new WP_Query(
				array(
					'category__in'        => $related_categories,
					'post__not_in'        => array( get_the_ID() ),
					'posts_per_page'      => 3,
					'ignore_sticky_posts' => true,
				)
			);

			if ( $related_query->have_posts() ) :
				?>
				<section class="baji-related-posts max-w-[1200px] mx-auto mt-20 pt-16 border-t border-gray-100/60">
					
                    <!-- هدر مطالب مرتبط -->
                    <div class="flex flex-col items-center justify-center text-center mb-10 md:mb-14">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-8 h-[2px] bg-baji-gold rounded-full"></span>
                            <span class="text-baji-gold text-xs font-bold tracking-[0.2em] uppercase">
                                <?php esc_html_e( 'بیشتر بخوانید', 'bajistyle' ); ?>
                            </span>
                            <span class="w-8 h-[2px] bg-baji-gold rounded-full"></span>
                        </div>
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-900 tracking-tight">
                            <?php esc_html_e( 'مطالب مرتبط', 'bajistyle' ); ?>
                        </h2>
                    </div>

                    <!-- گرید مطالب مرتبط (شبیه کارت‌های صفحه اصلی) -->
					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
						<?php
						while ( $related_query->have_posts() ) :
							$related_query->the_post();
							?>
                            <!-- کارت مقاله -->
                            <article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full border border-gray-100/80 transform hover:-translate-y-1">
                                
                                <!-- تصویر مقاله -->
                                <a href="<?php the_permalink(); ?>" class="block relative aspect-[16/10] overflow-hidden bg-gray-100">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out' ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                    
                                    <!-- تاریخ روی عکس -->
                                    <div class="absolute bottom-3 right-3 bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-full text-[11px] font-bold text-gray-700 shadow-sm">
                                        <?php echo get_the_date( 'j F Y' ); ?>
                                    </div>
                                </a>

                                <!-- اطلاعات مقاله -->
                                <div class="p-5 flex flex-col flex-grow justify-between">
                                    <div>
                                        <h3 class="text-base md:text-lg font-bold text-gray-900 group-hover:text-baji-gold transition-colors duration-300 line-clamp-2 mb-3 leading-snug">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        <p class="text-xs md:text-sm text-gray-500 line-clamp-2 leading-relaxed mb-4">
                                            <?php echo wp_trim_words( get_the_excerpt(), 18, '...' ); ?>
                                        </p>
                                    </div>
                                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between text-xs font-semibold text-gray-700 group-hover:text-baji-gold transition-colors">
                                        <span><?php esc_html_e( 'ادامه مطلب', 'bajistyle' ); ?></span>
                                        <i class="fa-solid fa-arrow-left text-[10px] transform group-hover:-translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </article>

						<?php endwhile; ?>
					</div>
				</section>
				<?php
				wp_reset_postdata();
			endif;
		endif;

		// نمایش بخش کامنت‌ها با یک طراحی ظرف‌بندی شده (Container)
		if ( comments_open() || get_comments_number() ) :
			?>
			<div class="baji-comments-wrapper max-w-4xl mx-auto mt-20 p-6 md:p-10 bg-white rounded-3xl shadow-sm border border-gray-100/50">
				<?php comments_template(); ?>
			</div>
			<?php
		endif;

	endwhile;
	?>

</div>

<?php
get_footer();