<?php
/**
 * فایل آرشیو عمومی قالب BajiStyle (دسته‌بندی، برچسب، نویسنده، تاریخ)
 *
 * توجه: این فایل برای آرشیو نوشته‌های وبلاگ استفاده می‌شود.
 * آرشیو محصولات ووکامرس از فایل اختصاصی
 * woocommerce/archive-product.php استفاده می‌کند که اولویت بالاتری
 * در سلسله‌مراتب قالب ووکامرس دارد.
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

	<header class="baji-archive-header mb-12 text-center">
		<span class="text-baji-gold text-xs tracking-[0.3em] uppercase">
			<?php esc_html_e( 'آرشیو', 'bajistyle' ); ?>
		</span>
		<h1 class="text-3xl md:text-4xl font-light mt-3">
			<?php the_archive_title(); ?>
		</h1>
		<?php if ( get_the_archive_description() ) : ?>
			<div class="baji-archive-description text-gray-500 mt-4 max-w-2xl mx-auto">
				<?php the_archive_description(); ?>
			</div>
		<?php endif; ?>
	</header>

	<div class="baji-archive-layout flex flex-col lg:flex-row gap-12">

		<div class="baji-archive-content flex-1 min-w-0">
			<?php if ( have_posts() ) : ?>

				<div class="baji-posts-grid grid grid-cols-1 md:grid-cols-2 <?php echo is_active_sidebar( 'sidebar-blog' ) ? '' : 'lg:grid-cols-3'; ?> gap-10">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
					endwhile;
					?>
				</div>

				<?php bajistyle_pagination(); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>

	</div>

</div>

<?php
get_footer();
