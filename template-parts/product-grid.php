<?php
/**
 * تمپلیت‌پارت گرید محصولات
 *
 * این فایل با get_template_part و آرگومان سوم (args) فراخوانی می‌شود
 * و بر اساس نوع کوئری درخواستی، محصولات را نمایش می‌دهد.
 *
 * نوع‌های پشتیبانی‌شده برای query_type:
 * - 'best_selling': پرفروش‌ترین محصولات (بر اساس متای فروش کلی ووکامرس)
 * - 'latest':       جدیدترین محصولات
 * - 'featured':     محصولات ویژه (Featured) ووکامرس
 * - 'on_sale':      محصولات دارای تخفیف
 * - 'category':     محصولات یک دسته‌بندی ووکامرس
 *
 * @package BajiStyle
 * @since 1.0.0
 *
 * @var array $args آرگومان‌های ارسالی: query_type (string), limit (int), is_slider (bool).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// دریافت آرگومان‌ها
$query_type = isset( $args['query_type'] ) ? sanitize_key( $args['query_type'] ) : 'latest';
$limit      = isset( $args['limit'] ) ? absint( $args['limit'] ) : 12;
$is_slider  = isset( $args['is_slider'] ) && $args['is_slider'] === true; // بررسی حالت اسلایدر
$category_slug = isset( $args['category_slug'] ) ? sanitize_title( $args['category_slug'] ) : '';

$query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
	'posts_per_page'      => $limit,
	'meta_query'          => array(), // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
);

switch ( $query_type ) {
	case 'category':
		if ( '' === $category_slug ) {
			return;
		}
		$query_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category_slug,
			),
		);
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
		break;

	case 'best_selling':
		$query_args['meta_key'] = 'total_sales'; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		$query_args['orderby']  = 'meta_value_num';
		$query_args['order']    = 'DESC';
		break;

	case 'featured':
		$query_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			),
		);
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
		break;

	case 'on_sale':
		$on_sale_ids = wc_get_product_ids_on_sale();
		if ( empty( $on_sale_ids ) ) {
			$on_sale_ids = array( 0 );
		}
		$query_args['post__in'] = $on_sale_ids;
		$query_args['orderby']  = 'date';
		$query_args['order']    = 'DESC';
		break;

	case 'latest':
	default:
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';
		break;
}

$products_query = new WP_Query( $query_args );

if ( ! $products_query->have_posts() ) {
	wp_reset_postdata();
	return;
}

// تعیین کلاس‌های تگ ul بر اساس اینکه گرید است یا اسلایدر
$list_classes = $is_slider 
	? 'swiper-wrapper' 
	: 'baji-products-grid grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-x-3 gap-y-12';
?>

<ul class="<?php echo esc_attr( $list_classes ); ?>">
	<?php
	// اگر اسلایدر فعال است، فیلتری اضافه می‌کنیم تا کلاس swiper-slide به تگ li محصول تزریق شود
	$baji_swiper_class_filter = function( $classes ) {
		$classes[] = 'swiper-slide';
		return $classes;
	};

	if ( $is_slider ) {
		add_filter( 'woocommerce_post_class', $baji_swiper_class_filter );
	}

	while ( $products_query->have_posts() ) :
		$products_query->the_post();
		wc_get_template_part( 'content', 'product' );
	endwhile;

	// بعد از اتمام حلقه، فیلتر را برمی‌داریم تا بقیه بخش‌های فروشگاه تحت تأثیر قرار نگیرند
	if ( $is_slider ) {
		remove_filter( 'woocommerce_post_class', $baji_swiper_class_filter );
	}
	?>
</ul>

<?php wp_reset_postdata(); ?>
