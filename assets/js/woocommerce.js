/**
 * منطق عمومی ووکامرس قالب BajiStyle
 *
 * این فایل صرفاً برای صفحات دارای ووکامرس بارگذاری می‌شود (به شرط
 * enqueue شرطی در functions.php) و شامل تعامل گالری تصاویر محصول و
 * هماهنگی رویدادهای پایه ووکامرس با رابط کاربری قالب است.
 *
 * توجه: قابلیت زوم تصویر (wc-product-gallery-zoom) و اسلایدر گالری
 * (wc-product-gallery-slider) توسط اسکریپت‌های هسته ووکامرس
 * (zoom.js و flexslider) که از طریق add_theme_support فعال شده‌اند
 * مدیریت می‌شوند؛ این فایل مکمل آن‌ها برای رفتارهای اختصاصی قالب است.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/* global jQuery */

/**
 * هماهنگی کلاس‌های ظاهری دکمه‌های انتخاب سایز/رنگ با Tailwind.
 *
 * ووکامرس به‌صورت پیش‌فرض dropdown متنی برای ویژگی‌های محصول متغیر
 * تولید می‌کند (که در inc/woocommerce-hooks.php استایل پایه گرفته است).
 * این تابع وضعیت انتخاب فعلی را برای واریانت‌های ناموجود غیرفعال
 * نمایش می‌دهد.
 *
 * @since 1.0.0
 */
function initVariationFeedback() {
	const forms = document.querySelectorAll( '.variations_form' );

	if ( ! forms.length || typeof window.jQuery === 'undefined' ) {
		return;
	}

	forms.forEach( ( formEl ) => {
		const $form = window.jQuery( formEl );

		$form.on( 'show_variation', ( event, variation ) => {
			const addToCartButton = formEl.querySelector( '.single_add_to_cart_button' );
			if ( addToCartButton && variation && variation.is_in_stock ) {
				addToCartButton.classList.remove( 'opacity-50', 'pointer-events-none' );
			}
		} );

		$form.on( 'hide_variation', () => {
			const addToCartButton = formEl.querySelector( '.single_add_to_cart_button' );
			if ( addToCartButton ) {
				addToCartButton.classList.add( 'opacity-50', 'pointer-events-none' );
			}
		} );
	} );
}

/**
 * نمایش پیام موفقیت کوتاه پس از افزودن محصول به سبد (بدون رفرش صفحه).
 *
 * این تابع به رویداد استاندارد jQuery ووکامرس (added_to_cart) گوش
 * می‌دهد که پس از AJAX add-to-cart در گرید محصولات شلیک می‌شود.
 *
 * @since 1.0.0
 */
function initAddToCartFeedback() {
	if ( typeof window.jQuery === 'undefined' ) {
		return;
	}

	window.jQuery( document.body ).on( 'added_to_cart', () => {
		const message = window.bajistyleWC && window.bajistyleWC.i18n
			? window.bajistyleWC.i18n.addedToCart
			: 'به سبد خرید اضافه شد';

		showBajiToast( message );
	} );
}

/**
 * کپی کد تخفیف خرید اول و نمایش بازخورد کوتاه.
 */
function initCouponCopy() {
	document.querySelectorAll( '.baji-copy-coupon' ).forEach( ( button ) => {
		button.addEventListener( 'click', async () => {
			const coupon = button.dataset.coupon || '';
			if ( ! coupon ) {
				return;
			}

			try {
				await navigator.clipboard.writeText( coupon );
				showBajiToast( 'کد تخفیف کپی شد' );
			} catch ( error ) {
				showBajiToast( coupon );
			}
		} );
	} );
}

/**
 * نمایش یک پیام کوتاه (Toast) گوشه صفحه برای بازخورد سریع به کاربر.
 *
 * @param {string} message متن پیام.
 * @since 1.0.0
 */
function showBajiToast( message ) {
	let toast = document.getElementById( 'baji-toast' );

	if ( ! toast ) {
		toast = document.createElement( 'div' );
		toast.id = 'baji-toast';
		toast.setAttribute( 'role', 'status' );
		toast.setAttribute( 'aria-live', 'polite' );
		toast.className =
			'fixed bottom-6 left-1/2 -translate-x-1/2 z-[200] bg-baji-black text-baji-white text-sm px-6 py-3 opacity-0 transition-opacity duration-300 pointer-events-none';
		document.body.appendChild( toast );
	}

	toast.textContent = message;
	toast.classList.remove( 'opacity-0' );
	toast.classList.add( 'opacity-100' );

	window.clearTimeout( toast._bajiTimeout ); // eslint-disable-line no-underscore-dangle
	toast._bajiTimeout = window.setTimeout( () => { // eslint-disable-line no-underscore-dangle
		toast.classList.remove( 'opacity-100' );
		toast.classList.add( 'opacity-0' );
	}, 2500 );
}

