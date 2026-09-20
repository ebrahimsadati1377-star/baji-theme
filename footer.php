<?php
/** BAJI approved blush footer */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
</main><!-- #main-content -->
<footer id="colophon" class="baji-footer-pink" dir="rtl">
<div class="bfp-wrap">
 <section class="bfp-brand">
  <a class="bfp-logo" href="<?php echo esc_url(home_url('/')); ?>">BAJI</a>
  <div class="bfp-tag">BE YOUR BEST</div>
  <h2>استایلی برای نسخه بهتر تو</h2>
  <div class="bfp-social">
   <?php $ig=get_theme_mod('bajistyle_social_instagram','https://www.instagram.com/baji.style/'); ?>
   <a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener" aria-label="اینستاگرام"><i class="fa-brands fa-instagram"></i></a>
   <a href="https://ble.ir/" target="_blank" rel="noopener" aria-label="بله" class="bfp-bale">بله</a>
  </div>
 </section>
 <div class="bfp-divider"><span>♡</span></div>
 <div class="bfp-links-grid">
  <nav><h3>راهنمای مشتریان</h3>
   <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">خرید از باجی</a>
   <a href="<?php echo esc_url(home_url('/contact/')); ?>">ارتباط با ما</a>
   <a href="<?php echo esc_url(home_url('/size-guide/')); ?>">چطور اندازه مناسب انتخاب کنیم؟</a>
   <a href="<?php echo esc_url(home_url('/contact/')); ?>">بگو چی شده، درستش می‌کنیم.</a>
   <a href="<?php echo esc_url(home_url('/terms/')); ?>">قوانین ساده ما</a>
   <a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات متداول</a>
  </nav>
  <nav><h3>لینک‌های کاربردی</h3>
   <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">ارسال رایگان باجی</a>
   <a href="<?php echo esc_url(home_url('/faq/')); ?>">پرسش‌های متداول</a>
   <a href="<?php echo esc_url(home_url('/about/')); ?>">درباره ما</a>
   <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a>
   <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">ثبت نام / ورود</a>
  </nav>
 </div>
 <div class="bfp-features">
  <div><i class="far fa-truck"></i><b>ارسال سریع</b><span>به سراسر کشور</span></div>
  <div><i class="far fa-shield-check"></i><b>ضمانت اصالت</b><span>و کیفیت کالا</span></div>
  <div><i class="far fa-headset"></i><b>پشتیبانی</b><span>پاسخگو و همراه</span></div>
 </div>
 <div class="bfp-trust">
  <a class="bfp-enamad" target="_blank" rel="noopener" href="https://trustseal.enamad.ir/?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn"><img src="https://trustseal.enamad.ir/logo.aspx?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn" alt="نماد اعتماد الکترونیکی"></a>
  <div class="bfp-partner bfp-digikala"><span class="bfp-digi-mark">⌣</span><b>digikala</b></div>
  <div class="bfp-partner bfp-snapp"><b>Snapp! Pay</b><small>اسنپ‌پی</small></div>
  <div class="bfp-partner bfp-torob"><span class="bfp-torob-mark">⬡</span><b>ترب‌پی</b></div>
 </div>
 <div class="bfp-copy">© فروشگاه اینترنتی باجی. تمامی حقوق محفوظ است.</div>
