<?php
/**
 * صفحه تکی محصول (Override کامل و لوکس ووکامرس)
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="baji-single-product-wrapper mx-auto px-4 md:px-8 py-12 max-w-[1400px]" dir="rtl">

	<div class="baji-breadcrumb mb-8 text-sm text-gray-500">
		<?php woocommerce_breadcrumb(); ?>
	</div>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php
		// بررسی ویدیوی محصول
		$video_id = function_exists('bajistyle_get_product_video_id') ? bajistyle_get_product_video_id( $product->get_id() ) : 0;

		// Fallback to old meta key if new one not found
		if ( ! $video_id ) {
			$video_id = get_post_meta( $product->get_id(), '_product_video_url', true );
			// If it's a URL, we need to get attachment ID from URL (not ideal but fallback)
			// For now just use URL directly if it's not an integer
			if ( $video_id && ! is_numeric( $video_id ) ) {
				$video_url = $video_id;
				$video_id = 0; // Will use URL directly
			}
		}

		$video_url = $video_id ? wp_get_attachment_url( $video_id ) : ( isset( $video_url ) ? $video_url : '' );
		$has_video = ! empty( $video_url );
		?>

		<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'baji-single-product grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start baji-swatches-enabled', $product ); ?>>

			<!-- 🌟 کانتینر گالری محصول -->
			<div class="baji-product-gallery-wrapper relative group">
				<?php
				do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>

			<!-- اطلاعات و مشخصات محصول -->
			<div class="baji-product-summary-wrapper flex flex-col justify-start">
				<div class="summary entry-summary space-y-6">
					
					<!-- عنوان محصول -->
					<h1 class="product_title entry-title text-2xl lg:text-3xl font-extrabold text-gray-900 leading-tight">
						<?php the_title(); ?>
					</h1>

					<!-- بخش قیمت تک‌خطی -->
					<div class="baji-price-inline-container my-4">
						<?php
						global $product;
						if ( $product->is_type( 'variable' ) ) :
							?>
							<div class="baji-variable-price-notice flex items-center gap-2 text-gray-600 text-sm font-medium">
								<i class="fa-solid fa-tags text-amber-500"></i>
								<span>برای مشاهده قیمت دقیق، ویژگی‌های محصول (رنگ/سایز) را انتخاب کنید.</span>
							</div>
							<div class="baji-dynamic-price mt-2">
								<?php echo $product->get_price_html(); ?>
							</div>
						<?php else : ?>
							<?php
							$regular_price = (float) $product->get_regular_price();
							$sale_price    = (float) $product->get_sale_price();
							$is_on_sale    = $product->is_on_sale() && $sale_price > 0 && $regular_price > $sale_price;
							$currency      = get_woocommerce_currency_symbol();

							if ( $is_on_sale ) :
								$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
								?>
								<div class="baji-price-inline-wrapper">
									<span class="baji-old-price"><?php echo number_format_i18n( $regular_price ); ?></span>
									<span class="baji-new-price"><?php echo number_format_i18n( $sale_price ); ?></span>
									<span class="baji-currency"><?php echo esc_html( $currency ); ?></span>
									<span class="baji-discount-pill">٪<?php echo number_format_i18n( $percentage ); ?></span>
								</div>
							<?php else : ?>
								<div class="baji-price-inline-wrapper">
									<span class="baji-new-price"><?php echo number_format_i18n( $product->get_price() ); ?></span>
									<span class="baji-currency"><?php echo esc_html( $currency ); ?></span>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>

					<?php
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
					do_action( 'woocommerce_single_product_summary' );
					?>

					<?php
					$in_wishlist = function_exists('bajistyle_is_in_wishlist') ? bajistyle_is_in_wishlist( $product->get_id() ) : false;
					?>
					<button type="button"
						class="baji-wishlist-toggle-btn mt-4 inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-500 transition-all bg-gray-50 hover:bg-red-50 px-4 py-2.5 rounded-xl font-medium border border-gray-200 hover:border-red-200"
						data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
						data-in-wishlist="<?php echo $in_wishlist ? '1' : '0'; ?>">
						<i class="<?php echo $in_wishlist ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart'; ?> baji-wishlist-icon text-base"></i>
						<span class="baji-wishlist-label">
							<?php echo $in_wishlist ? esc_html__( 'حذف از علاقه‌مندی‌ها', 'bajistyle' ) : esc_html__( 'افزودن به علاقه‌مندی‌ها', 'bajistyle' ); ?>
						</span>
					</button>
				</div>
			</div>

		</div>
		
		<div class="baji-product-tabs-wrapper mt-16 w-full border-t border-gray-100 pt-12">
			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
		</div>

		<?php
		if ( function_exists('bajistyle_get_recently_viewed_products') ) {
			$recently_viewed = bajistyle_get_recently_viewed_products( get_the_ID(), 12 );
			if ( ! empty( $recently_viewed ) ) :
				?>
				<section class="baji-recently-viewed mt-16 pt-12 border-t border-gray-100">
					<div class="flex items-center justify-between gap-4 mb-8 md:mb-12">
						<div>
							<span class="block w-8 md:w-10 h-[2px] bg-baji-gold rounded-full mb-3"></span>
							<h2 class="text-xl sm:text-2xl md:text-4xl font-black text-gray-900 tracking-tight">
								<?php esc_html_e( 'آخرین محصولات بازدید شده', 'bajistyle' ); ?>
							</h2>
						</div>
					</div>
					<div class="swiper baji-products-slider overflow-hidden relative pb-12">
						<ul class="swiper-wrapper">
						<?php
						$recent_query = new WP_Query(
							array(
								'post_type'      => 'product',
								'post__in'       => $recently_viewed,
								'orderby'        => 'post__in',
								'posts_per_page' => 12,
							)
						);

						if ( $recent_query->have_posts() ) :
							$recent_slide_class = function( $classes ) {
								$classes[] = 'swiper-slide';
								return $classes;
							};
							add_filter( 'woocommerce_post_class', $recent_slide_class );
							while ( $recent_query->have_posts() ) :
								$recent_query->the_post();
								wc_get_template_part( 'content', 'product' );
							endwhile;
							remove_filter( 'woocommerce_post_class', $recent_slide_class );
							wp_reset_postdata();
						endif;
						?>
						</ul>
						<div class="swiper-pagination !bottom-0"></div>
					</div>
				</section>
				<?php 
			endif; 
		}
		?>

	<?php endwhile; ?>

</div>

<!-- =========================================================================
     🎨 استایل‌های اختصاصی و بهینه‌سازی‌شده
     ========================================================================= -->
<style>
/* ─── فونت‌های پایه ─── */
.baji-swatches-enabled, 
.baji-swatch-item, 
.baji-swatch-item .baji-color-text,
.baji-single-product .single_add_to_cart_button,
.baji-qty-trigger,
.baji-single-product form.cart div.quantity input.qty,
.baji-swatches-enabled table.variations td.label,
.baji-price-card {
    font-family: Vazirmatn, Tahoma, sans-serif !important;
}

