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

	<footer id="colophon" class="baji-footer baji-footer-editorial">
		<div class="baji-footer-shell">
			<div class="baji-footer-masthead">
				<div>
					<span class="baji-footer-eyebrow"><?php esc_html_e( 'BajiStyle / Since 2024', 'bajistyle' ); ?></span>
					<p><?php esc_html_e( 'برای زنانی که استایل را زندگی می‌کنند.', 'bajistyle' ); ?></p>
				</div>
				<a class="baji-footer-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</a>
			</div>

			<div class="baji-footer-grid">
				<div class="baji-footer-about">
					<p><?php echo esc_html( get_theme_mod( 'bajistyle_brand_story_text', __( 'انتخاب‌های زنانه و معاصر با توجه به کیفیت، فرم و جزئیاتی که ماندگار می‌شوند.', 'bajistyle' ) ) ); ?></p>
					<div class="baji-footer-socials" aria-label="<?php esc_attr_e( 'شبکه‌های اجتماعی باجی‌استایل', 'bajistyle' ); ?>">
						<?php
						$socials = array(
							'instagram' => array( 'icon' => 'fa-brands fa-instagram', 'label' => __( 'اینستاگرام', 'bajistyle' ) ),
							'telegram'  => array( 'icon' => 'fa-brands fa-telegram', 'label' => __( 'تلگرام', 'bajistyle' ) ),
							'whatsapp'  => array( 'icon' => 'fa-brands fa-whatsapp', 'label' => __( 'واتساپ', 'bajistyle' ) ),
							'pinterest' => array( 'icon' => 'fa-brands fa-pinterest-p', 'label' => __( 'پینترست', 'bajistyle' ) ),
						);
						foreach ( $socials as $key => $social ) :
							$url = get_theme_mod( 'bajistyle_social_' . $key );
							if ( $url ) :
								?>
								<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
									<i class="<?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></i>
								</a>
								<?php
							endif;
						endforeach;
						?>
					</div>
				</div>

				<nav class="baji-footer-navigation" aria-label="<?php esc_attr_e( 'راهنمای خرید', 'bajistyle' ); ?>">
					<h2><?php esc_html_e( 'راهنمای خرید', 'bajistyle' ); ?></h2>
					<?php if ( has_nav_menu( 'footer-2' ) ) : ?>
						<?php wp_nav_menu( array( 'theme_location' => 'footer-2', 'container' => false, 'menu_class' => 'baji-footer-menu', 'depth' => 1 ) ); ?>
					<?php else : ?>
						<ul class="baji-footer-menu">
							<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'سؤالات متداول', 'bajistyle' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'ارسال و بازگشت کالا', 'bajistyle' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'درباره باجی‌استایل', 'bajistyle' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'تماس با ما', 'bajistyle' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</nav>

				<div class="baji-footer-contact">
					<h2><?php esc_html_e( 'ارتباط', 'bajistyle' ); ?></h2>
					<?php $phone = get_theme_mod( 'bajistyle_contact_phone' ); ?>
					<?php $email = get_theme_mod( 'bajistyle_contact_email' ); ?>
					<?php $address = get_theme_mod( 'bajistyle_contact_address' ); ?>
					<?php if ( $phone ) : ?><a class="baji-footer-contact__primary" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
					<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
					<?php if ( $address ) : ?><address><?php echo esc_html( $address ); ?></address><?php endif; ?>
				</div>

				<div class="baji-footer-trust" aria-label="<?php esc_attr_e( 'مجوزها و نشان‌های اعتماد', 'bajistyle' ); ?>">
					<a referrerpolicy="origin" target="_blank" rel="noopener" href="https://trustseal.enamad.ir/?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn" aria-label="<?php esc_attr_e( 'مشاهده اعتبار اینماد', 'bajistyle' ); ?>">
						<img referrerpolicy="origin" src="https://trustseal.enamad.ir/logo.aspx?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn" loading="lazy" width="72" height="72" alt="<?php esc_attr_e( 'اینماد باجی‌استایل', 'bajistyle' ); ?>">
					</a>
					<a target="_blank" rel="noopener" href="https://buy-with-digikala.digify.shop/d-namad/store/a64f9bac-752d-4aa3-ab04-d8a5e44ecd00" aria-label="<?php esc_attr_e( 'مشاهده نشان خرید با دیجی‌کالا', 'bajistyle' ); ?>">
						<img loading="lazy" width="72" height="72" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/digilogo.svg' ); ?>" alt="<?php esc_attr_e( 'خرید با دیجی‌کالا', 'bajistyle' ); ?>">
					</a>
				</div>
			</div>

			<div class="baji-footer-bottom">
				<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> — <?php echo esc_html( get_theme_mod( 'bajistyle_footer_copyright', __( 'تمامی حقوق برای BajiStyle محفوظ است.', 'bajistyle' ) ) ); ?></p>
				<div>
					<a href="<?php echo esc_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'حریم خصوصی', 'bajistyle' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'قوانین و مقررات', 'bajistyle' ); ?></a>
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
