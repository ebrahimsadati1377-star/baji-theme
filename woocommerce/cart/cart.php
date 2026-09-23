<?php
/**
 * BAJI premium cart.
 *
 * @package BajiStyle
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$cart_count      = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$cart_subtotal   = WC()->cart ? (float) WC()->cart->get_subtotal() : 0;
$free_target     = 3000000;
$free_remaining  = max( 0, $free_target - $cart_subtotal );
$free_percent    = $free_target > 0 ? min( 100, max( 0, ( $cart_subtotal / $free_target ) * 100 ) ) : 0;
$checkout_url    = wc_get_checkout_url();
$shop_url        = wc_get_page_permalink( 'shop' );
?>

<div class="premium-cart-container baji-cart-page" dir="rtl">
	<header class="baji-cart-hero">
		<div class="baji-cart-hero__copy">
			<span class="baji-cart-kicker">BAJI SHOPPING BAG</span>
			<h1>سبد خرید شما</h1>
			<p>محصولاتت را بررسی کن؛ تعداد را تغییر بده و با خیال راحت ادامه خرید را انجام بده.</p>
		</div>
		<div class="baji-cart-hero__count">
			<i class="fa-regular fa-bag-shopping"></i>
			<strong><?php echo esc_html( $cart_count ); ?></strong>
			<span>کالا</span>
		</div>
	</header>

	<div class="baji-cart-steps" aria-label="مراحل خرید">
		<span class="is-active"><i>۱</i><b>سبد خرید</b></span>
		<em></em>
		<span><i>۲</i><b>اطلاعات و پرداخت</b></span>
		<em></em>
		<span><i>۳</i><b>تأیید سفارش</b></span>
	</div>

	<?php if ( WC()->cart->is_empty() ) : ?>
		<section class="baji-cart-empty">
			<div class="baji-cart-empty__mark"><i class="fa-regular fa-bag-shopping"></i></div>
			<span>سبدت منتظر انتخاب‌های توئه</span>
			<h2>سبد خریدت هنوز خالیه</h2>
			<p>مدل‌های جدید باجی رو ببین و استایل بعدیت رو پیدا کن.</p>
			<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', $shop_url ) ); ?>">
				<span>مشاهده محصولات</span>
				<i class="fa-solid fa-arrow-left"></i>
			</a>
		</section>
	<?php else : ?>

		<section class="baji-cart-shipping-progress<?php echo $free_remaining <= 0 ? ' is-free' : ''; ?>">
			<div class="baji-cart-shipping-progress__icon"><i class="fa-solid fa-truck-fast"></i></div>
			<div class="baji-cart-shipping-progress__copy">
				<?php if ( $free_remaining > 0 ) : ?>
					<strong>فقط <?php echo wp_kses_post( wc_price( $free_remaining ) ); ?> تا ارسال رایگان</strong>
					<span>حد ارسال رایگان: <?php echo wp_kses_post( wc_price( $free_target ) ); ?></span>
				<?php else : ?>
					<strong>ارسال رایگان برای این سبد فعال شد</strong>
					<span>مبلغ سبدت به حد ارسال رایگان رسیده است.</span>
				<?php endif; ?>
				<div class="baji-cart-shipping-progress__bar"><span style="width:<?php echo esc_attr( number_format( $free_percent, 2, '.', '' ) ); ?>%"></span></div>
			</div>
			<div class="baji-cart-shipping-progress__percent"><?php echo esc_html( round( $free_percent ) ); ?>٪</div>
		</section>

		<div class="baji-cart-layout">
			<main class="baji-cart-main">
				<section class="baji-cart-items-card">
					<div class="baji-cart-section-head">
						<div>
							<small>محصولات انتخاب‌شده</small>
							<h2>سبد خرید</h2>
						</div>
						<a href="<?php echo esc_url( $shop_url ); ?>"><i class="fa-solid fa-plus"></i> ادامه خرید</a>
					</div>

					<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
						<?php do_action( 'woocommerce_before_cart_table' ); ?>
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<div class="baji-cart-items">
							<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
								<?php
								$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

								if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
									continue;
								}

								$product_permalink = apply_filters(
									'woocommerce_cart_item_permalink',
									$_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
									$cart_item,
									$cart_item_key
								);
								?>
								<article class="woocommerce-cart-form__cart-item cart_item baji-cart-item">
									<div class="baji-cart-item__image">
										<?php if ( $product_permalink ) : ?><a href="<?php echo esc_url( $product_permalink ); ?>"><?php endif; ?>
										<?php echo wp_kses_post( $_product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ) ); ?>
										<?php if ( $product_permalink ) : ?></a><?php endif; ?>
									</div>

									<div class="baji-cart-item__content">
										<div class="baji-cart-item__title-row">
											<div>
												<span class="baji-cart-item__eyebrow">BAJI</span>
												<h3>
													<?php if ( $product_permalink ) : ?><a href="<?php echo esc_url( $product_permalink ); ?>"><?php endif; ?>
													<?php echo wp_kses_post( $_product->get_name() ); ?>
													<?php if ( $product_permalink ) : ?></a><?php endif; ?>
												</h3>
											</div>
											<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
												class="remove baji-cart-item__remove"
												aria-label="<?php esc_attr_e( 'حذف این محصول', 'bajistyle' ); ?>"
												data-product_id="<?php echo esc_attr( $product_id ); ?>"
												data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
												<i class="fa-regular fa-trash-can"></i>
												<span>حذف</span>
											</a>
										</div>

										<?php $item_data = wc_get_formatted_cart_item_data( $cart_item ); ?>
										<?php if ( $item_data ) : ?>
											<div class="baji-cart-item__meta"><?php echo wp_kses_post( $item_data ); ?></div>
										<?php endif; ?>

										<div class="baji-cart-item__bottom">
											<div class="baji-cart-item__unit-price">
												<small>قیمت واحد</small>
												<strong><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
											</div>

											<div class="baji-qty-wrapper product-quantity">
												<button type="button" class="baji-qty-btn baji-minus" aria-label="<?php esc_attr_e( 'کاهش تعداد', 'bajistyle' ); ?>">
													<i class="fa-solid fa-minus"></i>
												</button>
												<input type="number"
													class="qty text"
													name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
													value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
													min="1"
													max="<?php echo esc_attr( -1 === $_product->get_max_purchase_quantity() ? '' : $_product->get_max_purchase_quantity() ); ?>"
													step="1"
													inputmode="numeric"
													aria-label="تعداد <?php echo esc_attr( $_product->get_name() ); ?>" />
												<button type="button" class="baji-qty-btn baji-plus" aria-label="<?php esc_attr_e( 'افزایش تعداد', 'bajistyle' ); ?>">
													<i class="fa-solid fa-plus"></i>
												</button>
											</div>

											<div class="baji-cart-item__subtotal">
												<small>جمع این محصول</small>
												<strong><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
											</div>
										</div>
									</div>
								</article>
							<?php endforeach; ?>
						</div>

						<?php do_action( 'woocommerce_cart_contents' ); ?>
						<?php do_action( 'woocommerce_after_cart_contents' ); ?>

						<button type="submit" class="hidden baji-update-cart-btn" name="update_cart" value="1">
							<?php esc_html_e( 'به‌روزرسانی سبد خرید', 'bajistyle' ); ?>
						</button>
						<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						<?php do_action( 'woocommerce_after_cart_table' ); ?>
					</form>
				</section>

				<div class="baji-cart-trust">
					<div><i class="fa-solid fa-shield-halved"></i><span><b>پرداخت امن</b><small>اتصال مستقیم به درگاه</small></span></div>
					<div><i class="fa-solid fa-box"></i><span><b>بسته‌بندی باجی</b><small>مرتب و مناسب ارسال</small></span></div>
					<div><i class="fa-solid fa-headset"></i><span><b>پشتیبانی</b><small>همراهت تا تکمیل سفارش</small></span></div>
				</div>

				<?php if ( function_exists( 'woocommerce_cross_sell_display' ) ) : ?>
					<div class="baji-cart-cross-sells">
						<?php woocommerce_cross_sell_display( 3, 3 ); ?>
					</div>
				<?php endif; ?>
			</main>

			<aside class="baji-cart-sidebar">
				<section class="baji-cart-summary">
					<div class="baji-cart-summary__head">
						<div>
							<small>خلاصه خرید</small>
							<h2>صورتحساب</h2>
						</div>
						<span><i class="fa-solid fa-lock"></i></span>
					</div>

					<div class="baji-cart-summary__rows">
						<div>
							<span>جمع محصولات</span>
							<strong><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></strong>
						</div>

						<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
							<div class="is-discount">
								<span><i class="fa-solid fa-tag"></i> تخفیف <?php echo esc_html( $code ); ?></span>
								<strong><?php wc_cart_totals_coupon_html( $coupon ); ?></strong>
							</div>
						<?php endforeach; ?>

						<?php if ( WC()->cart->needs_shipping() ) : ?>
							<div>
								<span>هزینه ارسال</span>
								<?php if ( WC()->cart->get_shipping_total() > 0 ) : ?>
									<strong><?php echo wp_kses_post( wc_price( WC()->cart->get_shipping_total() ) ); ?></strong>
								<?php elseif ( $free_remaining <= 0 ) : ?>
									<strong class="is-free">رایگان</strong>
								<?php else : ?>
									<strong class="is-muted">در مرحله بعد</strong>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<div class="baji-cart-summary__total">
						<span>مبلغ قابل پرداخت</span>
						<strong><?php echo wp_kses_post( WC()->cart->get_cart_total() ); ?></strong>
					</div>

					<?php if ( wc_coupons_enabled() ) : ?>
						<details class="baji-cart-coupon">
							<summary><span><i class="fa-regular fa-ticket"></i> کد تخفیف داری؟</span><i class="fa-solid fa-chevron-down"></i></summary>
							<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
								<input type="text" name="coupon_code" placeholder="کد تخفیف را وارد کن" autocomplete="off" />
								<button type="submit" name="apply_coupon" value="1">اعمال</button>
								<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
							</form>
						</details>
					<?php endif; ?>

					<a href="<?php echo esc_url( $checkout_url ); ?>" class="baji-cart-checkout">
						<span>
							<small>مرحله بعد</small>
							<b>ادامه و تکمیل خرید</b>
						</span>
						<i class="fa-solid fa-arrow-left"></i>
					</a>

					<div class="baji-cart-installments">
						<i class="fa-regular fa-credit-card"></i>
						<div><b>امکان خرید اقساطی</b><span>اسنپ‌پی، ترب‌پی و دیجی‌پی در مرحله پرداخت</span></div>
					</div>

					<p class="baji-cart-summary__safe"><i class="fa-solid fa-shield-heart"></i> اطلاعات پرداخت شما در باجی ذخیره نمی‌شود.</p>
				</section>
			</aside>
		</div>
	<?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
