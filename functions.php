<?php
/**
 * فایل اصلی توابع قالب BajiStyle
 *
 * این فایل شامل تمام هوک‌ها، فیلترها، تنظیمات Customizer،
 * بارگذاری استایل‌ها و اسکریپت‌ها، پشتیبانی از ووکامرس،
 * Custom Post Type ها و توابع کمکی قالب است.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

// جلوگیری از دسترسی مستقیم به فایل
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * ثابت‌های قالب
 * ---------------------------------------------------------------------- */
define( 'BAJISTYLE_VERSION', '1.0.4' );
define( 'BAJISTYLE_DIR', get_template_directory() );
define( 'BAJISTYLE_URI', get_template_directory_uri() );

/* -------------------------------------------------------------------------
 * راه‌اندازی اولیه قالب
 * ---------------------------------------------------------------------- */
if ( ! function_exists( 'bajistyle_setup' ) ) :
	/**
	 * تنظیمات اولیه و قابلیت‌های قالب را راه‌اندازی می‌کند.
	 *
	 * این تابع در هوک after_setup_theme فراخوانی می‌شود چون تمام
	 * APIهای مورد نیاز در آن لحظه در دسترس هستند.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_setup() {
		// بارگذاری فایل ترجمه قالب
		load_theme_textdomain( 'bajistyle', BAJISTYLE_DIR . '/languages' );

		// افزودن RSS feed لینک به <head>
		add_theme_support( 'automatic-feed-links' );

		// اجازه به وردپرس برای مدیریت عنوان صفحه (title tag)
		add_theme_support( 'title-tag' );

		// پشتیبانی از تصویر شاخص (Post Thumbnail)
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 800, 1000, true );

		// اندازه‌های تصویر اختصاصی قالب
		add_image_size( 'bajistyle-product-grid', 600, 800, true );
		add_image_size( 'bajistyle-hero', 1920, 1080, true );
		add_image_size( 'bajistyle-hero-mobile', 1080, 1350, true );
		add_image_size( 'bajistyle-category', 700, 900, true );
		add_image_size( 'bajistyle-thumbnail-small', 150, 200, true );

		// ثبت منوهای ناوبری
		register_nav_menus(
			array(
				'primary'   => __( 'منوی اصلی', 'bajistyle' ),
				'mobile'    => __( 'منوی موبایل', 'bajistyle' ),
				'footer-1'  => __( 'فوتر - درباره ما', 'bajistyle' ),
				'footer-2'  => __( 'فوتر - راهنمای خرید', 'bajistyle' ),
				'footer-3'  => __( 'فوتر - ارتباط با ما', 'bajistyle' ),
			)
		);

		// پشتیبانی از HTML5 برای عناصر مختلف
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			)
		);

		// پشتیبانی از Custom Logo
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 80,
				'width'       => 200,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// پشتیبانی از Custom Background
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'FFFFFF',
			)
		);

		// پشتیبانی کامل از ووکامرس
		add_theme_support( 'woocommerce' );
		add_theme_support(
			'wc-product-gallery-zoom'
		);
		add_theme_support(
			'wc-product-gallery-lightbox'
		);
		add_theme_support(
			'wc-product-gallery-slider'
		);

		// پشتیبانی از ادیتور بلوک (Gutenberg)
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/tailwind.css' );

		// تعریف پالت رنگی برند برای ادیتور بلوک
		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'طلایی برند', 'bajistyle' ),
					'slug'  => 'baji-gold',
					'color' => '#C9A227',
				),
				array(
					'name'  => __( 'مشکی', 'bajistyle' ),
					'slug'  => 'baji-black',
					'color' => '#111111',
				),
				array(
					'name'  => __( 'سفید', 'bajistyle' ),
					'slug'  => 'baji-white',
					'color' => '#FFFFFF',
				),
				array(
					'name'  => __( 'کرم روشن', 'bajistyle' ),
					'slug'  => 'baji-cream',
					'color' => '#F8F5EF',
				),
			)
		);

		// عرض پیش‌فرض محتوا (برای جاسازی صحیح ویدیو/تصویر)
		$GLOBALS['content_width'] = 1200;
	}
endif;
add_action( 'after_setup_theme', 'bajistyle_setup' );

/* -------------------------------------------------------------------------
 * تنظیمات عرض محتوای ووکامرس
 * ---------------------------------------------------------------------- */
