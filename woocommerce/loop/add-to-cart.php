<?php
/**
 * دکمه افزودن به سبد خرید در گرید محصولات (Override ووکامرس)
 *
 * نسخه اصلاح‌شده برای پشتیبانی از AJAX و باز شدن سبد کناری بدون
 * رفرش صفحه.
 *
 * @package BajiStyle
 * @since 1.0.0
 *
 * @var WC_Product $product شیء محصول فعلی (به‌صورت ضمنی در اسکوپ موجود است).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product || ! $product->is_purchasable() ) {
	return;
}

$button_classes = implode(
	' ',
	array_filter(
		array(
			'button',
			'baji-add-to-cart-btn',
			'block w-full text-center py-3 text-xs tracking-widest uppercase border border-baji-black transition-colors duration-300',
			'hover:bg-baji-black hover:text-baji-white',
			$product->is_in_stock() ? '' : 'opacity-50 pointer-events-none',
			$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			'product_type_' . $product->get_type(),
		)
	)
);
?>

<?php if ( $product->is_in_stock() ) : ?>
	<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
		data-quantity="1"
		data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
		data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
		aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
		rel="nofollow"
		class="<?php echo esc_attr( $button_classes ); ?>">
		<?php echo esc_html( $product->add_to_cart_text() ); ?>
	</a>
<?php else : ?>
	<span class="<?php echo esc_attr( $button_classes ); ?>">
		<?php esc_html_e( 'ناموجود', 'bajistyle' ); ?>
	</span>
<?php endif; ?>
