<?php
/**
 * نمایش رتبه‌بندی ستاره‌ای محصول در گرید (Override ووکامرس)
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

if ( ! $product || ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$average      = $product->get_average_rating();

if ( $rating_count <= 0 ) {
	return;
}
?>

<div class="baji-product-rating mt-2">
	<?php bajistyle_star_rating( (float) $average, (int) $rating_count ); ?>
</div>
