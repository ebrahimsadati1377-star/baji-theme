<?php
/** Mobile-safe header for BajiStyle. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html><html <?php language_attributes(); ?> dir="rtl"><head>
<meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#111111">
<?php wp_head(); ?>
<style id="baji-hamburger-critical">
#baji-menu-state{position:fixed;opacity:0;pointer-events:none}#baji-mobile-menu{position:fixed!important;inset:0!important;z-index:2147483000!important;background:#fff!important;transform:translateX(100%)!important;visibility:hidden!important;transition:transform .25s ease,visibility .25s!important;overflow-y:auto!important;color:#111!important}#baji-menu-state:checked~#page #baji-mobile-menu{transform:translateX(0)!important;visibility:visible!important}#baji-mobile-menu-toggle,#baji-mobile-menu-close{cursor:pointer}.baji-mm-head{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;border-bottom:1px solid #eee}.baji-mm-brand{font-size:23px;letter-spacing:.22em;font-weight:500}.baji-mm-close{font-size:32px;line-height:1;padding:4px 8px}.baji-mm-body{padding:16px 20px 30px}.baji-mm-primary{display:grid;gap:0}.baji-mm-primary a{display:flex;align-items:center;justify-content:space-between;padding:15px 2px;border-bottom:1px solid #f0f0f0;font-size:16px;font-weight:500;text-decoration:none;color:#111}.baji-mm-primary a:after{content:'‹';font-size:22px;color:#888}.baji-mm-account{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:22px}.baji-mm-account a{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px 8px;border:1px solid #e5e5e5;border-radius:12px;text-decoration:none;color:#111;font-size:14px}.baji-mm-note{margin-top:22px;padding:14px 16px;background:#f7f5f1;border-radius:12px;font-size:13px;line-height:1.9;color:#555;text-align:center}.baji-mm-instagram{display:block;margin-top:12px;padding:13px 16px;background:#111;color:#fff!important;border-radius:12px;text-align:center;text-decoration:none;font-size:14px}@media(min-width:768px){#baji-mobile-menu{display:none!important}}
</style></head>
<body <?php body_class( 'baji-body bg-baji-white text-baji-black font-vazir antialiased' ); ?>><?php wp_body_open(); ?>
<input type="checkbox" id="baji-menu-state" aria-hidden="true"><div id="page" class="baji-site-wrapper min-h-screen flex flex-col"><a class="baji-skip-link sr-only focus:not-sr-only" href="#main-content"><?php esc_html_e('رفتن به محتوای اصلی','bajistyle'); ?></a>
<div class="baji-top-banner w-full bg-baji-white flex justify-center"><a href="<?php echo esc_url(home_url('/')); ?>" class="block max-w-full"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/top-banner-mobile2.gif'); ?>" alt="BajiStyle" width="420" height="50" class="block w-[420px] max-w-full h-auto"></a><a href="<?php echo esc_url(home_url('/')); ?>" class="hidden md:block w-full"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/banner-desktop.jpg'); ?>" alt="BajiStyle" width="1400" height="100" class="block w-full h-[100px] object-cover"></a></div>
<div class="sticky top-0 z-50 w-full"><header id="masthead" class="baji-header bg-baji-white border-b border-gray-100"><div class="baji-header-inner max-w-[1400px] mx-auto px-4 md:px-8"><div class="flex items-center justify-between h-20 md:h-24 relative"><label for="baji-menu-state" id="baji-mobile-menu-toggle" class="baji-mobile-menu-toggle md:hidden flex flex-col gap-1.5 p-2" role="button" aria-label="باز کردن منو"><span class="block w-6 h-px bg-current"></span><span class="block w-6 h-px bg-current"></span><span class="block w-6 h-px bg-current"></span></label><nav id="baji-primary-navigation" class="baji-primary-nav hidden md:flex items-center gap-8" aria-label="منوی اصلی"><?php if(has_nav_menu('primary')){wp_nav_menu(array('theme_location'=>'primary','container'=>false,'menu_class'=>'baji-menu flex items-center gap-8','walker'=>new BajiStyle_Mega_Menu_Walker(),'depth'=>3));} ?></nav><div class="baji-logo absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"><?php if(has_custom_logo()){the_custom_logo();}else{?><a href="<?php echo esc_url(home_url('/')); ?>" class="baji-logo-text text-2xl md:text-3xl tracking-[0.3em] font-light"><?php bloginfo('name'); ?></a><?php } ?></div><div class="baji-header-actions flex items-center gap-4 md:gap-6 text-lg md:text-xl"><button type="button" class="baji-search-toggle flex items-center" aria-controls="baji-search-panel"><i class="far fa-search"></i></button><?php if(class_exists('WooCommerce')):?><a href="<?php echo esc_url(wc_get_account_endpoint_url('wishlist')); ?>" class="baji-header-wishlist relative flex items-center justify-center" aria-label="علاقه‌مندی‌ها" title="علاقه‌مندی‌ها"><i class="far fa-heart"></i></a><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hidden md:flex"><i class="far fa-user"></i></a><button type="button" class="baji-cart-toggle relative flex items-center" aria-controls="baji-cart-panel"><i class="far fa-shopping-bag"></i><span class="baji-cart-count absolute -top-2 -left-2 text-[10px] bg-baji-gold rounded-full w-4 h-4 flex items-center justify-center"><?php echo absint(WC()->cart?WC()->cart->get_cart_contents_count():0); ?></span></button><?php endif; ?></div></div></div><div id="baji-search-backdrop" class="fixed inset-0 z-50 hidden bg-black/45 backdrop-blur-[2px]"></div>
<div id="baji-search-panel" class="baji-search-panel fixed inset-x-0 top-0 bg-[#fffdfb] transform -translate-y-full z-[60] shadow-2xl">
  <div class="relative max-w-4xl mx-auto px-4 md:px-8 py-5 md:py-8">
    <div class="flex items-center justify-between mb-4">
      <div>
        <div class="text-[10px] md:text-xs tracking-[.22em] text-[#9b7d70] font-bold">BAJI SEARCH</div>
        <div class="text-lg md:text-2xl font-black text-[#2b211f]">دنبال چی می‌گردی؟</div>
      </div>
      <button type="button" id="baji-search-close" class="w-10 h-10 rounded-full bg-[#f5ece7] text-[#4b3832] flex items-center justify-center" aria-label="بستن جستجو"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <form role="search" method="get" class="baji-pro-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <input type="hidden" name="post_type" value="product">
      <div class="relative">
        <input id="baji-pro-search-input" type="search" name="s" autocomplete="off" placeholder="مثلاً شومیز، تیشرت، مانتو..." class="w-full h-14 md:h-16 rounded-2xl border border-[#e7d9d2] bg-white pr-5 pl-14 text-sm md:text-base outline-none focus:border-[#7b1327] focus:ring-2 focus:ring-[#7b1327]/10">
        <button type="submit" class="absolute left-2 top-1/2 -translate-y-1/2 w-11 h-11 md:w-12 md:h-12 rounded-xl bg-[#7b1327] text-white flex items-center justify-center" aria-label="جستجو"><i class="fa-solid fa-magnifying-glass"></i></button>
      </div>
    </form>
    <div class="mt-3 flex flex-wrap gap-2 text-[11px] md:text-xs">
      <span class="text-[#8b7a72] py-1.5">پیشنهاد:</span>
      <button type="button" class="baji-search-chip">شومیز</button>
      <button type="button" class="baji-search-chip">تیشرت</button>
      <button type="button" class="baji-search-chip">مانتو</button>
      <button type="button" class="baji-search-chip">ست</button>
      <button type="button" class="baji-search-chip">شلوار</button>
    </div>
    <div id="baji-live-search-status" class="mt-4 text-xs text-[#8b7a72] hidden"></div>
    <div id="baji-live-search-results" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-3 max-h-[55vh] overflow-y-auto"></div>
  </div>
</div></header></div>
<?php
$shop_url = class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/');
$account_url = class_exists('WooCommerce') ? wc_get_page_permalink('myaccount') : home_url('/');
$cart_url = class_exists('WooCommerce') ? wc_get_cart_url() : home_url('/');
$posts_page_id = (int) get_option('page_for_posts');
$blog_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/?post_type=post');
$contact_page = get_page_by_path('contact-us'); if(!$contact_page){$contact_page=get_page_by_path('contact');}
$contact_url = $contact_page ? get_permalink($contact_page) : home_url('/#footer');
$sale_url = add_query_arg('orderby','popularity',$shop_url);
$new_url = add_query_arg('orderby','date',$shop_url);
?>
<div id="baji-mobile-menu" class="baji-mobile-menu" aria-label="منوی موبایل"><div class="baji-mm-head"><span class="baji-mm-brand">BAJI</span><label for="baji-menu-state" id="baji-mobile-menu-close" class="baji-mm-close" role="button" aria-label="بستن منو">×</label></div><div class="baji-mm-body"><nav class="baji-mm-primary" aria-label="دسترسی سریع"><a href="<?php echo esc_url(home_url('/')); ?>">خانه</a><a href="<?php echo esc_url($shop_url); ?>">فروشگاه / همه محصولات</a><a href="<?php echo esc_url($new_url); ?>">جدیدترین‌ها</a><a href="<?php echo esc_url($sale_url); ?>">محبوب‌ترین‌ها و پیشنهادها</a><?php if(has_nav_menu('mobile')){wp_nav_menu(array('theme_location'=>'mobile','container'=>false,'items_wrap'=>'%3$s','depth'=>1));} ?><a href="<?php echo esc_url($blog_url); ?>">مجله باجی</a><a href="<?php echo esc_url($contact_url); ?>">تماس با ما</a></nav><div class="baji-mm-account"><a href="<?php echo esc_url($account_url); ?>"><i class="far fa-user"></i> حساب من</a><a href="<?php echo esc_url(wc_get_account_endpoint_url('wishlist')); ?>"><i class="far fa-heart"></i> علاقه‌مندی‌ها</a><a href="<?php echo esc_url($cart_url); ?>"><i class="far fa-shopping-bag"></i> سبد خرید</a></div><div class="baji-mm-note">خرید اقساطی با اسنپ‌پی، دیجی‌پی و ترب‌پی<br>ارسال رایگان برای سفارش‌های بالای ۳ میلیون تومان</div><a class="baji-mm-instagram" href="https://www.instagram.com/baji.style/" target="_blank" rel="noopener noreferrer">اینستاگرام @baji.style</a></div></div><main id="main-content" class="baji-main flex-1">