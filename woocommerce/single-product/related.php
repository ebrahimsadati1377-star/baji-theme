<?php
/**
 * Related products slider.
 *
 * @package BajiStyle
 * @version 10.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $related_products ) {
	return;
}

$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'محصولات مشابه', 'bajistyle' ) );
?>
<section class="baji-related-products related products mt-16 pt-12 border-t border-gray-100">
	<div class="flex items-center justify-between gap-4 mb-8 md:mb-12">
		<div>
			<span class="block w-8 md:w-10 h-[2px] bg-baji-gold rounded-full mb-3"></span>
			<?php if ( $heading ) : ?>
				<h2 class="text-xl sm:text-2xl md:text-4xl font-black text-gray-900 tracking-tight"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>
		</div>
	</div>

	<div class="swiper baji-products-slider overflow-hidden relative pb-12">
		<ul class="swiper-wrapper">
			<?php
			$related_slide_class = function( $classes ) {
				$classes[] = 'swiper-slide';
				return $classes;
			};
			add_filter( 'woocommerce_post_class', $related_slide_class );

			foreach ( $related_products as $related_product ) {
				$post_object = get_post( $related_product->get_id() );
				setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				wc_get_template_part( 'content', 'product' );
			}

			remove_filter( 'woocommerce_post_class', $related_slide_class );
			wp_reset_postdata();
			?>
		</ul>
		<div class="swiper-pagination !bottom-0"></div>
	</div>
</section>
