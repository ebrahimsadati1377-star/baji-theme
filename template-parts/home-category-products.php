<?php
/**
 * اسلایدرهای محصولات انتخاب‌شده بر اساس دسته‌بندی در صفحه اصلی.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) {
	return;
}

for ( $slot = 1; $slot <= 3; $slot++ ) :
	$term_id = absint( get_theme_mod( 'bajistyle_home_category_' . $slot, 0 ) );

	if ( 0 === $term_id ) {
		continue;
	}

	$term = get_term( $term_id, 'product_cat' );
	if ( ! $term || is_wp_error( $term ) ) {
		continue;
	}

	$custom_title = sanitize_text_field( get_theme_mod( 'bajistyle_home_category_title_' . $slot, '' ) );
	$section_title = '' !== $custom_title ? $custom_title : $term->name;
	$product_limit = absint( get_theme_mod( 'bajistyle_home_category_limit_' . $slot, 12 ) );
	$product_limit = min( 24, max( 4, $product_limit ) );
	$term_link     = get_term_link( $term );
	?>
	<section class="baji-category-products py-12 md:py-16 bg-baji-cream" data-category="<?php echo esc_attr( $term->slug ); ?>">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="flex flex-row items-center justify-between gap-4 mb-8 md:mb-12">
				<div>
					<h2 class="text-xl sm:text-2xl md:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight">
						<?php echo esc_html( $section_title ); ?>
					</h2>
				</div>

				<?php if ( ! is_wp_error( $term_link ) ) : ?>
					<a href="<?php echo esc_url( $term_link ); ?>" class="group flex items-center gap-1.5 md:gap-2 text-xs md:text-base font-medium text-gray-600 hover:text-gray-900 transition-colors duration-300 shrink-0">
						<span><?php esc_html_e( 'همه', 'bajistyle' ); ?></span>
						<i class="fa-solid fa-arrow-left text-xs md:text-sm transform group-hover:-translate-x-1.5 transition-transform duration-300"></i>
					</a>
				<?php endif; ?>
			</div>

			<div class="swiper baji-products-slider overflow-hidden relative pb-12">
				<?php
				get_template_part(
					'template-parts/product-grid',
					null,
					array(
						'query_type'    => 'category',
						'category_slug' => $term->slug,
						'limit'         => $product_limit,
						'is_slider'     => true,
					)
				);
				?>
				<div class="swiper-pagination !bottom-0"></div>
			</div>
		</div>
	</section>
<?php endfor; ?>
