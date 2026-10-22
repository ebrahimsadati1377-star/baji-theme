<?php
/**
 * اسلایدرهای محصولات انتخاب‌شده بر اساس دسته‌بندی در صفحه اصلی.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) {
	return;
}

// بنر خرید اقساطی بلافاصله بعد از بخش جدیدترین محصولات.
get_template_part( 'template-parts/installment-banner' );

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
	<section class="baji-category-products py-5 md:py-12 bg-baji-cream" data-category="<?php echo esc_attr( $term->slug ); ?>">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="baji-section-head">
				<div class="baji-section-head__copy">
					<span class="baji-section-head__eyebrow"><?php esc_html_e( 'دسته‌بندی منتخب', 'bajistyle' ); ?></span>
					<h2 class="baji-section-head__title"><?php echo esc_html( $section_title ); ?></h2>
				</div>

				<?php if ( ! is_wp_error( $term_link ) ) : ?>
					<a href="<?php echo esc_url( $term_link ); ?>" class="baji-section-head__link">
						<span><?php esc_html_e( 'مشاهده همه', 'bajistyle' ); ?></span>
						<i class="fa-solid fa-arrow-left"></i>
					</a>
				<?php endif; ?>
			</div>

			<div class="swiper baji-products-slider overflow-hidden relative pb-5 md:pb-10">
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