/* استایل قیمت پویا در محصولات متغیر */
.baji-price-card .price {
    font-size: 1.75rem !important;
    font-weight: 900 !important;
    color: #111827 !important;
    display: flex !important;
    align-items: baseline !important;
    gap: 0.5rem !important;
}
.baji-price-card .price del {
    font-size: 0.9rem !important;
    color: #9ca3af !important;
    font-weight: 500 !important;
}
.baji-price-card .price ins {
    text-decoration: none !important;
    color: #ef4444 !important;
}

/* مخفی کردن منوهای کشویی پیش‌فرض ووکامرس */
.baji-swatches-enabled form.variations_form table.variations select {
    display: none !important;
}

/* اصلاح ساختار جدول ویژگی‌ها */
.baji-swatches-enabled form.variations_form table.variations {
    width: 100% !important;
    display: block !important;
    clear: both !important;
    border: none !important;
    float: none !important;
}
.baji-swatches-enabled table.variations tr {
    display: block !important;
    width: 100% !important;
    margin-bottom: 1.25rem !important;
    clear: both !important;
    float: none !important;
}
.baji-swatches-enabled table.variations td.label {
    display: block !important;
    width: 100% !important;
    font-size: 0.9rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.6rem;
    padding: 0 !important;
    text-align: right !important;
}
.baji-swatches-enabled table.variations td.value {
    display: block !important;
    width: 100% !important;
    padding: 0 !important;
}

