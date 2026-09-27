<?php
/** Explicit BAJI marketing SMS preference. Unchecked by default. */
if (!defined('ABSPATH')) exit;
function baji_sms_optin_field() {
 echo '<p class="form-row form-row-wide" id="baji_sms_optin_field"><label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox"><input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox" name="baji_sms_marketing_optin" value="1" '.checked(!empty($_POST['baji_sms_marketing_optin']),true,false).' /> <span>مایلم پیامک محصولات جدید، تخفیف‌ها و پیشنهادهای باجی را دریافت کنم (اختیاری).</span></label></p>';
}
add_action('woocommerce_review_order_before_submit','baji_sms_optin_field',8);
add_action('woocommerce_register_form','baji_sms_optin_field',20);
add_action('woocommerce_checkout_create_order',function($order) {
 $order->update_meta_data('_baji_sms_marketing_optin',!empty($_POST['baji_sms_marketing_optin'])?'1':'0');
},20);
add_action('woocommerce_created_customer',function($id) {
 if (!empty($_POST['baji_sms_marketing_optin'])) update_user_meta($id,'baji_sms_marketing_optin','1');
},20);
add_action('woocommerce_checkout_order_processed',function($id) {
 $order=wc_get_order($id);
 if (!$order || !$order->get_customer_id()) return;
 // Only explicit checkout selection grants opt-in; an unchecked checkout does not revoke an earlier opt-in.
 if ($order->get_meta('_baji_sms_marketing_optin')==='1') update_user_meta($order->get_customer_id(),'baji_sms_marketing_optin','1');
},20);
