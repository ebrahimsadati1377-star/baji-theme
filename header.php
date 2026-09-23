<?php
/** Mobile-safe header for BajiStyle. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( isset( $_GET['baji_restore_promo_purge'] ) ) {
	if ( has_action( 'litespeed_purge_all' ) || defined( 'LSCWP_V' ) ) { do_action( 'litespeed_purge_all' ); }
}
?>
<!DOCTYPE html><html <?php language_attributes(); ?> dir="rtl"><head>
<meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#111111">
<?php wp_head(); ?>
<style id="baji-hamburger-critical">
#baji-menu-state{position:fixed;opacity:0;pointer-events:none}
#baji-mobile-menu{position:fixed!important;inset:0!important;z-index:2147483000!important;display:none!important;visibility:hidden!important;pointer-events:none!important;overflow-y:auto!important;overflow-x:hidden!important}
#baji-menu-state:checked~#page #baji-mobile-menu{display:block!important;visibility:visible!important;pointer-events:auto!important}
#baji-mobile-menu-toggle,#baji-mobile-menu-close{cursor:pointer}
@media(min-width:768px){#baji-mobile-menu{display:none!important}}
</style></head>
<body <?php body_class( 'baji-body bg-baji-white text-baji-black font-vazir antialiased' ); ?>><?php wp_body_open(); ?>
<input type="checkbox" id="baji-menu-state" aria-hidden="true"><div id="page" class="baji-site-wrapper min-h-screen flex flex-col"><a class="baji-skip-link sr-only focus:not-sr-only" href="#main-content"><?php esc_html_e('رفتن به محتوای اصلی','bajistyle'); ?></a>
<div class="baji-smart-promo" aria-label="خرید اقساطی باجی">
  <div class="baji-smart-promo-viewport">
    <div class="baji-smart-promo-slide baji-promo-v1 is-active"><span class="baji-promo-brand">BAJI</span><strong>خرید اقساطی از <b>باجی</b></strong><span class="baji-smart-promo-sub">همین حالا، بعداً پرداخت کن!</span><span class="baji-pay-logos"><span class="baji-pay-logo baji-pay-logo--snapp">Snapp! Pay</span><span class="baji-pay-logo baji-pay-logo--torob">ترب‌پی</span><span class="baji-pay-logo baji-pay-logo--digi">دیجی‌پی</span></span><span class="baji-promo-icon">♡</span></div>
    <div class="baji-smart-promo-slide baji-promo-v2"><span class="baji-promo-icon">🛍</span><strong>با <b>باجی</b>، راحت‌تر خرید کن</strong><span class="baji-smart-promo-sub">امکان پرداخت در ۴ قسط بدون کارمزد</span><span class="baji-pay-logos"><span class="baji-pay-logo baji-pay-logo--snapp">Snapp! Pay</span><span class="baji-pay-logo baji-pay-logo--torob">ترب‌پی</span><span class="baji-pay-logo baji-pay-logo--digi">دیجی‌پی</span></span><a class="baji-promo-cta" href="<?php echo esc_url( class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/') ); ?>">مشاهده محصولات</a></div>
    <div class="baji-smart-promo-slide baji-promo-v3"><span class="baji-promo-icon">٪</span><strong>۴ قسط، بدون کارمزد</strong><span class="baji-smart-promo-sub">با اسنپ‌پی، ترب‌پی و دیجی‌پی</span><span class="baji-pay-logos"><span class="baji-pay-logo baji-pay-logo--snapp">Snapp! Pay</span><span class="baji-pay-logo baji-pay-logo--torob">ترب‌پی</span><span class="baji-pay-logo baji-pay-logo--digi">دیجی‌پی</span></span><em>استایل امروز، پرداخت فردا ♡</em></div>
    <div class="baji-smart-promo-slide baji-promo-v4"><span class="baji-promo-feature">◉<small>۴ قسط<br>بدون کارمزد</small></span><span class="baji-promo-feature">♧<small>ارسال رایگان<br>بالای ۳ میلیون</small></span><strong>خرید اقساطی از <b>باجی</b></strong><span class="baji-pay-logos"><span class="baji-pay-logo baji-pay-logo--snapp">Snapp! Pay</span><span class="baji-pay-logo baji-pay-logo--torob">ترب‌پی</span><span class="baji-pay-logo baji-pay-logo--digi">دیجی‌پی</span></span><span class="baji-promo-feature">♡<small>کیفیت<br>BAJI</small></span></div>
    <div class="baji-smart-promo-slide baji-promo-v5"><span class="baji-promo-brand">BAJI</span><strong>خرید امروز، پرداخت در ۴ قسط</strong><span class="baji-smart-promo-sub">با اسنپ‌پی، ترب‌پی و دیجی‌پی</span><span class="baji-pay-logos"><span class="baji-pay-logo baji-pay-logo--snapp">Snapp! Pay</span><span class="baji-pay-logo baji-pay-logo--torob">ترب‌پی</span><span class="baji-pay-logo baji-pay-logo--digi">دیجی‌پی</span></span><em>Be your best ♡</em></div>
    <div class="baji-smart-promo-slide baji-promo-v6"><span class="baji-promo-icon">♡</span><strong>با <b>باجی</b>، به سبک خودت خرید کن</strong><span class="baji-smart-promo-sub">حالا بخر، قسطی پرداخت کن</span><span class="baji-pay-logos"><span class="baji-pay-logo baji-pay-logo--snapp">Snapp! Pay</span><span class="baji-pay-logo baji-pay-logo--torob">ترب‌پی</span><span class="baji-pay-logo baji-pay-logo--digi">دیجی‌پی</span></span><a class="baji-promo-cta" href="<?php echo esc_url( class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/') ); ?>">همین حالا خرید کن</a></div>
  </div>
  <div class="baji-smart-promo-dots" aria-hidden="true"><i class="is-active"></i><i></i><i></i><i></i><i></i><i></i></div>
</div><div class="sticky top-0 z-50 w-full"><header id="masthead" class="baji-header bg-baji-white border-b border-gray-100"><div class="baji-header-inner max-w-[1400px] mx-auto px-4 md:px-8"><div class="flex items-center justify-between h-20 md:h-24 relative"><label for="baji-menu-state" id="baji-mobile-menu-toggle" class="baji-mobile-menu-toggle md:hidden flex flex-col gap-1.5 p-2" role="button" aria-label="باز کردن منو"><span class="block w-6 h-px bg-current"></span><span class="block w-6 h-px bg-current"></span><span class="block w-6 h-px bg-current"></span></label><nav id="baji-primary-navigation" class="baji-primary-nav hidden md:flex items-center gap-8" aria-label="منوی اصلی"><?php if(has_nav_menu('primary')){wp_nav_menu(array('theme_location'=>'primary','container'=>false,'menu_class'=>'baji-menu flex items-center gap-8','walker'=>new BajiStyle_Mega_Menu_Walker(),'depth'=>3));} ?></nav><div class="baji-logo absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"><?php if(has_custom_logo()){the_custom_logo();}else{?><a href="<?php echo esc_url(home_url('/')); ?>" class="baji-logo-text text-2xl md:text-3xl tracking-[0.3em] font-light"><?php bloginfo('name'); ?></a><?php } ?></div><div class="baji-header-actions flex items-center gap-4 md:gap-6 text-lg md:text-xl"><button type="button" class="baji-search-toggle flex items-center" aria-controls="baji-search-panel" aria-label="جستجو"><i class="far fa-search"></i></button><?php if(class_exists('WooCommerce')):?><a href="<?php echo esc_url(wc_get_account_endpoint_url('wishlist')); ?>" class="baji-header-wishlist hidden md:flex relative items-center justify-center" aria-label="علاقه‌مندی‌ها" title="علاقه‌مندی‌ها"><i class="far fa-heart"></i></a><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="hidden md:flex"><i class="far fa-user"></i></a><button type="button" class="baji-cart-toggle hidden md:flex relative items-center" aria-controls="baji-cart-panel"><i class="far fa-shopping-bag"></i><span class="baji-cart-count absolute -top-2 -left-2 text-[10px] bg-baji-gold rounded-full w-4 h-4 flex items-center justify-center"><?php echo absint(WC()->cart?WC()->cart->get_cart_contents_count():0); ?></span></button><?php endif; ?></div></div></div><div id="baji-search-backdrop" class="fixed inset-0 z-50 hidden bg-black/45 backdrop-blur-[2px]"></div>
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
$wishlist_url = class_exists('WooCommerce') ? wc_get_account_endpoint_url('wishlist') : $account_url;
$cart_count = ( class_exists('WooCommerce') && WC()->cart ) ? absint( WC()->cart->get_cart_contents_count() ) : 0;
$wishlist_count = function_exists('bajistyle_get_wishlist_count') ? absint( bajistyle_get_wishlist_count() ) : 0;

$menu_user = wp_get_current_user();
$is_menu_user_logged_in = is_user_logged_in();
$menu_display_name = $is_menu_user_logged_in ? ( $menu_user->display_name ?: $menu_user->user_login ) : 'مهمان باجی';
$menu_phone = $is_menu_user_logged_in ? (string) get_user_meta( $menu_user->ID, 'billing_phone', true ) : '';
if ( $menu_phone && strlen( $menu_phone ) >= 7 ) {
	$menu_phone_masked = substr( $menu_phone, 0, 4 ) . '***' . substr( $menu_phone, -4 );
} else {
	$menu_phone_masked = '';
}

$baji_menu_term_url = static function( $term_id ) use ( $shop_url ) {
	$link = get_term_link( (int) $term_id, 'product_cat' );
	return is_wp_error( $link ) ? $shop_url : $link;
};
$menu_cat_blouse = $baji_menu_term_url( 17 );
$menu_cat_pants  = $baji_menu_term_url( 20 );
$menu_cat_rain   = $baji_menu_term_url( 333 );
$menu_cat_skirt  = $baji_menu_term_url( 19 );
?>
<div id="baji-mobile-menu" class="baji-mobile-menu" aria-label="منوی موبایل" aria-hidden="true">
  <div class="baji-mm-shell">
    <div class="baji-mm-head">
      <label for="baji-menu-state" id="baji-mobile-menu-close" class="baji-mm-close" role="button" aria-label="بستن منو"></label>
      <div class="baji-mm-brand-wrap">
        <span class="baji-mm-brand">BAJI</span>
        <span class="baji-mm-brand-en">MORE THAN FASHION</span>
      </div>
      <span class="baji-mm-head-spacer" aria-hidden="true"></span>
    </div>

    <div class="baji-mm-intro"><span>سبک زندگی زیباتر</span></div>

    <div class="baji-mm-body">
      <section class="baji-mm-member">
        <div class="baji-mm-member__avatar"><?php echo esc_html( mb_substr( $menu_display_name, 0, 1 ) ); ?></div>
        <div class="baji-mm-member__copy">
          <small><?php echo $is_menu_user_logged_in ? 'BAJI MEMBER' : 'BAJI CLUB'; ?></small>
          <strong><?php echo $is_menu_user_logged_in ? 'سلام ' . esc_html( $menu_display_name ) : 'به باجی خوش اومدی'; ?></strong>
          <span><?php echo $menu_phone_masked ? esc_html( $menu_phone_masked ) : ( $is_menu_user_logged_in ? 'حساب کاربری شما' : 'برای تجربه شخصی‌تر وارد حساب شو' ); ?></span>
        </div>
        <a href="<?php echo esc_url($account_url); ?>" class="baji-mm-member__action">
          <span><?php echo $is_menu_user_logged_in ? 'حساب من' : 'ورود / ثبت‌نام'; ?></span>
          <i class="fa-solid fa-chevron-left"></i>
        </a>
      </section>

      <section class="baji-mm-categories" aria-label="دسته‌بندی‌های محبوب">
        <div class="baji-mm-section-head">
          <div><small>SHOP BY CATEGORY</small><strong>دسته‌بندی‌های محبوب</strong></div>
          <a href="<?php echo esc_url($shop_url); ?>">همه محصولات <i class="fa-solid fa-chevron-left"></i></a>
        </div>
        <div class="baji-mm-category-grid">
          <a href="<?php echo esc_url($menu_cat_blouse); ?>"><i class="fa-regular fa-shirt"></i><span>شومیز</span></a>
          <a href="<?php echo esc_url($menu_cat_rain); ?>"><i class="fa-regular fa-cloud-rain"></i><span>بارونی</span></a>
          <a href="<?php echo esc_url($menu_cat_pants); ?>"><i class="fa-regular fa-person"></i><span>شلوار</span></a>
          <a href="<?php echo esc_url($menu_cat_skirt); ?>"><i class="fa-regular fa-person-dress"></i><span>دامن</span></a>
        </div>
      </section>
      <nav class="baji-mm-primary" aria-label="دسترسی سریع">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <span class="baji-mm-link-icon"><i class="fa-regular fa-house"></i></span>
          <span class="baji-mm-link-copy"><strong>خانه</strong><small>بازگشت به صفحه اصلی باجی</small></span>
          <i class="fa-solid fa-chevron-left baji-mm-link-arrow"></i>
        </a>
        <a href="<?php echo esc_url($shop_url); ?>">
          <span class="baji-mm-link-icon"><i class="fa-regular fa-bag-shopping"></i></span>
          <span class="baji-mm-link-copy"><strong>فروشگاه / همه محصولات</strong><small>مشاهده تمام مدل‌های موجود</small></span>
          <i class="fa-solid fa-chevron-left baji-mm-link-arrow"></i>
        </a>
        <a href="<?php echo esc_url($new_url); ?>">
          <span class="baji-mm-link-icon"><i class="fa-regular fa-sparkles"></i></span>
          <span class="baji-mm-link-copy"><strong>جدیدترین‌ها</strong><small>تازه‌ترین مدل‌های اضافه‌شده</small></span>
          <i class="fa-solid fa-chevron-left baji-mm-link-arrow"></i>
        </a>
        <a href="<?php echo esc_url($sale_url); ?>">
          <span class="baji-mm-link-icon"><i class="fa-regular fa-heart"></i></span>
          <span class="baji-mm-link-copy"><strong>محبوب‌ترین‌ها و پیشنهادها</strong><small>انتخاب‌های پرطرفدار و ویژه</small></span>
          <i class="fa-solid fa-chevron-left baji-mm-link-arrow"></i>
        </a>
        <a href="<?php echo esc_url($blog_url); ?>">
          <span class="baji-mm-link-icon"><i class="fa-regular fa-book-open"></i></span>
          <span class="baji-mm-link-copy"><strong>مجله باجی</strong><small>استایل، راهنما و ایده‌های پوشش</small></span>
          <i class="fa-solid fa-chevron-left baji-mm-link-arrow"></i>
        </a>
        <a href="<?php echo esc_url($contact_url); ?>">
          <span class="baji-mm-link-icon"><i class="fa-regular fa-phone"></i></span>
          <span class="baji-mm-link-copy"><strong>تماس با ما</strong><small>پشتیبانی و ارتباط با باجی</small></span>
          <i class="fa-solid fa-chevron-left baji-mm-link-arrow"></i>
        </a>
      </nav>

      <?php if ( has_nav_menu('mobile') ) : ?>
        <nav class="baji-mm-extra" aria-label="لینک‌های بیشتر">
          <?php wp_nav_menu(array('theme_location'=>'mobile','container'=>false,'menu_class'=>'baji-mm-extra-list','depth'=>1)); ?>
        </nav>
      <?php endif; ?>

      <div class="baji-mm-divider"><i class="fa-regular fa-diamond"></i></div>

      <div class="baji-mm-account">
        <a href="<?php echo esc_url($account_url); ?>">
          <i class="fa-regular fa-user"></i>
          <span>حساب من</span>
        </a>
        <a href="<?php echo esc_url($wishlist_url); ?>">
          <?php if ( $wishlist_count > 0 ) : ?><span class="baji-mm-quick-badge"><?php echo esc_html($wishlist_count); ?></span><?php endif; ?>
          <i class="fa-regular fa-heart"></i>
          <span>علاقه‌مندی‌ها</span>
        </a>
        <a href="<?php echo esc_url($cart_url); ?>">
          <?php if ( $cart_count > 0 ) : ?><span class="baji-mm-quick-badge"><?php echo esc_html($cart_count); ?></span><?php endif; ?>
          <i class="fa-regular fa-bag-shopping"></i>
          <span>سبد خرید</span>
        </a>
      </div>

      <a class="baji-mm-note" href="<?php echo esc_url($shop_url); ?>">
        <span class="baji-mm-note__icon"><i class="fa-regular fa-credit-card"></i></span>
        <span>
          <strong>خرید اقساطی با اسنپ‌پی، دیجی‌پی و ترب‌پی</strong>
          <small>ارسال رایگان برای سفارش‌های بالای ۳ میلیون تومان</small>
        </span>
        <i class="fa-solid fa-chevron-left baji-mm-note__arrow"></i>
      </a>

      <div class="baji-mm-social">
        <span>باجی؛ کیفیتی که با اولین پوشیدن حسش می‌کنی</span>
        <a class="baji-mm-instagram" href="https://www.instagram.com/baji.style/" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-instagram"></i>
          @baji.style
        </a>
      </div>
    </div>
  </div>
</div>
<main id="main-content" class="baji-main flex-1">