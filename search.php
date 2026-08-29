<?php
/**
 * فایل نتایج جستجو قالب BajiStyle
 *
 * نتایج جستجو می‌تواند شامل نوشته‌های وبلاگ و محصولات ووکامرس باشد.
 * محصولات با کارت اختصاصی محصول (شامل قیمت و دکمه افزودن به سبد)
 * و نوشته‌ها با کارت استاندارد وبلاگ نمایش داده می‌شوند.
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

	<header class="baji-archive-header mb-12 text-center">
		<span class="text-baji-gold text-xs tracking-[0.3em] uppercase">
			<?php esc_html_e( 'نتایج جستجو', 'bajistyle' ); ?>
		</span>
		<h1 class="text-3xl md:text-4xl font-light mt-3">
			<?php
			printf(
				/* translators: %s: عبارت جستجوشده */
				esc_html__( 'نتایج برای: «%s»', 'bajistyle' ),
				'<span class="text-baji-gold">' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
		<p class="text-gray-500 mt-3">
			<?php
			global $wp_query;
			printf(
				/* translators: %s: تعداد نتایج یافت‌شده */
				esc_html( _n( '%s نتیجه یافت شد', '%s نتیجه یافت شد', $wp_query->found_posts, 'bajistyle' ) ),
				esc_html( number_format_i18n( $wp_query->found_posts ) )
			);
			?>
		</p>
	</header>

	<div class="baji-search-search mb-12 max-w-md mx-auto">
		<?php
		if ( class_exists( 'WooCommerce' ) ) {
			get_product_search_form();
		} else {
			get_search_form();
		}
		?>
	</div>

	<?php if ( have_posts() ) : ?>

		<ul class="products baji-posts-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
			<?php
			while ( have_posts() ) :
				the_post();

				if ( 'product' === get_post_type() ) :
					wc_get_template_part( 'content', 'product' );
				else :
					get_template_part( 'template-parts/content', get_post_type() );
				endif;

			endwhile;
			?>
		</ul>

		<?php bajistyle_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content', 'none' ); ?>

	<?php endif; ?>

</div>

<?php
get_footer();
