<?php
/** BAJI approved pink footer */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
</main><!-- #main-content -->
<footer id="colophon" class="baji-footer-pink" dir="rtl">
 <div class="bfp-wrap">
  <section class="bfp-brand">
   <a class="bfp-logo" href="<?php echo esc_url(home_url('/')); ?>">BAJI</a><div class="bfp-tag">BE YOUR BEST</div>
   <h2><span>♥</span> استایلی برای نسخه بهتر تو <span>♥</span></h2>
   <div class="bfp-social">
    <?php $ig=get_theme_mod('bajistyle_social_instagram'); if($ig): ?><a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener" aria-label="اینستاگرام"><i class="fa-brands fa-instagram"></i></a><?php endif; ?>
    <a href="https://ble.ir/" target="_blank" rel="noopener" aria-label="بله" class="bfp-bale">بله</a>
   </div>
  </section>
  <div class="bfp-divider"><span>♥</span></div>
  <div class="bfp-links-grid">
   <nav><h3><i class="far fa-headset"></i> راهنمای مشتریان</h3>
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">خرید از باجی</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>">ارتباط با ما</a>
    <a href="<?php echo esc_url(home_url('/size-guide/')); ?>">چطور اندازه مناسب انتخاب کنیم؟</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>">بگو چی شده، درستش می‌کنیم.</a>
    <a href="<?php echo esc_url(home_url('/terms/')); ?>">قوانین ساده ما</a>
    <a href="<?php echo esc_url(home_url('/faq/')); ?>">سوالات متداول</a>
   </nav>
   <nav><h3><i class="far fa-link"></i> لینک‌های کاربردی</h3>
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">ارسال رایگان باجی</a>
    <a href="<?php echo esc_url(home_url('/faq/')); ?>">پرداخت‌های متداول</a>
    <a href="<?php echo esc_url(home_url('/about/')); ?>">درباره ما</a>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>">تماس با ما</a>
    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">ثبت نام / ورود</a>
    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>">باشگاه مشتریان</a>
   </nav>
  </div>
  <div class="bfp-features">
   <div><i class="far fa-truck"></i><b>ارسال سریع</b><span>به سراسر کشور</span></div>
   <div><i class="far fa-shield-check"></i><b>ضمانت اصالت</b><span>و کیفیت کالا</span></div>
   <div><i class="far fa-headset"></i><b>پشتیبانی</b><span>پاسخگو و همراه</span></div>
  </div>
  <div class="bfp-trust">
   <a class="bfp-enamad" target="_blank" rel="noopener" href="https://trustseal.enamad.ir/?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn"><img src="https://trustseal.enamad.ir/logo.aspx?id=661133&Code=KEQE0AsA3PbAohWIzUEBUZEejYgAGSdn" alt="نماد اعتماد الکترونیکی"></a>
   <div class="bfp-partner bfp-digikala"><b>دیجی‌کالا</b><small>digikala</small></div>
   <div class="bfp-partner bfp-snapp"><b>Snapp! Pay</b><small>اسنپ‌پی</small></div>
   <div class="bfp-partner bfp-torob"><b>ترب‌پی</b><small>خرید الآن، پرداخت بعداً</small></div>
  </div>
  <div class="bfp-owner">محسن باقریان | مالک برند باجی</div>
  <div class="bfp-copy">© فروشگاه اینترنتی باجی. تمامی حقوق محفوظ است.</div>
 </div>