/**
 * مقداردهی اولیه ماژول‌های اختصاصی ووکامرس.
 *
 * @since 1.0.0
 */

/**
 * اطمینان از راه‌اندازی گالری تصاویر محصول.
 *
 * در بعضی ترکیب‌های کش/دیفر، اسکریپت WooCommerce قبل از آماده‌شدن
 * وابستگی‌ها اجرا نمی‌شود و فقط تصویر اول دیده می‌شود. این تابع ابتدا
 * راه‌اندازی رسمی WooCommerce را دوباره امتحان می‌کند و اگر باز هم
 * FlexSlider ساخته نشد، یک fallback سبک با thumbnail ایجاد می‌کند.
 *
 * @since 1.0.73
 */
function initProductGalleryFallback() {
	const galleries = document.querySelectorAll( '.woocommerce-product-gallery' );

	galleries.forEach( ( gallery ) => {
		const images = Array.from( gallery.querySelectorAll( '.woocommerce-product-gallery__image' ) );
		if ( images.length < 2 ) {
			return;
		}

		const hasWooSlider = () =>
			gallery.querySelector( '.flex-viewport' ) ||
			gallery.querySelector( '.flex-control-thumbs' );

		const retryWooGallery = () => {
			if ( hasWooSlider() ) {
				return true;
			}

			if (
				typeof window.jQuery !== 'undefined' &&
				window.jQuery.fn &&
				typeof window.jQuery.fn.wc_product_gallery === 'function'
			) {
				try {
					window.jQuery( gallery ).wc_product_gallery( window.wc_single_product_params || {} );
				} catch ( error ) {
					// fallback دستی پایین‌تر اجرا می‌شود.
				}
			}

			return !! hasWooSlider();
		};

		// یک بار بعد از DOM ready و بار دیگر بعد از تکمیل load تلاش می‌کنیم.
		window.setTimeout( () => {
			if ( retryWooGallery() ) {
				return;
			}

			window.setTimeout( () => {
				if ( retryWooGallery() ) {
					return;
				}

				// اگر هسته WooCommerce همچنان گالری را نسازد، fallback ساده و مستقل.
				if ( gallery.classList.contains( 'baji-gallery-fallback-ready' ) ) {
					return;
				}

				gallery.classList.add( 'baji-gallery-fallback-ready' );
				let activeIndex = 0;

				const wrapper = gallery.querySelector( '.woocommerce-product-gallery__wrapper' );
				if ( ! wrapper ) {
					return;
				}

				images.forEach( ( item, index ) => {
					item.style.display = index === 0 ? 'block' : 'none';
				} );

				const thumbs = document.createElement( 'ol' );
				thumbs.className = 'flex-control-thumbs baji-fallback-thumbs';

				images.forEach( ( item, index ) => {
					const img = item.querySelector( 'img' );
					if ( ! img ) {
						return;
					}

					const li = document.createElement( 'li' );
					const thumb = document.createElement( 'img' );
					thumb.src = item.dataset.thumb || img.currentSrc || img.src;
					thumb.alt = item.dataset.thumbAlt || img.alt || '';
					thumb.loading = 'lazy';
					if ( index === 0 ) {
						thumb.classList.add( 'flex-active' );
					}

					thumb.addEventListener( 'click', () => {
						images[ activeIndex ].style.display = 'none';
						const oldThumb = thumbs.querySelector( 'img.flex-active' );
						if ( oldThumb ) {
							oldThumb.classList.remove( 'flex-active' );
						}

						activeIndex = index;
						images[ activeIndex ].style.display = 'block';
						thumb.classList.add( 'flex-active' );
					} );

					li.appendChild( thumb );
					thumbs.appendChild( li );
				} );

				wrapper.insertAdjacentElement( 'afterend', thumbs );
			}, 900 );
		}, 250 );
	} );
}

function initBajiStyleWooCommerce() {
	initVariationFeedback();
	initAddToCartFeedback();
	initCouponCopy();
	initProductGalleryFallback();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initBajiStyleWooCommerce );
} else {
	initBajiStyleWooCommerce();
}


