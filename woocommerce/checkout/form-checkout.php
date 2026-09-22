<?php
/**
 * Premium BAJI checkout.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() && 'no' === get_option( 'woocommerce_enable_guest_checkout' ) ) {
	echo '<p class="baji-checkout-login-required">' .
		wp_kses_post( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'برای ادامه فرایند خرید باید وارد حساب کاربری خود شوید.', 'bajistyle' ) ) ) .
		'</p>';
	return;
}
?>

<div class="baji-checkout-page">
	<header class="baji-checkout-hero">
		<div class="baji-checkout-hero__brand">BAJI</div>
		<div>
			<span class="baji-checkout-kicker">تکمیل خرید</span>
			<h1>فقط یک قدم تا استایل جدیدت</h1>
			<p>اطلاعات ارسال را وارد کن و روش پرداخت مناسب را انتخاب کن.</p>
		</div>
		<div class="baji-checkout-security"><i class="fa-solid fa-lock"></i><span>پرداخت امن</span></div>
	</header>

	<div class="baji-checkout-steps" aria-label="مراحل خرید">
		<span class="is-done"><i class="fa-solid fa-check"></i><b>سبد خرید</b></span>
		<em></em>
		<span class="is-active"><i>2</i><b>اطلاعات و پرداخت</b></span>
		<em></em>
		<span><i>3</i><b>تأیید سفارش</b></span>
	</div>

	<div class="baji-checkout-notices">
		<?php wc_print_notices(); ?>
	</div>

	<div class="baji-checkout-before-form">
		<?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>
	</div>

	<?php if ( shortcode_exists( 'bwdk_comp1' ) ) : ?>
		<div class="baji-checkout-digikala-top">
			<?php echo do_shortcode( '[bwdk_comp1]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php endif; ?>

	<?php if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) : ?>
		<div class="baji-checkout-login-required">
			<?php echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'برای تکمیل خرید، ابتدا باید وارد حساب کاربری خود شوید.', 'bajistyle' ) ) ); ?>
		</div>
	<?php else : ?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout baji-checkout-layout"
			action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<main class="baji-checkout-main">
				<?php if ( $checkout->get_checkout_fields() ) : ?>
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<section class="baji-checkout-card baji-checkout-card--details">
						<div class="baji-checkout-card__head">
							<span class="baji-checkout-card__icon"><i class="fa-regular fa-user"></i></span>
							<div>
								<small>مشخصات سفارش</small>
								<h2>اطلاعات دریافت‌کننده</h2>
								<p>این اطلاعات برای ارسال سفارش استفاده می‌شود.</p>
							</div>
						</div>

						<div class="woocommerce-billing-fields__field-wrapper baji-checkout-fields">
							<?php
							$billing_fields = $checkout->get_checkout_fields( 'billing' );
							foreach ( $billing_fields as $key => $field ) {
								woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
							}
							?>
						</div>
					</section>

					<?php if ( $checkout->get_checkout_fields( 'order' ) ) : ?>
						<section class="baji-checkout-card baji-checkout-card--notes">
							<div class="baji-checkout-card__head">
								<span class="baji-checkout-card__icon"><i class="fa-regular fa-message"></i></span>
								<div>
									<small>اختیاری</small>
									<h2>توضیحات سفارش</h2>
									<p>اگر نکته‌ای درباره ارسال داری اینجا بنویس.</p>
								</div>
							</div>
							<div class="baji-checkout-order-notes">
								<?php
								foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) {
									woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
								}
								?>
							</div>
						</section>
					<?php endif; ?>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				<?php endif; ?>

				<div class="baji-checkout-trust-row">
					<span><i class="fa-solid fa-shield-halved"></i> پرداخت امن</span>
					<span><i class="fa-solid fa-truck-fast"></i> ارسال سریع</span>
					<span><i class="fa-regular fa-headset"></i> پشتیبانی باجی</span>
				</div>
			</main>

			<aside class="baji-checkout-sidebar">
				<section class="baji-checkout-summary">
					<div class="baji-checkout-summary__head">
						<div>
							<small>سفارش شما</small>
							<h2>خلاصه و پرداخت</h2>
						</div>
						<i class="fa-solid fa-lock" aria-hidden="true"></i>
					</div>

					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<div class="baji-checkout-safe-note">
						<i class="fa-solid fa-shield-heart"></i>
						<span><b>خرید امن از باجی</b><small>اطلاعات پرداخت شما در سایت ذخیره نمی‌شود.</small></span>
					</div>
				</section>
			</aside>
		</form>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
