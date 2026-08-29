<?php
/**
 * فایل نمایش نظرات قالب BajiStyle
 *
 * شامل لیست نظرات با استایل سفارشی، رتبه‌بندی ستاره‌ای (در صورت
 * فعال بودن ووکامرس روی صفحه محصول) و فرم ارسال نظر جدید.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// محافظت در برابر دسترسی مستقیم به فایل خارج از حلقه نوشته‌ها.
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="baji-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="baji-comments-title text-2xl font-light mb-8">
			<?php
			$comment_count = get_comments_number();
			if ( 1 === (int) $comment_count ) {
				esc_html_e( 'یک دیدگاه', 'bajistyle' );
			} else {
				printf(
					/* translators: %s: تعداد دیدگاه‌ها */
					esc_html( _n( '%s دیدگاه', '%s دیدگاه', $comment_count, 'bajistyle' ) ),
					esc_html( number_format_i18n( $comment_count ) )
				);
			}
			?>
		</h2>

		<ol class="baji-comment-list space-y-8">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
					'callback'    => 'bajistyle_comment_callback',
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => esc_html__( '« قبلی', 'bajistyle' ),
				'next_text' => esc_html__( 'بعدی »', 'bajistyle' ),
			)
		);
		?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="baji-comments-closed text-sm text-gray-500 mt-6">
			<?php esc_html_e( 'امکان ارسال دیدگاه جدید برای این مطلب بسته شده است.', 'bajistyle' ); ?>
		</p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_form'         => 'baji-comment-form mt-10 space-y-4',
			'class_submit'       => 'baji-btn-primary inline-block px-8 py-3 bg-baji-black text-baji-white text-sm tracking-widest uppercase hover:bg-baji-gold hover:text-baji-black transition-colors duration-300',
			'title_reply'        => esc_html__( 'دیدگاه خود را بنویسید', 'bajistyle' ),
			'comment_field'      => '<p class="comment-form-comment"><label for="comment" class="block text-sm mb-2">' . esc_html__( 'دیدگاه شما', 'bajistyle' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" rows="6" class="w-full border border-gray-300 focus:border-baji-gold p-4 text-sm" required></textarea></p>',
			'label_submit'       => esc_html__( 'ارسال دیدگاه', 'bajistyle' ),
		)
	);
	?>

</div>
