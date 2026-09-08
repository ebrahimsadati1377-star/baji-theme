<?php
/**
 * Premium editorial footer for BajiStyle.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

	</main><!-- #main-content -->
	<?php get_template_part( 'template-parts/newsletter' ); ?>

	<footer id="colophon" class="baji-footer baji-footer-premium" dir="rtl">
		<div class="baji-footer-shell">
			<div class="baji-footer-masthead">
				<div class="baji-footer-intro">
					<span class="baji-footer-eyebrow"><?php esc_html_e( 'BAJISTYLE / SINCE 2024', 'bajistyle' ); ?></span>
					<h2><?php esc_html_e( 'برای زنانی که استایل را زندگی می‌کنند.', 'bajistyle' ); ?></h2>
					<p><?php echo esc_html( get_theme_mod( 'bajistyle_brand_story_text', __( 'انتخاب‌های زنانه و معاصر با تمرکز بر کیفیت، فرم و جزئیاتی که ماندگار می‌شوند.', 'bajistyle' ) ) ); ?></p>
				</div>
				<a class="baji-footer-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">BAJI</a>
			</div>

			<div class="baji-footer-divider" aria-hidden="true"></div>

			<div class="baji-footer-grid">
				<div class="baji-footer-column baji-footer-brand">
					<span class="baji-footer-title"><?php esc_html_e( 'با باجی همراه باشید', 'bajistyle' ); ?></span>
					<p><?php esc_html_e( 'کالکشن‌ها، استایل‌های تازه و خبرهای BAJI را دنبال کنید.', 'bajistyle' ); ?></p>
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
							if ( $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social['label'] ); ?>"><i class="<?php echo esc_attr( $social['icon'] ); ?>" aria-hidden="true"></i></a>
							<?php endif;
						endforeach; ?>
					</div>
				</div>

				<nav class="baji-footer-column baji-footer-navigation" aria-label="<?php esc_attr_e( 'راهنمای خرید', 'bajistyle' ); ?>">
					<span class="baji-footer-title"><?php esc_html_e( 'راهنمای خرید', 'bajistyle' ); ?></span>
					<?php if ( has_nav_menu( 'footer-2' ) ) :
						wp_nav_menu( array( 'theme_location' => 'footer-2', 'container' => false, 'menu_class' => 'baji-footer-menu', 'depth' => 1 ) );
					else : ?>
						<ul class="baji-footer-menu">
							<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'سؤالات متداول', 'bajistyle' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'ارسال و بازگشت کالا', 'bajistyle' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'درباره باجی‌استایل', 'bajistyle' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'تماس با ما', 'bajistyle' ); ?></a></li>
						</ul>
					<?php endif; ?>
				</nav>

				<div class="baji-footer-column baji-footer-contact">
					<span class="baji-footer-title"><?php esc_html_e( 'ارتباط با ما', 'bajistyle' ); ?></span>
					<?php $phone = get_theme_mod( 'bajistyle_contact_phone' ); $email = get_theme_mod( 'bajistyle_contact_email' ); $address = get_theme_mod( 'bajistyle_contact_address' ); ?>
					<?php if ( $phone ) : ?><a class="baji-footer-contact__primary" href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a><?php endif; ?>
					<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
					<?php if ( $address ) : ?><address><?php echo esc_html( $address ); ?></address><?php endif; ?>
				</div>

				<div class="baji-footer-column baji-footer-trust-wrap">
					<span class="baji-footer-title"><?php esc_html_e( 'خرید مطمئن', 'bajistyle' ); ?></span>
					<div class="baji-footer-trust" aria-label="<?php esc_attr_e( 'مجوزها و نشان‌های اعتماد', 'bajistyle' ); ?>">
						<a referrerpolicy="origin" target="_blank" rel="noopener" href="https://trustseal.enamad.ir/?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn" aria-label="<?php esc_attr_e( 'مشاهده اعتبار اینماد', 'bajistyle' ); ?>"><img referrerpolicy="origin" src="https://trustseal.enamad.ir/logo.aspx?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn" loading="lazy" width="72" height="72" alt="<?php esc_attr_e( 'اینماد باجی‌استایل', 'bajistyle' ); ?>"></a>
						<a target="_blank" rel="noopener" href="https://buy-with-digikala.digify.shop/d-namad/store/a64f9bac-752d-4aa3-ab04-d8a5e44ecd00" aria-label="<?php esc_attr_e( 'مشاهده نشان خرید با دیجی‌کالا', 'bajistyle' ); ?>"><img loading="lazy" width="72" height="72" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/digilogo.svg' ); ?>" alt="<?php esc_attr_e( 'خرید با دیجی‌کالا', 'bajistyle' ); ?>"></a>
					</div>
				</div>
			</div>

			<div class="baji-footer-bottom">
				<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> — <?php echo esc_html( get_theme_mod( 'bajistyle_footer_copyright', __( 'تمامی حقوق برای BajiStyle محفوظ است.', 'bajistyle' ) ) ); ?></p>
				<div class="baji-footer-legal"><a href="<?php echo esc_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'حریم خصوصی', 'bajistyle' ); ?></a><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'قوانین و مقررات', 'bajistyle' ); ?></a></div>
			</div>
		</div>
	</footer>

	<style id="baji-premium-footer-css">
	.baji-footer-premium{background:#11110f;color:#f6f2e9;margin-top:0;direction:rtl}.baji-footer-premium *{box-sizing:border-box}.baji-footer-shell{max-width:1440px;margin:0 auto;padding:72px 5vw 28px}.baji-footer-masthead{display:flex;justify-content:space-between;align-items:flex-end;gap:48px}.baji-footer-intro{max-width:620px}.baji-footer-eyebrow{display:block;color:#c7a968;font-size:11px;letter-spacing:.22em;margin-bottom:18px;direction:ltr;text-align:right}.baji-footer-intro h2{font-size:clamp(24px,3vw,44px);line-height:1.45;font-weight:500;margin:0 0 16px;color:#fff}.baji-footer-intro p,.baji-footer-brand p{color:#aaa79f;font-size:14px;line-height:2;margin:0;max-width:520px}.baji-footer-wordmark{font-family:Arial,sans-serif;font-size:clamp(58px,10vw,150px);line-height:.75;font-weight:700;letter-spacing:-.06em;color:#f6f2e9!important;text-decoration:none!important;direction:ltr;opacity:.96}.baji-footer-divider{height:1px;background:rgba(255,255,255,.13);margin:58px 0 44px}.baji-footer-grid{display:grid;grid-template-columns:1.35fr 1fr 1fr .9fr;gap:50px}.baji-footer-column{min-width:0}.baji-footer-title{display:block;color:#f6f2e9;font-size:13px;font-weight:600;margin-bottom:22px}.baji-footer-menu{list-style:none!important;margin:0!important;padding:0!important}.baji-footer-menu li{margin:0 0 12px}.baji-footer-premium a{color:#aaa79f;text-decoration:none;transition:color .25s ease,transform .25s ease}.baji-footer-menu a,.baji-footer-contact a,.baji-footer-contact address{font-size:13px;line-height:1.9}.baji-footer-premium a:hover{color:#c7a968}.baji-footer-contact{display:flex;flex-direction:column;align-items:flex-start;gap:8px}.baji-footer-contact .baji-footer-title{margin-bottom:14px}.baji-footer-contact__primary{color:#f6f2e9!important;font-size:16px!important;direction:ltr}.baji-footer-contact address{font-style:normal;color:#aaa79f}.baji-footer-socials{display:flex;gap:9px;margin-top:22px;direction:ltr;justify-content:flex-end}.baji-footer-socials a{width:38px;height:38px;border:1px solid rgba(255,255,255,.16);border-radius:50%;display:grid;place-items:center;color:#f6f2e9}.baji-footer-socials a:hover{border-color:#c7a968;color:#c7a968;transform:translateY(-2px)}.baji-footer-trust{display:flex;gap:10px;flex-wrap:wrap}.baji-footer-trust a{width:88px;height:88px;background:#f8f6f0;border-radius:10px;display:grid;place-items:center;padding:8px}.baji-footer-trust img{max-width:70px;max-height:70px;object-fit:contain}.baji-footer-bottom{border-top:1px solid rgba(255,255,255,.13);margin-top:46px;padding-top:24px;display:flex;align-items:center;justify-content:space-between;gap:24px;color:#77746e;font-size:11px}.baji-footer-bottom p{margin:0}.baji-footer-legal{display:flex;gap:24px}.baji-footer-legal a{font-size:11px;color:#77746e}@media(max-width:900px){.baji-footer-shell{padding:56px 24px 92px}.baji-footer-masthead{display:block}.baji-footer-wordmark{display:block;margin-top:48px;font-size:24vw;text-align:left}.baji-footer-divider{margin:42px 0 34px}.baji-footer-grid{grid-template-columns:1fr 1fr;gap:38px 24px}.baji-footer-bottom{align-items:flex-start;flex-direction:column-reverse}.baji-footer-socials{justify-content:flex-start}}@media(max-width:560px){.baji-footer-shell{padding-right:20px;padding-left:20px}.baji-footer-grid{grid-template-columns:1fr;gap:34px}.baji-footer-intro h2{font-size:26px}.baji-footer-wordmark{font-size:27vw}.baji-footer-trust a{width:82px;height:82px}.baji-footer-bottom{margin-top:36px}.baji-footer-legal{gap:18px}}
	</style>

	<!-- نوار ناوبری پایین موبایل -->
	<div class="baji-mobile-bottom-nav md:hidden fixed bottom-0 inset-x-0 z-50 border-t border-gray-100 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] flex items-center justify-around h-16 px-2" style="background-color:#ffffff!important;">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors"><i class="far fa-home text-xl"></i><span class="text-[10px] font-medium tracking-wide">خانه</span></a>
		<button type="button" class="baji-cart-toggle flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors" aria-label="<?php esc_attr_e( 'باز کردن سبد خرید', 'bajistyle' ); ?>" aria-expanded="false" aria-controls="baji-cart-panel"><div class="relative inline-block leading-none"><i class="far fa-shopping-bag text-xl"></i><span class="baji-cart-count absolute -top-2 -left-2 text-[10px] bg-baji-gold text-baji-black rounded-full w-4 h-4 flex items-center justify-center font-sans" data-cart-count="<?php echo absint( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>"><?php echo absint( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span></div><span class="text-[10px] font-medium tracking-wide">سبد خرید</span></button>
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'wishlist' ) ); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors"><i class="far fa-heart text-xl"></i><span class="text-[10px] font-medium tracking-wide">علاقه‌مندی</span></a>
		<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-black flex-1 py-1 transition-colors"><i class="far fa-user text-xl"></i><span class="text-[10px] font-medium tracking-wide">حساب من</span></a>
	</div>
</div><!-- #page -->

<div id="baji-cart-panel" class="fixed inset-y-0 left-0 bg-white shadow-2xl transition-transform duration-300" style="z-index:9999;width:400px;max-width:100%;transform:translateX(-100%);">
	<div class="flex justify-between items-center p-4 border-b"><h3 class="font-bold">سبد خرید</h3><button id="baji-cart-close" class="text-2xl p-2 hover:text-red-500 transition-colors">&times;</button></div>
	<div class="p-4 overflow-y-auto widget_shopping_cart_content" style="height:calc(100vh - 65px);"><?php woocommerce_mini_cart(); ?></div>
</div>
<div id="baji-cart-overlay" class="fixed inset-0 backdrop-blur-sm transition-opacity duration-300" style="z-index:9998;background-color:rgba(0,0,0,.5);opacity:0;pointer-events:none;"></div>
<?php wp_footer(); ?>
</body>
</html>
