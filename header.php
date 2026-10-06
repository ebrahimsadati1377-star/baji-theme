<?php
/** Mobile-safe header for BajiStyle. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html><html <?php language_attributes(); ?> dir="rtl"><head>
<meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#111111">
<?php wp_head(); ?>
<style id="baji-hamburger-critical">
#baji-menu-state{position:fixed;opacity:0;pointer-events:none}
#baji-mobile-menu{position:fixed!important;inset:0!important;z-index:2147483000!important;display:none!important;visibility:hidden!important;pointer-events:none!important;overflow-y:auto!important;overflow-x:hidden!important}
#baji-menu-state:checked~#page #baji-mobile-menu{display:block!important;visibility:visible!important;pointer-events:auto!important}
#baji-mobile-menu-toggle,#baji-mobile-menu-close{cursor:pointer}
.baji-smart-promo--single{min-height:38px;padding:6px 14px;display:flex;align-items:center;justify-content:center;gap:10px;background:linear-gradient(100deg,#6f1024 0%,#8f2037 52%,#6f1024 100%);color:#fff!important;text-decoration:none;box-shadow:0 6px 20px rgba(95,17,36,.16)}
.baji-smart-promo__gift{width:26px;height:26px;display:grid;place-items:center;border-radius:999px;background:rgba(255,255,255,.12);color:#f1cf99;font-size:12px;flex:0 0 auto}
.baji-smart-promo__copy{display:flex;align-items:baseline;justify-content:center;gap:8px;min-width:0;line-height:1.4}.baji-smart-promo__copy strong{font-size:12px;font-weight:900;white-space:nowrap}.baji-smart-promo__copy small{font-size:10px;color:#f7e9e0;white-space:nowrap}
.baji-smart-promo__arrow{font-size:10px;color:#f1cf99}
#masthead.baji-header{background:rgba(255,253,250,.97)!important;color:#231f20!important;border-bottom:1px solid rgba(111,16,36,.08)!important;box-shadow:0 8px 28px rgba(40,28,24,.045);backdrop-filter:blur(14px)}
#masthead .baji-header-inner>div{min-height:64px;height:64px!important}
#masthead .baji-logo img{max-height:34px;width:auto}
#masthead .baji-mobile-leading,#masthead .baji-header-actions{z-index:2}
#masthead .baji-header-icon{width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;border-radius:13px;color:#2b2422;background:transparent;transition:background .2s ease,color .2s ease,transform .2s ease}
#masthead .baji-header-icon:active{transform:scale(.96);background:#f8efeb}
#masthead .baji-cart-count{background:#7b1327!important;color:#fff!important;border:2px solid #fffdf9}
@media(max-width:767px){
  .baji-smart-promo--single{min-height:36px;padding:5px 10px;gap:7px}
  .baji-smart-promo__copy{gap:5px}.baji-smart-promo__copy strong{font-size:11px}.baji-smart-promo__copy small{font-size:9px;overflow:hidden;text-overflow:ellipsis;max-width:190px}
  #masthead .baji-header-inner{padding-left:12px!important;padding-right:12px!important}
  #masthead .baji-logo img{max-height:30px}
  #masthead .baji-header-icon{width:36px;height:36px;border-radius:12px;font-size:18px}
}
@media(min-width:768px){#baji-mobile-menu{display:none!important}#masthead .baji-header-inner>div{height:80px!important}}
</style></head>
<body <?php body_class( 'baji-body bg-baji-white text-baji-black font-vazir antialiased' ); ?>><?php wp_body_open(); ?>
<input type="checkbox" id="baji-menu-state" aria-hidden="true"><div id="page" class="baji-site-wrapper min-h-screen flex flex-col"><a class="baji-skip-link sr-only focus:not-sr-only" href="#main-content"><?php esc_html_e('رفتن به محتوای اصلی','bajistyle'); ?></a>
<a class="baji-smart-promo baji-smart-promo--single" href="<?php echo esc_url( class_exists('WooCommerce') ? wc_get_page_permalink('shop') : home_url('/') ); ?>" aria-label="خرید اقساطی باجی">
  <span class="baji-smart-promo__gift" aria-hidden="true"><i class="fa-solid fa-gift"></i></span>
  <span class="baji-smart-promo__copy"><strong>خرید اقساطی با باجی</strong><small>۴ قسط بدون کارمزد با اسنپ‌پی، ترب‌پی و دیجی‌پی</small></span>
  <span class="baji-smart-promo__arrow" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
</a><div class="sticky top-0 z-50 w-full"><header id="masthead" class="baji-header"><div class="baji-header-inner max-w-[1400px] mx-auto px-4 md:px-8"><div class="flex items-center justify-between relative">
  <div class="baji-mobile-leading md:hidden flex items-center gap-1">
    <label for="baji-menu-state" id="baji-mobile-menu-toggle" class="baji-header-icon" role="button" aria-label="باز کردن منو"><i class="fa-regular fa-bars"></i></label>
    <button type="button" class="baji-search-toggle baji-header-icon" aria-controls="baji-search-panel" aria-label="جستجو"><i class="far fa-search"></i></button>
  </div>
  <nav id="baji-primary-navigation" class="baji-primary-nav hidden md:flex items-center gap-8" aria-label="منوی اصلی"><?php if(has_nav_menu('primary')){wp_nav_menu(array('theme_location'=>'primary','container'=>false,'menu_class'=>'baji-menu flex items-center gap-8','walker'=>new BajiStyle_Mega_Menu_Walker(),'depth'=>3));} ?></nav>
  <div class="baji-logo absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"><?php if(has_custom_logo()){the_custom_logo();}else{?><a href="<?php echo esc_url(home_url('/')); ?>" class="baji-logo-text text-2xl md:text-3xl tracking-[0.3em] font-light">BAJI</a><?php } ?></div>
  <div class="baji-header-actions flex items-center gap-1 md:gap-3">
    <button type="button" class="baji-search-toggle baji-header-icon hidden md:inline-flex" aria-controls="baji-search-panel" aria-label="جستجو"><i class="far fa-search"></i></button>
    <?php if(class_exists('WooCommerce')):?>
      <a href="<?php echo esc_url(add_query_arg( 'tab', 'wishlist', wc_get_page_permalink( 'myaccount' ) )); ?>" class="baji-header-wishlist baji-header-icon relative inline-flex" aria-label="علاقه‌مندی‌ها" title="علاقه‌مندی‌ها"><i class="far fa-heart"></i></a>
      <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="baji-header-icon hidden md:inline-flex" aria-label="حساب کاربری"><i class="far fa-user"></i></a>
      <button type="button" class="baji-cart-toggle baji-header-icon relative inline-flex" aria-controls="baji-cart-panel" aria-label="سبد خرید"><i class="far fa-shopping-bag"></i><span class="baji-cart-count absolute -top-1 -left-1 text-[9px] rounded-full min-w-4 h-4 px-1 flex items-center justify-center"><?php echo absint(WC()->cart?WC()->cart->get_cart_contents_count():0); ?></span></button>
    <?php endif; ?>
  </div>
</div></div><div id="baji-search-backdrop" class="fixed inset-0 z-50 hidden bg-black/45 backdrop-blur-[2px]"></div>
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
$wishlist_url = class_exists('WooCommerce') ? add_query_arg( 'tab', 'wishlist', wc_get_page_permalink( 'myaccount' ) ) : $account_url;
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