/**
 * اسکریپت اختصاصی صفحه تک‌محصول قالب BajiStyle
 *
 * شامل: افزودن به سبد خرید با AJAX (بدون رفرش صفحه)، سوییچ‌های
 * تصویری رنگ/سایز (Swatches)، دکمه‌های افزایش/کاهش تعداد، و لایت‌باکس
 * گالری تصاویر محصول.
 *
 * @package BajiStyle
 * @since 1.0.5
 */

/* global jQuery, wc_add_to_cart_params */

jQuery(function($) {

    const productGalleryThumbs = document.querySelector('.baji-product-gallery-wrapper .flex-control-thumbs');

    if (productGalleryThumbs) {
        ['touchstart', 'touchmove', 'touchend', 'pointerdown', 'pointermove', 'pointerup'].forEach(function(eventName) {
            productGalleryThumbs.addEventListener(eventName, function(event) {
                event.stopPropagation();
            }, { passive: true });
        });
    }

    /* =========================================================
     * BajiStyle AJAX Add To Cart (اصلاح انکودینگ فرم و ارسال استاندارد)
     * ========================================================= */

    document.addEventListener('submit', function(e) {
        const $form = jQuery(e.target);
        if (!$form.is('form.cart')) return;

        e.preventDefault();
        e.stopImmediatePropagation();

        const $button = $form.find('.single_add_to_cart_button').first();

        if (!$button.length || $button.hasClass('loading') || $button.prop('disabled')) {
            return;
        }

        if ($form.hasClass('variations_form')) {
            const variationId = $form.find('input.variation_id').val();
            if (!variationId || variationId === '0' || variationId === '') {
                return;
            }
        }

        // استفاده مستقیم از serialize به جای serializeArray و jQuery.param جهت حفظ دقیق پارامترها و توکن‌ها
        let serializedData = $form.serialize();

        // ۱. حذف کلید add-to-cart از دیتای فرم برای جلوگیری از اجرای هوک مخفی ووکامرس (WC_Form_Handler)
        serializedData = serializedData.replace(/(^|&)add-to-cart=[^&]*/g, '').replace(/^&/, '');

        // ۲. ارسال شناسه محصول به صورت اختصاصی با کلید product_id
        const buttonVal = $button.val() || $form.find('[name="add-to-cart"]').val() || $form.find('[name="product_id"]').val();
        if (buttonVal) {
            serializedData += (serializedData ? '&' : '') + 'product_id=' + encodeURIComponent(buttonVal);
        }

        const originalText = $button.text();

        $button.addClass('loading').prop('disabled', true);

        let ajaxUrl = (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.wc_ajax_url)
            ? wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart')
            : '/?wc-ajax=add_to_cart';

        if (ajaxUrl.includes('admin-ajax.php')) {
            ajaxUrl = '/?wc-ajax=add_to_cart';
        }

        function resetButton() {
            $button.removeClass('loading').prop('disabled', false).text(originalText);
        }

        jQuery.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: serializedData,
            dataType: 'text',
            success: function(rawResponse, textStatus, xhr) {
                let response;
                try {
                    response = JSON.parse(rawResponse);
                } catch (parseErr) {
                    console.error('BAJI AJAX: پاسخ سرور JSON معتبر نیست.');
                    resetButton();
                    return;
                }

                // پاک کردن پیام‌های خطای قبلی
                $form.find('.baji-ajax-cart-error').remove();

                if (!response) {
                    resetButton();
                    return;
                }

                // اگر سرور خطا داد، جلوی رفرش صفحه را بگیرید و متن خطا را نمایش دهید
                if (response.error) {
                    resetButton();
                    
                    const errorMsg = response.message || 'امکان افزودن این تعداد به سبد خرید وجود ندارد (موجودی انبار محدود است).';
                    
                    // نمایش پیام خطا به صورت زنده زیر دکمه خرید
                    $button.after('<div class="baji-ajax-cart-error text-xs text-red-500 font-medium mt-2 text-center transition-all">' + errorMsg + '</div>');
                    
                    return;
                }

                // موفقیت در افزودن به سبد خرید
                if (response.fragments) {
                    jQuery.each(response.fragments, function(key, value) {
                        jQuery(key).replaceWith(value);
                    });
                    jQuery(document.body).trigger('wc_fragments_refreshed');
                } else {
                    jQuery(document.body).trigger('wc_fragment_refresh');
                }

                $button.removeClass('loading').prop('disabled', false);

                setTimeout(function() {
                    // Button already reset above
                }, 1800);

                jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
            },
            error: function(xhr, status, error) {
                console.error('BAJI AJAX HTTP ERROR — status:', status, '| error:', error);
                console.error('BAJI AJAX HTTP Status Code:', xhr.status);
                console.error('BAJI AJAX Response Body:', xhr.responseText || '(خالی)');
                resetButton();
            }
        });

        return false;
    }, true);

    /* =========================================================
     * مدیریت سوئیچ‌های رنگ و سایز (Swatches)
     * ========================================================= */

    const colorMap = {
        'سرمه‌ای': '#000080', 'سرمه ای': '#000080', 'آبی': '#3b82f6', 'ابی': '#3b82f6',
        'مشکی': '#000000', 'سیاه': '#000000', 'سفید': '#ffffff', 'قرمز': '#ef4444',
        'سبز': '#22c55e', 'زرد': '#eab308', 'طوسی': '#9ca3af', 'خاکستری': '#6b7280',
        'کرم': '#fef3c7', 'قهوه‌ای': '#78350f', 'قهوه ای': '#78350f', 'صورتی': '#ec4899',
        'بنفش': '#a855f7', 'نارنجی': '#f97316', 'طلایی': '#d4af37', 'یشمی': '#004225',
        'زرشکی': '#800020', 'خردلی': '#e1ad01', 'بژ': '#f5f5dc', 'فیروزه‌ای': '#40e0d0',
        'فیروزه ای': '#40e0d0', 'زیتونی': '#808000', 'نسکافه‌ای': '#b8977e', 'نسکافه ای': '#b8977e',
        'black': '#000000', 'white': '#ffffff', 'red': '#ef4444', 'blue': '#3b82f6',
        'green': '#22c55e', 'yellow': '#eab308'
    };

    function normalizeText(str) {
        if (!str) return '';
        return str.replace(/ي/g, 'ی').replace(/ك/g, 'ک').replace(/\s+/g, ' ').trim();
    }

    function initBajiSwatches() {
        $('form.variations_form table.variations select').each(function() {
            const $select = $(this);
            if ($select.next('.baji-swatch-container').length) return;

            const $row = $select.closest('tr');
            const labelText = normalizeText($row.find('.label').text() || $row.find('th').text() || '');
            const attributeName = normalizeText($select.attr('name') || '').toLowerCase();
            const attributeId = normalizeText($select.attr('id') || '').toLowerCase();

            const isColor = labelText.includes('رنگ') ||
                            attributeName.includes('color') || attributeName.includes('rang') ||
                            attributeId.includes('color') || attributeId.includes('rang');

            const $container = $('<div class="baji-swatch-container"></div>');

            $select.find('option').each(function() {
                const $option = $(this);
                const val = $option.val();
                const text = $option.text();

                if (!val) return;

                let extraClass = '';
                let htmlContent = text;

                if (isColor) {
                    const cleanText = normalizeText(text).toLowerCase();
                    const cleanVal = val.toLowerCase();
                    let hexColor = '';

                    for (const [colorName, colorHex] of Object.entries(colorMap)) {
                        if (cleanText.includes(colorName) || cleanVal.includes(colorName)) {
                            hexColor = colorHex;
                            break;
                        }
                    }

                    if (hexColor) {
                        extraClass = ' is-color';
                        if (cleanText.includes('سفید') || hexColor === '#ffffff') extraClass += ' is-color-white';
                        if (cleanText.includes('کرم')) extraClass += ' is-color-cream';
                        if (cleanText.includes('زرد')) extraClass += ' is-color-yellow';

                        htmlContent = `<span class="baji-color-circle" style="background: ${hexColor} !important;"></span><span class="baji-color-text">${text}</span>`;
                    } else {
                        extraClass = ' is-custom-text-color';
                        htmlContent = text;
                    }
                }

                const isSelected = $select.val() === val ? ' active' : '';
                const $swatchItem = $(`<div class="baji-swatch-item${extraClass}${isSelected}" data-value="${val}">${htmlContent}</div>`);

                $container.append($swatchItem);
            });

            $select.after($container);
        });
    }

    $(document).on('click', '.baji-swatch-item', function() {
        const $item = $(this);
        const $container = $item.closest('.baji-swatch-container');
        const $select = $container.prev('select');
        const value = $item.data('value');

        if ($item.hasClass('active')) {
            $item.removeClass('active');
            $select.val('').trigger('change');
        } else {
            $container.find('.baji-swatch-item').removeClass('active');
            $item.addClass('active');
            $select.val(value).trigger('change');
        }
    });

    $(document).on('check_variations', 'form.variations_form', function() {
        $('form.variations_form table.variations select').each(function() {
            const $select = $(this);
            const $container = $select.next('.baji-swatch-container');
            const currentVal = $select.val();

            $container.find('.baji-swatch-item').removeClass('active');
            if (currentVal) {
                $container.find(`.baji-swatch-item[data-value="${currentVal}"]`).addClass('active');
            }
        });
    });

    /* =========================================================
     * مدیریت دکمه‌های کم/زیاد کردن تعداد محصول
     * ========================================================= */

    function initBajiQuantityButtons() {
        $('form.cart div.quantity').each(function() {
            const $qtyContainer = $(this);
            const $input = $qtyContainer.find('input.qty, input[name="quantity"]');

            if (!$input.length || $input.attr('type') === 'hidden' || $input.is(':hidden')) {
                $qtyContainer.addClass('baji-qty-hidden').hide();
                $qtyContainer.find('.baji-qty-trigger').remove();
                return;
            }

            $qtyContainer.removeClass('baji-qty-hidden').show();
            if ($qtyContainer.find('.baji-qty-trigger').length) return;

            const $minusBtn = $('<div class="baji-qty-trigger baji-minus"></div>');
            const $plusBtn = $('<div class="baji-qty-trigger baji-plus"></div>');

            $qtyContainer.prepend($minusBtn);
            $qtyContainer.append($plusBtn);

            $minusBtn.off('click').on('click', function() {
                let currentVal = parseFloat($input.val()) || 1;
                const min = parseFloat($input.attr('min')) || 1;
                if (currentVal > min) {
                    $input.val(currentVal - 1).trigger('change');
                }
            });

            $plusBtn.off('click').on('click', function() {
                let currentVal = parseFloat($input.val()) || 1;
                const max = parseFloat($input.attr('max'));
                if (!max || currentVal < max) {
                    $input.val(currentVal + 1).trigger('change');
                }
            });
        });
    }

    initBajiSwatches();
    initBajiQuantityButtons();

    $(document.body).on('wc_variation_form woocommerce_variation_has_changed', function() {
        initBajiSwatches();
        initBajiQuantityButtons();
    });

    /* =========================================================
     * مدیریت لایت‌باکس سفارشی (تصاویر)
     * ========================================================= */

    const lightbox = document.getElementById('baji-custom-lightbox');
    const lightboxImg = document.getElementById('baji-lightbox-img');
    const closeBtn = document.getElementById('baji-lightbox-close');
    const backdrop = document.getElementById('baji-lightbox-backdrop');

    if (lightbox) {
        function openLightbox(url) {
            if (!url) return;
            lightboxImg.src = url;
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.style.display = 'none';
            lightboxImg.src = '';
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function(e) {
            const link = e.target.closest('.baji-product-gallery-wrapper .woocommerce-product-gallery__image a');
            if (!link) return;

            e.preventDefault();
            e.stopPropagation();

            const img = link.querySelector('img');
            if (!img) return;

            const largeImage =
                img.getAttribute('data-large_image') ||
                img.getAttribute('data-src') ||
                link.getAttribute('href') ||
                img.getAttribute('src');

            openLightbox(largeImage);
        }, true);

        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (backdrop) backdrop.addEventListener('click', closeLightbox);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
        });
    }

    /* =========================================================
     * مدیریت مودال ویدیو استوری (اینستاگرام-style)
     * ========================================================= */

    const videoStoryWrapper = document.querySelector('.baji-product-video-story');
    const videoStoryTrigger = document.querySelector('.baji-product-video-trigger');
    const videoStoryPreview = document.querySelector('.baji-product-video-preview');
    const videoStorySound = document.querySelector('.baji-product-video-sound');
    const videoModal = document.getElementById('baji-video-story-modal');
    const videoModalPlayer = document.getElementById('baji-video-modal-player');
    const videoModalClose = document.getElementById('baji-video-modal-close');
    const videoModalBackdrop = document.getElementById('baji-video-modal-backdrop');

    if (videoStoryWrapper && videoStoryTrigger && videoModal && videoModalPlayer) {
		if (videoStoryPreview && videoStorySound) {
			videoStorySound.addEventListener('click', function(event) {
				event.stopPropagation();
				videoStoryPreview.muted = !videoStoryPreview.muted;
				videoStorySound.setAttribute('aria-pressed', String(!videoStoryPreview.muted));
				videoStorySound.setAttribute('aria-label', videoStoryPreview.muted ? 'Turn on video sound' : 'Mute video sound');
				videoStorySound.innerHTML = videoStoryPreview.muted
					? '<i class="fa-solid fa-volume-xmark"></i>'
					: '<i class="fa-solid fa-volume-high"></i>';
			});
		}

        function openVideoModal(videoUrl) {
            if (!videoUrl) return;
            videoModalPlayer.src = videoUrl;
            videoModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // شروع پخش خودکار
            videoModalPlayer.play().catch(function(err) {
                // autoplay blocked - user needs to click play
                console.log('Autoplay blocked:', err);
            });
        }

        function closeVideoModal() {
            videoModal.style.display = 'none';
            videoModalPlayer.pause();
            videoModalPlayer.src = '';
            document.body.style.overflow = '';
        }

        // کلیک روی ویدیو در گالری
        videoStoryTrigger.addEventListener('click', function() {
            const videoUrl = videoStoryWrapper.getAttribute('data-video-url');
            if (videoUrl) {
                openVideoModal(videoUrl);
            }
        });

        // بستن مودال
        if (videoModalClose) videoModalClose.addEventListener('click', closeVideoModal);
        if (videoModalBackdrop) videoModalBackdrop.addEventListener('click', closeVideoModal);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && videoModal.style.display === 'flex') {
                closeVideoModal();
            }
        });

        // وقتی ویدیو تموم شد، مودال باز بماند (نه بسته شود)
        videoModalPlayer.addEventListener('ended', function() {
            // می‌توان اینجا تصمیم گرفت آیا مودال بسته شود یا خیر
            // فعلا باز می‌ماند تا کاربر دستی ببندد
        });
    }
});
