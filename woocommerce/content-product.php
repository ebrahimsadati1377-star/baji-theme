<?php
/**
 * Minimal Product Card - WooCommerce Grid Override
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_id = $product->get_id();
$in_wishlist = function_exists( 'bajistyle_is_in_wishlist' ) && bajistyle_is_in_wishlist( $product_id );
?>

<li <?php wc_product_class( 'group', $product ); ?>>

	<!-- تصویر محصول -->
	<div class="relative overflow-hidden bg-gray-100 rounded-lg aspect-[3/4]">

		<a
			href="<?php echo esc_url( $product->get_permalink() ); ?>"
			class="block w-full h-full"
			aria-label="<?php echo esc_attr( $product->get_name() ); ?>"
		>

			<?php
			if ( $product->get_image_id() ) {

				echo wp_get_attachment_image(
					$product->get_image_id(),
					'bajistyle-product-grid',
					false,
					array(
						'class'    => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 rounded-lg',
						'loading'  => 'lazy',
						'decoding' => 'async',
						'sizes'    => '(max-width: 767px) 50vw, (max-width: 1023px) 33vw, 25vw',
					)
				);

			} else {

				echo wc_placeholder_img(
					'bajistyle-product-grid',
					array(
						'class'    => 'w-full h-full object-cover rounded-lg',
						'loading'  => 'lazy',
						'decoding' => 'async',
					)
				);

			}
			?>

		</a>


		<!-- علاقه‌مندی -->
		<button
			type="button"
			class="baji-quick-wishlist absolute top-3 right-3 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition shadow-sm z-10"
			data-product-id="<?php echo esc_attr( $product_id ); ?>"
			data-in-wishlist="<?php echo $in_wishlist ? '1' : '0'; ?>"
			aria-pressed="<?php echo $in_wishlist ? 'true' : 'false'; ?>"
			aria-label="<?php echo esc_attr( $in_wishlist ? __( 'حذف از علاقه‌مندی‌ها', 'bajistyle' ) : __( 'افزودن به علاقه‌مندی‌ها', 'bajistyle' ) ); ?>"
		>
			<span class="text-base">

				<?php if ( $in_wishlist ) : ?>

					<i class="baji-wishlist-icon fa-solid fa-heart text-rose-600"></i>

				<?php else : ?>

					<i class="baji-wishlist-icon fa-regular fa-heart text-gray-700"></i>

				<?php endif; ?>

			</span>
		</button>


		<!-- تخفیف -->
		<?php
		if ( $product->is_on_sale() ) :

			$regular_price = 0;
			$sale_price    = 0;

			if ( $product->is_type( 'variable' ) ) {

				$regular_price = (float) $product->get_variation_regular_price( 'max' );
				$sale_price    = (float) $product->get_variation_sale_price( 'min' );

			} else {

				$regular_price = (float) $product->get_regular_price();
				$sale_price    = (float) $product->get_sale_price();

			}

			if ( $regular_price > 0 && $sale_price > 0 && $sale_price < $regular_price ) {

				$discount = round(
					( ( $regular_price - $sale_price ) / $regular_price ) * 100
				);

				if ( $discount > 0 ) :
					?>

					<span class="baji-discount-ribbon">
						<?php echo esc_html( $discount ); ?>%
					</span>

					<?php
				endif;
			}

		endif;
		?>

	</div>


	<!-- اطلاعات محصول -->
	<div class="mt-3 space-y-1 text-center">

		<a
			href="<?php echo esc_url( $product->get_permalink() ); ?>"
			class="block"
		>

			<h3 class="text-sm font-medium text-gray-800 hover:text-black transition-colors">
				<?php echo esc_html( $product->get_name() ); ?>
			</h3>

            <div class="mt-2 flex items-center justify-center">
                <div class="baji-product-price">
                    <?php echo wp_kses_post( $product->get_price_html() ); ?>
                </div>
            </div>

		</a>

	</div>

</li>