/* کانتینر دکمه‌های افقی رنگ و سایز */
.baji-swatch-container {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: wrap !important;
    gap: 0.625rem !important;
    margin-top: 0.25rem !important;
    width: 100% !important;
    clear: both !important;
}

/* استایل کپسول‌های دکمه‌ها */
.baji-swatch-item {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer;
    border: 1px solid #e5e7eb;
    background-color: #ffffff;
    padding: 0.5rem 1.1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4b5563;
    transition: all 0.2s ease;
    user-select: none;
    gap: 0.5rem;
}
.baji-swatch-item:hover {
    border-color: #9ca3af;
    color: #1f2937;
}
.baji-swatch-item.active {
    border-color: #111827 !important;
    background-color: #f9fafb !important;
    color: #111827 !important;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 0 0 1px #111827;
}
.baji-swatch-item.active:not(.is-color) {
    background-color: #111827 !important;
    color: #fff !important;
}

.baji-color-circle {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 50%;
    display: inline-block;
    border: 1px solid rgba(0, 0, 0, 0.15);
    position: relative;
    flex-shrink: 0;
}

.baji-color-text {
    font-size: 0.75rem !important;
    font-weight: 600 !important;
    color: #4b5563;
}
.baji-swatch-item.active .baji-color-text {
    color: #111827 !important;
    font-weight: 700 !important;
}

.baji-swatch-item.active .baji-color-circle::after {
    content: "\f00c" !important; 
    font-family: "Font Awesome 7 Pro", "Font Awesome 7 Free", "Font Awesome 6 Pro", var(--fa-family-classic) !important;
    font-size: 0.65rem !important;
    color: #ffffff !important;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-weight: 900 !important; 
    text-shadow: none !important;
}
.baji-swatch-item.is-color-white.active .baji-color-circle::after,
.baji-swatch-item.is-color-cream.active .baji-color-circle::after,
.baji-swatch-item.is-color-yellow.active .baji-color-circle::after {
    color: #000000 !important;
}

.reset_variations {
    font-size: 0.75rem !important;
    color: #ef4444 !important;
    text-decoration: none;
    margin-top: 0.5rem;
    display: inline-block;
}

.baji-single-product form.cart .single_add_to_cart_button {
    flex: 1 1 auto !important;
    height: 3.2rem !important;
}

.baji-single-product form.cart div.quantity.baji-qty-hidden,
.baji-single-product form.cart div.quantity:has(input[type="hidden"]) {
    display: none !important;
}

.baji-single-product form.cart digify-clickable-box-modal,
.baji-single-product form.cart [data-bwdk-context] {
    width: 100% !important;
    flex-basis: 100% !important;
    margin-top: 0.5rem !important;
}

.baji-single-product .cart .woocommerce-variation-add-to-cart {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 1rem !important;
    width: 100% !important;
    margin-top: 1rem !important;
}

.baji-single-product form.cart div.quantity {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    background: #f9fafb !important;
    border: 1px solid #e5e7eb !important;
    border-radius: 0.75rem !important;
    height: 3.2rem !important;
    width: 8rem !important;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden !important;
    float: none !important;
    box-shadow: none !important;
    position: relative !important;
}

.baji-single-product form.cart div.quantity *:not(input.qty):not(.baji-qty-trigger) {
    display: none !important;
}

.baji-single-product form.cart div.quantity input.qty {
    width: 3rem !important;
    height: 100% !important;
    background: transparent !important;
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    font-weight: 700 !important;
    color: #111827 !important;
    font-size: 1.1rem !important;
    padding: 0 !important;
    text-align: center !important;
    margin: 0 !important;
    flex: 1 !important;
}
.baji-single-product form.cart div.quantity input::-webkit-outer-spin-button,
.baji-single-product form.cart div.quantity input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.baji-qty-trigger {
    width: 2.5rem !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #4b5563 !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    user-select: none !important;
    font-family: "Font Awesome 7 Pro", "Font Awesome 7 Free", "Font Awesome 6 Pro" !important;
    font-size: 0.9rem !important;
    font-weight: 900 !important;
    z-index: 2 !important;
}
.baji-qty-trigger:hover {
    background-color: #f3f4f6 !important;
    color: #111827 !important;
}

.baji-minus::before { content: "\f068" !important; }
.baji-plus::before { content: "\f067" !important; }

