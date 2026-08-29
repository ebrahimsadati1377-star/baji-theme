<?php
/**
 * نمایش قیمت محصول در گرید (Override ووکامرس)
 *
 * @package BajiStyle
 * @since 1.0.0
 *
 * @var WC_Product $product شیء محصول فعلی.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product ) {
	return;
}

$price_html = $product->get_price_html();

if ( empty( $price_html ) ) {
	return;
}
?>

<span class="baji-price block mt-2 text-sm <?php echo $product->is_on_sale() ? 'baji-price-on-sale' : ''; ?>">
	<?php echo wp_kses_post( $price_html ); ?>
</span>
