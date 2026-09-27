<?php
/**
 * Optional Iranian (Jalali) birthday with separate birthday-message consent.
 * Dates are never public. Checkout stores the values on the order; accounts
 * store them as WooCommerce customer metadata for BAJI's consent-gated sync.
 */
defined( 'ABSPATH' ) || exit;

function baji_birthday_ascii( $value ) {
	return strtr( trim( (string) $value ), array(
		'۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9',
		'٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9',
	) );
}

/** Pure PHP Gregorian/Jalali conversion; no extension or remote script needed. */
function baji_birthday_j_to_g( $jy, $jm, $jd ) {
	$jy += 1595;
	$days = -355668 + 365 * $jy + intdiv( $jy, 33 ) * 8 + intdiv( $jy % 33 + 3, 4 )
		+ $jd + ( $jm < 7 ? ( $jm - 1 ) * 31 : ( $jm - 7 ) * 30 + 186 );
	$gy = 400 * intdiv( $days, 146097 );
	$days %= 146097;
	if ( $days > 36524 ) {
		$gy += 100 * intdiv( --$days, 36524 );
		$days %= 36524;
		if ( $days >= 365 ) ++$days;
	}
	$gy += 4 * intdiv( $days, 1461 );
	$days %= 1461;
	if ( $days > 365 ) {
		$gy += intdiv( $days - 1, 365 );
		$days = ( $days - 1 ) % 365;
	}
	$gd = $days + 1;
	$months = array( 0, 31, ( $gy % 4 === 0 && $gy % 100 !== 0 || $gy % 400 === 0 ) ? 29 : 28,
		31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
	$gm = 1;
	while ( $gm < 13 && $gd > $months[ $gm ] ) $gd -= $months[ $gm++ ];
	return array( $gy, $gm, $gd );
}
function baji_birthday_g_to_j( $gy, $gm, $gd ) {
	$gdm = array( 0,31,59,90,120,151,181,212,243,273,304,334 );
	$jy = $gy > 1600 ? 979 : 0;
	$gy -= $gy > 1600 ? 1600 : 621;
	$gy2 = $gm > 2 ? $gy + 1 : $gy;
	$days = 365 * $gy + intdiv( $gy2 + 3, 4 ) - intdiv( $gy2 + 99, 100 )
		+ intdiv( $gy2 + 399, 400 ) - 80 + $gd + $gdm[ $gm - 1 ];
	$jy += 33 * intdiv( $days, 12053 );
	$days %= 12053;
	$jy += 4 * intdiv( $days, 1461 );
	$days %= 1461;
	if ( $days > 365 ) {
		$jy += intdiv( $days - 1, 365 );
		$days = ( $days - 1 ) % 365;
	}
	$jm = $days < 186 ? 1 + intdiv( $days, 31 ) : 7 + intdiv( $days - 186, 30 );
	$jd = 1 + ( $days < 186 ? $days % 31 : ( $days - 186 ) % 30 );
	return array( $jy, $jm, $jd );
}
function baji_birthday_today_jalali() {
	$today = new DateTimeImmutable( 'now', new DateTimeZone( 'Asia/Tehran' ) );
	return baji_birthday_g_to_j( (int) $today->format('Y'), (int) $today->format('m'), (int) $today->format('d') );
}
function baji_birthday_valid( $year, $month, $day ) {
	$y = (int) baji_birthday_ascii( $year );
	$m = (int) baji_birthday_ascii( $month );
	$d = (int) baji_birthday_ascii( $day );
	$now = baji_birthday_today_jalali();
	if ( $y < 1300 || $y > $now[0] || $m < 1 || $m > 12 || $d < 1 || $d > 31 ) return '';
	if ( ( $m > 6 && $d > 30 ) ) return '';
	$gregorian = baji_birthday_j_to_g( $y, $m, $d );
	if ( baji_birthday_g_to_j( ...$gregorian ) !== array( $y, $m, $d ) ) return '';
	if ( (int) sprintf('%04d%02d%02d',$y,$m,$d) > (int) sprintf('%04d%02d%02d',...$now) ) return '';
	return sprintf('%04d/%02d/%02d', $y, $m, $d);
}
function baji_birthday_parts( $date ) {
	if ( ! preg_match( '~^(\d{4})/(\d\d)/(\d\d)$~D', baji_birthday_ascii( $date ), $m ) ) return array('','','');
	return array( $m[1], (string)(int)$m[2], (string)(int)$m[3] );
}
function baji_birthday_year_options() {
	$now = baji_birthday_today_jalali();
	$years = array( '' => 'سال تولد' );
	for ( $y = $now[0]; $y >= 1300; --$y ) $years[ (string)$y ] = (string)$y;
	return $years;
}
function baji_birthday_month_options() {
	$names = array('فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند');
	$out = array( ''=>'ماه تولد' );
	foreach ( $names as $i=>$name ) $out[ (string)($i+1) ]=$name;
	return $out;
}
function baji_birthday_day_options() {
	$out = array( ''=>'روز تولد' );
	for ( $i=1;$i<=31;++$i ) $out[(string)$i]=(string)$i;
	return $out;
}
function baji_birthday_post_value( $key ) {
	return isset($_POST[$key]) && !is_array($_POST[$key])
		? baji_birthday_ascii( sanitize_text_field( wp_unslash( $_POST[$key] ) ) ) : '';
}
function baji_birthday_post_date( $prefix ) {
	$year=baji_birthday_post_value( $prefix.'year' );
	$month=baji_birthday_post_value( $prefix.'month' );
	$day=baji_birthday_post_value( $prefix.'day' );
	$filled=($year!=='' || $month!=='' || $day!=='');
	return array( 'filled'=>$filled,'date'=> $filled ? baji_birthday_valid( $year,$month,$day ) : '' );
}
function baji_birthday_user_values( $uid ) {
	$saved=(string)get_user_meta($uid,'baji_birthdate_jalali',true);
	return baji_birthday_parts($saved);
}
/** Checkout billing form: birthday optional, separate from general marketing. */
add_filter( 'woocommerce_checkout_fields', function( $fields ) {
	$parts = is_user_logged_in() ? baji_birthday_user_values( get_current_user_id() ) : array('','','');
	$opt = is_user_logged_in() ? get_user_meta(get_current_user_id(),'baji_birthday_sms_consent',true)==='1' : false;
	$controls = array(
		'billing_baji_birth_year'=>array('label'=>'سال تولد (شمسی)','options'=>baji_birthday_year_options(),'default'=>$parts[0],'priority'=>125,'class'=>array('form-row-wide','baji-birth-year')),
		'billing_baji_birth_month'=>array('label'=>'ماه تولد','options'=>baji_birthday_month_options(),'default'=>$parts[1],'priority'=>126,'class'=>array('form-row-first','baji-birth-month')),
		'billing_baji_birth_day'=>array('label'=>'روز تولد','options'=>baji_birthday_day_options(),'default'=>$parts[2],'priority'=>127,'class'=>array('form-row-last','baji-birth-day')),
	);
	foreach ($controls as $key=>$field) {
		$fields['billing'][$key]=array_merge($field,array('type'=>'select','required'=>false,'label_class'=>array('baji-birth-label')));
	}
	$fields['billing']['billing_baji_birthday_optin']=array(
		'type'=>'checkbox','label'=>'مایلم روز تولدم فقط پیامک تبریک و پیشنهاد هدیه تولد باجی را دریافت کنم.',
		'required'=>false,'default'=>$opt?'1':'0','priority'=>128,
		'class'=>array('form-row-wide','baji-birthday-consent'),
	);
	return $fields;
}, 10050 );

add_action( 'woocommerce_checkout_process', function() {
	$data=baji_birthday_post_date('billing_baji_birth_');
	if ($data['filled'] && $data['date']==='') wc_add_notice( 'لطفاً تاریخ تولد شمسی را درست وارد کنید.', 'error' );
	if (baji_birthday_post_value('billing_baji_birthday_optin')==='1' && $data['date']==='')
		wc_add_notice( 'برای دریافت پیامک تولد، تاریخ تولد را کامل وارد کنید.', 'error' );
} );

add_action( 'woocommerce_checkout_create_order', function($order,$data) {
	$birth=baji_birthday_post_date('billing_baji_birth_');
	$consent=baji_birthday_post_value('billing_baji_birthday_optin')==='1' && $birth['date']!=='';
	if ($birth['filled'] && $birth['date']!=='') {
		$order->update_meta_data('baji_birthdate_jalali',$birth['date']);
	}
	$order->update_meta_data('baji_birthday_sms_consent',$consent?'1':'0');
}, 20, 2 );

function baji_birthday_update_user_meta( $uid, $birth, $consent ) {
	if ( !$uid ) return;
	$customer=new WC_Customer($uid);
	if ( $birth['filled'] && $birth['date']!=='' ) {
		$customer->update_meta_data('baji_birthdate_jalali',$birth['date']);
	}
	$customer->update_meta_data('baji_birthday_sms_consent',$consent?'1':'0');
	$customer->save();
}
add_action( 'woocommerce_checkout_order_processed', function($id,$data,$order) {
	if (!$order || !$order->get_customer_id()) return;
	$birth=baji_birthday_post_date('billing_baji_birth_');
	$consent=baji_birthday_post_value('billing_baji_birthday_optin')==='1' && $birth['date']!=='';
	// Keep existing date when a logged-in customer leaves the optional date blank.
	if (!$birth['filled']) {
		$parts=baji_birthday_user_values($order->get_customer_id());
		if ($parts[0]!=='') $birth['date']=baji_birthday_valid(...$parts);
		$consent=baji_birthday_post_value('billing_baji_birthday_optin')==='1' && $birth['date']!=='';
	}
	baji_birthday_update_user_meta($order->get_customer_id(),$birth,$consent);
}, 20, 3 );

/** The same optional controls on My Account > account details. */
add_action('woocommerce_edit_account_form',function() {
	$uid=get_current_user_id();
	$parts=baji_birthday_user_values($uid);
	$keys=array('account_baji_birth_year','account_baji_birth_month','account_baji_birth_day');
	$options=array(baji_birthday_year_options(),baji_birthday_month_options(),baji_birthday_day_options());
	foreach($keys as $i=>$key) {
		if (isset($_POST[$key]) && !is_array($_POST[$key])) $parts[$i]=baji_birthday_post_value($key);
	}
	$opt=isset($_POST['save_account_details']) ? baji_birthday_post_value('account_baji_birthday_optin')==='1'
		: get_user_meta($uid,'baji_birthday_sms_consent',true)==='1';
	?>
	<section class="baji-birthday-account" aria-labelledby="baji-birthday-account-title">
		<h3 id="baji-birthday-account-title">هدیه تولدت از باجی 🤍</h3>
		<p>تاریخ تولدت را به شمسی وارد کن تا همان روز تبریک بگوییم. ثبت تاریخ اختیاری است.</p>
		<div class="baji-birthday-account-fields">
		<?php foreach ($keys as $i=>$key): ?>
			<label for="<?php echo esc_attr($key); ?>">
				<span><?php echo esc_html(array('سال تولد','ماه تولد','روز تولد')[$i]); ?></span>
				<select name="<?php echo esc_attr($key); ?>" id="<?php echo esc_attr($key); ?>">
				<?php foreach($options[$i] as $value=>$label): ?>
					<option value="<?php echo esc_attr($value); ?>" <?php selected((string)$parts[$i],(string)$value); ?>><?php echo esc_html($label); ?></option>
				<?php endforeach; ?>
				</select>
			</label>
		<?php endforeach; ?>
		</div>
		<label class="baji-birthday-account-consent" for="account_baji_birthday_optin">
			<input type="checkbox" id="account_baji_birthday_optin" name="account_baji_birthday_optin" value="1" <?php checked($opt); ?>>
			<span>مایلم روز تولدم پیامک تبریک و پیشنهاد هدیه تولد باجی را دریافت کنم.</span>
		</label>
		<small>این رضایت فقط مربوط به پیامک تولد است؛ هر زمان بخواهی می‌توانی آن را برداری.</small>
	</section>
	<?php
});
add_action('woocommerce_save_account_details_errors',function($errors,$user){
	$data=baji_birthday_post_date('account_baji_birth_');
	if ($data['filled'] && $data['date']==='') $errors->add('baji_birthday_invalid','تاریخ تولد شمسی معتبر نیست؛ سال، ماه و روز را بررسی کن.');
	if (baji_birthday_post_value('account_baji_birthday_optin')==='1' && !$data['filled'] && !get_user_meta($user->ID,'baji_birthdate_jalali',true))
		$errors->add('baji_birthday_missing','برای دریافت پیامک تولد، ابتدا تاریخ تولد را وارد کن.');
},20,2);
add_action('woocommerce_save_account_details',function($uid) {
	$birth=baji_birthday_post_date('account_baji_birth_');
	if (!$birth['filled']) {
		$parts=baji_birthday_user_values($uid);
		if ($parts[0]!=='') $birth['date']=baji_birthday_valid(...$parts);
	}
	$consent=baji_birthday_post_value('account_baji_birthday_optin')==='1' && $birth['date']!=='';
	baji_birthday_update_user_meta($uid,$birth,$consent);
},20);
