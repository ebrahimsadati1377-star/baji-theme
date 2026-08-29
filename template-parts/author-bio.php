<?php
/**
 * تمپلیت‌پارت نمایش بیوگرافی نویسنده زیر تک‌نوشته
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$author_description = get_the_author_meta( 'description' );

if ( empty( $author_description ) ) {
	return;
}
?>

<div class="baji-author-bio max-w-3xl mx-auto mt-12 p-8 bg-baji-cream flex items-start gap-6">
	<?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', '', array( 'class' => 'rounded-full shrink-0' ) ); ?>
	<div>
		<h3 class="text-lg font-light mb-2">
			<?php
			printf(
				/* translators: %s: نام نویسنده */
				esc_html__( 'درباره %s', 'bajistyle' ),
				esc_html( get_the_author() )
			);
			?>
		</h3>
		<p class="text-sm text-gray-600 leading-7"><?php echo esc_html( $author_description ); ?></p>
	</div>
</div>
