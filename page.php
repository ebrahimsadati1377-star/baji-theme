<?php
/**
 * فایل صفحه استاتیک (Page) قالب BajiStyle
 *
 * برای صفحات معمولی وردپرس مانند «درباره ما»، «تماس با ما» و
 * «حریم خصوصی» استفاده می‌شود. این فایل از Gutenberg و بلوک‌های
 * align-wide پشتیبانی می‌کند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="baji-content-wrapper max-w-[1400px] mx-auto px-4 md:px-8 py-12">

	<?php bajistyle_breadcrumb(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'baji-page' ); ?>>

			<?php if ( ! is_front_page() ) : ?>
				<header class="baji-page-header mb-10 text-center">
					<h1 class="text-3xl md:text-4xl font-light"><?php the_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="baji-page-thumbnail mb-12 max-w-5xl mx-auto">
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

			<div class="baji-page-content max-w-4xl mx-auto prose prose-neutral prose-headings:font-light prose-a:text-baji-gold leading-8">
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

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="baji-comments-wrapper max-w-3xl mx-auto mt-16">
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>

		</article>

		<?php
	endwhile;
	?>

</div>

<?php
get_footer();
