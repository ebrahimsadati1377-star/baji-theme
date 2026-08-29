/**
 * منطق عمومی ووکامرس قالب BajiStyle
 *
 * این فایل صرفاً برای صفحات دارای ووکامرس بارگذاری می‌شود (به شرط
 * enqueue شرطی در functions.php) و شامل تعامل گالری تصاویر محصول و
 * هماهنگی رویدادهای پایه ووکامرس با رابط کاربری قالب است.
 *
 * توجه: قابلیت زوم تصویر (wc-product-gallery-zoom) و اسلایدر گالری
 * (wc-product-gallery-slider) توسط اسکریپت‌های هسته ووکامرس
 * (zoom.js و flexslider) که از طریق add_theme_support فعال شده‌اند
 * مدیریت می‌شوند؛ این فایل مکمل آن‌ها برای رفتارهای اختصاصی قالب است.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/* global jQuery */

/**
 * هماهنگی کلاس‌های ظاهری دکمه‌های انتخاب سایز/رنگ با Tailwind.
 *
 * ووکامرس به‌صورت پیش‌فرض dropdown متنی برای ویژگی‌های محصول متغیر
 * تولید می‌کند (که در inc/woocommerce-hooks.php استایل پایه گرفته است).
 * این تابع وضعیت انتخاب فعلی را برای واریانت‌های ناموجود غیرفعال
 * نمایش می‌دهد.
 *
 * @since 1.0.0
 */
function initVariationFeedback() {
	const forms = document.querySelectorAll( '.variations_form' );

	if ( ! forms.length || typeof window.jQuery === 'undefined' ) {
		return;
	}

	forms.forEach( ( formEl ) => {
		const $form = window.jQuery( formEl );

		$form.on( 'show_variation', ( event, variation ) => {
			const addToCartButton = formEl.querySelector( '.single_add_to_cart_button' );
			if ( addToCartButton && variation && variation.is_in_stock ) {
				addToCartButton.classList.remove( 'opacity-50', 'pointer-events-none' );
			}
		} );

		$form.on( 'hide_variation', () => {
			const addToCartButton = formEl.querySelector( '.single_add_to_cart_button' );
			if ( addToCartButton ) {
				addToCartButton.classList.add( 'opacity-50', 'pointer-events-none' );
			}
		} );
	} );
}

/**
 * نمایش پیام موفقیت کوتاه پس از افزودن محصول به سبد (بدون رفرش صفحه).
 *
 * این تابع به رویداد استاندارد jQuery ووکامرس (added_to_cart) گوش
 * می‌دهد که پس از AJAX add-to-cart در گرید محصولات شلیک می‌شود.
 *
 * @since 1.0.0
 */
function initAddToCartFeedback() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	window.jQuery( document.body ).on( 'added_to_cart', () => {
		const message = window.bajistyleWC && window.bajistyleWC.i18n
			? window.bajistyleWC.i18n.addedToCart
			: 'به سبد خرید اضافه شد';

		showBajiToast( message );
	} );
}

/**
 * کپی کد تخفیف خرید اول و نمایش بازخورد کوتاه.
 */
function initCouponCopy() {
	document.querySelectorAll( '.baji-copy-coupon' ).forEach( ( button ) => {
		button.addEventListener( 'click', async () => {
			const coupon = button.dataset.coupon || '';
			if ( ! coupon ) {
				return;
			}

			try {
				await navigator.clipboard.writeText( coupon );
				showBajiToast( 'کد تخفیف کپی شد' );
			} catch ( error ) {
				showBajiToast( coupon );
			}
		} );
	} );
}

/**
 * نمایش یک پیام کوتاه (Toast) گوشه صفحه برای بازخورد سریع به کاربر.
 *
 * @param {string} message متن پیام.
 * @since 1.0.0
 */
function showBajiToast( message ) {
	let toast = document.getElementById( 'baji-toast' );

	if ( ! toast ) {
		toast = document.createElement( 'div' );
		toast.id = 'baji-toast';
		toast.setAttribute( 'role', 'status' );
		toast.setAttribute( 'aria-live', 'polite' );
		toast.className =
			'fixed bottom-6 left-1/2 -translate-x-1/2 z-[200] bg-baji-black text-baji-white text-sm px-6 py-3 opacity-0 transition-opacity duration-300 pointer-events-none';
		document.body.appendChild( toast );
	}

	toast.textContent = message;
	toast.classList.remove( 'opacity-0' );
	toast.classList.add( 'opacity-100' );

	window.clearTimeout( toast._bajiTimeout ); // eslint-disable-line no-underscore-dangle
	toast._bajiTimeout = window.setTimeout( () => { // eslint-disable-line no-underscore-dangle
		toast.classList.remove( 'opacity-100' );
		toast.classList.add( 'opacity-0' );
	}, 2500 );
}

/**
 * مقداردهی اولیه ماژول‌های اختصاصی ووکامرس.
 *
 * @since 1.0.0
 */
function initBajiStyleWooCommerce() {
	initVariationFeedback();
	initAddToCartFeedback();
	initCouponCopy();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initBajiStyleWooCommerce );
} else {
	initBajiStyleWooCommerce();
}
