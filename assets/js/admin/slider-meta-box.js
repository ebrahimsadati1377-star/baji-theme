/**
 * مدیریت آپلودگر تصویر اختصاصی موبایل در صفحه ویرایش اسلاید (پیشخوان وردپرس)
 *
 * این فایل فقط در صفحه ویرایش/افزودن پست از نوع baji_slider بارگذاری
 * می‌شود (به bajistyle_slider_admin_assets در inc/custom-post-types.php
 * مراجعه کنید) و از wp.media (کتابخانه رسانه استاندارد وردپرس) برای
 * انتخاب تصویر استفاده می‌کند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/* global jQuery, wp */

jQuery( function ( $ ) {
	'use strict';

	if ( typeof wp === 'undefined' || typeof wp.media === 'undefined' ) {
		return;
	}

	const i18n = typeof window.bajistyleSliderAdmin !== 'undefined'
		? window.bajistyleSliderAdmin
		: {
			mediaTitle: 'انتخاب تصویر موبایل',
			mediaButtonText: 'استفاده از این تصویر',
			selectLabel: 'انتخاب تصویر موبایل',
			changeLabel: 'تغییر تصویر موبایل',
		};

	let mediaFrame = null;

	const selectButton = document.getElementById( 'bajistyle-select-mobile-image' );
	const removeButton = document.getElementById( 'bajistyle-remove-mobile-image' );
	const hiddenInput = document.getElementById( 'bajistyle_mobile_image_id' );
	const previewWrapper = document.getElementById( 'bajistyle-mobile-image-preview' );

	if ( ! selectButton || ! hiddenInput || ! previewWrapper ) {
		return;
	}

	selectButton.addEventListener( 'click', ( event ) => {
		event.preventDefault();

		// استفاده مجدد از فریم رسانه در صورت باز بودن قبلی (بهینه‌سازی حافظه).
		if ( mediaFrame ) {
			mediaFrame.open();
			return;
		}

		mediaFrame = wp.media( {
			title: i18n.mediaTitle,
			button: { text: i18n.mediaButtonText },
			library: { type: 'image' },
			multiple: false,
		} );

		mediaFrame.on( 'select', () => {
			const attachment = mediaFrame.state().get( 'selection' ).first().toJSON();
			const imageUrl = ( attachment.sizes && attachment.sizes.medium )
				? attachment.sizes.medium.url
				: attachment.url;

			hiddenInput.value = attachment.id;

			let img = previewWrapper.querySelector( 'img' );
			if ( ! img ) {
				img = document.createElement( 'img' );
				img.style.maxWidth = '100%';
				img.style.height = 'auto';
				previewWrapper.appendChild( img );
			}
			img.src = imageUrl;
			img.style.display = '';

			selectButton.textContent = i18n.changeLabel;

			if ( removeButton ) {
				removeButton.style.display = '';
			}
		} );

		mediaFrame.open();
	} );

	if ( removeButton ) {
		removeButton.addEventListener( 'click', ( event ) => {
			event.preventDefault();

			hiddenInput.value = '';

			const img = previewWrapper.querySelector( 'img' );
			if ( img ) {
				img.style.display = 'none';
				img.removeAttribute( 'src' );
			}

			selectButton.textContent = i18n.selectLabel;
			removeButton.style.display = 'none';
		} );
	}
} );
