<?php
/**
 * برچسب تخفیف (Sale Flash) محصول (Override ووکامرس)
 *
 * توجه: خروجی این فایل توسط فیلتر bajistyle_sale_flash در
 * inc/woocommerce-hooks.php نیز قابل تغییر است؛ این فایل به‌عنوان
 * Override مستقیم تمپلیت برای کنترل کامل ساختار HTML نگه داشته شده است.
 *
 * @package BajiStyle
 * @since 1.0.0
 *
 * @var WC_Product $product شیء محصول فعلی.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

if ( ! $product || ! $product->is_on_sale() ) {
	return;
}

// محاسبه درصد تخفیف برای نمایش (در صورت محصول ساده با قیمت مشخص).
$percentage = '';
if ( $product->get_regular_price() && $product->get_sale_price() && is_numeric( $product->get_regular_price() ) && is_numeric( $product->get_sale_price() ) ) {
	$regular = (float) $product->get_regular_price();
	$sale    = (float) $product->get_sale_price();
	if ( $regular > 0 ) {
		$percentage = round( ( ( $regular - $sale ) / $regular ) * 100 );
	}
}
?>

<span class="baji-sale-badge absolute top-3 right-3 z-10 bg-baji-black text-baji-gold text-2xs tracking-widest px-3 py-1 uppercase">
	<?php
	if ( $percentage ) {
		printf(
			/* translators: %s: درصد تخفیف */
			esc_html__( '٪%s تخفیف', 'bajistyle' ),
			esc_html( $percentage )
		);
	} else {
		esc_html_e( 'تخفیف', 'bajistyle' );
	}
	?>
</span>
