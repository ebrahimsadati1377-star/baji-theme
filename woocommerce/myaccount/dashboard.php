<?php
/**
 * داشبورد حساب کاربری (Override کامل ووکامرس)
 *
 * صفحه خوش‌آمدگویی داشبورد در my-account/ با کارت‌های دسترسی سریع
 * به سفارش‌ها، آدرس‌ها، علاقه‌مندی‌ها و اطلاعات حساب.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();
?>

<div class="baji-account-dashboard">

	<div class="baji-dashboard-welcome mb-10">
		<h2 class="text-2xl font-light mb-2">
			<?php
			printf(
				/* translators: %s: نام کاربر */
				esc_html__( 'خوش آمدید، %s', 'bajistyle' ),
				'<span class="text-baji-gold">' . esc_html( $current_user->display_name ) . '</span>'
			);
			?>
		</h2>
		<p class="text-sm text-gray-500">
			<?php
			$allowed_html = array( 'a' => array( 'href' => array() ) );
			echo wp_kses(
				sprintf(
					/* translators: 1: ایمیل کاربر 2: لینک خروج از حساب */
					__( 'از این بخش می‌توانید سفارش‌ها، آدرس‌ها و اطلاعات حساب کاربری خود (%1$s) را مدیریت کنید. برای خروج از حساب کاربری %2$s.', 'bajistyle' ),
					'<strong>' . esc_html( $current_user->user_email ) . '</strong>',
					'<a href="' . esc_url( wc_logout_url() ) . '" class="text-baji-gold underline">' . esc_html__( 'اینجا کلیک کنید', 'bajistyle' ) . '</a>'
				),
				array(
					'strong' => array(),
					'a'      => array(
						'href'  => array(),
						'class' => array(),
					),
				)
			);
			?>
		</p>
	</div>

	<div class="baji-dashboard-cards grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

		<a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="baji-dashboard-card group p-6 border border-gray-200 hover:border-baji-gold transition-colors duration-300">
			<span class="baji-dashboard-card-icon block text-2xl text-baji-gold mb-3" aria-hidden="true">▣</span>
			<h3 class="text-sm tracking-wide mb-1 group-hover:text-baji-gold transition-colors"><?php esc_html_e( 'سفارش‌های من', 'bajistyle' ); ?></h3>
			<p class="text-xs text-gray-400"><?php esc_html_e( 'مشاهده تاریخچه و وضعیت سفارش‌ها', 'bajistyle' ); ?></p>
		</a>

		<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="baji-dashboard-card group p-6 border border-gray-200 hover:border-baji-gold transition-colors duration-300">
			<span class="baji-dashboard-card-icon block text-2xl text-baji-gold mb-3" aria-hidden="true">⌂</span>
			<h3 class="text-sm tracking-wide mb-1 group-hover:text-baji-gold transition-colors"><?php esc_html_e( 'آدرس‌ها', 'bajistyle' ); ?></h3>
			<p class="text-xs text-gray-400"><?php esc_html_e( 'مدیریت آدرس‌های صورت‌حساب و ارسال', 'bajistyle' ); ?></p>
		</a>

		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'wishlist' ) ); ?>" class="baji-dashboard-card group p-6 border border-gray-200 hover:border-baji-gold transition-colors duration-300">
			<span class="baji-dashboard-card-icon block text-2xl text-baji-gold mb-3" aria-hidden="true">♡</span>
			<h3 class="text-sm tracking-wide mb-1 group-hover:text-baji-gold transition-colors"><?php esc_html_e( 'علاقه‌مندی‌های من', 'bajistyle' ); ?></h3>
			<p class="text-xs text-gray-400"><?php esc_html_e( 'محصولاتی که ذخیره کرده‌اید', 'bajistyle' ); ?></p>
		</a>

		<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="baji-dashboard-card group p-6 border border-gray-200 hover:border-baji-gold transition-colors duration-300">
			<span class="baji-dashboard-card-icon block text-2xl text-baji-gold mb-3" aria-hidden="true">⚇</span>
			<h3 class="text-sm tracking-wide mb-1 group-hover:text-baji-gold transition-colors"><?php esc_html_e( 'اطلاعات حساب', 'bajistyle' ); ?></h3>
			<p class="text-xs text-gray-400"><?php esc_html_e( 'ویرایش نام، ایمیل و رمز عبور', 'bajistyle' ); ?></p>
		</a>

	</div>

	<?php
	/**
	 * هوک woocommerce_account_dashboard.
	 * برای سازگاری با افزونه‌های شخص ثالث که محتوای اضافی به داشبورد اضافه می‌کنند، حفظ شده است.
	 */
	do_action( 'woocommerce_account_dashboard' );
	?>

</div>
