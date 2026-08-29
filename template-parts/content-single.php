<?php
/**
 * تمپلیت‌پارت نمایش محتوای کامل یک نوشته در صفحه single.php
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'baji-single-post' ); ?>>

	<header class="baji-single-header mb-8 text-center max-w-3xl mx-auto">
		<?php
		$categories_list = get_the_category_list( esc_html__( '، ', 'bajistyle' ) );
		if ( $categories_list ) :
			?>
			<div class="baji-single-categories text-baji-gold text-xs tracking-[0.2em] uppercase mb-4">
				<?php echo wp_kses_post( $categories_list ); ?>
			</div>
		<?php endif; ?>

		<h1 class="baji-single-title text-3xl md:text-5xl font-light leading-tight mb-6">
			<?php the_title(); ?>
		</h1>

		<div class="baji-single-meta flex items-center justify-center gap-4 text-sm text-gray-500">
			<?php bajistyle_posted_by(); ?>
			<span aria-hidden="true">•</span>
			<?php bajistyle_posted_on(); ?>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="baji-single-thumbnail mb-12 max-w-5xl mx-auto">
			<?php
			the_post_thumbnail(
				'large',
				array(
					'class'   => 'w-full aspect-[16/9] object-cover',
					'loading' => 'eager',
					'alt'     => the_title_attribute( array( 'echo' => false ) ),
				)
			);
			?>
		</div>
	<?php endif; ?>

	<div class="baji-single-content max-w-3xl mx-auto prose prose-neutral prose-headings:font-light prose-a:text-baji-gold leading-8">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="baji-page-links text-sm text-gray-500 mt-8">' . esc_html__( 'صفحات:', 'bajistyle' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>

	<footer class="baji-single-footer max-w-3xl mx-auto mt-10 pt-6 border-t border-gray-100">
		<div class="flex flex-wrap items-center justify-between gap-4">
			<?php bajistyle_entry_footer(); ?>
			<?php bajistyle_social_share_links(); ?>
		</div>
	</footer>

</article>
