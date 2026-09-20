document.addEventListener('DOMContentLoaded',function(){
 var panel=document.getElementById('baji-cart-panel');
 if(!panel)return;
 function lat(s){return String(s||'').replace(/[۰-۹]/g,function(d){return '۰۱۲۳۴۵۶۷۸۹'.indexOf(d);}).replace(/[٠-٩]/g,function(d){return '٠١٢٣٤٥٦٧٨٩'.indexOf(d);});}
 function num(s){var n=lat(s).replace(/[^0-9]/g,'');return n?parseInt(n,10):0;}
 function fmt(n){return new Intl.NumberFormat('fa-IR').format(Math.max(0,Math.round(n)))+' تومان';}
 function shipping(){
  var box=panel.querySelector('.baji-cart-shipping');
  var totalEl=panel.querySelector('.woocommerce-mini-cart__total .amount, .woocommerce-mini-cart__total .woocommerce-Price-amount');
  if(!box||!totalEl)return;
  var current=num(totalEl.textContent);
  box.innerHTML='<div class="baji-cart-shipping__row"><i class="far fa-truck"></i><div><b class="is-free">ارسال همه سفارش‌ها رایگان است</b><span>بدون حداقل مبلغ خرید</span></div></div><div class="baji-cart-shipping__bar"><span style="width:100%"></span></div><div class="baji-cart-shipping__meta"><span>فعلی: '+fmt(current)+'</span><span>هزینه ارسال: رایگان</span></div>';
 }
 function coupon(){
  var body=panel.querySelector('.widget_shopping_cart_content'),total=body&&body.querySelector('.woocommerce-mini-cart__total');
  if(!body||!total||body.querySelector('.baji-mini-coupon'))return;
  var host=total.parentElement,wrap=document.createElement('div');
  wrap.className='baji-mini-coupon';
  wrap.innerHTML='<div class="baji-mini-coupon__field"><i class="far fa-gift"></i><input type="text" placeholder="کد تخفیف را وارد کنید"><button type="button">اعمال</button></div><div class="baji-mini-coupon__message"></div>';
  host.insertBefore(wrap,total);
  wrap.querySelector('button').addEventListener('click',function(){
   var code=wrap.querySelector('input').value.trim(),msg=wrap.querySelector('.baji-mini-coupon__message'),btn=this;
   if(!code){msg.textContent='کد تخفیف را وارد کنید.';msg.className='baji-mini-coupon__message is-error';return;}
   btn.disabled=true;btn.textContent='...';
   var q=new URLSearchParams({action:'baji_apply_cart_coupon',nonce:panel.dataset.couponNonce||'',coupon_code:code});
   fetch(panel.dataset.ajaxUrl,{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'},credentials:'same-origin',body:q.toString()}).then(function(r){return r.json();}).then(function(d){
    msg.textContent=d&&d.data&&d.data.message?d.data.message:(d&&d.success?'کد تخفیف اعمال شد.':'کد تخفیف معتبر نیست.');
    msg.className='baji-mini-coupon__message '+(d&&d.success?'is-success':'is-error');
    if(d&&d.success&&window.jQuery)window.jQuery(document.body).trigger('wc_fragment_refresh');
   }).catch(function(){msg.textContent='خطا در اعمال کد تخفیف.';msg.className='baji-mini-coupon__message is-error';}).finally(function(){btn.disabled=false;btn.textContent='اعمال';});
  });
 }
 function refresh(){setTimeout(function(){shipping();coupon();},80);}
 refresh();
 if(window.jQuery)window.jQuery(document.body).on('wc_fragments_refreshed added_to_cart removed_from_cart updated_wc_div',refresh);
 document.querySelectorAll('.baji-cart-toggle').forEach(function(b){b.addEventListener('click',refresh);});
});