<?php
/**
 * فایل فوتر قالب BajiStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

	</main><!-- #main-content -->

	<?php get_template_part( 'template-parts/newsletter' ); ?>

	<footer id="colophon" class="baji-footer bg-baji-black text-baji-white">
		<!-- نوار طلایی نازک بالای فوتر -->
		<div class="h-px w-full bg-gradient-to-l from-transparent via-baji-gold/4 to-transparent"></div>

		<div class="max-w-[1280px] mx-auto px-5 md:px-10 py-16 md:py-20">
			<div class="grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-8">

				<!-- ستون ۱: برند (۵ ستون) -->
				<div class="baji-footer-brand md:col-span-5">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block mb-5">
						<?php
						if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
							the_custom_logo();
						} else {
							echo '<span class="text-2xl font-light tracking-[0.2em] uppercase">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
						}
						?>
					</a>
					<p class="text-sm text-gray-400 leading-8 max-w-sm font-light">
						<?php
						echo esc_html(
							get_theme_mod(
								'bajistyle_brand_story_text',
								__( 'BajiStyle با عشق به زیبایی و توجه به جزئیات متولد شد تا لحظات شما را خاص‌تر کند.', 'bajistyle' )
							)
						);
						?>
					</p>

					<!-- شبکه‌های اجتماعی -->
					<div class="baji-social-links flex items-center gap-3 mt-7">
						<?php
						$socials = array(
							'instagram' => array( 'icon' => 'fab fa-instagram', 'label' => 'اینستاگرام' ),
							'telegram'  => array( 'icon' => 'fab fa-telegram-plane', 'label' => 'تلگرام' ),
							'whatsapp'  => array( 'icon' => 'fab fa-whatsapp', 'label' => 'واتساپ' ),
							'linkedin'  => array( 'icon' => 'fab fa-linkedin-in', 'label' => 'لینکدین' ),
						);
						foreach ( $socials as $key => $social ) :
							$url = get_theme_mod( 'bajistyle_social_' . $key );
							if ( $url ) :
						?>
							<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"
								aria-label="<?php echo esc_attr( $social['label'] ); ?>"
								class="w-9 h-9 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:border-baji-gold hover:text-baji-gold hover:-translate-y-0.5 transition-all duration-300">
								<i class="<?php echo esc_attr( $social['icon'] ); ?> text-sm"></i>
							</a>
						<?php
							endif;
						endforeach;
						?>
					</div>
				</div>

				<!-- ستون ۲: لینک‌های راهنما (۳ ستون) -->
				<div class="md:col-span-3 md:col-start-7">
					<h4 class="text-baji-gold text-xs font-medium tracking-[0.25em] uppercase mb-6"><?php esc_html_e( 'راهنمای خرید', 'bajistyle' ); ?></h4>
					<?php if ( has_nav_menu( 'footer-2' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-2',
								'container'      => false,
								'menu_class'     => 'baji-footer-menu space-y-3 text-sm text-gray-400',
								'link_before'    => '<span class="hover:text-baji-gold transition-colors duration-300">',
								'link_after'     => '</span>',
							)
						);
						?>
					<?php else : ?>
						<ul class="space-y-3 text-sm text-gray-400">
							<li><a href="#" class="hover:text-baji-gold transition-colors duration-300"><?php esc_html_e( 'راهنمای انتخاب سایز', 'bajistyle' ); ?></a></li>
							<li><a href="#" class="hover:text-baji-gold transition-colors duration-300"><?php esc_html_e( 'شرایط ارسال و تحویل', 'bajistyle' ); ?></a></li>
							<li><a href="#" class="hover:text-baji-gold transition-colors duration-300"><?php esc_html_e( 'بازگشت و تعویض کالا', 'bajistyle' ); ?></a></li>
							<li><a href="#" class="hover:text-baji-gold transition-colors duration-300"><?php esc_html_e( 'سؤالات متداول', 'bajistyle' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</div>

				<!-- ستون ۳: ارتباط با ما (۴ ستون) -->
				<div class="md:col-span-4">
					<h4 class="text-baji-gold text-xs font-medium tracking-[0.25em] uppercase mb-6"><?php esc_html_e( 'ارتباط با ما', 'bajistyle' ); ?></h4>
					<ul class="space-y-3 text-sm text-gray-400 font-light">
						<?php $phone = get_theme_mod( 'bajistyle_contact_phone' ); ?>
						<?php if ( $phone ) : ?>
							<li class="flex items-center gap-3">
								<i class="far fa-phone-alt text-baji-gold text-xs w-4"></i>
								<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="hover:text-baji-gold transition-colors duration-300">
									<?php echo esc_html( $phone ); ?>
								</a>
							</li>
						<?php endif; ?>

						<?php $email = get_theme_mod( 'bajistyle_contact_email' ); ?>
						<?php if ( $email ) : ?>
							<li class="flex items-center gap-3">
								<i class="far fa-envelope text-baji-gold text-xs w-4"></i>
								<a href="mailto:<?php echo esc_attr( $email ); ?>" class="hover:text-baji-gold transition-colors duration-300">
									<?php echo esc_html( $email ); ?>
								</a>
							</li>
						<?php endif; ?>

						<?php $address = get_theme_mod( 'bajistyle_contact_address' ); ?>
						<?php if ( $address ) : ?>
							<li class="flex items-start gap-3 leading-7">
								<i class="far fa-map-marker-alt text-baji-gold text-xs w-4 mt-1.5"></i>
								<span><?php echo esc_html( $address ); ?></span>
							</li>
						<?php endif; ?>
					</ul>

					<!-- مجوزهای قانونی -->
					<div class="baji-trust-logos flex items-center gap-3 mt-7">
						<a referrerpolicy="origin" target="_blank"
							href="https://trustseal.enamad.ir/?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn"
							class="block opacity-80 hover:opacity-100 transition-opacity duration-300">
							<img referrerpolicy="origin"
								src="https://trustseal.enamad.ir/logo.aspx?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn"
								alt="اینماد فروشگاه باجی استایل"
								class="bg-white rounded-lg p-2" style="max-width:68px; height:auto;" />
						</a>
						<a referrerpolicy="origin" target="_blank"
							href="https://buy-with-digikala.digify.shop/d-namad/store/a64f9bac-752d-4aa3-ab04-d8a5e44ecd00"
							class="block opacity-80 hover:opacity-100 transition-opacity duration-300">
							<img referrerpolicy="origin"
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/digilogo.svg' ); ?>"
								alt="خرید از باجی استایل با دیجی‌کالا"
								class="bg-white rounded-lg p-2" style="max-width:68px; height:auto;" />
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- نوار کپی رایت -->
		<div class="baji-footer-bottom border-t border-white/10">
			<div class="max-w-[1280px] mx-auto px-5 md:px-10 py-6 flex flex-col md:flex-row items-center justify-between gap-3">
				<p class="text-xs text-gray-500 font-light">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<?php echo esc_html( get_theme_mod( 'bajistyle_footer_copyright', __( 'تمامی حقوق برای BajiStyle محفوظ است.', 'bajistyle' ) ) ); ?>
				</p>
				<div class="flex items-center gap-5 text-xs text-gray-600">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-baji-gold transition-colors duration-300"><?php esc_html_e( 'حریم خصوصی', 'bajistyle' ); ?></a>
					<span class="w-px h-3 bg-gray-700"></span>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-baji-gold transition-colors duration-300"><?php esc_html_e( 'قوانین و مقررات', 'bajistyle' ); ?></a>
				</div>
			</div>
		</div>
	</footer>

	<!-- نوار ناوبری پایین موبایل -->
	<div class="baji-mobile-bottom-nav md:hidden fixed bottom-0 inset-x-0 z-50 border-t border-gray-100 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] flex items-center justify-around h-16 px-2" style="background-color: #ffffff !important;">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors">
			<i class="far fa-home text-xl"></i>
			<span class="text-[10px] font-medium tracking-wide">خانه</span>
		</a>
		<button type="button" class="baji-cart-toggle flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors" aria-label="<?php esc_attr_e( 'باز کردن سبد خرید', 'bajistyle' ); ?>" aria-expanded="false" aria-controls="baji-cart-panel">
			<div class="relative inline-block leading-none">
				<i class="far fa-shopping-bag text-xl"></i>
				<span class="baji-cart-count absolute -top-2 -left-2 text-[10px] bg-baji-gold text-baji-black rounded-full w-4 h-4 flex items-center justify-center font-sans" data-cart-count="<?php echo absint( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>">
					<?php echo absint( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>
				</span>
			</div>
			<span class="text-[10px] font-medium tracking-wide">سبد خرید</span>
		</button>
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'wishlist' ) ); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors">
			<i class="far fa-heart text-xl"></i>
			<span class="text-[10px] font-medium tracking-wide">علاقه‌مندی</span>
		</a>
		<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors">
			<i class="far fa-user text-xl"></i>
			<span class="text-[10px] font-medium tracking-wide">حساب من</span>
		</a>
	</div>
</div><!-- #page -->

<!-- پنل سبد خرید (مستقل از کامپایل تیلویند) -->
<div id="baji-cart-panel" class="fixed inset-y-0 left-0 bg-white shadow-2xl transition-transform duration-300" style="z-index: 9999; width: 400px; max-width: 100%; transform: translateX(-100%);">
    <div class="flex justify-between items-center p-4 border-b">
        <h3 class="font-bold">سبد خرید</h3>
        <button id="baji-cart-close" class="text-2xl p-2 hover:text-red-500 transition-colors">&times;</button>
    </div>

    <div class="p-4 overflow-y-auto widget_shopping_cart_content" style="height: calc(100vh - 65px);">
        <?php woocommerce_mini_cart(); ?>
    </div>
</div>

<!-- لایه تاریک (Overlay) -->
<div id="baji-cart-overlay" class="fixed inset-0 backdrop-blur-sm transition-opacity duration-300" style="z-index: 9998; background-color: rgba(0, 0, 0, 0.5); opacity: 0; pointer-events: none;"></div>
<?php wp_footer(); ?>
</body>
</html>
