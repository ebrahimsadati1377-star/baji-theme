/**
 * فایل اصلی جاوااسکریپت قالب BajiStyle
 *
 * این فایل نقطه ورود (entry point) اصلی است و وظایف عمومی قالب
 * (هدر شفاف، پنل جستجو، فرم خبرنامه، wishlist و دکمه‌های عمومی) را
 * مدیریت می‌کند. ماژول‌های navigation.js و animations.js پیش از این
 * فایل بارگذاری می‌شوند (به ترتیب وابستگی در functions.php).
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/**
 * مدیریت تغییر پس‌زمینه هدر هنگام اسکرول صفحه.
 *
 * @since 1.0.0
 */
function initHeaderScrollEffect() {
	const header = document.getElementById( 'masthead' );
	if ( ! header ) {
		return;
	}

	const SCROLL_THRESHOLD = 80;

	const updateHeaderState = () => {
		const isScrolled = window.scrollY > SCROLL_THRESHOLD;
		header.dataset.scrolled = isScrolled ? 'true' : 'false';
		header.classList.toggle( 'baji-header-scrolled', isScrolled );
	};

	// اجرای اولیه (برای حالتی که صفحه با اسکرول قبلی بارگذاری شده باشد).
	updateHeaderState();

	window.addEventListener( 'scroll', updateHeaderState, { passive: true } );
}

/**
 * مدیریت باز/بسته‌شدن پنل جستجوی کشویی در هدر.
 *
 * @since 1.0.0
 */
function initSearchPanel() {
	const toggleButton = document.querySelector( '.baji-search-toggle' );
	const searchPanel = document.getElementById( 'baji-search-panel' );
	const closeButton = document.getElementById( 'baji-search-close' );
	const backdrop = document.getElementById( 'baji-search-backdrop' );

	if ( ! toggleButton || ! searchPanel ) {
		return;
	}

	const openPanel = () => {
		searchPanel.classList.remove( '-translate-y-full' );
		searchPanel.setAttribute( 'aria-hidden', 'false' );
		toggleButton.setAttribute( 'aria-expanded', 'true' );
		if ( backdrop ) {
			backdrop.classList.remove( 'hidden' );
			backdrop.setAttribute( 'aria-hidden', 'false' );
		}

		const input = searchPanel.querySelector( 'input[type="search"]' );
		if ( input ) {
			window.setTimeout( () => input.focus(), 300 );
		}
	};

	const closePanel = () => {
		searchPanel.classList.add( '-translate-y-full' );
		searchPanel.setAttribute( 'aria-hidden', 'true' );
		toggleButton.setAttribute( 'aria-expanded', 'false' );
		if ( backdrop ) {
			backdrop.classList.add( 'hidden' );
			backdrop.setAttribute( 'aria-hidden', 'true' );
		}
	};

	toggleButton.addEventListener( 'click', () => {
		const isOpen = toggleButton.getAttribute( 'aria-expanded' ) === 'true';
		if ( isOpen ) {
			closePanel();
		} else {
			openPanel();
		}
	} );

	if ( closeButton ) {
		closeButton.addEventListener( 'click', closePanel );
	}

	if ( backdrop ) {
		backdrop.addEventListener( 'click', closePanel );
	}

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' ) {
			closePanel();
		}
	} );
}

/**
 * مدیریت ارسال فرم خبرنامه با AJAX.
 *
 * @since 1.0.0
 */
function initNewsletterForm() {
	const form = document.getElementById( 'baji-newsletter-form' );
	if ( ! form ) {
		return;
	}

	const messageEl = form.parentElement
		? form.parentElement.querySelector( '.baji-newsletter-message' )
		: null;

	const showMessage = ( text, isError ) => {
		if ( ! messageEl ) {
			return;
		}
		messageEl.textContent = text;
		messageEl.classList.remove( 'hidden' );
		messageEl.classList.toggle( 'text-red-500', Boolean( isError ) );
		messageEl.classList.toggle( 'text-baji-gold', ! isError );
	};

	form.addEventListener( 'submit', async ( event ) => {
		event.preventDefault();

		if ( typeof window.bajistyleWC === 'undefined' ) {
			return;
		}

		const emailInput = form.querySelector( 'input[name="newsletter_email"]' );
		const nonceInput = form.querySelector( 'input[name="baji_newsletter_nonce"]' );
		const submitButton = form.querySelector( 'button[type="submit"]' );

		if ( ! emailInput || ! emailInput.value ) {
			showMessage( window.bajistyleWC.i18n.error || 'خطایی رخ داد.', true );
			return;
		}

		if ( submitButton ) {
			submitButton.disabled = true;
		}

		try {
			const body = new URLSearchParams( {
				action: 'bajistyle_newsletter_subscribe',
				nonce: nonceInput ? nonceInput.value : '',
				email: emailInput.value,
			} );

			const response = await fetch( window.bajistyleWC.ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: body.toString(),
			} );

			const data = await response.json();

			if ( data.success ) {
				showMessage( data.data.message, false );
				form.reset();
			} else {
				showMessage( ( data.data && data.data.message ) || window.bajistyleWC.i18n.error, true );
			}
		} catch ( error ) {
			showMessage( window.bajistyleWC.i18n.error || 'خطایی رخ داد.', true );
		} finally {
			if ( submitButton ) {
				submitButton.disabled = false;
			}
		}
	} );
}

/**
 * مدیریت دکمه‌های افزودن/حذف علاقه‌مندی‌ها (هم در گرید محصول و هم در صفحه تکی).
 *
 * @since 1.0.0
 */
