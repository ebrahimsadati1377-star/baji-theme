<?php
/**
 * Homepage product stories sourced from uploaded product videos.
 *
 * @package BajiStyle
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) {
	return;
}

$stories_query = new WP_Query(
	array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'relation' => 'OR',
			array(
				'key'     => '_bajistyle_product_video_id',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'NUMERIC',
			),
			array(
				'key'     => '_product_video_url',
				'value'   => '',
				'compare' => '!=',
			),
		),
	)
);

$stories = array();
while ( $stories_query->have_posts() ) {
	$stories_query->the_post();
	$product_id = get_the_ID();
	$video_id   = absint( get_post_meta( $product_id, '_bajistyle_product_video_id', true ) );
	$video_url  = $video_id ? wp_get_attachment_url( $video_id ) : '';

	if ( ! $video_url ) {
		$video_url = get_post_meta( $product_id, '_product_video_url', true );
	}

	if ( ! $video_url ) {
		continue;
	}

	$stories[] = array(
		'id'        => $product_id,
		'name'      => get_the_title(),
		'video_url' => $video_url,
		'url'       => get_permalink(),
		'thumbnail' => get_the_post_thumbnail_url( $product_id, 'woocommerce_thumbnail' ),
	);
}
wp_reset_postdata();

if ( empty( $stories ) ) {
	return;
}
?>

<section class="baji-product-stories" aria-labelledby="baji-product-stories-title">
	<div class="baji-product-stories__inner">
		<div class="baji-product-stories__intro">
			<span aria-hidden="true"></span>
			<h2 id="baji-product-stories-title"><?php esc_html_e( 'استوری محصولات', 'bajistyle' ); ?></h2>
		</div>
		<div class="baji-product-stories__rail" role="list">
			<?php foreach ( $stories as $index => $story ) : ?>
				<button
					type="button"
					class="baji-product-story-trigger"
					role="listitem"
					data-story-index="<?php echo esc_attr( $index ); ?>"
					data-video-url="<?php echo esc_url( $story['video_url'] ); ?>"
					data-product-url="<?php echo esc_url( $story['url'] ); ?>"
					data-product-name="<?php echo esc_attr( $story['name'] ); ?>"
					aria-label="<?php echo esc_attr( sprintf( __( 'مشاهده استوری %s', 'bajistyle' ), $story['name'] ) ); ?>"
				>
					<span class="baji-product-story-trigger__ring">
						<?php if ( $story['thumbnail'] ) : ?>
							<img src="<?php echo esc_url( $story['thumbnail'] ); ?>" alt="" loading="lazy" decoding="async">
						<?php else : ?>
							<?php echo wc_placeholder_img( 'woocommerce_thumbnail', array( 'alt' => '' ) ); ?>
						<?php endif; ?>
						<i class="fa-solid fa-play" aria-hidden="true"></i>
					</span>
					<span class="baji-product-story-trigger__name"><?php echo esc_html( $story['name'] ); ?></span>
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<div id="baji-product-stories-viewer" class="baji-stories-viewer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'استوری محصولات', 'bajistyle' ); ?>" aria-hidden="true">
	<div class="baji-stories-viewer__backdrop" data-story-close></div>
	<div class="baji-stories-viewer__stage">
		<div class="baji-story-progress" aria-hidden="true">
			<?php foreach ( $stories as $story ) : ?>
				<span><i></i></span>
			<?php endforeach; ?>
		</div>
		<header class="baji-stories-viewer__header">
			<strong data-story-title></strong>
			<div>
				<button type="button" data-story-sound aria-label="<?php esc_attr_e( 'روشن کردن صدای ویدئو', 'bajistyle' ); ?>" aria-pressed="false"><i class="fa-solid fa-volume-xmark"></i></button>
				<button type="button" data-story-close aria-label="<?php esc_attr_e( 'بستن استوری', 'bajistyle' ); ?>"><i class="fa-solid fa-xmark"></i></button>
			</div>
		</header>
		<video data-story-video playsinline muted preload="metadata"></video>
		<button type="button" class="baji-story-nav baji-story-nav--prev" data-story-prev aria-label="<?php esc_attr_e( 'استوری قبلی', 'bajistyle' ); ?>"></button>
		<button type="button" class="baji-story-nav baji-story-nav--next" data-story-next aria-label="<?php esc_attr_e( 'استوری بعدی', 'bajistyle' ); ?>"></button>
		<a class="baji-stories-viewer__product" data-story-product href="#">
			<span><?php esc_html_e( 'مشاهده محصول', 'bajistyle' ); ?></span>
			<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
		</a>
	</div>
</div>
