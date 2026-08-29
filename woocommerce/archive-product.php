<?php
/**
 * صفحه آرشیو فروشگاه (Override کامل ووکامرس)
 *
 * شامل سیستم فیلتر پیشرفته (دسته‌بندی، قیمت، رنگ، سایز)، مرتب‌سازی
 * سفارشی و گرید محصولات با کلاس‌های Tailwind.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

/**
 * هوک woocommerce_before_main_content.
 * در inc/woocommerce-hooks.php رپر اصلی (<main>) باز می‌شود.
 */
do_action( 'woocommerce_before_main_content' );
?>

<div class="baji-shop-header text-center mb-12">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<span class="text-baji-gold text-xs tracking-[0.3em] uppercase">
			<?php esc_html_e( 'فروشگاه', 'bajistyle' ); ?>
		</span>
		<h1 class="baji-shop-title text-3xl md:text-4xl font-light mt-3">
			<?php woocommerce_page_title(); ?>
		</h1>
	<?php endif; ?>

	<?php
	/**
	 * هوک woocommerce_archive_description.
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</div>

<?php do_action( 'bajistyle_before_shop_breadcrumb' ); ?>
<?php woocommerce_breadcrumb(); ?>

<div class="baji-shop-layout flex flex-col lg:flex-row gap-12">

	<!-- سایدبار فیلتر پیشرفته -->
	<aside id="baji-shop-filters" class="baji-shop-filters w-full lg:w-72 shrink-0" aria-label="<?php esc_attr_e( 'فیلتر محصولات', 'bajistyle' ); ?>">

		<button type="button" class="baji-filters-mobile-toggle lg:hidden w-full flex items-center justify-between px-4 py-3 border border-gray-300 mb-4" aria-expanded="false" aria-controls="baji-filters-content">
			<span class="text-sm tracking-wide"><?php esc_html_e( 'فیلترها', 'bajistyle' ); ?></span>
			<span aria-hidden="true">+</span>
		</button>

		<div id="baji-filters-content" class="baji-filters-content space-y-10 lg:sticky lg:top-32">

			<!-- فیلتر دسته‌بندی -->
			<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
				<?php dynamic_sidebar( 'shop-sidebar' ); ?>
			<?php else : ?>
				<div class="baji-filter-group">
					<h3 class="text-sm tracking-widest uppercase mb-4"><?php esc_html_e( 'دسته‌بندی', 'bajistyle' ); ?></h3>
					<?php
					$product_categories = get_terms(
						array(
							'taxonomy'   => 'product_cat',
							'hide_empty' => true,
						)
					);

					if ( ! is_wp_error( $product_categories ) && ! empty( $product_categories ) ) :
						?>
						<ul class="space-y-3 text-sm text-gray-600">
							<?php foreach ( $product_categories as $category ) : ?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="hover:text-baji-gold transition-colors flex items-center justify-between">
										<span><?php echo esc_html( $category->name ); ?></span>
										<span class="text-xs text-gray-400">(<?php echo absint( $category->count ); ?>)</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<!-- فیلتر قیمت -->
				<div class="baji-filter-group">
					<h3 class="text-sm tracking-widest uppercase mb-4"><?php esc_html_e( 'محدوده قیمت', 'bajistyle' ); ?></h3>
					<?php the_widget( 'WC_Widget_Price_Filter' ); ?>
				</div>

				<!-- فیلتر ویژگی: رنگ -->
				<?php if ( taxonomy_exists( 'pa_color' ) ) : ?>
					<div class="baji-filter-group">
						<h3 class="text-sm tracking-widest uppercase mb-4"><?php esc_html_e( 'رنگ', 'bajistyle' ); ?></h3>
						<?php
						the_widget(
							'WC_Widget_Layered_Nav',
							array(
								'attribute' => 'color',
								'query_type' => 'and',
							)
						);
						?>
					</div>
				<?php endif; ?>

				<!-- فیلتر ویژگی: سایز -->
				<?php if ( taxonomy_exists( 'pa_size' ) ) : ?>
					<div class="baji-filter-group">
						<h3 class="text-sm tracking-widest uppercase mb-4"><?php esc_html_e( 'سایز', 'bajistyle' ); ?></h3>
						<?php
						the_widget(
							'WC_Widget_Layered_Nav',
							array(
								'attribute' => 'size',
								'query_type' => 'and',
							)
						);
						?>
					</div>
				<?php endif; ?>

				<!-- فیلتر موجودی -->
				<div class="baji-filter-group">
					<?php the_widget( 'WC_Widget_Product_Stock_Filter' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</aside>

	<!-- محتوای اصلی فروشگاه -->
	<div class="baji-shop-content flex-1 min-w-0">

		<!-- نوار نتایج و مرتب‌سازی -->
		<div class="baji-shop-toolbar flex flex-wrap items-center justify-between gap-4 mb-8 pb-4 border-b border-gray-100">
			<div class="baji-result-count text-sm text-gray-500">
				<?php woocommerce_result_count(); ?>
			</div>
			<div class="baji-catalog-ordering">
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		</div>

		<?php if ( woocommerce_product_loop() ) : ?>

			<?php
			/**
			 * هوک woocommerce_before_shop_loop.
			 */
			do_action( 'woocommerce_before_shop_loop' );
			?>

            <?php
            woocommerce_product_loop_start();
            ?>
            
            <?php
            if ( wc_get_loop_prop( 'total' ) ) :
            
            	while ( have_posts() ) :
            		the_post();
            
            		/**
            		 * هوک استاندارد ووکامرس
            		 */
            		do_action( 'woocommerce_shop_loop' );
            
            		/**
            		 * کارت محصول
            		 */
            		wc_get_template_part( 'content', 'product' );
            
            	endwhile;
            
            endif;
            ?>
            
            <?php woocommerce_product_loop_end(); ?>

			<?php
			/**
			 * هوک woocommerce_after_shop_loop.
			 * (شامل صفحه‌بندی پیش‌فرض ووکامرس)
			 */
			do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php else : ?>

			<?php
			/**
			 * هوک woocommerce_no_products_found.
			 */
			do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>

	</div>
</div>

<?php
/**
 * هوک woocommerce_after_main_content.
 * در inc/woocommerce-hooks.php رپر اصلی (</main>) بسته می‌شود.
 */
do_action( 'woocommerce_after_main_content' );

/**
 * هوک woocommerce_sidebar پیش‌فرض حذف نشده تا سازگاری با
 * افزونه‌های شخص ثالث حفظ شود؛ سایدبار اصلی فروشگاه به‌صورت
 * دستی در بالا رندر شده است.
 */

get_footer();