</div>
</footer>
<style id="baji-footer-pink-css">
.baji-footer-pink,.baji-footer-pink *{box-sizing:border-box}.baji-footer-pink{background:#fff5f6!important;color:#25252b!important;font-family:inherit!important}.bfp-wrap{max-width:760px!important;margin:0 auto!important;padding:38px 20px 96px!important}.bfp-brand{text-align:center!important}.bfp-logo{display:block!important;color:#090909!important;text-decoration:none!important;font:64px/.95 Georgia,serif!important;letter-spacing:.08em!important}.bfp-tag{font:9px/1.5 Georgia,serif!important;letter-spacing:.48em!important;margin:7px 0 20px!important}.bfp-brand h2{font-size:20px!important;line-height:1.8!important;font-weight:900!important;margin:0 0 18px!important}.bfp-social{display:flex!important;justify-content:center!important;gap:12px!important}.bfp-social a{width:48px!important;height:48px!important;border-radius:50%!important;display:grid!important;place-items:center!important;text-decoration:none!important;background:#f8dfe3!important;color:#bc5265!important;font-size:23px!important}.bfp-social .bfp-bale{background:#fff!important;border:2px solid #22a8aa!important;color:#159294!important;font-size:12px!important;font-weight:900!important}.bfp-divider{height:48px!important;display:flex!important;align-items:center!important;gap:10px!important;color:#df6075!important}.bfp-divider:before,.bfp-divider:after{content:''!important;height:1px!important;background:#efb9c2!important;flex:1!important}.bfp-divider span{font-size:18px!important}.bfp-links-grid{display:grid!important;grid-template-columns:1fr 1fr!important;direction:rtl!important}.bfp-links-grid nav{padding:8px 18px 18px!important;text-align:right!important}.bfp-links-grid nav+nav{border-right:1px solid #efb9c2!important}.bfp-links-grid h3{font-size:19px!important;font-weight:900!important;margin:0 0 14px!important;color:#24242a!important}.bfp-links-grid a{position:relative!important;display:block!important;color:#34343b!important;text-decoration:none!important;font-size:13px!important;line-height:2.55!important;padding-right:14px!important}.bfp-links-grid a:before{content:''!important;position:absolute!important;right:0!important;top:50%!important;width:6px!important;height:6px!important;border:1.5px solid #d86578!important;border-radius:50%!important;transform:translateY(-50%)!important}.bfp-features{display:grid!important;grid-template-columns:repeat(3,1fr)!important;gap:7px!important;margin-top:12px!important}.bfp-features>div{min-height:92px!important;background:#fbe4e8!important;border-radius:8px!important;display:flex!important;flex-direction:column!important;align-items:center!important;justify-content:center!important;text-align:center!important;padding:10px 5px!important}.bfp-features i{font-size:24px!important;color:#d64f68!important;margin-bottom:7px!important}.bfp-features b{font-size:12px!important;line-height:1.7!important}.bfp-features span{font-size:9px!important;line-height:1.7!important;color:#665b5d!important}.bfp-trust{margin-top:12px!important;background:#fff!important;border:8px solid #fbe4e8!important;border-radius:8px!important;display:grid!important;grid-template-columns:repeat(4,1fr)!important;align-items:center!important;min-height:112px!important;overflow:hidden!important}.bfp-trust>*{min-width:0!important;min-height:82px!important;display:flex!important;flex-direction:column!important;align-items:center!important;justify-content:center!important;text-align:center!important;border-left:1px solid #f1c4cc!important;text-decoration:none!important}.bfp-trust>*:last-child{border-left:0!important}.bfp-enamad img{width:60px!important;height:60px!important;object-fit:contain!important}.bfp-partner b{font-size:13px!important;line-height:1.3!important}.bfp-partner small{font-size:8px!important;margin-top:3px!important}.bfp-digikala{color:#e62f59!important}.bfp-digikala b{font-family:Arial,sans-serif!important;font-weight:900!important;font-size:13px!important}.bfp-digi-mark{font:bold 25px/1 Arial!important;color:#e62f59!important;transform:rotate(180deg)!important}.bfp-snapp b{color:#00c879!important;font:bold 13px/1.2 Arial,sans-serif!important}.bfp-snapp small{color:#303030!important}.bfp-torob{color:#3b62d9!important}.bfp-torob-mark{font-size:29px!important;line-height:.8!important;color:#3b62d9!important}.bfp-torob b{font-size:12px!important}.bfp-copy{text-align:center!important;font-size:10px!important;color:#6e6668!important;margin-top:20px!important}.baji-mobile-bottom-nav{background:#fff!important;color:#727c85!important;border-top:1px solid #eee!important}.baji-mobile-bottom-nav a,.baji-mobile-bottom-nav button{color:#727c85!important}.baji-mobile-bottom-nav a[href*="wishlist"]{display:flex!important}
@media(min-width:768px){.bfp-wrap{max-width:1000px!important;padding:55px 32px 42px!important}.bfp-logo{font-size:72px!important}.bfp-brand h2{font-size:24px!important}.bfp-links-grid nav{padding:14px 70px 28px!important}.bfp-links-grid h3{font-size:22px!important}.bfp-links-grid a{font-size:15px!important}.bfp-features>div{min-height:110px!important}.bfp-features b{font-size:15px!important}.bfp-features span{font-size:11px!important}.bfp-trust{min-height:135px!important}.bfp-trust>*{min-height:100px!important}.bfp-enamad img{width:76px!important;height:76px!important}.bfp-partner b{font-size:18px!important}}
</style>
<div class="baji-mobile-bottom-nav md:hidden fixed bottom-0 inset-x-0 z-50 border-t border-gray-100 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] flex items-center justify-around h-16 px-1" style="background-color:#fff!important;"><a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 flex-1"><i class="far fa-home text-xl"></i><span class="text-[10px]">خانه</span></a><a href="<?php echo esc_url(home_url('/my-account/wishlist/')); ?>" class="baji-mobile-wishlist relative flex flex-col items-center justify-center gap-1 text-gray-500 flex-1"><span class="relative"><i class="far fa-heart text-xl"></i><?php if(function_exists('bajistyle_get_wishlist_count') && bajistyle_get_wishlist_count()>0): ?><span class="baji-wishlist-count absolute -top-2 -left-2 text-[9px] bg-[#cf6f78] text-white rounded-full min-w-4 h-4 px-1 flex items-center justify-center"><?php echo absint(bajistyle_get_wishlist_count()); ?></span><?php endif; ?></span><span class="text-[10px]">علاقه‌مندی‌ها</span></a><button type="button" class="baji-cart-toggle flex flex-col items-center justify-center gap-1 text-gray-500 flex-1" aria-controls="baji-cart-panel"><i class="far fa-shopping-bag text-xl"></i><span class="text-[10px]">سبد خرید</span></button><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="flex flex-col items-center justify-center gap-1 text-gray-500 flex-1"><i class="far fa-user text-xl"></i><span class="text-[10px]">حساب من</span></a></div>
</div><!-- #page -->
<div id="baji-cart-panel" class="baji-cart-drawer" aria-hidden="true" data-coupon-nonce="<?php echo esc_attr(wp_create_nonce('baji_cart_coupon')); ?>" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"><div class="baji-cart-drawer__head"><button id="baji-cart-close" type="button" class="baji-cart-drawer__close" aria-label="بستن"><i class="fa-solid fa-xmark"></i></button><div class="baji-cart-drawer__title"><span class="baji-cart-drawer__bag"><i class="far fa-shopping-bag"></i><span class="baji-cart-count"><?php echo absint(WC()->cart?WC()->cart->get_cart_contents_count():0); ?></span></span><div><b>سبد خرید شما</b><small>خرید امن و سریع از BAJI</small></div></div></div><div class="baji-cart-shipping" data-free-shipping-target="0"><div class="baji-cart-shipping__row"><i class="far fa-truck"></i><div><b class="baji-cart-shipping__title">ارسال رایگان</b><span class="baji-cart-shipping__text">برای همه سفارش‌ها</span></div></div><div class="baji-cart-shipping__bar"><span style="width:0%"></span></div><div class="baji-cart-shipping__meta"><span class="baji-cart-shipping__current"></span><span>بدون حداقل خرید</span></div></div><div class="baji-cart-drawer__body widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div><div class="baji-cart-coupon-static"><form method="post" action="<?php echo esc_url(wc_get_cart_url()); ?>"><div class="baji-mini-coupon__field"><i class="far fa-gift"></i><input type="text" name="coupon_code" placeholder="کد تخفیف را وارد کنید" autocomplete="off"><button type="submit" name="apply_coupon" value="1">اعمال</button></div><?php wp_nonce_field('woocommerce-cart','woocommerce-cart-nonce'); ?></form></div><div class="baji-cart-trust"><div><i class="far fa-shield-check"></i><b>پرداخت امن</b></div><div><i class="far fa-truck"></i><b>ارسال سریع</b></div><div><i class="far fa-headset"></i><b>پشتیبانی</b></div></div></div><div id="baji-cart-overlay" class="baji-cart-overlay"></div>
<script id="baji-cart-drawer-js">document.addEventListener('DOMContentLoaded',function(){const panel=document.getElementById('baji-cart-panel'),overlay=document.getElementById('baji-cart-overlay'),close=document.getElementById('baji-cart-close'),toggles=document.querySelectorAll('.baji-cart-toggle');if(!panel||!overlay||!toggles.length)return;function openCart(){panel.classList.add('is-open');overlay.classList.add('is-open');panel.setAttribute('aria-hidden','false');document.body.style.overflow='hidden'}function closeCart(){panel.classList.remove('is-open');overlay.classList.remove('is-open');panel.setAttribute('aria-hidden','true');document.body.style.overflow=''}toggles.forEach(function(btn){btn.addEventListener('click',openCart)});if(close)close.addEventListener('click',closeCart);overlay.addEventListener('click',closeCart);document.addEventListener('keydown',function(e){if(e.key==='Escape')closeCart()})});</script>
<script id="baji-mobile-horizontal-lock">
document.addEventListener('DOMContentLoaded',function(){
  if(!window.matchMedia('(max-width: 767px)').matches) return;

  const resetX=function(){
    if(window.scrollX!==0){
      window.scrollTo(0,window.scrollY);
    }
  };

  resetX();
  window.setTimeout(resetX,60);
  window.setTimeout(resetX,250);
  window.addEventListener('resize',resetX,{passive:true});
  window.addEventListener('orientationchange',function(){window.setTimeout(resetX,120);},{passive:true});
  window.addEventListener('scroll',function(){
    if(window.scrollX!==0) resetX();
  },{passive:true});
});
</script>
<?php wp_footer(); ?>
</body></html>