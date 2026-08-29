<?php
/**
 * صفحه سبد خرید - نسخه Premium UI/UX (Override اختصاصی ووکامرس)
 *
 * این نسخه با طراحی اختصاصی (رنگ ایندیگو، آیکون‌های Font Awesome) به
 * درخواست مستقیم کارفرما جایگزین طراحی استاندارد برند BajiStyle شده
 * است. Font Awesome از طریق functions.php (بارگذاری bajistyle-fontawesome)
 * فعال می‌شود. آپدیت تعداد محصولات به‌صورت AJAX و بدون رفرش صفحه در
 * assets/js/cart.js پیاده‌سازی شده (نه به‌صورت اسکریپت درون‌خطی) تا در
 * صورت نمایش هم‌زمان این تمپلیت در سبد خرید کناری (هدر) و صفحه اصلی
 * سبد خرید، رویدادها فقط یک‌بار ثبت شوند.
 *
 * @package BajiStyle
 * @since 1.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="premium-cart-container max-w-7xl mx-auto px-4 py-8 lg:py-12 transition-opacity duration-300" dir="rtl">

	<header class="mb-8 lg:mb-12">
		<h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
			<i class="fa-duotone fa-cart-shopping text-indigo-600"></i>
			سبد خرید شما
			<span class="text-base font-medium bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full mr-2">
				<?php echo absint( WC()->cart->get_cart_contents_count() ); ?> کالا
			</span>
		</h1>
	</header>

	<?php if ( WC()->cart->is_empty() ) : ?>

		<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center max-w-2xl mx-auto">
			<div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
				<i class="fa-light fa-basket-shopping-simple text-6xl text-gray-300"></i>
			</div>
			<h2 class="text-2xl font-bold text-gray-800 mb-4"><?php esc_html_e( 'سبد خرید شما در حال حاضر خالی است.', 'bajistyle' ); ?></h2>
			<p class="text-gray-500 mb-8"><?php esc_html_e( 'پیشنهاد می‌کنیم به فروشگاه برگردید و محصولات شگفت‌انگیز ما را بررسی کنید.', 'bajistyle' ); ?></p>
			<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
				class="inline-flex items-center gap-2 bg-indigo-600 text-white px-8 py-3.5 rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-600/20 transition-all font-medium">
				<?php esc_html_e( 'شروع به گشت و گذار', 'bajistyle' ); ?>
				<i class="fa-regular fa-arrow-left"></i>
			</a>
		</div>

	<?php else : ?>

		<div class="flex flex-col lg:flex-row gap-8 items-start">

			<div class="w-full lg:w-2/3 xl:w-8/12">
				<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<div class="space-y-4">
						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>

								<div class="woocommerce-cart-form__cart-item cart_item bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 hover:shadow-md transition-shadow relative">

									<div class="absolute top-4 left-4 sm:static sm:order-last">
										<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
											class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors remove"
											aria-label="<?php esc_attr_e( 'حذف این محصول', 'bajistyle' ); ?>"
											data-product_id="<?php echo esc_attr( $product_id ); ?>"
											data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
											<i class="fa-regular fa-trash"></i>
										</a>
									</div>

									<div class="w-24 h-24 sm:w-28 sm:h-28 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden relative border border-gray-100">
										<?php echo wp_kses_post( $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover' ) ) ); ?>
									</div>

									<div class="flex-1 min-w-0">
										<h3 class="text-base sm:text-lg font-bold text-gray-800 mb-1 leading-tight">
											<?php if ( ! $product_permalink ) : ?>
												<?php echo wp_kses_post( $_product->get_name() ); ?>
											<?php else : ?>
												<a href="<?php echo esc_url( $product_permalink ); ?>" class="hover:text-indigo-600 transition-colors line-clamp-2">
													<?php echo wp_kses_post( $_product->get_name() ); ?>
												</a>
											<?php endif; ?>
										</h3>

										<?php if ( $_product->is_type( 'variation' ) ) : ?>
											<div class="text-sm text-gray-500 mb-3 bg-gray-50 inline-block px-3 py-1 rounded-lg">
												<?php echo wc_get_formatted_variation( $_product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</div>
										<?php endif; ?>

										<div class="flex flex-wrap items-center gap-4 mt-4">
											<div class="text-sm font-medium text-gray-400 line-through hidden sm:block">
												<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</div>

											<div class="baji-qty-wrapper product-quantity flex items-center bg-gray-50 border border-gray-200 rounded-lg h-10 w-28">
												<button type="button" class="baji-qty-btn baji-minus w-8 h-full flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-colors" aria-label="<?php esc_attr_e( 'کاهش تعداد', 'bajistyle' ); ?>">
													<i class="fa-regular fa-minus text-xs"></i>
												</button>
												<input type="number"
													class="qty text w-full h-full text-center bg-transparent border-0 font-semibold text-gray-800 focus:ring-0 p-0 text-sm"
													name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
													value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
													min="1"
													max="<?php echo esc_attr( -1 === $_product->get_max_purchase_quantity() ? '' : $_product->get_max_purchase_quantity() ); ?>"
													step="1"
													inputmode="numeric" />
												<button type="button" class="baji-qty-btn baji-plus w-8 h-full flex items-center justify-center text-gray-500 hover:text-indigo-600 transition-colors" aria-label="<?php esc_attr_e( 'افزایش تعداد', 'bajistyle' ); ?>">
													<i class="fa-regular fa-plus text-xs"></i>
												</button>
											</div>

											<div class="mr-auto sm:mr-0 sm:ml-auto">
												<span class="text-lg font-bold text-gray-900">
													<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												</span>
											</div>
										</div>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>

					<button type="submit" class="hidden baji-update-cart-btn" name="update_cart" value="1">
						<?php esc_html_e( 'به‌روزرسانی سبد خرید', 'bajistyle' ); ?>
					</button>

					<?php do_action( 'woocommerce_cart_contents' ); ?>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</form>

				<?php if ( function_exists( 'woocommerce_cross_sell_display' ) ) : ?>
					<div class="mt-12 pt-8 border-t border-gray-200">
						<?php woocommerce_cross_sell_display( 3, 3 ); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="w-full lg:w-1/3 xl:w-4/12 lg:sticky lg:top-8">

				<?php if ( wc_coupons_enabled() ) : ?>
					<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
						<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" class="flex gap-2 relative">
							<i class="fa-regular fa-ticket-percent absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
							<input type="text" name="coupon_code" class="w-full pl-4 pr-11 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="<?php echo esc_attr_x( 'کد تخفیف دارید؟', 'placeholder', 'bajistyle' ); ?>" />
							<button type="submit" class="bg-gray-800 text-white px-5 py-3 rounded-xl hover:bg-gray-900 transition font-medium text-sm whitespace-nowrap" name="apply_coupon" value="1">
								<?php esc_html_e( 'اعمال', 'bajistyle' ); ?>
							</button>
						</form>
					</div>
				<?php endif; ?>

				<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8">
					<h3 class="text-xl font-bold text-gray-800 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e( 'فاکتور شما', 'bajistyle' ); ?></h3>

					<div class="space-y-4 mb-6 text-sm text-gray-600">
						<div class="flex justify-between items-center">
							<span><?php esc_html_e( 'جمع محصولات:', 'bajistyle' ); ?></span>
							<span class="font-medium text-gray-800"><?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?></span>
						</div>

						<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
							<div class="flex justify-between items-center text-emerald-600 bg-emerald-50 p-2 rounded-lg">
								<span class="flex items-center gap-2">
									<i class="fa-solid fa-tags"></i>
									<?php
									printf(
										/* translators: %s: کد تخفیف */
										esc_html__( 'تخفیف (%s):', 'bajistyle' ),
										esc_html( $code )
									);
									?>
								</span>
								<span class="font-bold">- <?php echo wp_kses_post( wc_cart_totals_coupon_html( $coupon ) ); ?></span>
							</div>
						<?php endforeach; ?>

						<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
							<div class="flex justify-between items-center">
								<span><?php esc_html_e( 'هزینه ارسال:', 'bajistyle' ); ?></span>
								<?php if ( WC()->cart->get_shipping_total() > 0 ) : ?>
									<span class="font-medium text-gray-800"><?php echo wp_kses_post( wc_price( WC()->cart->get_shipping_total() ) ); ?></span>
								<?php else : ?>
									<span class="font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded text-xs"><?php esc_html_e( 'در مرحله بعد', 'bajistyle' ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() && WC()->cart->get_taxes_total() > 0 ) : ?>
							<div class="flex justify-between items-center">
								<span><?php esc_html_e( 'مالیات:', 'bajistyle' ); ?></span>
								<span class="font-medium text-gray-800"><?php echo wp_kses_post( wc_price( WC()->cart->get_taxes_total() ) ); ?></span>
							</div>
						<?php endif; ?>
					</div>

					<div class="flex justify-between items-center pt-6 border-t border-gray-100 mb-8">
						<span class="text-base font-bold text-gray-800"><?php esc_html_e( 'مبلغ قابل پرداخت:', 'bajistyle' ); ?></span>
						<span class="text-2xl font-extrabold text-indigo-600"><?php echo wp_kses_post( WC()->cart->get_cart_total() ); ?></span>
					</div>

                    <a href="https://bajistyle.ir/checkout/" class="baji-btn-primary w-full flex items-center justify-center gap-2 !py-4 !rounded-xl text-lg hover:!bg-indigo-700">
                        <i class="fa-regular fa-credit-card"></i>
                        ادامه جهت تسویه حساب
                    </a>

					<div class="mt-6 pt-6 border-t border-gray-50 flex justify-center items-center gap-6 opacity-60 grayscale hover:grayscale-0 transition-all duration-300">
						<div class="text-center">
							<i class="fa-solid fa-shield-check text-xl mb-1 text-emerald-600"></i>
							<p class="text-[10px] font-medium text-gray-500"><?php esc_html_e( 'پرداخت امن', 'bajistyle' ); ?></p>
						</div>
						<div class="text-center">
							<i class="fa-solid fa-truck-fast text-xl mb-1 text-indigo-600"></i>
							<p class="text-[10px] font-medium text-gray-500"><?php esc_html_e( 'ارسال سریع', 'bajistyle' ); ?></p>
						</div>
						<div class="text-center">
							<i class="fa-solid fa-headset text-xl mb-1 text-amber-500"></i>
							<p class="text-[10px] font-medium text-gray-500"><?php esc_html_e( 'پشتیبانی ۲۴/۷', 'bajistyle' ); ?></p>
						</div>
					</div>
				</div>

			</div>
		</div>

	<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