/**
 * Enable touch swipe navigation for WooCommerce product galleries.
 * Keeps the current gallery UI and adds left/right swipe on mobile.
 */
function initProductGallerySwipe() {
  document.querySelectorAll('.woocommerce-product-gallery').forEach(function(gallery) {
    if (gallery.dataset.bajiSwipeReady === '1') return;
    gallery.dataset.bajiSwipeReady = '1';

    var startX = 0;
    var startY = 0;
    var tracking = false;

    function getThumbs() {
      return Array.from(gallery.querySelectorAll('.flex-control-thumbs img'));
    }

    function getActiveIndex(thumbs) {
      var idx = thumbs.findIndex(function(img) {
        return img.classList.contains('flex-active');
      });
      return idx >= 0 ? idx : 0;
    }

    function go(delta) {
      var thumbs = getThumbs();
      if (thumbs.length < 2) return;

      var current = getActiveIndex(thumbs);
      var next = current + delta;
      if (next < 0) next = thumbs.length - 1;
      if (next >= thumbs.length) next = 0;

      thumbs[next].dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));
    }

    gallery.addEventListener('touchstart', function(e) {
      if (!e.touches || e.touches.length !== 1) return;
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;
      tracking = true;
    }, { passive: true });

    gallery.addEventListener('touchend', function(e) {
      if (!tracking || !e.changedTouches || !e.changedTouches.length) return;
      tracking = false;

      var dx = e.changedTouches[0].clientX - startX;
      var dy = e.changedTouches[0].clientY - startY;

      if (Math.abs(dx) < 45 || Math.abs(dx) <= Math.abs(dy)) return;

      // RTL-friendly: swipe left => next, swipe right => previous.
      go(dx < 0 ? 1 : -1);
    }, { passive: true });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initProductGallerySwipe);
} else {
  initProductGallerySwipe();
}


/**
 * Product 5117: direct swipe through the seven final distinct BAJI images.
 * This bypasses stale/duplicate WordPress media records while keeping the
 * visible product page clean and swipeable on mobile.
 */
function initBajiDirectSwipe5117() {
  if (!document.body.classList.contains('postid-5117')) return;

  var gallery = document.querySelector('.woocommerce-product-gallery');
  if (!gallery || gallery.dataset.bajiDirectSwipeReady === '1') return;
  gallery.dataset.bajiDirectSwipeReady = '1';

  var images = [
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-01-20261103-175137-4d212f.jpg',
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-02-20261103-175423-fb329a.jpg',
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-03-20261103-175456-2515e0.jpg',
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-04-20261103-175459-eb08a8.jpg',
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-05-20261103-175503-1bd0f3.jpg',
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-06-20261103-175507-447377.jpg',
    'https://manage.bajistyle.ir/uploads/chatgpt/baji-bag-final-07-20261103-175510-b09c58.jpg'
  ];

  var index = 0;
  var startX = 0;
  var startY = 0;
  var tracking = false;

  function getMainImage() {
    return gallery.querySelector(
      '.woocommerce-product-gallery__image.flex-active-slide img, ' +
      '.woocommerce-product-gallery__image img, img.wp-post-image'
    );
  }

  function render() {
    var img = getMainImage();
    if (!img) return;

    var src = images[index];
    img.src = src;
    img.srcset = '';
    img.removeAttribute('sizes');

    var link = img.closest('a');
    if (link) link.href = src;

    gallery.dataset.bajiDirectSwipeIndex = String(index);
  }

  gallery.style.touchAction = 'pan-y';
  render();

  gallery.addEventListener('touchstart', function(e) {
    if (!e.touches || e.touches.length !== 1) return;
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
    tracking = true;
  }, { passive: true });

  gallery.addEventListener('touchend', function(e) {
    if (!tracking || !e.changedTouches || !e.changedTouches.length) return;
    tracking = false;

    var dx = e.changedTouches[0].clientX - startX;
    var dy = e.changedTouches[0].clientY - startY;

    if (Math.abs(dx) < 45 || Math.abs(dx) <= Math.abs(dy)) return;

    index += dx < 0 ? 1 : -1;
    if (index < 0) index = images.length - 1;
    if (index >= images.length) index = 0;

    render();
  }, { passive: true });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initBajiDirectSwipe5117);
} else {
  initBajiDirectSwipe5117();
}
