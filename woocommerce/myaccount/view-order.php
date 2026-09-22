<?php
/**
 * Premium BAJI order details inside My Account.
 *
 * @package BajiStyle
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id );

if ( ! $order || ( (int) $order->get_user_id() !== get_current_user_id() && ! current_user_can( 'manage_woocommerce' ) ) ) {
	wc_print_notice( 'این سفارش در دسترس نیست.', 'error' );
	return;
}

$status        = $order->get_status();
$status_label  = wc_get_order_status_name( $status );
$date_created  = $order->get_date_created();
$date_modified = $order->get_date_modified();
$date_paid     = $order->get_date_paid();
$date_done     = $order->get_date_completed();

$status_tone = 'neutral';
if ( in_array( $status, array( 'failed', 'cancelled', 'refunded' ), true ) ) {
	$status_tone = 'danger';
} elseif ( in_array( $status, array( 'completed', 'processing' ), true ) ) {
	$status_tone = 'success';
} elseif ( in_array( $status, array( 'pending', 'on-hold' ), true ) ) {
	$status_tone = 'warning';
}

$status_copy = array(
	'pending'    => 'سفارش ثبت شده و منتظر تکمیل پرداخت است.',
	'on-hold'    => 'سفارش ثبت شده و در حال بررسی است.',
	'processing' => 'پرداخت تأیید شده و سفارش در حال آماده‌سازی است.',
	'completed'  => 'سفارش تکمیل شده است. امیدواریم از خریدت لذت ببری.',
	'cancelled'  => 'این سفارش لغو شده است.',
	'failed'     => 'پرداخت این سفارش تکمیل نشده است.',
	'refunded'   => 'مبلغ این سفارش بازپرداخت شده است.',
);
$status_text = $status_copy[ $status ] ?? 'آخرین وضعیت سفارش در این صفحه نمایش داده می‌شود.';

$transaction_id = (string) $order->get_transaction_id();
if ( '' === $transaction_id ) {
	foreach ( $order->get_customer_order_notes() as $note ) {
		$plain_note = str_ireplace( array( '<br>', '<br/>', '<br />' ), "\n", (string) $note->comment_content );
		$plain_note = wp_strip_all_tags( $plain_note );
		if ( preg_match( '/شناسه\s*تراکنش\s*:?\s*([A-Za-z0-9\-]+)/u', $plain_note, $match ) ) {
			$transaction_id = $match[1];
			break;
		}
	}
}

$timeline = array();
if ( $date_created ) {
	$timeline[] = array(
		'title' => 'سفارش ثبت شد',
		'text'  => 'سفارش شما در باجی ثبت شد.',
		'date'  => $date_created,
		'tone'  => 'done',
		'icon'  => 'fa-bag-shopping',
	);
}
if ( $date_paid ) {
	$timeline[] = array(
		'title' => 'پرداخت تأیید شد',
		'text'  => 'پرداخت سفارش با موفقیت تأیید شد.',
		'date'  => $date_paid,
		'tone'  => 'done',
		'icon'  => 'fa-credit-card',
	);
}
if ( 'processing' === $status ) {
	$timeline[] = array(
		'title' => 'در حال آماده‌سازی',
		'text'  => 'سفارش شما برای ارسال در حال آماده‌سازی است.',
		'date'  => $date_modified,
		'tone'  => 'active',
		'icon'  => 'fa-box-open',
	);
} elseif ( 'completed' === $status ) {
	$timeline[] = array(
		'title' => 'سفارش تکمیل شد',
		'text'  => 'فرایند این سفارش با موفقیت تکمیل شده است.',
		'date'  => $date_done ?: $date_modified,
		'tone'  => 'done',
		'icon'  => 'fa-check',
	);
} elseif ( in_array( $status, array( 'failed', 'cancelled', 'refunded' ), true ) ) {
	$timeline[] = array(
		'title' => $status_label,
		'text'  => $status_text,
		'date'  => $date_modified,
		'tone'  => 'danger',
		'icon'  => 'fa-circle-exclamation',
	);
} elseif ( in_array( $status, array( 'pending', 'on-hold' ), true ) ) {
	$timeline[] = array(
		'title' => $status_label,
		'text'  => $status_text,
		'date'  => $date_modified,
		'tone'  => 'active',
		'icon'  => 'fa-clock',
	);
}

$actions = wc_get_account_orders_actions( $order );
unset( $actions['view'] );

$billing_address  = $order->get_formatted_billing_address();
$shipping_address = $order->get_formatted_shipping_address();
$customer_note    = $order->get_customer_note();
?>
<div class="baji-view-order">
	<section class="baji-view-order-head">
		<div class="baji-view-order-head__main">
			<span class="baji-view-order-head__icon"><i class="fa-regular fa-file-lines"></i></span>
			<div>
				<small>جزئیات سفارش</small>
				<h2>سفارش #<?php echo esc_html( $order->get_order_number() ); ?></h2>
				<p><?php echo esc_html( $status_text ); ?></p>
			</div>
		</div>
		<div class="baji-view-order-head__meta">
			<div>
				<small><i class="fa-regular fa-calendar"></i> تاریخ ثبت</small>
				<strong><?php echo esc_html( $date_created ? wc_format_datetime( $date_created, 'Y/m/d' ) : '—' ); ?></strong>
			</div>
			<span class="baji-view-order-status baji-view-order-status--<?php echo esc_attr( $status_tone ); ?>">
				<i class="fa-solid <?php echo 'danger' === $status_tone ? 'fa-circle-exclamation' : ( 'success' === $status_tone ? 'fa-circle-check' : 'fa-clock' ); ?>"></i>
				<?php echo esc_html( $status_label ); ?>
			</span>
		</div>
	</section>

	<?php if ( $actions ) : ?>
		<div class="baji-view-order-actions">
			<?php foreach ( $actions as $key => $action ) : ?>
				<a class="baji-view-order-action baji-view-order-action--<?php echo esc_attr( sanitize_html_class( $key ) ); ?>" href="<?php echo esc_url( $action['url'] ); ?>">
					<?php echo esc_html( $action['name'] ); ?>
				</a>
			<?php endforeach; ?>
			<a class="baji-view-order-action baji-view-order-action--ghost" href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>">بازگشت به سفارش‌ها</a>
		</div>
	<?php endif; ?>

	<section class="baji-view-order-card">
		<div class="baji-view-order-title">
			<span><i class="fa-solid fa-wave-square"></i></span>
			<div><small>روند سفارش</small><h3>به‌روزرسانی‌های سفارش</h3></div>
		</div>
		<div class="baji-view-order-timeline">
			<?php foreach ( $timeline as $event ) : ?>
				<article class="baji-view-order-timeline__item is-<?php echo esc_attr( $event['tone'] ); ?>">
					<div class="baji-view-order-timeline__dot"><i class="fa-solid <?php echo esc_attr( $event['icon'] ); ?>"></i></div>
					<div class="baji-view-order-timeline__copy">
						<strong><?php echo esc_html( $event['title'] ); ?></strong>
						<p><?php echo esc_html( $event['text'] ); ?></p>
					</div>
					<time><?php echo esc_html( $event['date'] ? wc_format_datetime( $event['date'], 'Y/m/d - H:i' ) : '' ); ?></time>
				</article>
			<?php endforeach; ?>
		</div>
	</section>

	<div class="baji-view-order-info-grid">
		<section class="baji-view-order-mini">
			<div class="baji-view-order-mini__icon"><i class="fa-solid fa-credit-card"></i></div>
			<div>
				<small>روش پرداخت</small>
				<strong><?php echo esc_html( $order->get_payment_method_title() ?: 'ثبت نشده' ); ?></strong>
				<?php if ( $transaction_id ) : ?>
					<p>شناسه پیگیری: <span dir="ltr"><?php echo esc_html( $transaction_id ); ?></span></p>
				<?php endif; ?>
			</div>
		</section>
		<section class="baji-view-order-mini">
			<div class="baji-view-order-mini__icon"><i class="fa-solid fa-truck-fast"></i></div>
			<div>
				<small>ارسال سفارش</small>
				<strong><?php echo esc_html( $order->get_shipping_method() ?: 'بدون روش ارسال' ); ?></strong>
				<p><?php echo $shipping_address ? wp_kses_post( $shipping_address ) : 'آدرس ارسال ثبت نشده است.'; ?></p>
			</div>
		</section>
	</div>

	<section class="baji-view-order-card baji-view-order-card--items">
		<div class="baji-view-order-title">
			<span><i class="fa-solid fa-box"></i></span>
			<div><small>محصولات این خرید</small><h3>جزئیات سفارش</h3></div>
		</div>
		<div class="baji-view-order-items">
			<?php foreach ( $order->get_items( 'line_item' ) as $item_id => $item ) : ?>
				<?php
				$product    = $item->get_product();
				$image_html = $product ? $product->get_image( array( 112, 140 ), array( 'loading' => 'lazy' ) ) : wc_placeholder_img( array( 112, 140 ) );
				$item_meta  = wc_display_item_meta(
					$item,
					array(
						'echo'      => false,
						'separator' => ' • ',
					)
				);
				$product_url = $product && $product->is_visible() ? $product->get_permalink( $item ) : '';
				?>
				<article class="baji-view-order-item">
					<div class="baji-view-order-item__image">
						<?php if ( $product_url ) : ?><a href="<?php echo esc_url( $product_url ); ?>"><?php endif; ?>
						<?php echo wp_kses_post( $image_html ); ?>
						<?php if ( $product_url ) : ?></a><?php endif; ?>
					</div>
					<div class="baji-view-order-item__content">
						<h4>
							<?php if ( $product_url ) : ?><a href="<?php echo esc_url( $product_url ); ?>"><?php endif; ?>
							<?php echo esc_html( $item->get_name() ); ?>
							<?php if ( $product_url ) : ?></a><?php endif; ?>
						</h4>
						<?php if ( $item_meta ) : ?><div class="baji-view-order-item__meta"><?php echo wp_kses_post( $item_meta ); ?></div><?php endif; ?>
						<span class="baji-view-order-item__qty">تعداد: <?php echo esc_html( $item->get_quantity() ); ?></span>
					</div>
					<div class="baji-view-order-item__price"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="baji-view-order-totals">
			<?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
				<?php if ( 'payment_method' === $key ) continue; ?>
				<div class="<?php echo 'order_total' === $key ? 'is-total' : ''; ?>">
					<span><?php echo esc_html( $total['label'] ); ?></span>
					<strong><?php echo wp_kses_post( $total['value'] ); ?></strong>
				</div>
			<?php endforeach; ?>
		</div>
	</section>

	<div class="baji-view-order-info-grid">
		<section class="baji-view-order-mini baji-view-order-mini--address">
			<div class="baji-view-order-mini__icon"><i class="fa-solid fa-location-dot"></i></div>
			<div>
				<small>اطلاعات دریافت‌کننده</small>
				<strong><?php echo esc_html( trim( $order->get_formatted_billing_full_name() ) ?: '—' ); ?></strong>
				<?php if ( $order->get_billing_phone() ) : ?><p dir="ltr"><?php echo esc_html( $order->get_billing_phone() ); ?></p><?php endif; ?>
				<p><?php echo $billing_address ? wp_kses_post( $billing_address ) : 'آدرس صورتحساب ثبت نشده است.'; ?></p>
			</div>
		</section>
		<section class="baji-view-order-support">
			<i class="fa-regular fa-headset"></i>
			<div><small>پشتیبانی باجی</small><strong>درباره این سفارش سوالی داری؟</strong><p>شماره سفارش را برای پشتیبانی بفرست تا سریع‌تر راهنمایی‌ات کنیم.</p></div>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">ارتباط با ما</a>
		</section>
	</div>

	<?php if ( $customer_note ) : ?>
		<section class="baji-view-order-note">
			<i class="fa-regular fa-message"></i>
			<div><strong>یادداشت شما</strong><p><?php echo wp_kses_post( nl2br( esc_html( $customer_note ) ) ); ?></p></div>
		</section>
	<?php endif; ?>
</div>
