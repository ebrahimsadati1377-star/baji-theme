/**
 * مدیریت ناوبری قالب BajiStyle (منوی موبایل و مگامنو)
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/**
 * باز و بسته کردن منوی موبایل با کنترل overlay و دسترسی‌پذیری.
 * Overlay اختیاری است تا نبودن آن مانع کارکرد دکمه همبرگری نشود.
 */
function initMobileMenu() {
	const state = document.getElementById( 'baji-menu-state' );
	const toggleButton = document.getElementById( 'baji-mobile-menu-toggle' );
	const closeButton = document.getElementById( 'baji-mobile-menu-close' );
	const menu = document.getElementById( 'baji-mobile-menu' );

	if ( ! state || ! toggleButton || ! menu ) return;

	let lastFocused = null;

	const syncMenuState = () => {
		const isOpen = Boolean( state.checked );
		menu.setAttribute( 'aria-hidden', isOpen ? 'false' : 'true' );
		toggleButton.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		document.body.classList.toggle( 'baji-mobile-menu-open', isOpen );
		document.body.style.overflow = isOpen ? 'hidden' : '';

		if ( isOpen ) {
			lastFocused = document.activeElement;
			window.setTimeout( () => {
				if ( closeButton ) closeButton.focus();
			}, 60 );
		} else if ( lastFocused && typeof lastFocused.focus === 'function' ) {
			window.setTimeout( () => lastFocused.focus(), 20 );
		}
	};

	state.addEventListener( 'change', syncMenuState );

	menu.querySelectorAll( 'a' ).forEach( ( link ) => {
		link.addEventListener( 'click', () => {
			state.checked = false;
			syncMenuState();
		} );
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' && state.checked ) {
			state.checked = false;
			syncMenuState();
		}
	} );

	syncMenuState();
}

function initMegaMenu() {
	const menuItems = document.querySelectorAll( '.baji-has-mega' );
	if ( ! menuItems.length ) return;
	let closeTimeout = null;

	menuItems.forEach( ( item ) => {
		const panel = item.querySelector( '.baji-mega-menu-panel' );
		if ( ! panel ) return;

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
			if ( ! item.contains( event.relatedTarget ) ) closePanel();
		} );
	} );
}

function initShopFiltersToggle() {
	const toggleButton = document.querySelector( '.baji-filters-mobile-toggle' );
	const content = document.getElementById( 'baji-filters-content' );
	if ( ! toggleButton || ! content ) return;

	const isDesktop = () => window.matchMedia( '(min-width: 1024px)' ).matches;
	if ( ! isDesktop() ) content.classList.add( 'hidden' );

	toggleButton.addEventListener( 'click', () => {
		const isHidden = content.classList.contains( 'hidden' );
		content.classList.toggle( 'hidden' );
		toggleButton.setAttribute( 'aria-expanded', isHidden ? 'true' : 'false' );
	} );

	window.addEventListener( 'resize', () => {
		if ( isDesktop() ) content.classList.remove( 'hidden' );
	} );
}

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
