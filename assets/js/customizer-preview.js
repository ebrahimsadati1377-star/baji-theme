/**
 * اسکریپت پیش‌نمایش زنده Customizer قالب BajiStyle
 *
 * این فایل فقط داخل iframe پیش‌نمایش Customizer وردپرس بارگذاری
 * می‌شود (از طریق customize_preview_init در inc/customizer.php) و
 * تغییرات رنگ، عنوان هیرو و سایر تنظیمات postMessage را بدون رفرش
 * کامل صفحه نمایش می‌دهد.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/* global wp */

( function () {
	if ( typeof wp === 'undefined' || typeof wp.customize === 'undefined' ) {
		return;
	}

	// به‌روزرسانی رنگ طلایی برند.
	wp.customize( 'bajistyle_color_primary', ( value ) => {
		value.bind( ( newValue ) => {
			document.documentElement.style.setProperty( '--baji-gold', newValue );
		} );
	} );

	// به‌روزرسانی رنگ مشکی برند.
	wp.customize( 'bajistyle_color_dark', ( value ) => {
		value.bind( ( newValue ) => {
			document.documentElement.style.setProperty( '--baji-black', newValue );
		} );
	} );

	// به‌روزرسانی رنگ کرم روشن.
	wp.customize( 'bajistyle_color_cream', ( value ) => {
		value.bind( ( newValue ) => {
			document.documentElement.style.setProperty( '--baji-cream', newValue );
		} );
	} );

	// به‌روزرسانی متن عنوان هیرو (در صورت نبود اسلایدر فعال).
	wp.customize( 'bajistyle_hero_title', ( value ) => {
		value.bind( ( newValue ) => {
			const heroTitle = document.querySelector( '.baji-hero-static h1' );
			if ( heroTitle ) {
				heroTitle.textContent = newValue;
			}
		} );
	} );

	// به‌روزرسانی متن زیرعنوان هیرو.
	wp.customize( 'bajistyle_hero_subtitle', ( value ) => {
		value.bind( ( newValue ) => {
			const heroSubtitle = document.querySelector( '.baji-hero-static span' );
			if ( heroSubtitle ) {
				heroSubtitle.textContent = newValue;
			}
		} );
	} );

	// به‌روزرسانی متن دکمه هیرو.
	wp.customize( 'bajistyle_hero_button_text', ( value ) => {
		value.bind( ( newValue ) => {
			const heroButton = document.querySelector( '.baji-hero-static .baji-btn-primary' );
			if ( heroButton ) {
				heroButton.textContent = newValue;
			}
		} );
	} );

	// به‌روزرسانی عنوان داستان برند.
	wp.customize( 'bajistyle_brand_story_title', ( value ) => {
		value.bind( ( newValue ) => {
			const storyTitle = document.querySelector( '.baji-brand-story-content h2' );
			if ( storyTitle ) {
				storyTitle.textContent = newValue;
			}
		} );
	} );

	// به‌روزرسانی متن داستان برند.
	wp.customize( 'bajistyle_brand_story_text', ( value ) => {
		value.bind( ( newValue ) => {
			const storyText = document.querySelector( '.baji-brand-story-content p' );
			if ( storyText ) {
				storyText.textContent = newValue;
			}
		} );
	} );

	// به‌روزرسانی متن کپی‌رایت فوتر.
	wp.customize( 'bajistyle_footer_copyright', ( value ) => {
		value.bind( ( newValue ) => {
			const copyrightEl = document.querySelector( '.baji-footer-bottom p' );
			if ( copyrightEl ) {
				copyrightEl.textContent = newValue;
			}
		} );
	} );
} )();
