/**
 * مدیریت آپلودر ویدیو در صفحه ویرایش محصول (پیشخوان وردپرس)
 *
 * این فایل فقط در صفحه ویرایش/افزودن پست از نوع product بارگذاری
 * می‌شود (به bajistyle_product_video_admin_assets در inc/product-video.php
 * مراجعه کنید) و از wp.media (کتابخانه رسانه استاندارد وردپرس) برای
 * انتخاب ویدیو استفاده می‌کند.
 *
 * @package BajiStyle
 * @since 1.0.6
 */

/* global jQuery, wp */

jQuery( function ( $ ) {
	'use strict';

	if ( typeof wp === 'undefined' || typeof wp.media === 'undefined' ) {
		return;
	}

	const i18n = typeof window.bajistyleProductVideoAdmin !== 'undefined'
		? window.bajistyleProductVideoAdmin
		: {
			mediaTitle:      'انتخاب ویدیوی محصول',
			mediaButtonText: 'استفاده از این ویدیو',
			selectLabel:     'انتخاب ویدیو',
			changeLabel:     'تغییر ویدیو',
		};

	let mediaFrame = null;

	const selectButton  = document.getElementById( 'bajistyle-select-video' );
	const removeButton  = document.getElementById( 'bajistyle-remove-video' );
	const hiddenInput   = document.getElementById( 'bajistyle_product_video_id' );
	const previewWrapper = document.getElementById( 'bajistyle-video-preview' );

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
			title:    i18n.mediaTitle,
			button:   { text: i18n.mediaButtonText },
			library:  { type: 'video' }, // فقط ویدیوها
			multiple: false,
		} );

		mediaFrame.on( 'select', () => {
			const attachment = mediaFrame.state().get( 'selection' ).first().toJSON();
			const videoUrl   = attachment.url;

			hiddenInput.value = attachment.id;

			// پیش‌نمایش ویدیو
			let videoEl = previewWrapper.querySelector( 'video' );
			if ( ! videoEl ) {
				videoEl = document.createElement( 'video' );
				videoEl.controls = true;
				videoEl.style.maxWidth = '100%';
				videoEl.style.height = 'auto';
				videoEl.style.borderRadius = '8px';
				videoEl.style.display = 'block';
				previewWrapper.appendChild( videoEl );
			}
			videoEl.src = videoUrl;
			videoEl.style.display = '';

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

			const videoEl = previewWrapper.querySelector( 'video' );
			if ( videoEl ) {
				videoEl.remove();
			}

			selectButton.textContent = i18n.selectLabel;
			removeButton.style.display = 'none';
		} );
	}
} );