<?php
/**
 * تمپلیت‌پارت نمایش یک نوشته در گرید آرشیو/وبلاگ
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'baji-post-card group' ); ?>>

	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="block overflow-hidden mb-5 aspect-[4/5]">
			<?php
			the_post_thumbnail(
				'medium_large',
				array(
					'class'   => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105',
					'loading' => 'lazy',
					'alt'     => the_title_attribute( array( 'echo' => false ) ),
				)
			);
			?>
		</a>
	<?php endif; ?>

	<div class="baji-post-card-content">
		<?php bajistyle_posted_on(); ?>

		<h2 class="baji-post-title text-xl font-light mt-2 mb-3">
			<a href="<?php the_permalink(); ?>" class="hover:text-baji-gold transition-colors duration-200">
				<?php the_title(); ?>
			</a>
		</h2>

		<div class="baji-post-excerpt text-sm text-gray-500 leading-7">
			<?php echo esc_html( bajistyle_get_excerpt( 18 ) ); ?>
		</div>

		<div class="mt-4">
			<?php bajistyle_entry_footer(); ?>
		</div>
	</div>
</article>