/**
 * عرض گالری تصاویر محصول ووکامرس را تنظیم می‌کند.
 *
 * @return array تنظیمات عرض تصویر گالری محصول.
 */
function bajistyle_woocommerce_image_dimensions() {
	$catalog = array(
		'width'  => 600,
		'height' => 800,
		'crop'   => 1,
	);
	$single = array(
		'width'  => 800,
		'height' => 1000,
		'crop'   => 1,
	);
	$thumbnail = array(
		'width'  => 150,
		'height' => 200,
		'crop'   => 1,
	);

	update_option( 'shop_catalog_image_size', $catalog );
	update_option( 'shop_single_image_size', $single );
	update_option( 'shop_thumbnail_image_size', $thumbnail );
}
add_action( 'after_switch_theme', 'bajistyle_woocommerce_image_dimensions' );

/* -------------------------------------------------------------------------
 * ثبت منوهای ابزارک (Widget Areas)
 * ---------------------------------------------------------------------- */
/**
 * نواحی ابزارک قالب را ثبت می‌کند.
 *
 * @since 1.0.0
 */
function bajistyle_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'سایدبار وبلاگ', 'bajistyle' ),
			'id'            => 'sidebar-blog',
			'description'   => __( 'این ناحیه در صفحات وبلاگ و آرشیو مقالات نمایش داده می‌شود.', 'bajistyle' ),
			'before_widget' => '<div id="%1$s" class="baji-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="baji-widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'فیلتر فروشگاه (ووکامرس)', 'bajistyle' ),
			'id'            => 'shop-sidebar',
			'description'   => __( 'این ناحیه در سایدبار فیلتر صفحه آرشیو فروشگاه نمایش داده می‌شود. در صورت خالی بودن، فیلترهای پیش‌فرض قالب نمایش داده می‌شوند.', 'bajistyle' ),
			'before_widget' => '<div id="%1$s" class="baji-filter-group %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="text-sm tracking-widest uppercase mb-4">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'فوتر - ستون درباره ما', 'bajistyle' ),
			'id'            => 'footer-about',
			'description'   => __( 'ستون اول فوتر.', 'bajistyle' ),
			'before_widget' => '<div id="%1$s" class="baji-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="baji-footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'فوتر - شبکه‌های اجتماعی', 'bajistyle' ),
			'id'            => 'footer-social',
			'description'   => __( 'ستون چهارم فوتر برای آیکون‌های شبکه‌های اجتماعی.', 'bajistyle' ),
			'before_widget' => '<div id="%1$s" class="baji-footer-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="baji-footer-widget-title">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'bajistyle_widgets_init' );

/* -------------------------------------------------------------------------
 * بارگذاری استایل‌ها و اسکریپت‌ها (Enqueue)
 * ---------------------------------------------------------------------- */
/**
 * استایل‌ها و اسکریپت‌های قالب را به‌درستی بارگذاری می‌کند.
 *
 * @since 1.0.0
 */
