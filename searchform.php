<?php
/**
 * فرم جستجوی عمومی سایت (غیر ووکامرسی) قالب BajiStyle
 *
 * این فرم زمانی استفاده می‌شود که get_search_form() در غیاب
 * ووکامرس فراخوانی شود (مثلاً اگر ووکامرس غیرفعال باشد).
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$unique_id = wp_unique_id( 'baji-search-form-' );
?>

<form role="search" method="get" class="baji-search-form flex items-stretch border border-gray-300 focus-within:border-baji-gold" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>" class="sr-only">
		<?php esc_html_e( 'جستجو برای:', 'bajistyle' ); ?>
	</label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="baji-search-field flex-1 px-4 py-3 text-sm focus:outline-none"
		placeholder="<?php echo esc_attr_x( 'جستجو در سایت...', 'placeholder', 'bajistyle' ); ?>"
		value="<?php echo get_search_query() ? esc_attr( get_search_query() ) : ''; ?>"
		name="s" />
	<button type="submit" class="baji-search-submit px-5 bg-baji-black text-baji-white hover:bg-baji-gold hover:text-baji-black transition-colors duration-300">
		<span class="sr-only"><?php esc_html_e( 'جستجو', 'bajistyle' ); ?></span>
		<span aria-hidden="true">⌕</span>
	</button>
</form>
