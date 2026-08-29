<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 11.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table w-full text-sm mb-6 border-collapse">
	<thead>
		<tr class="border-b border-black/10 text-gray-500 font-normal">
			<th class="product-name text-right pb-3 font-normal"><?php esc_html_e( 'محصول', 'woocommerce' ); ?></th>
			<th class="product-total text-left pb-3 font-normal"><?php esc_html_e( 'مجموع', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody class="divide-y divide-black/5">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-name py-4 text-right align-top">
						<div class="font-medium text-gray-900">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity font-normal text-xs text-gray-500">×&nbsp;' . sprintf( '%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="product-total py-4 text-left font-medium text-gray-900 align-top">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot class="border-t border-black/10 divide-y divide-black/5">

		<tr class="cart-subtotal">
			<th class="py-3 text-right font-normal text-gray-600"><?php esc_html_e( 'جمع کل سبد خرید', 'woocommerce' ); ?></th>
			<td class="py-3 text-left font-medium text-gray-900"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th class="py-3 text-right font-normal text-gray-600"><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td class="py-3 text-left font-medium text-green-600"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th class="py-3 text-right font-normal text-gray-600"><?php echo esc_html( $fee->name ); ?></th>
				<td class="py-3 text-left font-medium text-gray-900"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th class="py-3 text-right font-normal text-gray-600"><?php echo esc_html( $tax->label ); ?></th>
						<td class="py-3 text-left font-medium text-gray-900"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th class="py-3 text-right font-normal text-gray-600"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td class="py-3 text-left font-medium text-gray-900"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total text-base font-semibold">
			<th class="pt-4 pb-2 text-right text-gray-900"><?php esc_html_e( 'مجموع قابل پرداخت', 'woocommerce' ); ?></th>
			<td class="pt-4 pb-2 text-left text-gray-900"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>