function bajistyle_enqueue_assets() {
	// فونت وزیرمتن از فایل محلی
	wp_enqueue_style(
		'bajistyle-vazirmatn-font',
		BAJISTYLE_URI . '/assets/fonts/vazirmatn/vazirmatn.css',
		array(),
		BAJISTYLE_VERSION
	);

	// خروجی Tailwind (فایل کامپایل‌شده)
	wp_enqueue_style(
		'bajistyle-tailwind',
		BAJISTYLE_URI . '/assets/css/tailwind.css',
		array(),
		BAJISTYLE_VERSION
	);

	// استایل‌های اختصاصی قالب (وابسته به تیلویند)
	wp_enqueue_style(
		'bajistyle-custom',
		BAJISTYLE_URI . '/assets/css/custom.css',
		array( 'bajistyle-tailwind' ),
		BAJISTYLE_VERSION
	);
	
	// لود فونت‌اوسام پرو (نسخه مینیفای شده و سبک) - وابستگی‌های اشتباه حذف شدند
	wp_enqueue_style(
		'bajistyle-fontawesome-pro',
		BAJISTYLE_URI . '/assets/css/all.min.css',
		array(),
		BAJISTYLE_VERSION
	);

	// استایل style.css برای شناسایی استاندارد قالب وردپرس
	wp_enqueue_style(
		'bajistyle-style',
		get_stylesheet_uri(),
		array(),
		BAJISTYLE_VERSION
	);

	// اسکریپت‌های اصلی قالب
	wp_enqueue_script(
		'bajistyle-navigation',
		BAJISTYLE_URI . '/assets/js/navigation.js',
		array(),
		BAJISTYLE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	wp_enqueue_script(
		'bajistyle-animations',
		BAJISTYLE_URI . '/assets/js/animations.js',
		array(),
		BAJISTYLE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	wp_enqueue_script(
		'bajistyle-main',
		BAJISTYLE_URI . '/assets/js/main.js',
		array( 'bajistyle-navigation', 'bajistyle-animations' ),
		BAJISTYLE_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// اسکریپت‌های اختصاصی ووکامرس فقط در صفحات مرتبط
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script(
			'bajistyle-woocommerce',
			BAJISTYLE_URI . '/assets/js/woocommerce.js',
			array( 'jquery' ),
			BAJISTYLE_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		wp_enqueue_script(
			'bajistyle-cart',
			BAJISTYLE_URI . '/assets/js/cart.js',
			array( 'jquery', 'bajistyle-woocommerce' ),
			BAJISTYLE_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);

		if ( is_checkout() ) {
			wp_enqueue_script(
				'bajistyle-checkout',
				BAJISTYLE_URI . '/assets/js/checkout.js',
				array( 'jquery', 'bajistyle-woocommerce' ),
				BAJISTYLE_VERSION,
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);
		}

		/**
		 * اسکریپت AJAX صفحه تک‌محصول (افزودن به سبد بدون رفرش، سوییچ
		 * رنگ/سایز، دکمه‌های تعداد، لایت‌باکس گالری).
		 *
		 * توجه فنی مهم: این اسکریپت قبلاً به‌صورت <script> درون‌خطی
		 * وسط فایل woocommerce/single-product.php قرار داشت. مشکل این
		 * روش این است که ترتیب اجرای آن به محل دقیق بارگذاری jQuery در
		 * صفحه بستگی دارد؛ اگر jQuery (مثلاً توسط یک افزونه کش/بهینه‌ساز
		 * مانند LiteSpeed Cache یا WP Rocket با گزینه «انتقال jQuery به
		 * پایین صفحه») دیرتر از این اسکریپت اجرا شود، کل اسکریپت با خطای
		 * «jQuery is not defined» متوقف می‌شود و دکمه افزودن به سبد هیچ
		 * واکنشی نشان نمی‌دهد — دقیقاً همان رفتاری که گزارش شده است.
		 * با enqueue کردن این فایل و اعلام صریح وابستگی به 'jquery'،
		 * وردپرس تضمین می‌کند jQuery همیشه پیش از این اسکریپت بارگذاری
		 * شود، صرف‌نظر از تنظیمات کش/بهینه‌سازی سایت.
		 */
		if ( is_product() ) {
			wp_enqueue_script(
				'bajistyle-single-product-ajax',
				BAJISTYLE_URI . '/assets/js/single-product-ajax.js',
				array( 'jquery' ),
				BAJISTYLE_VERSION,
				array(
					'in_footer' => true,
					'strategy'  => 'defer',
				)
			);
		}

		// ارسال داده‌های لازم از PHP به جاوااسکریپت به‌صورت امن
		wp_localize_script(
			'bajistyle-woocommerce',
			'bajistyleWC',
			array(
				'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'bajistyle_wc_nonce' ),
				'cartUrl'        => wc_get_cart_url(),
				'checkoutUrl'    => wc_get_checkout_url(),
				'currencySymbol' => get_woocommerce_currency_symbol(),
				'i18n'           => array(
					'addedToCart'   => __( 'به سبد خرید اضافه شد', 'bajistyle' ),
					'addToWishlist' => __( 'افزودن به علاقه‌مندی‌ها', 'bajistyle' ),
					'removeFromWishlist' => __( 'حذف از علاقه‌مندی‌ها', 'bajistyle' ),
					'outOfStock'    => __( 'ناموجود', 'bajistyle' ),
					'error'         => __( 'خطایی رخ داد. لطفاً دوباره تلاش کنید.', 'bajistyle' ),
				),
			)
		);
	}

	// پشتیبانی از کامنت‌های تو در تو
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bajistyle_enqueue_assets' );

/**
 * بارگذاری اسکریپت‌های جاوااسکریپت به‌صورت ماژول (type="module").
 *
 * @param string $tag    تگ اسکریپت اصلی.
 * @param string $handle نام دستگیره اسکریپت.
 * @return string تگ اصلاح‌شده.
 */
function bajistyle_add_module_type( $tag, $handle ) {
	$module_scripts = array(
		'bajistyle-main',
		'bajistyle-navigation',
		'bajistyle-animations',
		'bajistyle-woocommerce',
		'bajistyle-cart',
		'bajistyle-checkout',
	);

	if ( in_array( $handle, $module_scripts, true ) ) {
		$tag = str_replace( ' src', ' type="module" src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'bajistyle_add_module_type', 10, 2 );

/* -------------------------------------------------------------------------
 * بارگذاری فایل‌های اضافی قالب (inc)
 * ---------------------------------------------------------------------- */
require BAJISTYLE_DIR . '/inc/class-mega-menu-walker.php';
require BAJISTYLE_DIR . '/inc/customizer.php';
require BAJISTYLE_DIR . '/inc/custom-post-types.php';
require BAJISTYLE_DIR . '/inc/woocommerce-hooks.php';
require BAJISTYLE_DIR . '/inc/wishlist.php';
require BAJISTYLE_DIR . '/inc/recently-viewed.php';
require BAJISTYLE_DIR . '/inc/newsletter.php';
require BAJISTYLE_DIR . '/inc/template-tags.php';
require BAJISTYLE_DIR . '/inc/security.php';
require BAJISTYLE_DIR . '/inc/seo.php';
require BAJISTYLE_DIR . '/inc/product-video.php';

/* -------------------------------------------------------------------------
 * ثبت بلوک‌های قالب برای Gutenberg
 * ---------------------------------------------------------------------- */
/**
 * استایل‌های سفارشی بلوک Gutenberg را اضافه می‌کند.
 *
 * @since 1.0.0
 */
function bajistyle_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/button',
		array(
			'name'  => 'baji-outline-gold',
			'label' => __( 'حاشیه طلایی', 'bajistyle' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'baji-cream-bg',
			'label' => __( 'پس‌زمینه کرم', 'bajistyle' ),
		)
	);
}
add_action( 'init', 'bajistyle_register_block_styles' );

/**
 * پهنای صف بلوک‌های گوتنبرگ را با Tailwind هماهنگ می‌کند.
 *
 * @since 1.0.0
 */
function bajistyle_block_editor_assets() {
	wp_enqueue_style(
		'bajistyle-block-editor-style',
		BAJISTYLE_URI . '/assets/css/custom.css',
		array(),
		BAJISTYLE_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'bajistyle_block_editor_assets' );

/* -------------------------------------------------------------------------
 * بهینه‌سازی و عملکرد
 * ---------------------------------------------------------------------- */
/**
 * حذف نسخه کوئری‌استرینگ از فایل‌های استایل و اسکریپت برای بهبود کش مرورگر.
 *
 * @param string $src آدرس فایل.
 * @return string آدرس بدون نسخه.
 */
function bajistyle_remove_version_query_string( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'bajistyle_remove_version_query_string', 9999 );
add_filter( 'script_loader_src', 'bajistyle_remove_version_query_string', 9999 );

/**
 * غیرفعال‌سازی Emoji های پیش‌فرض وردپرس برای افزایش سرعت بارگذاری.
 *
 * @since 1.0.0
 */
function bajistyle_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'bajistyle_disable_emojis' );

/**
 * فعال‌سازی lazy load بومی برای تصاویر محتوا (پشتیبانی پیش‌فرض وردپرس).
 * این فیلتر صرفاً برای اطمینان از سازگاری اعمال شده است.
 */
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

/* -------------------------------------------------------------------------
 * پشتیبانی از Child Theme
 * ---------------------------------------------------------------------- */
/**
 * در صورت استفاده از قالب فرزند، استایل آن را پس از استایل والد بارگذاری می‌کند.
 *
 * @since 1.0.0
 */
function bajistyle_child_theme_support() {
	if ( is_child_theme() ) {
		wp_enqueue_style(
			'bajistyle-child-style',
			get_stylesheet_directory_uri() . '/style.css',
			array( 'bajistyle-custom' ),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'bajistyle_child_theme_support', 20 );

/* -------------------------------------------------------------------------
 * محدودیت‌های امنیتی پایه (تکمیلی در inc/security.php)
 * ---------------------------------------------------------------------- */
/**
 * نسخه وردپرس را از خروجی head و RSS مخفی می‌کند.
 *
 * @return string رشته خالی.
 */
function bajistyle_remove_wp_version() {
	return '';
}
add_filter( 'the_generator', 'bajistyle_remove_wp_version' );



/**
 * BajiStyle - Redirect WooCommerce My Account to Custom Login
 */

// 1. Redirect anyone accessing /my-account/ to /login/
add_action('template_redirect', 'baji_redirect_my_account_to_login');
function baji_redirect_my_account_to_login() {
    // Check if we're on the my-account page and user is not logged in
    if (is_page('my-account') || (function_exists('is_account_page') && is_account_page())) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/login'), 301);
            exit;
        }
    }
}

// 2. Override WooCommerce's account page endpoint for non-logged-in users
add_filter('woocommerce_account_menu_items', 'baji_custom_my_account_menu', 999);
function baji_custom_my_account_menu($menu_items) {
    // If user is not logged in, remove all menu items except login/register
    if (!is_user_logged_in()) {
        return array(); // Return empty array to hide menu
    }
    return $menu_items;
}

// 3. Redirect all WooCommerce login/register endpoints
add_action('init', 'baji_redirect_woocommerce_login_endpoints');
function baji_redirect_woocommerce_login_endpoints() {
    if (!is_user_logged_in()) {
        global $wp;
        
        // Check for WooCommerce login/register endpoints
        if (isset($wp->query_vars['lost-password']) || 
            isset($wp->query_vars['register']) || 
            isset($wp->query_vars['edit-account'])) {
            
            wp_redirect(home_url('/login'), 301);
            exit;
        }
    }
}

// 4. Change WooCommerce My Account endpoint for non-logged-in users
add_filter('woocommerce_login_redirect', 'baji_redirect_to_home', 999);
add_filter('woocommerce_registration_redirect', 'baji_redirect_to_home', 999);
function baji_redirect_to_home($redirect) {
    return home_url('/');
}

// 5. If using page template, force redirect
add_action('wp', 'baji_force_redirect_from_my_account');
function baji_force_redirect_from_my_account() {
    if (is_page('my-account') && !is_user_logged_in()) {
        wp_redirect(home_url('/login'), 301);
        exit;
    }
}

// 6. Hide WooCommerce My Account from menu for guests (optional)
add_filter('wp_nav_menu_objects', 'baji_hide_my_account_from_menu', 10, 2);
function baji_hide_my_account_from_menu($items, $args) {
    if (!is_user_logged_in()) {
        foreach ($items as $key => $item) {
            // Hide if menu item links to my-account
            if (strpos($item->url, '/my-account') !== false) {
                unset($items[$key]);
            }
        }
    }
    return $items;
}


function baji_enqueue_swiper() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
}
add_action('wp_enqueue_scripts', 'baji_enqueue_swiper');


add_filter( 'woocommerce_get_price_html', 'remove_toman_from_regular_price', 10, 2 );

function remove_toman_from_regular_price( $price, $product ) {
    // بررسی اینکه آیا محصول در حراج است یا خیر
    if ( $product->is_on_sale() ) {
        // حذف کلمه تومان از داخل تگ <del> (قیمت خط‌خورده)
        // این عبارت منظم (Regex) فقط داخل تگ del را هدف قرار می‌دهد
        $price = preg_replace( '/(<del[^>]*>.*?)(تومان)(.*?<\/del>)/u', '$1$3', $price );
    }
    return $price;
}


// در فایل functions.php قالب
add_filter('woocommerce_product_tabs', 'customize_product_tabs_with_icons', 98);
function customize_product_tabs_with_icons($tabs) {
    // افزودن آیکون به تب توضیحات
    $tabs['description']['title'] = '<i class="fas fa-align-left"></i> توضیحات';
    
    // افزودن آیکون به تب اطلاعات
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = '<i class="fas fa-tags"></i> مشخصات';
    }
    
    // افزودن آیکون به تب نظرات
    if (isset($tabs['reviews'])) {
        $tabs['reviews']['title'] = '<i class="fas fa-star"></i> نظرات';
    }
    
    return $tabs;
}



/**
 * افزودن کلاس‌های Tailwind به دکمه‌های مینی‌کارت
 */
add_filter( 'woocommerce_widget_shopping_cart_buttons', function( $buttons ) {
    return str_replace( 
        array( 'button wc-forward', 'button checkout wc-forward' ), 
        array( 
            'button wc-forward block w-full text-center py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-all', 
            'button checkout wc-forward block w-full text-center py-3 bg-baji-black hover:bg-baji-gold text-white hover:text-black font-medium rounded-lg transition-all mt-2' 
        ), 
        $buttons 
    );
}, 10 );



/**
 * ۱. مدیریت فیلدهای تسویه‌حساب، تغییر اولویت و غیرفعال کردن اعتبارسنجی فیلدهای مخفی
 */
add_filter( 'woocommerce_checkout_fields', 'baji_fix_and_customize_checkout_fields', 9999 );
function baji_fix_and_customize_checkout_fields( $fields ) {

    // تنظیم ترتیب و اولویت نمایش
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_last_name']['priority']  = 20;
    $fields['billing']['billing_phone']['priority']      = 30;
    $fields['billing']['billing_state']['priority']      = 40; // استان
    $fields['billing']['billing_city']['priority']       = 50; // شهر
    $fields['billing']['billing_address_1']['priority']  = 60; // آدرس کامل

    // اجباری کردن شماره تماس و تغییر لیبل آدرس
    $fields['billing']['billing_phone']['required']     = true;
    $fields['billing']['billing_address_1']['label']    = 'آدرس کامل';

    // غیرفعال کردن الزام (Required) برای فیلدهایی که قرار است مخفی شوند
    $fields['billing']['billing_country']['required']  = false;
    $fields['billing']['billing_postcode']['required'] = false;
    $fields['billing']['billing_email']['required']    = false;

    // مخفی کردن فیلدهای اضافه با کلاس CSS
    $fields['billing']['billing_country']['class'][]  = 'hidden';
    $fields['billing']['billing_postcode']['class'][] = 'hidden';
    $fields['billing']['billing_email']['class'][]    = 'hidden';

    // حذف کامل فیلدهای شرکتی و آدرس دوم
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_address_2'] );
 
    return $fields;
}

/**
 * ۲. تنظیم کشور پیش‌فرض روی ایران (IR) برای جلوگیری از ارور کشور
 */
add_filter( 'default_checkout_billing_country', 'baji_set_default_country' );
function baji_set_default_country() {
    return 'IR'; // کد دو حرفی کشور ایران
}

/**
 * ۳. مقداردهی ایمیل پیش‌فرض در صورت خالی بودن
 */
add_action( 'woocommerce_checkout_create_order', 'baji_set_default_checkout_email', 10, 2 );
function baji_set_default_checkout_email( $order, $data ) {
    if ( empty( $data['billing_email'] ) ) {
        $order->set_billing_email( 'no-reply@bajistyle.ir' );
    }
}

/**
 * ۴. استایل CSS برای مخفی‌سازی کامل عناصر در فرانت‌اند
 */
add_action( 'wp_head', 'baji_checkout_custom_css' );
function baji_checkout_custom_css() {
    if ( is_checkout() ) {
        echo '<style>
            .woocommerce-billing-fields .form-row.hidden { display: none !important; }
            .woocommerce-billing-fields > h3 { display: none !important; }
        </style>';
    }
}


/**
 * هدایت کاربر لاگین‌نکرده به صفحه لاگین و بازگشت به تسویه‌حساب بعد از لاگین
 */
add_action( 'template_redirect', 'baji_force_login_checkout' );

function baji_force_login_checkout() {
    // اگر در صفحه تسویه حساب هستیم و کاربر لاگین نیست
    if ( is_checkout() && ! is_user_logged_in() ) {
        
        // آدرس صفحه لاگین (در اینجا صفحه حساب کاربری ووکامرس است)
        $login_page_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
        
        // آدرس فعلی (Checkout) را به عنوان پارامتر برای بازگشت ذخیره می‌کنیم
        $redirect_url = add_query_arg( 'redirect_to', urlencode( wc_get_checkout_url() ), $login_page_url );
        
        wp_redirect( $redirect_url );
        exit;
    }
}



/**
 * حل مشکل انکودینگ نام ویژگی‌های فارسی در درخواست‌های AJAX افزودن به سبد خرید ووکامرس
 */
add_action('woocommerce_before_add_to_cart_handler', function() {
    if (isset($_GET['wc-ajax']) && $_GET['wc-ajax'] === 'add_to_cart') {
        $decoded_post = array();
        foreach ($_POST as $key => $value) {
            $decoded_key = urldecode($key);
            $decoded_post[$decoded_key] = $value;
        }
        $_POST = array_merge($_POST, $decoded_post);
    }
}, 5);


/**
 * جایگزینی هاندر AJAX ووکامرس برای پشتیبانی کامل از محصولات متغیر
 */
/**
 * هاندر اصلاح‌شده AJAX ووکامرس برای پشتیبانی کامل از محصولات متغیر و ساده
 */
remove_action( 'wc_ajax_add_to_cart', array( 'WC_AJAX', 'add_to_cart' ) );
add_action( 'wc_ajax_add_to_cart', 'baji_custom_ajax_add_to_cart' );

function baji_custom_ajax_add_to_cart() {
    ob_start();

    // پاکسازی پیام‌های قبلی
    wc_clear_notices();

    $product_id   = absint( $_POST['product_id'] ?? $_POST['add-to-cart'] ?? 0 );
    $quantity     = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
    $variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
    $variations   = array();

    // اگر متغیر انتخاب شده، شناسه محصول اصلی (Parent ID) را استخراج می‌کنیم
    if ( $variation_id > 0 ) {
        $variation_obj = wc_get_product( $variation_id );
        if ( $variation_obj ) {
            $product_id = $variation_obj->get_parent_id();
        }
    }

    $product_id = apply_filters( 'woocommerce_add_to_cart_product_id', $product_id );

    // استخراج و Decode ویژگی‌های انتخابی (رنگ، سایز و ...)
    foreach ( $_POST as $key => $value ) {
        if ( strpos( $key, 'attribute_' ) === 0 ) {
            $variations[ urldecode( $key ) ] = wp_unslash( $value );
        }
    }

    // اعتبارسنجی اولیه ووکامرس
    $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );

    if ( $passed_validation && $product_id ) {
        // افزودن به سبد خرید (در صورت موفقیت، کلید آیتم سبد خرید را برمی‌گرداند)
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations );

        if ( $cart_item_key ) {
            do_action( 'woocommerce_ajax_added_to_cart', $product_id );

            if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
                wc_add_to_cart_message( array( $product_id => $quantity ), true );
            }

            // پاکسازی خطاهای احتمالی ناشی از تداخل و ارسال قطعات جدید سبد خرید
            wc_clear_notices();
            WC_AJAX::get_refreshed_fragments();
            wp_die();
        }
    }

    // اگر به هر دلیلی افزوده نشد (مثل اتمام واقعی موجودی)، متن خطا ارسال می‌شود
    $notices = wc_get_notices( 'error' );
    wc_clear_notices();

    $error_message = ! empty( $notices ) ? strip_tags( $notices[0]['notice'] ) : 'امکان افزودن این محصول به سبد خرید وجود ندارد.';

    wp_send_json( array(
        'error'       => true,
        'message'     => $error_message,
        'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
    ) );

    wp_die();
}


/**
 * تنظیمات اختصاصی برای نمایش بدون مشکل سایت در آی‌فریم بازار (Digify / Bazaar)
 */

// ۱. تنظیم هدرهای CSP و حذف X-Frame-Options
add_action('send_headers', 'baji_allow_iframe_and_set_csp', 9999);
function baji_allow_iframe_and_set_csp() {
    // حذف هدر مسدودکننده آی‌فریم
    if (function_exists('header_remove')) {
        header_remove('X-Frame-Options');
    }

    // تنظیم هدر Content-Security-Policy برای دامنه‌های مجاز بازار
    $allowed_domains = array(
        "'self'",
        "https://bazaar.digify.shop",
        "https://bazaar.staging.digifyteam.ir",
        "https://buy-with-digikala.digify.shop"
    );

    header("Content-Security-Policy: frame-ancestors " . implode(' ', $allowed_domains) . ";", true);
}

// ۲. تزریق مشخصه‌های SameSite=None; Secure; Partitioned به تمامی کوکی‌های ارسال‌شده
header_register_callback(function() {
    $headers = headers_list();
    $updated_cookies = array();

    foreach ($headers as $header) {
        if (stripos($header, 'Set-Cookie:') === 0) {
            $cookie_str = $header;

            // تنظیم SameSite=None
            if (stripos($cookie_str, 'SameSite=') !== false) {
                $cookie_str = preg_replace('/SameSite=[a-zA-Z]+/i', 'SameSite=None', $cookie_str);
            } else {
                $cookie_str .= '; SameSite=None';
            }

            // تنظیم Secure
            if (stripos($cookie_str, 'Secure') === false) {
                $cookie_str .= '; Secure';
            }

            // تنظیم Partitioned (سازگاری با CHIPS در کروم)
            if (stripos($cookie_str, 'Partitioned') === false) {
                $cookie_str .= '; Partitioned';
            }

            $updated_cookies[] = $cookie_str;
        }
    }

    // جایگزینی کوکی‌ها با نسخه اصلاح‌شده
    if (!empty($updated_cookies)) {
        header_remove('Set-Cookie');
        foreach ($updated_cookies as $cookie) {
            header($cookie, false);
        }
    }
});
