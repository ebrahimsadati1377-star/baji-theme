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
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	const $ = window.jQuery;

	$( document ).off( 'click.bajiCartRemove', '.baji-cart-item-remove' );
	$( document ).on( 'click.bajiCartRemove', '.baji-cart-item-remove', function ( event ) {
		event.preventDefault();
		event.stopPropagation();

		const $link = $( this );
		const $item = $link.closest( '.baji-cart-item' );
		const cartItemKey = $link.data( 'cart_item_key' );

		if ( ! cartItemKey ) {
			window.location.href = $link.attr( 'href' );
			return;
		}

		$item.css( { opacity: '0.45', pointerEvents: 'none' } );

		let ajaxUrl = '';
		if ( window.wc_add_to_cart_params && window.wc_add_to_cart_params.wc_ajax_url ) {
			ajaxUrl = window.wc_add_to_cart_params.wc_ajax_url.replace( '%%endpoint%%', 'remove_from_cart' );
		} else if ( window.bajistyleWC && window.bajistyleWC.ajaxUrl ) {
			ajaxUrl = window.location.origin + '/?wc-ajax=remove_from_cart';
		} else {
			ajaxUrl = window.location.origin + '/?wc-ajax=remove_from_cart';
		}

		$.ajax( {
			type: 'POST',
			url: ajaxUrl,
			data: { cart_item_key: cartItemKey },
			dataType: 'json',
			success( response ) {
				if ( response && response.fragments ) {
					$.each( response.fragments, function ( selector, html ) {
						$( selector ).replaceWith( html );
					} );

					try {
						if ( window.sessionStorage ) {
							sessionStorage.setItem( 'wc_fragments_refreshed', Date.now() );
							if ( response.cart_hash ) {
								sessionStorage.setItem( 'wc_cart_hash_' + window.location.host, response.cart_hash );
							}
						}
					} catch ( error ) {}

					$( document.body ).trigger( 'removed_from_cart', [ response.fragments, response.cart_hash, $link ] );
					$( document.body ).trigger( 'wc_fragment_refresh' );

					const panel = document.getElementById( 'baji-cart-panel' );
					if ( panel ) {
						panel.classList.add( 'is-open' );
						panel.setAttribute( 'aria-hidden', 'false' );
					}
					return;
				}

				window.location.reload();
			},
			error() {
				$item.css( { opacity: '', pointerEvents: '' } );
				window.location.href = $link.attr( 'href' );
			},
		} );
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
 * کنترل تعداد داخل مینی‌کارت.
 */
function initMiniCartQuantityControls() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	const $ = window.jQuery;
	let busy = false;

	$( document ).off( 'click.bajiMiniQty', '.baji-mini-cart-qty__btn' );
	$( document ).on( 'click.bajiMiniQty', '.baji-mini-cart-qty__btn', function ( event ) {
		event.preventDefault();

		if ( busy ) return;

		const $button = $( this );
		const $controls = $button.closest( '.baji-mini-cart-controls' );
		const $value = $controls.find( '.baji-mini-cart-qty__value' );
		const cartItemKey = $controls.data( 'cart_item_key' );
		let quantity = parseInt( $value.text(), 10 ) || 1;

		if ( $button.hasClass( 'baji-mini-cart-qty__plus' ) ) {
			quantity += 1;
		} else {
			quantity -= 1;
		}

		if ( quantity < 1 ) {
			const $remove = $controls.closest( '.baji-cart-item' ).find( '.baji-cart-item-remove' );
			if ( $remove.length ) {
				$remove.trigger( 'click' );
			}
			return;
		}

		if ( ! window.bajistyleWC || ! window.bajistyleWC.ajaxUrl ) return;

		busy = true;
		$controls.addClass( 'is-loading' );

		$.ajax( {
			type: 'POST',
			url: window.bajistyleWC.ajaxUrl,
			dataType: 'json',
			data: {
				action: 'baji_update_mini_cart_quantity',
				nonce: window.bajistyleWC.nonce,
				cart_item_key: cartItemKey,
				quantity: quantity,
			},
			success( response ) {
				if ( response && response.success && response.data && response.data.mini_cart ) {
					$( '#baji-cart-panel .widget_shopping_cart_content' ).html( response.data.mini_cart );
					$( '.baji-cart-count' ).text( response.data.cart_count || 0 );

					const panel = document.getElementById( 'baji-cart-panel' );
					if ( panel ) {
						const shippingBox = panel.querySelector( '.baji-cart-shipping' );
						if ( shippingBox ) {
							const title = shippingBox.querySelector( '.baji-cart-shipping__title' );
							const text = shippingBox.querySelector( '.baji-cart-shipping__text' );
							const bar = shippingBox.querySelector( '.baji-cart-shipping__bar span' );
							const currentEl = shippingBox.querySelector( '.baji-cart-shipping__current' );
							const remaining = Number( response.data.shipping_remaining || 0 );
							const percent = Number( response.data.shipping_percent || 0 );
							const isFree = Boolean( response.data.shipping_is_free );
							const fmt = ( n ) => new Intl.NumberFormat( 'fa-IR' ).format( Math.max( 0, Math.round( Number( n ) || 0 ) ) ) + ' تومان';

							if ( title ) {
								title.textContent = isFree
									? 'ارسال سفارش شما رایگان شد'
									: 'فقط ' + fmt( remaining ) + ' تا ارسال رایگان';
								title.classList.toggle( 'is-free', isFree );
							}
							if ( text ) {
								text.textContent = isFree
									? 'تبریک! هزینه ارسال این سفارش رایگان شد.'
									: 'حد ارسال رایگان: ۳ میلیون تومان';
							}
							if ( bar ) {
								bar.style.width = Math.max( 0, Math.min( 100, percent ) ) + '%';
							}
							if ( currentEl ) {
								currentEl.textContent = 'فعلی: ' + fmt( response.data.cart_subtotal || 0 );
							}
						}

						panel.classList.add( 'is-open' );
						panel.setAttribute( 'aria-hidden', 'false' );
					}

					$( document.body ).trigger( 'updated_cart_totals', [ response.data ] );
				} else {
					window.location.reload();
				}
			},
			error() {
				window.location.reload();
			},
			complete() {
				busy = false;
			},
		} );
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
    initMiniCartQuantityControls();
});