<?php
/**
 * Premium BAJI address book.
 *
 * @package BajiStyle
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$account_url = wc_get_page_permalink( 'myaccount' );

$address_types = array(
	'billing' => array(
		'title'       => 'آدرس صورتحساب',
		'description' => 'برای صدور فاکتور و اطلاعات پرداخت استفاده می‌شود.',
		'icon'        => 'fa-file-invoice',
	),
	'shipping' => array(
		'title'       => 'آدرس ارسال',
		'description' => 'سفارش‌های باجی به این آدرس ارسال می‌شوند.',
		'icon'        => 'fa-truck-fast',
	),
);

$countries = WC()->countries->get_countries();
?>
<div class="baji-address-book">
	<section class="baji-address-book__intro">
		<span class="baji-address-book__intro-icon"><i class="fa-solid fa-location-dot"></i></span>
		<div>
			<small>دفترچه آدرس باجی</small>
			<h2>آدرس‌های ذخیره‌شده</h2>
			<p>آدرس‌های ارسال و صورتحساب را از همین‌جا مشاهده و ویرایش کن.</p>
		</div>
	</section>

	<div class="baji-address-grid">
		<?php foreach ( $address_types as $type => $config ) : ?>
			<?php
			$first_name = (string) get_user_meta( $customer_id, $type . '_first_name', true );
			$last_name  = (string) get_user_meta( $customer_id, $type . '_last_name', true );
			$address_1  = (string) get_user_meta( $customer_id, $type . '_address_1', true );
			$address_2  = (string) get_user_meta( $customer_id, $type . '_address_2', true );
			$city       = (string) get_user_meta( $customer_id, $type . '_city', true );
			$state      = (string) get_user_meta( $customer_id, $type . '_state', true );
			$postcode   = (string) get_user_meta( $customer_id, $type . '_postcode', true );
			$country    = (string) get_user_meta( $customer_id, $type . '_country', true );
			$phone      = (string) get_user_meta( $customer_id, $type . '_phone', true );
			$email      = (string) get_user_meta( $customer_id, $type . '_email', true );

			if ( 'shipping' === $type && '' === $phone ) {
				$phone = (string) get_user_meta( $customer_id, 'billing_phone', true );
			}

			$state_name = $state;
			if ( $country ) {
				$states = WC()->countries->get_states( $country );
				if ( is_array( $states ) && isset( $states[ $state ] ) ) {
					$state_name = $states[ $state ];
				}
			}
			$country_name = $country && isset( $countries[ $country ] ) ? $countries[ $country ] : '';
			$full_name    = trim( $first_name . ' ' . $last_name );
			$location     = implode( '، ', array_filter( array( $state_name, $city ) ) );
			$full_address = implode( '، ', array_filter( array( $address_1, $address_2 ) ) );
			$is_empty     = '' === $full_name && '' === $full_address && '' === $city && '' === $state;
			$edit_url     = wc_get_endpoint_url( 'edit-address', $type, $account_url );
			?>
			<section class="baji-address-card<?php echo $is_empty ? ' is-empty' : ''; ?>">
				<header class="baji-address-card__head">
					<div class="baji-address-card__title">
						<span><i class="fa-solid <?php echo esc_attr( $config['icon'] ); ?>"></i></span>
						<div>
							<h3><?php echo esc_html( $config['title'] ); ?></h3>
							<p><?php echo esc_html( $config['description'] ); ?></p>
						</div>
					</div>
					<a class="baji-address-card__edit" href="<?php echo esc_url( $edit_url ); ?>">
						<i class="fa-solid fa-pen"></i>
						<span><?php echo $is_empty ? 'افزودن' : 'ویرایش'; ?></span>
					</a>
				</header>

				<?php if ( $is_empty ) : ?>
					<div class="baji-address-card__empty">
						<i class="fa-regular fa-map"></i>
						<strong>هنوز آدرسی ثبت نشده</strong>
						<p>برای تکمیل سریع‌تر خرید بعدی، آدرس خودت را اضافه کن.</p>
						<a href="<?php echo esc_url( $edit_url ); ?>">ثبت آدرس</a>
					</div>
				<?php else : ?>
					<div class="baji-address-details">
						<div class="baji-address-row">
							<span class="baji-address-row__icon"><i class="fa-regular fa-user"></i></span>
							<div class="baji-address-row__label">نام گیرنده</div>
							<strong><?php echo esc_html( $full_name ?: '—' ); ?></strong>
						</div>

						<div class="baji-address-row">
							<span class="baji-address-row__icon"><i class="fa-solid fa-location-dot"></i></span>
							<div class="baji-address-row__label">استان / شهر</div>
							<strong><?php echo esc_html( $location ?: $country_name ?: '—' ); ?></strong>
						</div>

						<div class="baji-address-row baji-address-row--address">
							<span class="baji-address-row__icon"><i class="fa-regular fa-building"></i></span>
							<div class="baji-address-row__label">آدرس کامل</div>
							<strong><?php echo esc_html( $full_address ?: '—' ); ?></strong>
						</div>

						<?php if ( $postcode ) : ?>
							<div class="baji-address-row">
								<span class="baji-address-row__icon"><i class="fa-solid fa-hashtag"></i></span>
								<div class="baji-address-row__label">کد پستی</div>
								<strong dir="ltr"><?php echo esc_html( $postcode ); ?></strong>
							</div>
						<?php endif; ?>

						<?php if ( $phone ) : ?>
							<div class="baji-address-row">
								<span class="baji-address-row__icon"><i class="fa-solid fa-phone"></i></span>
								<div class="baji-address-row__label">شماره تماس</div>
								<strong dir="ltr"><?php echo esc_html( $phone ); ?></strong>
							</div>
						<?php endif; ?>

						<?php if ( 'billing' === $type && $email && 'no-reply@bajistyle.ir' !== $email ) : ?>
							<div class="baji-address-row">
								<span class="baji-address-row__icon"><i class="fa-regular fa-envelope"></i></span>
								<div class="baji-address-row__label">ایمیل</div>
								<strong dir="ltr"><?php echo esc_html( $email ); ?></strong>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</section>
		<?php endforeach; ?>
	</div>
</div>
