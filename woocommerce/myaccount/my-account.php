<?php
/**
 * BAJI premium My Account dashboard.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	?>
	<div class="baji-account-guest">
		<div class="baji-account-guest__mark">BAJI</div>
		<h2>برای دیدن حساب کاربری وارد شوید</h2>
		<p>سفارش‌ها، آدرس‌ها و علاقه‌مندی‌های شما بعد از ورود در دسترس هستند.</p>
		<a href="<?php echo esc_url( home_url( '/login/' ) ); ?>">ورود / ثبت‌نام</a>
	</div>
	<?php
	return;
}

$current_user   = wp_get_current_user();
$user_id        = get_current_user_id();
$display_name   = trim( (string) get_user_meta( $user_id, 'first_name', true ) );
$display_name   = $display_name ?: $current_user->display_name;
$display_name   = $display_name ?: 'همراه باجی';
$initial        = function_exists( 'mb_substr' ) ? mb_substr( $display_name, 0, 1, 'UTF-8' ) : substr( $display_name, 0, 1 );
$phone          = (string) get_user_meta( $user_id, 'billing_phone', true );
$phone          = $phone ?: ( preg_match( '/^09\d{9}$/', (string) $current_user->user_login ) ? $current_user->user_login : '' );
$masked_phone   = $phone;
if ( strlen( $phone ) >= 8 ) {
	$masked_phone = substr( $phone, 0, 4 ) . ' ••• ' . substr( $phone, -4 );
}

$all_orders = wc_get_orders(
	array(
		'customer' => $user_id,
		'limit'    => -1,
		'orderby'  => 'date',
		'order'    => 'DESC',
		'return'   => 'objects',
	)
);

$recent_orders = array_slice( $all_orders, 0, 3 );
$ongoing_count = 0;
$done_count    = 0;
foreach ( $all_orders as $order ) {
	if ( in_array( $order->get_status(), array( 'pending', 'on-hold', 'processing' ), true ) ) {
		$ongoing_count++;
	}
	if ( 'completed' === $order->get_status() ) {
		$done_count++;
	}
}

$wishlist_count = function_exists( 'bajistyle_get_wishlist_count' ) ? (int) bajistyle_get_wishlist_count() : 0;
$account_url     = wc_get_page_permalink( 'myaccount' );

$current_tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'dashboard';
if ( is_wc_endpoint_url( 'view-order' ) ) {
	$current_tab = 'view-order';
} elseif ( is_wc_endpoint_url( 'orders' ) ) {
	$current_tab = 'orders';
} elseif ( is_wc_endpoint_url( 'edit-address' ) ) {
	$current_tab = 'address';
} elseif ( is_wc_endpoint_url( 'edit-account' ) ) {
	$current_tab = 'edit-account';
} elseif ( is_wc_endpoint_url( 'wishlist' ) ) {
	$current_tab = 'wishlist';
}

$tabs = array(
	'dashboard'    => array( 'label' => 'خانه حساب', 'icon' => 'fa-house' ),
	'orders'       => array( 'label' => 'سفارش‌ها', 'icon' => 'fa-bag-shopping' ),
	'address'      => array( 'label' => 'آدرس‌ها', 'icon' => 'fa-location-dot' ),
	'wishlist'     => array( 'label' => 'علاقه‌مندی‌ها', 'icon' => 'fa-heart' ),
	'edit-account' => array( 'label' => 'اطلاعات من', 'icon' => 'fa-user-pen' ),
);

$ordered_products = array();
foreach ( $all_orders as $order ) {
	foreach ( $order->get_items( 'line_item' ) as $item ) {
		$product = $item->get_product();
		if ( ! $product ) {
			continue;
		}
		$product_id = $product->get_id();
		if ( isset( $ordered_products[ $product_id ] ) ) {
			continue;
		}
		$ordered_products[ $product_id ] = $product;
		if ( count( $ordered_products ) >= 4 ) {
			break 2;
		}
	}
}
?>

<div class="baji-account-shell">
	<section class="baji-account-hero">
		<div class="baji-account-identity">
			<div class="baji-account-avatar" aria-hidden="true"><?php echo esc_html( $initial ); ?></div>
			<div>
				<span class="baji-account-eyebrow">BAJI MEMBER</span>
				<h1>سلام <?php echo esc_html( $display_name ); ?> <span>🤍</span></h1>
				<p>
					<?php if ( $masked_phone ) : ?>
						<span dir="ltr"><?php echo esc_html( $masked_phone ); ?></span>
					<?php elseif ( $current_user->user_email ) : ?>
						<?php echo esc_html( $current_user->user_email ); ?>
					<?php else : ?>
						حساب کاربری باجی
					<?php endif; ?>
				</p>
			</div>
		</div>
		<a class="baji-account-logout" href="<?php echo esc_url( wc_logout_url( home_url( '/login/' ) ) ); ?>">
			<i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
			<span>خروج</span>
		</a>
	</section>

	<nav class="baji-account-tabs" aria-label="بخش‌های حساب کاربری">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<?php
			$url = add_query_arg( 'tab', $key, $account_url );
			$active_key = 'view-order' === $current_tab ? 'orders' : $current_tab;
			$is_active  = $active_key === $key;
			?>
			<a class="<?php echo $is_active ? 'is-active' : ''; ?>" href="<?php echo esc_url( $url ); ?>">
				<i class="fa-solid <?php echo esc_attr( $tab['icon'] ); ?>" aria-hidden="true"></i>
				<span><?php echo esc_html( $tab['label'] ); ?></span>
			</a>
		<?php endforeach; ?>
	</nav>

	<main class="baji-account-main">
		<?php if ( 'dashboard' === $current_tab ) : ?>
			<section class="baji-account-stats" aria-label="خلاصه حساب">
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'orders', $account_url ) ); ?>">
					<span class="baji-account-stat-icon"><i class="fa-solid fa-bag-shopping"></i></span>
					<strong><?php echo esc_html( count( $all_orders ) ); ?></strong>
					<small>کل سفارش‌ها</small>
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'orders', $account_url ) ); ?>">
					<span class="baji-account-stat-icon"><i class="fa-regular fa-clock"></i></span>
					<strong><?php echo esc_html( $ongoing_count ); ?></strong>
					<small>سفارش جاری</small>
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'orders', $account_url ) ); ?>">
					<span class="baji-account-stat-icon"><i class="fa-solid fa-check"></i></span>
					<strong><?php echo esc_html( $done_count ); ?></strong>
					<small>تحویل‌شده</small>
				</a>
				<a href="<?php echo esc_url( add_query_arg( 'tab', 'wishlist', $account_url ) ); ?>">
					<span class="baji-account-stat-icon"><i class="fa-regular fa-heart"></i></span>
					<strong><?php echo esc_html( $wishlist_count ); ?></strong>
					<small>علاقه‌مندی</small>
				</a>
			</section>

			<div class="baji-account-grid">
				<section class="baji-account-card baji-account-card--orders">
					<div class="baji-account-card-head">
						<div>
							<span>وضعیت خریدها</span>
							<h2>آخرین سفارش‌ها</h2>
						</div>
						<a href="<?php echo esc_url( add_query_arg( 'tab', 'orders', $account_url ) ); ?>">مشاهده همه</a>
					</div>

					<?php if ( $recent_orders ) : ?>
						<div class="baji-account-order-list">
							<?php foreach ( $recent_orders as $order ) : ?>
								<?php
								$items       = $order->get_items( 'line_item' );
								$first_item  = $items ? reset( $items ) : false;
								$product     = $first_item ? $first_item->get_product() : false;
								$image_html  = $product ? $product->get_image( array( 88, 110 ), array( 'loading' => 'lazy' ) ) : wc_placeholder_img( array( 88, 110 ) );
								$item_label  = $first_item ? $first_item->get_name() : 'سفارش باجی';
								$more_count  = max( 0, count( $items ) - 1 );
								$status_name = wc_get_order_status_name( $order->get_status() );
								?>
								<article class="baji-account-order">
									<div class="baji-account-order-thumb"><?php echo wp_kses_post( $image_html ); ?></div>
									<div class="baji-account-order-info">
										<div class="baji-account-order-top">
											<b>#<?php echo esc_html( $order->get_order_number() ); ?></b>
											<span class="baji-order-status baji-order-status--<?php echo esc_attr( $order->get_status() ); ?>"><?php echo esc_html( $status_name ); ?></span>
										</div>
										<h3><?php echo esc_html( $item_label ); ?><?php echo $more_count ? ' +' . esc_html( $more_count ) . ' کالا' : ''; ?></h3>
										<div class="baji-account-order-meta">
											<span><?php echo esc_html( wc_format_datetime( $order->get_date_created(), 'Y/m/d' ) ); ?></span>
											<strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
										</div>
									</div>
									<a class="baji-account-order-link" href="<?php echo esc_url( $order->get_view_order_url() ); ?>" aria-label="مشاهده سفارش <?php echo esc_attr( $order->get_order_number() ); ?>">
										<i class="fa-solid fa-chevron-left"></i>
									</a>
								</article>
							<?php endforeach; ?>
						</div>
					<?php else : ?>
						<div class="baji-account-empty">
							<i class="fa-solid fa-bag-shopping"></i>
							<h3>هنوز سفارشی نداری</h3>
							<p>اولین انتخابت از باجی منتظرته.</p>
							<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">شروع خرید</a>
						</div>
					<?php endif; ?>
				</section>

				<aside class="baji-account-side">
					<section class="baji-account-card baji-account-quick">
						<div class="baji-account-card-head">
							<div><span>دسترسی سریع</span><h2>حساب من</h2></div>
						</div>
						<a href="<?php echo esc_url( add_query_arg( 'tab', 'address', $account_url ) ); ?>"><i class="fa-solid fa-location-dot"></i><span><b>آدرس‌ها</b><small>مدیریت آدرس ارسال و صورتحساب</small></span><em>›</em></a>
						<a href="<?php echo esc_url( add_query_arg( 'tab', 'edit-account', $account_url ) ); ?>"><i class="fa-solid fa-user-pen"></i><span><b>اطلاعات من</b><small>نام، ایمیل و مشخصات حساب</small></span><em>›</em></a>
						<a href="<?php echo esc_url( add_query_arg( 'tab', 'wishlist', $account_url ) ); ?>"><i class="fa-regular fa-heart"></i><span><b>علاقه‌مندی‌ها</b><small>مدل‌هایی که برای بعد ذخیره کردی</small></span><em>›</em></a>
					</section>

					<section class="baji-account-support">
						<i class="fa-regular fa-headset"></i>
						<div>
							<span>پشتیبانی باجی</span>
							<strong>برای خریدت سوالی داری؟</strong>
							<p>پیامت رو بفرست، همراهت هستیم.</p>
						</div>
						<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">ارتباط با ما</a>
					</section>
				</aside>
			</div>

			<?php if ( $ordered_products ) : ?>
				<section class="baji-account-repeat">
					<div class="baji-account-card-head">
						<div><span>انتخاب‌های قبلی تو</span><h2>دوباره ببین</h2></div>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">همه محصولات</a>
					</div>
					<div class="baji-account-repeat-grid">
						<?php foreach ( $ordered_products as $product ) : ?>
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
								<div><?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ) ); ?></div>
								<h3><?php echo esc_html( $product->get_name() ); ?></h3>
								<span><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

		<?php else : ?>
			<section class="baji-account-section">
				<?php
				if ( 'view-order' === $current_tab ) {
					do_action( 'woocommerce_account_view-order_endpoint', absint( get_query_var( 'view-order' ) ) );
				} elseif ( 'orders' === $current_tab ) {
					$page = absint( get_query_var( 'orders' ) );
					do_action( 'woocommerce_account_orders_endpoint', $page ?: 1 );
				} elseif ( 'edit-account' === $current_tab ) {
					do_action( 'woocommerce_account_edit-account_endpoint' );
				} elseif ( 'address' === $current_tab ) {
					if ( is_wc_endpoint_url( 'edit-address' ) ) {
						do_action( 'woocommerce_account_edit-address_endpoint', get_query_var( 'edit-address' ) );
					} else {
						wc_get_template( 'myaccount/my-address.php' );
					}
				} elseif ( 'wishlist' === $current_tab ) {
					get_template_part( 'template-parts/account/wishlist' );
				}
				?>
			</section>
		<?php endif; ?>
	</main>
</div>
