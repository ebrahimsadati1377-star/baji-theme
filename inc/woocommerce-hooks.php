<?php
/**
 * هوک‌ها و تنظیمات اختصاصی ووکامرس قالب BajiStyle
 *
 * این فایل ساختار پیش‌فرض ووکامرس را با هوک‌ها به‌جای override کامل
 * تمپلیت‌ها سفارشی می‌کند، تا حد امکان با قابلیت‌های آینده ووکامرس
 * سازگار بماند. بخش‌هایی که نیاز به override کامل دارند در پوشه
 * woocommerce/ این قالب قرار گرفته‌اند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* -------------------------------------------------------------------------
 * عرض رپر اصلی ووکامرس
 * ---------------------------------------------------------------------- */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * باز کردن رپر سفارشی محتوای اصلی ووکامرس با کلاس‌های Tailwind.
 *
 * @since 1.0.0
 */
function bajistyle_woocommerce_wrapper_start() {
	echo '<main id="main" class="baji-shop-main max-w-[1600px] mx-auto px-4 md:px-8 py-12">';
}
add_action( 'woocommerce_before_main_content', 'bajistyle_woocommerce_wrapper_start', 10 );

/**
 * بستن رپر سفارشی محتوای اصلی ووکامرس.
 *
 * @since 1.0.0
 */
function bajistyle_woocommerce_wrapper_end() {
	echo '</main>';
}
add_action( 'woocommerce_after_main_content', 'bajistyle_woocommerce_wrapper_end', 10 );

/* -------------------------------------------------------------------------
 * تعداد محصولات هر ردیف و هر صفحه آرشیو
 * ---------------------------------------------------------------------- */
/**
 * تعداد محصولات نمایش‌داده‌شده در هر صفحه آرشیو فروشگاه را تنظیم می‌کند.
 *
 * @return int تعداد محصولات.
 */
function bajistyle_products_per_page() {
	return 24;
}
add_filter( 'loop_shop_per_page', 'bajistyle_products_per_page', 20 );

/**
 * تعداد ستون‌های گرید محصولات را برای پشتیبانی از کلاس‌های Tailwind تنظیم می‌کند.
 *
 * @return int تعداد ستون‌ها.
 */
function bajistyle_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'bajistyle_loop_columns' );

/* -------------------------------------------------------------------------
 * حذف breadcrumb پیش‌فرض و افزودن نسخه سفارشی (در صورت نیاز)
 * ---------------------------------------------------------------------- */
/**
 * استایل جداکننده breadcrumb ووکامرس را با نسخه سفارشی RTL هماهنگ می‌کند.
 *
 * @param array $defaults تنظیمات پیش‌فرض breadcrumb.
 * @return array تنظیمات اصلاح‌شده.
 */
function bajistyle_woocommerce_breadcrumbs( $defaults ) {
	$defaults['delimiter']   = ' <span class="mx-2 text-baji-gold">/</span> ';
	$defaults['wrap_before'] = '<nav class="baji-breadcrumb text-sm text-gray-500 mb-6">';
	$defaults['wrap_after']  = '</nav>';
	$defaults['home']        = __( 'خانه', 'bajistyle' );
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'bajistyle_woocommerce_breadcrumbs' );

/* -------------------------------------------------------------------------
 * متن‌های اختصاصی دکمه افزودن به سبد خرید
 * ---------------------------------------------------------------------- */
/**
 * متن دکمه افزودن به سبد خرید را در آرشیو محصولات شخصی‌سازی می‌کند.
 *
 * @return string متن دکمه.
 */
