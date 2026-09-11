/**
 * مدیریت ناوبری قالب BajiStyle (منوی موبایل و مگامنو)
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/**
 * باز و بسته کردن منوی موبایل با کنترل overlay و دسترسی‌پذیری.
 * Overlay اختیاری است تا نبودن آن مانع کارکرد دکمه همبرگری نشود.
 *
 * @since 1.0.0
 */
function initMobileMenu() {
	const toggleButton = document.querySelector( '.baji-mobile-menu-toggle' );
	const closeButton = document.querySelector( '.baji-mobile-menu-close' );
	const menu = document.getElementById( 'baji-mobile-menu' );
	const overlay = document.getElementById( 'baji-mobile-overlay' );

	if ( ! toggleButton || ! menu ) {
		return;
	}

	const openMenu = () => {
		menu.classList.remove( 'translate-x-full' );
		if ( overlay ) {
			overlay.classList.remove( 'opacity-0', 'pointer-events-none' );
		}
		menu.setAttribute( 'aria-hidden', 'false' );
		toggleButton.setAttribute( 'aria-expanded', 'true' );
		document.body.style.overflow = 'hidden';
	};

	const closeMenu = () => {
		menu.classList.add( 'translate-x-full' );
		if ( overlay ) {
			overlay.classList.add( 'opacity-0', 'pointer-events-none' );
		}
		menu.setAttribute( 'aria-hidden', 'true' );
		toggleButton.setAttribute( 'aria-expanded', 'false' );
		document.body.style.overflow = '';
	};

	toggleButton.addEventListener( 'click', openMenu );

	if ( closeButton ) {
		closeButton.addEventListener( 'click', closeMenu );
	}

	if ( overlay ) {
		overlay.addEventListener( 'click', closeMenu );
	}

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' && menu.getAttribute( 'aria-hidden' ) === 'false' ) {
			closeMenu();
		}
	} );
}

/**
 * مدیریت نمایش/مخفی‌سازی پنل مگامنو با هاور و فوکوس کیبورد.
 *
 * استفاده از تأخیر کوتاه (debounce) برای جلوگیری از پرش ناخواسته
 * پنل هنگام عبور سریع موس از روی آیتم‌های منو.
 *
 * @since 1.0.0
 */
function initMegaMenu() {
	const menuItems = document.querySelectorAll( '.baji-has-mega' );

	if ( ! menuItems.length ) {
		return;
	}

	let closeTimeout = null;

	menuItems.forEach( ( item ) => {
		const panel = item.querySelector( '.baji-mega-menu-panel' );
		if ( ! panel ) {
			return;
		}

		const openPanel = () => {
			if ( closeTimeout ) {
				window.clearTimeout( closeTimeout );
				closeTimeout = null;
			}
			panel.classList.remove( 'opacity-0', 'invisible', 'translate-y-2' );
		};

		const closePanel = () => {
			closeTimeout = window.setTimeout( () => {
				panel.classList.add( 'opacity-0', 'invisible', 'translate-y-2' );
			}, 150 );
		};

		item.addEventListener( 'mouseenter', openPanel );
		item.addEventListener( 'mouseleave', closePanel );
		item.addEventListener( 'focusin', openPanel );
		item.addEventListener( 'focusout', ( event ) => {
			if ( ! item.contains( event.relatedTarget ) ) {
				closePanel();
			}
		} );
	} );
}

/**
 * مقداردهی اولیه فیلترهای موبایل صفحه آرشیو فروشگاه (نمایش/مخفی‌سازی).
 *
 * @since 1.0.0
 */
function initShopFiltersToggle() {
	const toggleButton = document.querySelector( '.baji-filters-mobile-toggle' );
	const content = document.getElementById( 'baji-filters-content' );

	if ( ! toggleButton || ! content ) {
		return;
	}

	const isDesktop = () => window.matchMedia( '(min-width: 1024px)' ).matches;

	if ( ! isDesktop() ) {
		content.classList.add( 'hidden' );
	}

	toggleButton.addEventListener( 'click', () => {
		const isHidden = content.classList.contains( 'hidden' );
		content.classList.toggle( 'hidden' );
		toggleButton.setAttribute( 'aria-expanded', isHidden ? 'true' : 'false' );
	} );

	window.addEventListener( 'resize', () => {
		if ( isDesktop() ) {
			content.classList.remove( 'hidden' );
		}
	} );
}

/**
 * مقداردهی اولیه تمام ماژول‌های ناوبری.
 *
 * @since 1.0.0
 */
function initBajiStyleNavigation() {
	initMobileMenu();
	initMegaMenu();
	initShopFiltersToggle();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initBajiStyleNavigation );
} else {
	initBajiStyleNavigation();
}