.baji-single-product .single_add_to_cart_button {
    flex: 1;
    height: 3.2rem !important;
    background-color: #111827 !important;
    color: #ffffff !important;
    font-size: 1rem !important;
    font-weight: 700 !important;
    border-radius: 0.75rem !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.75rem !important;
    border: none !important;
    cursor: pointer;
}
.baji-single-product .single_add_to_cart_button:hover {
    background-color: #1f2937 !important;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px -5px rgba(17, 24, 39, 0.2) !important;
}

/* تب‌ها */
.baji-product-tabs-wrapper {
    background: #ffffff !important;
    border-radius: 16px !important;
    padding: 24px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
}

.baji-price-inline-wrapper {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 0.625rem !important;
    direction: rtl !important;
    white-space: nowrap !important;
    padding: 10px 0;
}

.baji-price-inline-wrapper span {
    display: inline-block !important;
    line-height: 1 !important;
    float: none !important;
    position: static !important;
    margin: 0 !important;
    padding: 0 !important;
}

.baji-price-inline-wrapper .baji-old-price {
    color: #9ca3af !important;
    text-decoration: line-through !important;
    font-size: 0.95rem !important;
    font-weight: 500 !important;
}

.baji-price-inline-wrapper .baji-new-price {
    color: #111827 !important;
    font-size: 1.5rem !important;
    font-weight: 900 !important;
}

.baji-price-inline-wrapper .baji-currency {
    color: #6b7280 !important;
    font-size: 0.8rem !important;
    font-weight: 700 !important;
}

.baji-price-inline-wrapper .baji-discount-pill {
    background-color: #fff1f2 !important;
    color: #f43f5e !important;
    font-size: 0.75rem !important;
    font-weight: 700 !important;
    padding: 0.25rem 0.5rem !important;
    border-radius: 0.375rem !important;
    border: 1px solid #ffe4e6 !important;
}

.baji-single-product form.cart {
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
}

.baji-single-product form.cart div.quantity,
.baji-single-product form.cart .single_add_to_cart_button {
    flex-shrink: 0 !important;
}

/* 🌟 گالری محصول و تصاویر بندانگشتی (انتقال تامبنایل‌ها به سمت راست) */
@media (min-width: 768px) {
    .baji-product-gallery-wrapper .woocommerce-product-gallery {
        display: flex !important;
        flex-direction: row !important;
        gap: 16px !important;
        align-items: flex-start !important;
    }
    .baji-product-gallery-wrapper .woocommerce-product-gallery__wrapper {
        flex: 1 !important;
        min-width: 0 !important;
    }
    .baji-product-gallery-wrapper .flex-control-thumbs {
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        width: 85px !important;
        flex-shrink: 0 !important;
        margin: 0 !important;
        max-height: 520px !important;
        overflow-y: auto !important;
        padding-right: 4px !important;
        list-style: none !important;
        padding-left: 0 !important;
        order: -1 !important; /* قرارگیری در سمت راست در حالت RTL */
    }
    .baji-product-gallery-wrapper .flex-control-thumbs li {
        flex: 0 0 auto !important;
    }
    .baji-product-gallery-wrapper .flex-control-thumbs::-webkit-scrollbar {
        width: 4px;
    }
    .baji-product-gallery-wrapper .flex-control-thumbs::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 4px;
    }
}

@media (max-width: 767px) {

    .baji-product-gallery-wrapper .flex-control-thumbs {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        gap: 8px !important;

        width: 100% !important;
        max-width: 100% !important;

        margin-top: 12px !important;
        padding: 0 0 6px 0 !important;

        overflow-x: auto !important;
        overflow-y: hidden !important;

        list-style: none !important;
        -webkit-overflow-scrolling: touch !important;
        scroll-behavior: smooth !important;
        touch-action: pan-x !important;
        overscroll-behavior-x: contain !important;

        scrollbar-width: none !important;
    }

    /* مخفی کردن اسکرول‌بار */
    .baji-product-gallery-wrapper .flex-control-thumbs::-webkit-scrollbar {
        display: none !important;
        height: 0 !important;
    }

    /* هر تامبنیل عرض ثابت داشته باشد */
    .baji-product-gallery-wrapper .flex-control-thumbs li {
        width: 72px !important;
        min-width: 72px !important;
        max-width: 72px !important;

        height: 96px !important;
        flex: 0 0 72px !important;

        margin: 0 !important;
    }

    .baji-product-gallery-wrapper .flex-control-thumbs li img {
        display: block !important;

        width: 72px !important;
        height: 96px !important;

        aspect-ratio: auto !important;
        object-fit: cover !important;

        border-radius: 9px !important;
    }
}

