<?php
/**
 * BAJI edit account form.
 *
 * @package BajiStyle
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );

$user = wp_get_current_user();
$account_email = (string) $user->user_email;
if ( 'no-reply@bajistyle.ir' === strtolower( $account_email ) ) {
	$account_email = '';
}
?>
<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<label for="account_first_name"><?php esc_html_e( 'نام', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" aria-required="true" />
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<label for="account_last_name"><?php esc_html_e( 'نام خانوادگی', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" aria-required="true" />
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_display_name"><?php esc_html_e( 'نام نمایشی', 'woocommerce' ); ?>&nbsp;<span class="required" aria-hidden="true">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr( $user->display_name ); ?>" aria-required="true" />
		<span id="account_display_name_description"><em><?php esc_html_e( 'این نام در حساب کاربری و نظرات شما نمایش داده می‌شود.', 'bajistyle' ); ?></em></span>
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide baji-account-email-optional">
		<label for="account_email">
			<?php esc_html_e( 'آدرس ایمیل', 'woocommerce' ); ?>
			<span class="baji-optional-label"><?php esc_html_e( 'اختیاری', 'bajistyle' ); ?></span>
		</label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $account_email ); ?>" />
		<span class="baji-account-email-note">
			<i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i>
			<?php esc_html_e( 'اطلاع‌رسانی‌های سفارش باجی از طریق شماره موبایل انجام می‌شود؛ وارد کردن ایمیل الزامی نیست.', 'bajistyle' ); ?>
		</span>
	</p>

	<fieldset>
		<legend><?php esc_html_e( 'تغییر گذرواژه', 'woocommerce' ); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current"><?php esc_html_e( 'رمز عبور فعلی (در صورتی که قصد تغییر ندارید خالی بگذارید)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_1"><?php esc_html_e( 'رمز عبور جدید (در صورتی که قصد تغییر ندارید خالی بگذارید)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_2"><?php esc_html_e( 'تأیید رمز عبور جدید', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'ذخیره تغییرات', 'woocommerce' ); ?>"><?php esc_html_e( 'ذخیره تغییرات', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
