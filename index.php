<?php
/**
 * فایل اصلی الگوی قالب (Fallback اصلی وردپرس)
 *
 * این فایل به‌عنوان عمومی‌ترین قالب در سلسله‌مراتب الگوی وردپرس
 * عمل می‌کند و در صورت نبود فایل اختصاصی‌تر (مانند archive.php یا
 * single.php) استفاده می‌شود. همچنین برای نمایش لیست نوشته‌های
 * وبلاگ به کار می‌رود.
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

	<?php if ( have_posts() ) : ?>

		<header class="baji-archive-header mb-12 text-center">
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<h1 class="text-3xl md:text-4xl font-light"><?php single_post_title(); ?></h1>
			<?php else : ?>
				<h1 class="text-3xl md:text-4xl font-light"><?php esc_html_e( 'وبلاگ BajiStyle', 'bajistyle' ); ?></h1>
				<p class="text-gray-500 mt-3"><?php esc_html_e( 'تازه‌ترین مطالب درباره مد، استایل و دنیای پوشاک', 'bajistyle' ); ?></p>
			<?php endif; ?>
		</header>

		<div class="baji-posts-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
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

<?php
get_footer();
