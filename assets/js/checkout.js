/**
 * بهبود تجربه کاربری صفحه تسویه‌حساب قالب BajiStyle
 *
 * این فایل فقط در صفحه چک‌اوت بارگذاری می‌شود (به شرط is_checkout()
 * در functions.php). فرایند اصلی پرداخت و اعتبارسنجی توسط هسته
 * ووکامرس مدیریت می‌شود؛ این اسکریپت صرفاً تجربه بصری را بهبود می‌دهد.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/* global jQuery */

/**
 * نمایش لودینگ ظریف روی بخش خلاصه سفارش هنگام به‌روزرسانی AJAX
 * (مثلاً پس از تغییر کشور/استان یا اعمال کد تخفیف).
 *
 * @since 1.0.0
 */
function initCheckoutLoadingState() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	const orderReview = document.getElementById( 'order_review' );
	if ( ! orderReview ) {
		return;
	}

	window.jQuery( document.body ).on( 'updated_checkout', () => {
		orderReview.classList.remove( 'opacity-50' );
	} );

	window.jQuery( document.body ).on( 'update_checkout', () => {
		orderReview.classList.add( 'opacity-50' );
	} );
}

/**
 * نمایش/مخفی‌سازی هوشمند فیلدهای آدرس ارسال بر اساس چک‌باکس
 * «ارسال به آدرس متفاوت» (رفتار استاندارد ووکامرس را کمی روان‌تر می‌کند).
 *
 * @since 1.0.0
 */
function initShipToDifferentAddressToggle() {
	const checkbox = document.getElementById( 'ship-to-different-address-checkbox' );
	const shippingFields = document.querySelector( '.baji-checkout-shipping' );

	if ( ! checkbox || ! shippingFields ) {
		return;
	}

	const updateVisibility = () => {
		shippingFields.style.transition = 'opacity 0.3s ease';
		shippingFields.style.opacity = checkbox.checked ? '1' : '0.6';
	};

	checkbox.addEventListener( 'change', updateVisibility );
	updateVisibility();
}

/**
 * اسکرول نرم به اولین فیلد دارای خطای اعتبارسنجی پس از ارسال ناموفق فرم.
 *
 * ووکامرس پیام خطا را در بالای فرم (.woocommerce-NoticeGroup) چاپ
 * می‌کند؛ این تابع کاربر را به‌صورت نرم به آن بخش هدایت می‌کند.
 *
 * @since 1.0.0
 */
function initCheckoutErrorScroll() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	window.jQuery( document.body ).on( 'checkout_error', () => {
		const noticeGroup = document.querySelector( '.woocommerce-NoticeGroup, .woocommerce-error' );
		if ( noticeGroup ) {
			noticeGroup.scrollIntoView( { behavior: 'smooth', block: 'center' } );
		}
	} );
}

/**
 * مقداردهی اولیه ماژول‌های صفحه تسویه‌حساب.
 *
 * @since 1.0.0
 */
function initBajiStyleCheckout() {
	initCheckoutLoadingState();
	initShipToDifferentAddressToggle();
	initCheckoutErrorScroll();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initBajiStyleCheckout );
} else {
	initBajiStyleCheckout();
}
