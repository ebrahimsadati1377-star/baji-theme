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
	const input = document.getElementById( 'baji-pro-search-input' );
	const results = document.getElementById( 'baji-live-search-results' );
	const status = document.getElementById( 'baji-live-search-status' );
	const chips = document.querySelectorAll( '.baji-search-chip' );
	let timer = null;
	let controller = null;

	if ( ! toggleButton || ! searchPanel ) return;

	const openPanel = () => {
		searchPanel.classList.remove( '-translate-y-full' );
		searchPanel.setAttribute( 'aria-hidden', 'false' );
		toggleButton.setAttribute( 'aria-expanded', 'true' );
		if ( backdrop ) backdrop.classList.remove( 'hidden' );
		window.setTimeout( () => input && input.focus(), 220 );
	};

	const closePanel = () => {
		searchPanel.classList.add( '-translate-y-full' );
		searchPanel.setAttribute( 'aria-hidden', 'true' );
		toggleButton.setAttribute( 'aria-expanded', 'false' );
		if ( backdrop ) backdrop.classList.add( 'hidden' );
	};

	const money = ( price ) => {
		if ( ! price ) return '';
		const raw = Number( price );
		if ( ! Number.isFinite( raw ) ) return '';
		return new Intl.NumberFormat( 'fa-IR' ).format( raw ) + ' تومان';
	};

	const render = ( items ) => {
		if ( ! results ) return;
		results.innerHTML = '';
		if ( ! items.length ) {
			if ( status ) { status.textContent = 'محصولی پیدا نشد.'; status.classList.remove('hidden'); }
			return;
		}
		if ( status ) status.classList.add('hidden');
		items.forEach( ( p ) => {
			const img = p.images && p.images[0] ? p.images[0].thumbnail || p.images[0].src : '';
			const price = p.prices && p.prices.price ? Number(p.prices.price) / Math.pow(10, p.prices.currency_minor_unit || 0) : null;
			const regular = p.prices && p.prices.regular_price ? Number(p.prices.regular_price) / Math.pow(10, p.prices.currency_minor_unit || 0) : null;
			const sale = regular && price && price < regular;
			const card = document.createElement('a');
			card.href = p.permalink || '#';
			card.className = 'baji-live-result';
			card.innerHTML =
				'<div class="baji-live-result__img">' +
					( img ? '<img src="' + img + '" alt="" loading="lazy">' : '<span>BAJI</span>' ) +
				'</div>' +
				'<div class="baji-live-result__body">' +
					'<div class="baji-live-result__name">' + (p.name || '') + '</div>' +
					'<div class="baji-live-result__price">' +
						( sale ? '<del>' + money(regular) + '</del>' : '' ) +
						'<strong>' + money(price) + '</strong>' +
					'</div>' +
				'</div>';
			results.appendChild(card);
		});
	};

	const searchProducts = async ( q ) => {
		if ( ! q || q.trim().length < 2 ) {
			if ( results ) results.innerHTML = '';
			if ( status ) status.classList.add('hidden');
			return;
		}
		if ( controller ) controller.abort();
		controller = new AbortController();
		if ( status ) { status.textContent = 'در حال جستجو...'; status.classList.remove('hidden'); }
		try {
			const url = '/wp-json/wc/store/v1/products?per_page=6&search=' + encodeURIComponent(q.trim());
			const res = await fetch(url,{signal:controller.signal});
			if(!res.ok) throw new Error('search failed');
			const data = await res.json();
			render(Array.isArray(data)?data:[]);
		} catch(e) {
			if(e.name==='AbortError') return;
			if ( status ) { status.textContent = 'جستجو موقتاً در دسترس نیست.'; status.classList.remove('hidden'); }
		}
	};

	toggleButton.addEventListener( 'click', () => {
		const isOpen = toggleButton.getAttribute( 'aria-expanded' ) === 'true';
		isOpen ? closePanel() : openPanel();
	} );
	if ( closeButton ) closeButton.addEventListener( 'click', closePanel );
	if ( backdrop ) backdrop.addEventListener( 'click', closePanel );
	document.addEventListener( 'keydown', ( event ) => { if ( event.key === 'Escape' ) closePanel(); } );

	if ( input ) {
		input.addEventListener('input',() => {
			clearTimeout(timer);
			timer = setTimeout(() => searchProducts(input.value), 260);
		});
	}
	chips.forEach(chip => chip.addEventListener('click',() => {
		if(!input) return;
		input.value = chip.textContent.trim();
		searchProducts(input.value);
		input.focus();
	}));
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
function initWishlistShortcut() {
	const bottomNav = document.querySelector('.baji-mobile-bottom-nav');
	if ( bottomNav && ! bottomNav.querySelector('.baji-mobile-wishlist') ) {
		const link = document.createElement('a');
		link.href = '/my-account/wishlist/';
		link.className = 'baji-mobile-wishlist flex flex-col items-center justify-center gap-1 text-gray-500 flex-1';
		link.setAttribute('aria-label','علاقه‌مندی‌ها');
		link.innerHTML = '<i class="far fa-heart text-xl"></i><span class="text-[10px]">علاقه‌مندی‌ها</span>';
		const cart = bottomNav.querySelector('.baji-cart-toggle');
		if ( cart ) {
			bottomNav.insertBefore(link, cart);
		} else {
			bottomNav.appendChild(link);
		}
	}

	const actions = document.querySelector('.baji-header-actions');
	if ( actions && ! actions.querySelector('.baji-header-wishlist') ) {
		const link = document.createElement('a');
		link.href = '/my-account/wishlist/';
		link.className = 'baji-header-wishlist relative flex items-center justify-center';
		link.setAttribute('aria-label','علاقه‌مندی‌ها');
		link.title = 'علاقه‌مندی‌ها';
		link.innerHTML = '<i class="far fa-heart"></i>';
		const cart = actions.querySelector('.baji-cart-toggle');
		if ( cart ) {
			actions.insertBefore(link, cart);
		} else {
			actions.appendChild(link);
		}
	}
}

function initBajiStyle() {
	initHeaderScrollEffect();
	initSearchPanel();
	initNewsletterForm();
	initWishlistButtons();
	initWishlistShortcut();
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