function bajistyle_custom_add_to_cart_text() {
	return __( 'افزودن به سبد', 'bajistyle' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'bajistyle_custom_add_to_cart_text' );

/**
 * متن دکمه افزودن به سبد خرید را در صفحه تکی محصول شخصی‌سازی می‌کند.
 *
 * @return string متن دکمه.
 */
function bajistyle_custom_single_add_to_cart_text() {
	return __( 'افزودن به سبد خرید', 'bajistyle' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'bajistyle_custom_single_add_to_cart_text' );

/* -------------------------------------------------------------------------
 * Sale Flash سفارشی (برچسب تخفیف)
 * ---------------------------------------------------------------------- */
/**
 * محتوای برچسب تخفیف را با کلاس‌های Tailwind برند بازنویسی می‌کند.
 *
 * @param string     $html محتوای پیش‌فرض HTML.
 * @param WP_Post    $post شیء پست.
 * @param WC_Product $product شیء محصول.
 * @return string محتوای HTML اصلاح‌شده.
 */
function bajistyle_sale_flash( $html, $post, $product ) {
	if ( ! $product->is_on_sale() ) {
		return '';
	}

	return '<span class="baji-sale-badge absolute top-3 right-3 z-10 bg-baji-black text-baji-gold text-xs tracking-widest px-3 py-1 uppercase">' . esc_html__( 'تخفیف', 'bajistyle' ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'bajistyle_sale_flash', 10, 3 );

/* -------------------------------------------------------------------------
 * فیلدهای سفارشی صفحه تسویه‌حساب
 * ---------------------------------------------------------------------- */
/**
 * فیلدهای فرم تسویه‌حساب را مطابق نیاز بازار ایران بازآرایی می‌کند.
 *
 * @param array $fields فیلدهای پیش‌فرض فرم تسویه‌حساب.
 * @return array فیلدهای اصلاح‌شده.
 */
function bajistyle_checkout_fields( $fields ) {
	if ( isset( $fields['billing']['billing_company'] ) ) {
		$fields['billing']['billing_company']['required'] = false;
	}

	if ( isset( $fields['billing']['billing_phone'] ) ) {
		$fields['billing']['billing_phone']['priority'] = 25;
		$fields['billing']['billing_phone']['class']    = array( 'form-row-wide' );
	}

	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'bajistyle_checkout_fields' );

/* -------------------------------------------------------------------------
 * تنظیمات Related Products (محصولات مرتبط)
 * ---------------------------------------------------------------------- */
/**
 * تعداد و آرگومان‌های نمایش محصولات مرتبط را تنظیم می‌کند.
 *
 * @param array $args آرگومان‌های پیش‌فرض.
 * @return array آرگومان‌های اصلاح‌شده.
 */
function bajistyle_related_products_args( $args ) {
	$args['posts_per_page'] = 12;
	$args['columns']        = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'bajistyle_related_products_args' );

/**
 * نمایش پیشنهاد مینیمال خرید اول در خلاصه محصول.
 */
function bajistyle_first_purchase_coupon_bar() {
	$coupon = trim( (string) get_theme_mod( 'bajistyle_first_purchase_coupon', '' ) );

	if ( '' === $coupon ) {
		return;
	}
	?>
	<div class="baji-first-purchase-offer" role="note">
		<span class="baji-first-purchase-offer__icon" aria-hidden="true"><i class="fa-solid fa-sparkles"></i></span>
		<span class="baji-first-purchase-offer__text"><?php esc_html_e( '۱۰٪ تخفیف برای اولین خریدت', 'bajistyle' ); ?></span>
		<button type="button" class="baji-copy-coupon" data-coupon="<?php echo esc_attr( $coupon ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'کپی کد تخفیف %s', 'bajistyle' ), $coupon ) ); ?>">
			<code><?php echo esc_html( $coupon ); ?></code>
			<i class="fa-regular fa-copy" aria-hidden="true"></i>
		</button>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'bajistyle_first_purchase_coupon_bar', 35 );

/* -------------------------------------------------------------------------
 * حذف نوار اطلاعات نتایج و مرتب‌سازی پیش‌فرض (نسخه سفارشی در فایل آرشیو)
 * ---------------------------------------------------------------------- */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/* -------------------------------------------------------------------------
 * افزودن کلاس‌های Tailwind به فرم افزودن به سبد محصولات متغیر
 * ---------------------------------------------------------------------- */
/**
 * کلاس‌های ظاهری دراپ‌داون انتخاب ویژگی محصول (سایز/رنگ) را تنظیم می‌کند.
 *
 * @param array $args آرگومان‌های دراپ‌داون.
 * @return array آرگومان‌های اصلاح‌شده.
 */
function bajistyle_dropdown_variation_attribute_options_args( $args ) {
	$args['class'] = 'baji-variation-select w-full border border-gray-300 focus:border-baji-gold py-3 px-4 text-sm';
	return $args;
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'bajistyle_dropdown_variation_attribute_options_args' );

/* -------------------------------------------------------------------------
 * Schema Markup برای سئو محصولات
 * ---------------------------------------------------------------------- */
/**
 * اطمینان از فعال بودن خروجی Structured Data پیش‌فرض ووکامرس.
 * ووکامرس به‌صورت پیش‌فرض Schema.org Product/Offer را تولید می‌کند؛
 * این تابع صرفاً برای افزودن فیلد brand به schema استفاده می‌شود.
 *
 * @param array      $markup داده‌های ساختاریافته.
 * @param WC_Product $product شیء محصول.
 * @return array داده‌های اصلاح‌شده.
 */
function bajistyle_structured_data_product( $markup, $product ) {
	$markup['brand'] = array(
		'@type' => 'Brand',
		'name'  => 'BajiStyle',
	);
	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'bajistyle_structured_data_product', 10, 2 );

/* -------------------------------------------------------------------------
 * شمارنده آیتم‌های سبد خرید در هدر (AJAX)
 * ---------------------------------------------------------------------- */
/**
 * فرگمنت‌های AJAX ووکامرس را برای به‌روزرسانی شمارنده سبد در هدر اضافه می‌کند.
 *
 * @param array $fragments فرگمنت‌های موجود.
 * @return array فرگمنت‌های اصلاح‌شده.
 */
function bajistyle_cart_count_fragment( $fragments ) {
	ob_start();
	?>
	<span class="baji-cart-count absolute -top-2 -left-2 text-[10px] bg-baji-gold text-baji-black rounded-full w-4 h-4 flex items-center justify-center font-sans" data-cart-count="<?php echo absint( WC()->cart->get_cart_contents_count() ); ?>">
		<?php echo absint( WC()->cart->get_cart_contents_count() ); ?>
	</span>
	<?php
	$fragments['.baji-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'bajistyle_cart_count_fragment' );

/* -------------------------------------------------------------------------
 * فعال‌سازی سبد خرید کناری (Slide-out Cart) به‌جای رفتن مستقیم به صفحه سبد
 * ---------------------------------------------------------------------- */
/**
 * AJAX را برای افزودن به سبد خرید در صفحه آرشیو فعال می‌کند تا
 * سبد کناری بدون رفرش صفحه به‌روزرسانی شود.
 */
add_filter( 'woocommerce_loop_add_to_cart_args', 'bajistyle_loop_add_to_cart_args', 10, 2 );

/**
 * کلاس ajax_add_to_cart را به دکمه‌های افزودن به سبد در آرشیو اضافه می‌کند.
 *
 * @param array      $args آرگومان‌های دکمه.
 * @param WC_Product $product شیء محصول.
 * @return array آرگومان‌های اصلاح‌شده.
 */
function bajistyle_loop_add_to_cart_args( $args, $product ) {
	if ( $product && $product->is_purchasable() && $product->is_in_stock() ) {
		$args['class'] = implode(
			' ',
			array(
				'button',
				'product_type_' . $product->get_type(),
				$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				'baji-add-to-cart-btn',
			)
		);
	}
	return $args;
}

/* -------------------------------------------------------------------------
 * صفحه حساب کاربری: افزودن منوی علاقه‌مندی‌ها
 * ---------------------------------------------------------------------- */
/**
 * تب «علاقه‌مندی‌ها» را به منوی صفحه حساب کاربری ووکامرس اضافه می‌کند.
 *
 * @param array $items آیتم‌های منوی حساب کاربری.
 * @return array آیتم‌های اصلاح‌شده.
 */
function bajistyle_account_menu_items( $items ) {
	$logout = $items['customer-logout'];
	unset( $items['customer-logout'] );

	$items['wishlist']         = __( 'علاقه‌مندی‌های من', 'bajistyle' );
	$items['customer-logout']  = $logout;

	return $items;
}
add_filter( 'woocommerce_account_menu_items', 'bajistyle_account_menu_items' );

/**
 * محتوای endpoint علاقه‌مندی‌ها را در صفحه حساب کاربری رندر می‌کند.
 *
 * @since 1.0.0
 */
function bajistyle_account_wishlist_endpoint_content() {
	get_template_part( 'template-parts/account/wishlist' );
}
add_action( 'woocommerce_account_wishlist_endpoint', 'bajistyle_account_wishlist_endpoint_content' );

/**
 * ثبت endpoint سفارشی «wishlist» برای صفحه حساب کاربری.
 *
 * @since 1.0.0
 */
function bajistyle_add_wishlist_endpoint() {
	add_rewrite_endpoint( 'wishlist', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'bajistyle_add_wishlist_endpoint' );

/**
 * شناسه endpoint را به Query Vars ووکامرس اضافه می‌کند.
 *
 * @param array $vars متغیرهای کوئری موجود.
 * @return array متغیرهای اصلاح‌شده.
 */
function bajistyle_wishlist_query_vars( $vars ) {
	$vars['wishlist'] = 'wishlist';
	return $vars;
}
add_filter( 'woocommerce_get_query_vars', 'bajistyle_wishlist_query_vars' );