.baji-product-gallery-wrapper .flex-control-thumbs li {
    width: 100% !important;
    float: none !important;
    margin: 0 !important;
}

.baji-product-gallery-wrapper .flex-control-thumbs li img {
    width: 100% !important;
    aspect-ratio: 3 / 4 !important;
    object-fit: cover !important;
    border-radius: 10px !important;
    opacity: .6 !important;
    cursor: pointer;
    border: 2px solid transparent !important;
    transition: all 0.2s ease;
}

.baji-product-gallery-wrapper .flex-control-thumbs li img.flex-active {
    opacity: 1 !important;
    border-color: #111827 !important;
}

/* Keep the mobile thumbnail dimensions after the generic desktop thumbnail rules. */
@media (max-width: 767px) {
    .baji-product-gallery-wrapper .flex-control-thumbs li {
        width: 72px !important;
        min-width: 72px !important;
        max-width: 72px !important;
        height: 96px !important;
        flex: 0 0 72px !important;
    }
    .baji-product-gallery-wrapper .flex-control-thumbs li img {
        width: 72px !important;
        height: 96px !important;
        aspect-ratio: auto !important;
    }
}

.baji-product-gallery-wrapper .woocommerce-product-gallery__image {
    background: #f8f8f6 !important;
    border-radius: 18px !important;
    overflow: hidden !important;
}

.baji-product-gallery-wrapper .woocommerce-product-gallery__image img {
    cursor: zoom-in !important;
    width: 100% !important;
    height: auto !important;
    object-fit: contain !important;
}

@media (min-width: 1024px) {
    .baji-single-product {
        display: grid !important;
        grid-template-columns: 50% 50% !important;
        gap: 10px !important;
        align-items: start !important;
    }

    .baji-single-product .baji-product-gallery-wrapper .woocommerce-product-gallery,
    .baji-single-product .baji-product-gallery-wrapper .woocommerce div.product div.images,
    .baji-single-product .baji-product-gallery-wrapper .woocommerce-page div.product div.images {
        width: 80% !important;
        float: none !important;
        margin: 0 !important;
    }

}

/* 🎬 استایل ویدیو استوری (اینستاگرام-style) */
.baji-product-video-story {
    position: relative !important;
    width: 100% !important;
    max-width: 280px !important;
    aspect-ratio: 4 / 5 !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    background: #000 !important;
    box-shadow: 0 12px 30px rgba(17, 24, 39, 0.14) !important;
}
.baji-product-video-preview {
    width: 100% !important;
    height: 100% !important;
    display: block !important;
    object-fit: cover !important;
    filter: brightness(0.78) !important;
}
.baji-product-video-trigger {
    position: absolute !important;
    inset: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border: 0 !important;
    padding: 0 !important;
    cursor: pointer !important;
    background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.48) 100%) !important;
}
.baji-product-video-trigger:focus-visible {
    outline: 3px solid #d4af37 !important;
    outline-offset: -5px !important;
}
.baji-product-video-badge {
    position: absolute !important;
    top: 12px !important;
    right: 12px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 30px !important;
    height: 30px !important;
    color: #fff !important;
    background: rgba(0, 0, 0, 0.52) !important;
    border-radius: 9999px !important;
    z-index: 2 !important;
    pointer-events: none !important;
}
.baji-product-video-sound {
    position: absolute !important;
    bottom: 12px !important;
    left: 12px !important;
    z-index: 3 !important;
    width: 34px !important;
    height: 34px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #fff !important;
    background: rgba(0, 0, 0, 0.52) !important;
    border: 1px solid rgba(255, 255, 255, 0.24) !important;
    border-radius: 9999px !important;
    cursor: pointer !important;
    transition: background-color 0.2s ease, transform 0.2s ease !important;
}
.baji-product-video-sound:hover,
.baji-product-video-sound:focus-visible {
    background: rgba(0, 0, 0, 0.72) !important;
    transform: scale(1.06) !important;
}