function initWishlistButtons() {
	const selectors = '.baji-quick-wishlist, .baji-wishlist-toggle-btn';

	document.addEventListener( 'click', async ( event ) => {
		const button = event.target.closest( selectors );
		if ( ! button ) {
			return;
		}

		event.preventDefault();

		if ( typeof window.bajistyleWC === 'undefined' ) {
			return;
		}

		const productId = button.dataset.productId;
		if ( ! productId ) {
			return;
		}

		button.disabled = true;
		button.setAttribute( 'aria-busy', 'true' );

		try {
			const body = new URLSearchParams( {
				action: 'bajistyle_toggle_wishlist',
				nonce: window.bajistyleWC.nonce,
				product_id: productId,
			} );

			const response = await fetch( window.bajistyleWC.ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: body.toString(),
			} );

			const data = await response.json();

			if ( data.success ) {
				const isAdded = data.data.added;
				const wishlistPage = button.closest( '.baji-account-wishlist' );

				// به‌روزرسانی تمام دکمه‌های مرتبط با همین محصول در صفحه (گرید + صفحه تکی).
				document
					.querySelectorAll( `${ selectors }[data-product-id="${ productId }"]` )
					.forEach( ( relatedButton ) => {
						relatedButton.dataset.inWishlist = isAdded ? '1' : '0';
						relatedButton.setAttribute( 'aria-pressed', isAdded ? 'true' : 'false' );
						relatedButton.setAttribute(
							'aria-label',
							isAdded
								? window.bajistyleWC.i18n.removeFromWishlist
								: window.bajistyleWC.i18n.addToWishlist
						);

						const icon = relatedButton.querySelector( '.baji-wishlist-icon' );
						if ( icon ) {
							icon.classList.toggle( 'fa-solid', isAdded );
							icon.classList.toggle( 'fa-regular', ! isAdded );
							icon.classList.toggle( 'text-rose-600', isAdded );
							icon.classList.toggle( 'text-gray-700', ! isAdded );
						}

						const label = relatedButton.querySelector( '.baji-wishlist-label' );
						if ( label ) {
							label.textContent = isAdded
								? window.bajistyleWC.i18n.removeFromWishlist
								: window.bajistyleWC.i18n.addToWishlist;
						}
					} );

				// به‌روزرسانی شمارنده علاقه‌مندی‌ها در هدر.
				const wishlistCountEl = document.querySelector( '.baji-wishlist-count' );
				if ( wishlistCountEl ) {
					wishlistCountEl.textContent = data.data.count;
				}

				if ( wishlistPage && ! data.data.added ) {
					const grid = wishlistPage.querySelector( '[data-wishlist-grid]' );
					const item = button.closest( '.baji-wishlist-item' );
					const emptyState = wishlistPage.querySelector( '[data-wishlist-empty]' );
					const pageCount = wishlistPage.querySelector( '[data-wishlist-count]' );
					const status = wishlistPage.querySelector( '[data-wishlist-status]' );

					if ( pageCount ) pageCount.textContent = data.data.count;
					if ( status ) status.textContent = window.bajistyleWC.i18n.removeFromWishlist;
					if ( item ) {
						item.classList.add( 'is-removing' );
						window.setTimeout( () => item.remove(), 220 );
					}
					if ( Number( data.data.count ) === 0 ) {
						window.setTimeout( () => {
							if ( grid ) grid.classList.add( 'hidden' );
							if ( emptyState ) emptyState.classList.remove( 'hidden' );
						}, 220 );
					}
				}
			}
		} catch ( error ) {
			// خطای شبکه به‌آرامی نادیده گرفته می‌شود تا تجربه کاربر مختل نشود.
			window.console.error( 'BajiStyle wishlist error:', error );
		} finally {
			button.disabled = false;
			button.removeAttribute( 'aria-busy' );
		}
	} );
}

/**
 * مقداردهی اولیه تمام ماژول‌های صفحه پس از آماده شدن DOM.
 *
 * @since 1.0.0
 */
function initBajiStyle() {
	initHeaderScrollEffect();
	initSearchPanel();
	initNewsletterForm();
	initWishlistButtons();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initBajiStyle );
} else {
	initBajiStyle();
}


document.addEventListener('DOMContentLoaded', function () {
    const productsSlider = new Swiper('.baji-products-slider', {
        // تنظیمات پیش‌فرض (برای موبایل)
        slidesPerView: 1.6,      
        spaceBetween: 12,      // فاصله بین محصولات در موبایل (کمی کمتر کردم تا جا بشوند)
        
        // تنظیمات ریسپانسیو برای تبلت و دسکتاپ
        breakpoints: {
            768: { // معادل md در تیلوند
                slidesPerView: 4,
                spaceBetween: 20,
            },
            1024: { // معادل lg در تیلوند
                slidesPerView: 6,
                spaceBetween: 24,
            }
        },

        // فعال‌سازی نقاط پایین
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        // فعال‌سازی دکمه‌های ناوبری
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});




/**
 * اسکریپت اسلایدر هیرو به همراه انیمیشن محتوا
 */
// راه‌اندازی اسلایدر هیرو با Swiper
document.addEventListener('DOMContentLoaded', function () {
    const heroElement = document.querySelector('.baji-hero-swiper');
    if (!heroElement) return;

    const heroSwiper = new Swiper('.baji-hero-swiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        grabCursor: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        navigation: {
            nextEl: '.baji-hero-next',
            prevEl: '.baji-hero-prev',
        },
        pagination: {
            el: '.baji-hero-pagination',
            clickable: true,
        },
    });
});
