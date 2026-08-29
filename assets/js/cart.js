/**
 * مدیریت سبد خرید کناری (Slide-out Cart) قالب BajiStyle
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/* global jQuery */

/**
 * مدیریت باز و بسته کردن پنل سبد خرید (اصلاح شده با Event Delegation)
 */
/**
 * مدیریت باز و بسته کردن پنل سبد خرید (بدون وابستگی به کلاس‌های تیلویند)
 */
function initSlideOutCart() {
    document.addEventListener('click', function(e) {
        const panel = document.getElementById('baji-cart-panel');
        const overlay = document.getElementById('baji-cart-overlay');
        
        if (!panel || !overlay) return;

        // ۱. باز کردن پنل و لایه تاریک
        if (e.target.closest('.baji-cart-toggle')) {
            e.preventDefault();
            
            // پنل را بیاور داخل
            panel.style.transform = 'translateX(0)';
            
            // لایه تاریک را نمایش بده و قابل کلیک کن
            overlay.style.opacity = '1';
            overlay.style.pointerEvents = 'auto';
            
            document.body.style.overflow = 'hidden';
        }

        // ۲. بستن پنل (کلیک روی ضربدر یا لایه تاریک)
        if (e.target.closest('#baji-cart-close') || e.target.id === 'baji-cart-overlay') {
            if (e.target.closest('#baji-cart-close')) e.preventDefault();
            
            // پنل را بفرست بیرون
            panel.style.transform = 'translateX(-100%)';
            
            // لایه تاریک را مخفی و غیرقابل کلیک کن
            overlay.style.opacity = '0';
            overlay.style.pointerEvents = 'none';
            
            document.body.style.overflow = '';
        }
    });
}

/**
 * به‌روزرسانی شمارنده سبد خرید.
 */
function initCartFragmentsRefresh() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	window.jQuery( document.body ).on( 'wc_fragments_refreshed wc_fragments_loaded', () => {} );
}

/**
 * مدیریت حذف آیتم از سبد خرید.
 */
function initCartItemRemoval() {
	document.addEventListener( 'click', ( event ) => {
		const removeLink = event.target.closest( '.baji-cart-item-remove' );
		if ( ! removeLink ) {
			return;
		}

		const cartItem = removeLink.closest( '.baji-cart-item' );
		if ( cartItem ) {
			cartItem.style.opacity = '0.4';
			cartItem.style.pointerEvents = 'none';
		}
	} );
}

/**
 * مدیریت دکمه‌های افزایش/کاهش تعداد.
 */
function initPremiumQtyButtons() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	const $ = window.jQuery;

	$( document ).on( 'click', '.baji-qty-btn', function ( event ) {
		event.preventDefault();

		const $btn = $( this );
		const $input = $btn.siblings( '.qty' );

		if ( ! $input.length ) {
			return;
		}

		const step = parseFloat( $input.attr( 'step' ) ) || 1;
		const min = parseFloat( $input.attr( 'min' ) ) || 0;
		const maxAttr = $input.attr( 'max' );
		const max = maxAttr ? parseFloat( maxAttr ) : null;
		let current = parseFloat( $input.val() ) || 0;

		if ( $btn.hasClass( 'baji-plus' ) ) {
			if ( null === max || current < max ) {
				current += step;
			}
		} else if ( $btn.hasClass( 'baji-minus' ) ) {
			if ( current > min ) {
				current -= step;
			}
		}

		$input.val( current ).trigger( 'change' );
	} );
}

/**
 * آپدیت خودکار سبد خرید AJAX.
 */
function initPremiumCartAjaxUpdate() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	const $ = window.jQuery;

	if ( ! $( '.premium-cart-container' ).length ) {
		return;
	}

	let updateTimer = null;

	$( document ).on( 'change', '.premium-cart-container .qty', function () {
		const changedInput = this;

		if ( updateTimer ) {
			window.clearTimeout( updateTimer );
		}

		$( '.premium-cart-container' ).addClass( 'opacity-40 pointer-events-none' );

		updateTimer = window.setTimeout( () => {
			const $form = $( changedInput ).closest( 'form.woocommerce-cart-form' );

			if ( ! $form.length || typeof window.bajistyleWC === 'undefined' ) {
				$( '.premium-cart-container' ).removeClass( 'opacity-40 pointer-events-none' );
				return;
			}

			$.ajax( {
				type: 'POST',
				url: window.bajistyleWC.cartUrl,
				data: `${ $form.serialize() }&update_cart=1`,
				success( response ) {
					const $freshContainer = $( response ).find( '.premium-cart-container' ).first();

					if ( $freshContainer.length ) {
						$( '.premium-cart-container' ).each( function () {
							$( this ).html( $freshContainer.html() );
						} );
					}

					$( document.body ).trigger( 'wc_fragment_refresh' );
					$( document.body ).trigger( 'updated_cart_totals' );

					$( '.premium-cart-container' ).removeClass( 'opacity-40 pointer-events-none' );
				},
				error() {
					$( '.premium-cart-container' ).removeClass( 'opacity-40 pointer-events-none' );
				},
			} );
		}, 600 );
	} );
}

/**
 * مقداردهی اولیه نهایی پس از لود شدن DOM
 */
document.addEventListener('DOMContentLoaded', function() {
    initSlideOutCart();
    initCartFragmentsRefresh();
    initCartItemRemoval();
    initPremiumQtyButtons();
    initPremiumCartAjaxUpdate();
});