/* اسکرول‌بار برای موبایل در گالری */
@media (max-width: 767px) {
    .baji-product-video-story {
        max-width: 100% !important;
        border-radius: 12px !important;
    }
    .baji-product-video-preview {
        border-radius: 12px !important;
    }
}

/* انیمیشن ورود مودال ویدیو */
#baji-video-story-modal {
    animation: bajiModalFadeIn 0.2s ease-out;
}
#baji-video-story-modal .relative {
    width: 100vw !important;
    height: 100vh !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
#baji-video-story-modal video {
    animation: bajiModalSlideUp 0.3s ease-out;
}

@keyframes bajiModalFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes bajiModalSlideUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* ویدیو مودال - فول‌اسکرین واقعی */
#baji-video-story-modal .relative > div {
    width: 100vw !important;
    height: 100vh !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
#baji-video-story-modal video {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
    object-fit: contain !important;
    border-radius: 0 !important;
}

/* دکمه بستن مودال - حالت hover */
#baji-video-modal-close:hover {
    background: rgba(255,255,255,0.3) !important;
    transform: rotate(90deg);
    transition: all 0.2s ease;
}


</style>

<!-- =========================================================================
     🌟 لایت‌باکس مستقل (کاملاً ایمن و مجزا از ساختار آژاکس)
     ========================================================================= -->
<div id="baji-custom-lightbox" class="fixed inset-0 z-[99999] items-center justify-center bg-black/80 p-4 sm:p-10 hidden" style="display: none;">
	<div class="absolute inset-0 cursor-pointer" id="baji-lightbox-backdrop"></div>
	<button type="button" id="baji-lightbox-close" class="absolute top-6 right-6 sm:top-10 sm:right-10 z-10 text-white/70 hover:text-white transition-colors cursor-pointer">
		<i class="fa-solid fa-xmark text-3xl sm:text-4xl"></i>
	</button>
	<img id="baji-lightbox-img" src="" class="relative z-10 max-h-[90vh] max-w-full object-contain rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
</div>

<!-- =========================================================================
     🎬 مودال ویدیو - استایل استوری اینستاگرام
     ========================================================================= -->
<div id="baji-video-story-modal" class="fixed inset-0 hidden" style="display: none; z-index: 2147483647;" role="dialog" aria-modal="true" aria-label="مشاهده ویدیو محصول">
	<div class="absolute inset-0 bg-black/70 backdrop-blur-md cursor-pointer" id="baji-video-modal-backdrop" style="background: rgba(3, 7, 18, 0.88); -webkit-backdrop-filter: blur(16px); backdrop-filter: blur(16px);"></div>
	<div class="relative z-10 flex items-center justify-center min-h-screen p-0">
		<div class="relative w-full h-full max-w-full max-h-[100vh]">
			<!-- دکمه بستن -->
			<button type="button" id="baji-video-modal-close" class="absolute -top-12 right-0 z-20 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors cursor-pointer" aria-label="بستن ویدیو">
				<i class="fa-solid fa-xmark text-xl"></i>
			</button>
			<!-- پلیر ویدیو -->
			<video id="baji-video-modal-player" class="w-full h-full max-w-full max-h-full object-contain rounded-none shadow-[0_20px_50px_rgba(0,0,0,0.5)]" controls>
				<source src="" type="video/mp4">
				مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
			</video>
		</div>
	</div>
</div>

<!-- =========================================================================
     ⚙️ اسکریپت‌های مدیریت سوئیچ‌ها، تعداد و لایت‌باکس
     ========================================================================= -->
<!-- 
     اسکریپت AJAX افزودن به سبد، سوییچ رنگ/سایز، دکمه‌های تعداد و
     لایت‌باکس گالری به assets/js/single-product-ajax.js منتقل شد.
     دلیل: اسکریپت درون‌خطی قبلی به ترتیب بارگذاری jQuery در صفحه
     وابسته بود و در صورت تأخیر jQuery (مثلاً توسط افزونه کش) با
     خطا متوقف می‌شد. اسکریپت جدید با wp_enqueue_script() و وابستگی
     صریح به 'jquery' بارگذاری می‌شود که این مشکل را برای همیشه رفع
     می‌کند (به functions.php مراجعه کنید).
-->

<?php
get_footer();
