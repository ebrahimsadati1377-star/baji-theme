<?php
/**
 * تمپلیت‌پارت نظرات مشتریان (Testimonials)
 *
 * نظرات از طریق ویجت اختصاصی یا با fallback به نظرات ثبت‌شده روی
 * محصولات با بالاترین امتیاز (در صورت فعال بودن ووکامرس) نمایش
 * داده می‌شوند. در صورت نبود محتوای پویا، نمونه‌های پیش‌فرض
 * (Placeholder) نمایش داده می‌شود تا طراحی صفحه کامل بماند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$testimonials = array();

// تلاش برای دریافت نظرات با بالاترین امتیاز از محصولات ووکامرس.
if ( class_exists( 'WooCommerce' ) ) {
	$comments = get_comments(
		array(
			'status'      => 'approve',
			'post_type'   => 'product',
			'number'      => 3,
			'meta_key'    => 'rating', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'orderby'     => 'meta_value_num',
			'order'       => 'DESC',
		)
	);

	foreach ( $comments as $comment ) {
		$rating = get_comment_meta( $comment->comment_ID, 'rating', true );
		$testimonials[] = array(
			'author'  => $comment->comment_author,
			'content' => $comment->comment_content,
			'rating'  => $rating ? (float) $rating : 5,
		);
	}
}

// در صورت نبود نظر واقعی، نمونه‌های پیش‌فرض جایگزین می‌شوند.
if ( empty( $testimonials ) ) {
	$testimonials = array(
		array(
			'author'  => __( 'نگار احمدی', 'bajistyle' ),
			'content' => __( 'کیفیت پارچه و دوخت محصولات فوق‌العاده بود. حس می‌کنم یک تکه از یک برند لوکس واقعی را خریده‌ام.', 'bajistyle' ),
			'rating'  => 5,
		),
		array(
			'author'  => __( 'سارا محمدی', 'bajistyle' ),
			'content' => __( 'بسته‌بندی شیک، ارسال سریع و پشتیبانی عالی. تجربه خرید آنلاینم تا به حال این‌قدر دلنشین نبود.', 'bajistyle' ),
			'rating'  => 5,
		),
		array(
			'author'  => __( 'مریم رضایی', 'bajistyle' ),
			'content' => __( 'طراحی‌ها واقعاً خاص و متفاوت از فروشگاه‌های دیگر هستند. حتماً دوباره خرید می‌کنم.', 'bajistyle' ),
			'rating'  => 4.5,
		),
	);
}
?>

<section class="baji-testimonials py-10 md:py-10 bg-baji-black text-baji-white" aria-label="<?php esc_attr_e( 'نظرات مشتریان', 'bajistyle' ); ?>">
	<div class="max-w-5xl mx-auto px-4 md:px-8 text-center">

		<span class="text-baji-gold text-xs tracking-[0.3em] uppercase">
			<?php esc_html_e( 'نظرات مشتریان', 'bajistyle' ); ?>
		</span>
		<h2 class="text-3xl md:text-4xl font-light mt-3 mb-14">
			<?php esc_html_e( 'تجربه خرید مشتریان ما', 'bajistyle' ); ?>
		</h2>

		<div class="baji-testimonial-slider relative" data-baji-testimonial-slider data-autoplay="7000">
			<?php
			$index = 0;
			foreach ( $testimonials as $testimonial ) :
				?>
				<div class="baji-testimonial-slide <?php echo 0 === $index ? '' : 'hidden'; ?>" data-testimonial-index="<?php echo absint( $index ); ?>">
					<div class="flex items-center justify-center mb-6">
						<?php bajistyle_star_rating( (float) $testimonial['rating'] ); ?>
					</div>
					<blockquote class="text-lg md:text-2xl font-light leading-relaxed mb-8">
						&laquo; <?php echo esc_html( $testimonial['content'] ); ?> &raquo;
					</blockquote>
					<cite class="text-sm text-baji-gold tracking-widest uppercase not-italic">
						<?php echo esc_html( $testimonial['author'] ); ?>
					</cite>
				</div>
				<?php
				++$index;
			endforeach;
			?>

			<div class="baji-testimonial-dots flex items-center justify-center gap-3 mt-10">
				<?php for ( $i = 0; $i < count( $testimonials ); $i++ ) : ?>
					<button type="button" class="baji-testimonial-dot w-2 h-2 rounded-full border border-baji-gold transition-colors duration-300 <?php echo 0 === $i ? 'bg-baji-gold' : 'bg-transparent'; ?>"
						data-testimonial-target="<?php echo absint( $i ); ?>"
						aria-label="<?php
						printf(
							/* translators: %d: شماره نظر */
							esc_attr__( 'نمایش نظر %d', 'bajistyle' ),
							absint( $i + 1 )
						);
						?>"></button>
				<?php endfor; ?>
			</div>
		</div>

	</div>
</section>