</footer>
<style id="baji-footer-pink-css">
.baji-footer-pink,.baji-footer-pink *{box-sizing:border-box}.baji-footer-pink{background:linear-gradient(180deg,#fffafa 0%,#fff3f4 100%)!important;color:#20252b!important;font-family:inherit!important}.bfp-wrap{max-width:1120px;margin:auto;padding:48px 28px 100px}.bfp-brand{text-align:center}.bfp-logo{display:block;font:68px/1 Georgia,serif;letter-spacing:.08em;color:#050505!important;text-decoration:none}.bfp-tag{font:10px/1.6 Georgia,serif;letter-spacing:.52em;margin:4px 0 24px}.bfp-brand h2{font-size:26px;font-weight:800;margin:0 0 26px}.bfp-brand h2 span{color:#e84d6d;margin:0 10px}.bfp-social{display:flex;justify-content:center;gap:18px}.bfp-social a{width:58px;height:58px;border-radius:50%;background:#f9dfe3;color:#9a4552!important;display:grid;place-items:center;text-decoration:none;font-size:27px}.bfp-social .bfp-bale{font-size:14px;font-weight:900;color:#fff!important;background:#1fa7a8}.bfp-divider{height:50px;display:flex;align-items:center;gap:14px;color:#e84d6d}.bfp-divider:before,.bfp-divider:after{content:'';height:1px;background:#ef9aaa;flex:1}.bfp-links-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;border-bottom:0}.bfp-links-grid nav{padding:20px 56px;text-align:right}.bfp-links-grid nav+nav{border-right:1px solid #f1b9c2}.bfp-links-grid h3{font-size:25px;margin:0 0 24px;font-weight:900}.bfp-links-grid h3 i{color:#e84d6d;margin-left:8px}.bfp-links-grid a{display:block;color:#27313a!important;text-decoration:none;font-size:17px;line-height:2.65}.bfp-features{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:18px}.bfp-features>div{background:#fde9ec;border-radius:10px;min-height:116px;display:grid;grid-template-columns:56px auto;grid-template-rows:auto auto;align-content:center;padding:18px 22px}.bfp-features i{grid-row:1/3;font-size:35px;color:#e83f65;align-self:center}.bfp-features b{font-size:16px}.bfp-features span{font-size:14px}.bfp-trust{margin-top:18px;background:#fff;border:14px solid #fde9ec;border-radius:10px;display:grid;grid-template-columns:repeat(4,1fr);align-items:center;min-height:145px}.bfp-trust>*{min-height:92px;display:flex;flex-direction:column;align-items:center;justify-content:center;border-left:1px solid #f3b6c0;text-decoration:none}.bfp-trust>*:last-child{border-left:0}.bfp-enamad img{width:78px;height:78px;object-fit:contain}.bfp-partner b{font-size:24px}.bfp-partner small{font-size:11px;margin-top:4px}.bfp-digikala b,.bfp-digikala small{color:#e62f59}.bfp-snapp b{color:#00d88a;font-family:Arial,sans-serif}.bfp-torob b{color:#6334e8}.bfp-owner{text-align:center;font-size:15px;font-weight:700;margin:32px 0 5px}.bfp-copy{text-align:center;font-size:13px;color:#4f555a}
@media(max-width:900px){.bfp-wrap{padding:34px 18px 95px}.bfp-logo{font-size:58px}.bfp-brand h2{font-size:21px}.bfp-links-grid nav{padding:15px 18px}.bfp-links-grid h3{font-size:21px}.bfp-links-grid a{font-size:14px;line-height:2.75}.bfp-features{grid-template-columns:repeat(3,1fr)}.bfp-features>div{min-height:100px;grid-template-columns:40px auto;padding:12px 8px}.bfp-features i{font-size:27px}.bfp-features b{font-size:12px}.bfp-features span{font-size:10px}.bfp-trust{border-width:10px;min-height:120px}.bfp-trust>*{min-height:85px}.bfp-enamad img{width:62px;height:62px}.bfp-partner b{font-size:16px}.bfp-partner small{font-size:8px}.bfp-owner{font-size:13px}}
@media(max-width:520px){.bfp-links-grid{grid-template-columns:1fr 1fr}.bfp-links-grid nav{padding:12px 10px}.bfp-links-grid h3{font-size:18px}.bfp-links-grid a{font-size:12px}.bfp-features{gap:6px}.bfp-trust{grid-template-columns:repeat(4,1fr)}.bfp-partner b{font-size:13px}}
</style>
<div class="baji-mobile-bottom-nav md:hidden fixed bottom-0 inset-x-0 z-50 flex items-center justify-around h-16 px-1" style="background:#cf536a!important;color:#fff!important"><a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center justify-center gap-1 flex-1" style="color:#fff"><i class="far fa-home text-xl"></i><span class="text-[10px]">خانه</span></a><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="flex flex-col items-center justify-center gap-1 flex-1" style="color:#fff"><i class="far fa-grid-2 text-xl"></i><span class="text-[10px]">دسته بندی</span></a><button type="button" class="baji-cart-toggle flex flex-col items-center justify-center gap-1 flex-1" style="color:#fff" aria-controls="baji-cart-panel"><i class="far fa-shopping-cart text-xl"></i><span class="text-[10px]">سبد خرید</span></button><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="flex flex-col items-center justify-center gap-1 flex-1" style="color:#fff"><i class="far fa-user text-xl"></i><span class="text-[10px]">ورود / عضویت</span></a><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="flex flex-col items-center justify-center gap-1 flex-1" style="color:#fff"><i class="far fa-headset text-xl"></i><span class="text-[10px]">پشتیبانی</span></a></div>
</div><!-- #page -->
<div id="baji-cart-panel" class="baji-cart-drawer" aria-hidden="true" data-coupon-nonce="<?php echo esc_attr( wp_create_nonce( 'baji_cart_coupon' ) ); ?>" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"><div class="baji-cart-drawer__head"><button id="baji-cart-close" type="button" class="baji-cart-drawer__close" aria-label="بستن"><i class="fa-solid fa-xmark"></i></button><div class="baji-cart-drawer__title"><span class="baji-cart-drawer__bag"><i class="far fa-shopping-bag"></i><span class="baji-cart-count"><?php echo absint(WC()->cart?WC()->cart->get_cart_contents_count():0); ?></span></span><div><b>سبد خرید شما</b><small>خرید امن و سریع از BAJI</small></div></div></div><div class="baji-cart-shipping" data-free-shipping-target="3000000"><div class="baji-cart-shipping__row"><i class="far fa-truck"></i><div><b class="baji-cart-shipping__title">ارسال رایگان</b><span class="baji-cart-shipping__text">برای سفارش‌های بالای ۳ میلیون تومان</span></div></div><div class="baji-cart-shipping__bar"><span style="width:0%"></span></div><div class="baji-cart-shipping__meta"><span class="baji-cart-shipping__current"></span><span>هدف: ۳,۰۰۰,۰۰۰ تومان</span></div></div><div class="baji-cart-drawer__body widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div><div class="baji-cart-coupon-static"><form method="post" action="<?php echo esc_url( wc_get_cart_url() ); ?>"><div class="baji-mini-coupon__field"><i class="far fa-gift"></i><input type="text" name="coupon_code" placeholder="کد تخفیف را وارد کنید" autocomplete="off"><button type="submit" name="apply_coupon" value="1">اعمال</button></div><?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?></form></div><div class="baji-cart-trust"><div><i class="far fa-shield-check"></i><b>پرداخت امن</b></div><div><i class="far fa-truck"></i><b>ارسال سریع</b></div><div><i class="far fa-headset"></i><b>پشتیبانی</b></div></div></div><div id="baji-cart-overlay" class="baji-cart-overlay"></div>
<script id="baji-cart-drawer-js">document.addEventListener('DOMContentLoaded',function(){const panel=document.getElementById('baji-cart-panel'),overlay=document.getElementById('baji-cart-overlay'),close=document.getElementById('baji-cart-close'),toggles=document.querySelectorAll('.baji-cart-toggle');if(!panel||!overlay||!toggles.length)return;function openCart(){panel.classList.add('is-open');overlay.classList.add('is-open');panel.setAttribute('aria-hidden','false');document.body.style.overflow='hidden'}function closeCart(){panel.classList.remove('is-open');overlay.classList.remove('is-open');panel.setAttribute('aria-hidden','true');document.body.style.overflow=''}toggles.forEach(function(btn){btn.addEventListener('click',openCart)});if(close)close.addEventListener('click',closeCart);overlay.addEventListener('click',closeCart);document.addEventListener('keydown',function(e){if(e.key==='Escape')closeCart()})});</script>
<?php wp_footer(); ?>
</body></html>