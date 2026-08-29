<?php
/**
 * فرم تسویه‌حساب (Override کامل ووکامرس)
 *
 * @package BajiStyle
 * @since 1.0.0
 *
 * @var WC_Checkout $checkout شیء تسویه‌حساب ووکامرس.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() && 'no' === get_option( 'woocommerce_enable_guest_checkout' ) ) {
	echo '<p class="baji-checkout-login-required text-center text-gray-500 py-12">' .
		wp_kses_post( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'برای ادامه فرایند خرید باید وارد حساب کاربری خود شوید.', 'bajistyle' ) ) ) .
		'</p>';
	return;
}
?>

<div class="baji-checkout-wrapper w-full">

	<!-- ۱. چاپ پیام‌های خطا و اطلاع‌رسانی در بالای صفحه و عرض کامل -->
	<div class="baji-checkout-notices w-full mb-8">
		<?php wc_print_notices(); ?>
	</div>

	<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

	<?php if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) : ?>

		<div>
			<?php echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'برای تکمیل خرید، ابتدا باید وارد حساب کاربری خود شوید.', 'bajistyle' ) ) ); ?>
		</div>

	<?php else : ?>
						<?php echo do_shortcode('[bwdk_comp1]'); ?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout baji-checkout-form flex flex-col lg:flex-row-reverse gap-12"
			action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<div class="baji-checkout-customer-details-wrapper flex-1 min-w-0">

				<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div class="baji-checkout-customer-details space-y-10">

						<!-- بخش فیلدهای صورت‌حساب -->
						<div class="baji-checkout-billing">
							<h3 class="text-lg font-light mb-6"><?php esc_html_e( 'اطلاعات دریافت‌کننده و آدرس', 'bajistyle' ); ?></h3>
							<div class="woocommerce-billing-fields__field-wrapper baji-form-fields grid grid-cols-1 md:grid-cols-2 gap-4">
								<?php
								$billing_fields = $checkout->get_checkout_fields( 'billing' );
								foreach ( $billing_fields as $key => $field ) {
									woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
								}
								?>
							</div>
						</div>

						<!-- بخش یادداشت‌های سفارش -->
						<?php if ( $checkout->get_checkout_fields( 'order' ) ) : ?>
							<div class="baji-checkout-order-notes">
								<?php
								$order_fields = $checkout->get_checkout_fields( 'order' );
								foreach ( $order_fields as $key => $field ) {
									woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
								}
								?>
							</div>
						<?php endif; ?>

						<!-- بخش خلاصه سفارش -->
						<div class="baji-checkout-order-review-wrapper lg:w-full shrink-0 bg-baji-cream p-8 h-fit lg:sticky lg:top-32">
							<h3 class="text-lg font-light mb-6"><?php esc_html_e( 'خلاصه سفارش', 'bajistyle' ); ?></h3>

							<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

							<div id="order_review" class="woocommerce-checkout-review-order">
								<?php do_action( 'woocommerce_checkout_order_review' ); ?>
							</div>
						</div>

					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

			</div>

		</form>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

</div>