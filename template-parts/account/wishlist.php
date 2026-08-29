<?php
/**
 * Wishlist account experience.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wishlist_ids   = array_values( array_filter( array_map( 'absint', bajistyle_get_wishlist_items() ) ) );
$wishlist_count = count( $wishlist_ids );
$has_items      = $wishlist_count > 0;
?>

<section class="baji-account-wishlist" aria-labelledby="baji-wishlist-title">
	<header class="baji-wishlist-header">
		<div class="baji-wishlist-heading">
			<span class="baji-wishlist-kicker"><?php esc_html_e( 'منتخب‌های تو', 'bajistyle' ); ?></span>
			<h2 id="baji-wishlist-title"><?php esc_html_e( 'علاقه‌مندی‌ها', 'bajistyle' ); ?></h2>
			<p><?php esc_html_e( 'انتخاب‌هایی که دوست داشتی، یک‌جا برای تصمیم بعدی.', 'bajistyle' ); ?></p>
		</div>
		<div class="baji-wishlist-total" aria-live="polite">
			<strong data-wishlist-count><?php echo esc_html( $wishlist_count ); ?></strong>
			<span><?php esc_html_e( 'محصول ذخیره‌شده', 'bajistyle' ); ?></span>
		</div>
	</header>

	<p class="baji-wishlist-status sr-only" data-wishlist-status role="status" aria-live="polite"></p>

	<div class="baji-wishlist-empty<?php echo $has_items ? ' hidden' : ''; ?>" data-wishlist-empty>
		<div class="baji-wishlist-empty__mark" aria-hidden="true"><i class="fa-regular fa-heart"></i></div>
		<p class="baji-wishlist-kicker"><?php esc_html_e( 'لیستت منتظر اولین انتخابه', 'bajistyle' ); ?></p>
		<h3><?php esc_html_e( 'چیزی چشمت رو نگرفته؟', 'bajistyle' ); ?></h3>
		<p><?php esc_html_e( 'روی قلب کنار هر محصول بزن تا برای بعد اینجا نگهش داریم.', 'bajistyle' ); ?></p>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="baji-wishlist-shop-link">
			<span><?php esc_html_e( 'دیدن محصولات', 'bajistyle' ); ?></span>
			<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
		</a>
	</div>

	<ul class="baji-wishlist-grid baji-products-grid<?php echo $has_items ? '' : ' hidden'; ?>" data-wishlist-grid>
		<?php
		if ( $has_items ) {
			$wishlist_query = new WP_Query(
				array(
					'post_type'           => 'product',
					'post_status'         => 'publish',
					'post__in'            => $wishlist_ids,
					'orderby'             => 'post__in',
					'posts_per_page'      => -1,
					'ignore_sticky_posts' => true,
				)
			);

			$wishlist_item_class = function( $classes ) {
				$classes[] = 'baji-wishlist-item';
				return $classes;
			};
			add_filter( 'woocommerce_post_class', $wishlist_item_class );

			while ( $wishlist_query->have_posts() ) {
				$wishlist_query->the_post();
				wc_get_template_part( 'content', 'product' );
			}

			remove_filter( 'woocommerce_post_class', $wishlist_item_class );
			wp_reset_postdata();
		}
		?>
	</ul>
</section>
