<?php
/**
 * فایل هدر قالب BajiStyle
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#111111" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'baji-body bg-baji-white text-baji-black font-vazir antialiased' ); ?>>
<?php wp_body_open(); ?>

<a class="baji-skip-link sr-only focus:not-sr-only focus:absolute focus:top-0 focus:right-0 focus:z-[100] focus:bg-baji-black focus:text-baji-white focus:px-4 focus:py-2" href="#main-content">
	<?php esc_html_e( 'رفتن به محتوای اصلی', 'bajistyle' ); ?>
</a>

<div id="page" class="baji-site-wrapper min-h-screen flex flex-col">

<!-- بنر تبلیغاتی بالای سایت -->
<div class="baji-top-banner w-full bg-baji-white flex justify-center">

	<a
		href="<?php echo esc_url( home_url( '/' ) ); ?>"
		class="block max-w-full"
	>
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/top-banner-mobile2.gif' ); ?>"
			alt="<?php esc_attr_e( 'بنر BajiStyle', 'bajistyle' ); ?>"
			width="420"
			height="50"
			class="block w-[420px] max-w-full h-auto"
		>
	</a>

	<!-- بنر دسکتاپ -->
	<a
		href="<?php echo esc_url( home_url( '/' ) ); ?>"
		class="hidden md:block w-full"
	>
		<img
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/banner-desktop.jpg' ); ?>"
			alt="<?php esc_attr_e( 'بنر BajiStyle', 'bajistyle' ); ?>"
			width="1400"
			height="100"
			class="block w-full h-[100px] object-cover"
		>
	</a>

</div>

<!-- کانتینر چسبان بالای صفحه شامل بنر و هدر -->
<div class="sticky top-0 z-50 w-full">



	<!-- هدر اصلی -->
	<header id="masthead" class="baji-header bg-baji-white border-b border-gray-100 transition-all duration-300" data-scrolled="false">
		<div class="baji-header-inner max-w-[1400px] mx-auto px-4 md:px-8">
			<div class="flex items-center justify-between h-20 md:h-24 relative">

				<!-- دکمه منوی موبایل -->
				<button type="button" class="baji-mobile-menu-toggle md:hidden flex flex-col gap-1.5 p-2" aria-label="<?php esc_attr_e( 'باز کردن منو', 'bajistyle' ); ?>" aria-expanded="false" aria-controls="baji-mobile-menu">
					<span class="block w-6 h-px bg-current"></span>
					<span class="block w-6 h-px bg-current"></span>
					<span class="block w-6 h-px bg-current"></span>
				</button>

				<!-- منوی اصلی دسکتاپ -->
				<nav id="baji-primary-navigation" class="baji-primary-nav hidden md:flex items-center gap-8" aria-label="<?php esc_attr_e( 'منوی اصلی', 'bajistyle' ); ?>">
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_class'     => 'baji-menu flex items-center gap-8',
								'walker'         => new BajiStyle_Mega_Menu_Walker(),
								'depth'          => 3,
							)
						);
					}
					?>
				</nav>

				<!-- لوگو -->
				<div class="baji-logo absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="baji-logo-text text-2xl md:text-3xl tracking-[0.3em] font-light">
							<?php bloginfo( 'name' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<!-- آیکون‌های هدر -->
				<div class="baji-header-actions flex items-center gap-4 md:gap-6 text-lg md:text-xl">
					<button type="button" class="baji-search-toggle flex items-center" aria-label="<?php esc_attr_e( 'باز کردن جستجو', 'bajistyle' ); ?>" aria-expanded="false" aria-controls="baji-search-panel">
						<i class="far fa-search" aria-hidden="true"></i>
					</button>

					<?php if ( class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'wishlist' ) ); ?>" class="baji-wishlist-link relative hidden md:flex items-center" aria-label="<?php esc_attr_e( 'علاقه‌مندی‌های من', 'bajistyle' ); ?>">
							<i class="far fa-heart" aria-hidden="true"></i>
							<span class="baji-wishlist-count absolute -top-2 -left-2 text-[10px] bg-baji-gold text-baji-black rounded-full w-4 h-4 flex items-center justify-center font-sans">
								<?php echo absint( bajistyle_get_wishlist_count() ); ?>
							</span>
						</a>

						<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="baji-account-link hidden md:flex items-center" aria-label="<?php esc_attr_e( 'حساب کاربری', 'bajistyle' ); ?>">
							<i class="far fa-user" aria-hidden="true"></i>
						</a>

						<button type="button" class="baji-cart-toggle relative flex items-center" aria-label="<?php esc_attr_e( 'باز کردن سبد خرید', 'bajistyle' ); ?>" aria-expanded="false" aria-controls="baji-cart-panel">
							<i class="far fa-shopping-bag" aria-hidden="true"></i>
							<span class="baji-cart-count absolute -top-2 -left-2 text-[10px] bg-baji-gold text-baji-black rounded-full w-4 h-4 flex items-center justify-center font-sans" data-cart-count="<?php echo absint( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>">
								<?php echo absint( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?>
							</span>
						</button>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div id="baji-search-backdrop" class="fixed inset-0 z-50 hidden bg-black/40" aria-hidden="true"></div>

		<!-- پنل جستجوی کشویی (z-index اصلاح شده) -->
		<div id="baji-search-panel" class="baji-search-panel fixed inset-x-0 top-0 bg-baji-white border-b border-gray-200 transform -translate-y-full transition-transform duration-300 z-[60]" aria-hidden="true">
			<div class="relative max-w-3xl mx-auto px-4 py-8" style="padding-left: 3.5rem;">
				<button type="button" id="baji-search-close" class="absolute top-3 left-4 p-2 text-gray-500 hover:text-baji-black" aria-label="Close search">
					<i class="far fa-times" aria-hidden="true"></i>
				</button>
				<?php get_product_search_form(); ?>
			</div>
		</div>
	</header>

</div>

<!-- منوی کشویی موبایل -->
<div id="baji-mobile-menu" class="baji-mobile-menu fixed inset-0 bg-baji-white z-[70] transform translate-x-full transition-transform duration-300" aria-hidden="true">
	<div class="flex items-center justify-between px-4 h-20 border-b border-gray-100">
		<span class="text-xl tracking-widest"><?php bloginfo( 'name' ); ?></span>
		<button type="button" class="baji-mobile-menu-close text-lg p-2" aria-label="<?php esc_attr_e( 'بستن منو', 'bajistyle' ); ?>">
			<i class="far fa-times" aria-hidden="true"></i>
		</button>
	</div>
	<nav class="px-4 py-8" aria-label="<?php esc_attr_e( 'منوی موبایل', 'bajistyle' ); ?>">
		<?php
		if ( has_nav_menu( 'mobile' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'mobile',
					'container'      => false,
					'menu_class'     => 'baji-mobile-menu-list flex flex-col gap-6 text-lg',
				)
			);
		} elseif ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'baji-mobile-menu-list flex flex-col gap-6 text-lg',
					'depth'          => 1,
				)
			);
		}
		?>
	</nav>
</div>

<!-- شروع محتوای اصلی -->
<main id="main-content" class="baji-main flex-1">
