# Project Context

## Project
BajiStyle - WordPress / WooCommerce women's fashion website.

## Stack
- WordPress
- WooCommerce
- PHP 8.3
- Tailwind CSS
- Alpine.js
- JavaScript ES6
- RTL Persian
- Vazirmatn

## Important Architecture

### Theme
Theme path:
wp-content/themes/bajistyle/

Important files:
- inc/product-video.php
- assets/js/admin/product-video.js
- woocommerce/single-product.php

### WC Manager
WC Manager is a separate application that communicates with WordPress/WooCommerce REST API.

Important files:
- public/ajax/upload_video.php
- public/product_edit.php
- public/assets/js/product_edit.js
- public/ajax/product_save.php
- includes/WooCommerceClient.php

## Current Feature
Product video system:
- Upload video to WordPress Media Library
- Store attachment ID in `_bajistyle_product_video_id`
- Store video URL in `_product_video_url`
- Display video on product frontend in 9:16 Story-style format
- WC Manager can upload and save product videos

## Current Status
- upload_max_filesize issue: fixed
- REST API meta registration: fixed
- WC Manager upload endpoint: implemented
- Previous 503 issue: suspected PHP-FPM related and needs end-to-end verification
- Video gallery poster issue: FIXED - removed poster attribute so video frames show directly instead of product featured image
- Video modal fullscreen issue: FIXED - removed playsinline, made modal truly fullscreen (100vw/100vh), removed border-radius on modal video
- Product-page video preview: updated to a compact 4:5 card (max 280px on desktop), with an accessible dedicated play button. The preview loads metadata only and opens the existing fullscreen modal.
- Product video modal layering: fixed by assigning the modal the maximum CSS z-index (`2147483647`), so it covers fixed headers, bottom navigation, and promotional banners.
- Product video modal backdrop: darkens and blurs the page behind the open video while keeping the player sharp.
- The video backdrop now also has inline dark/blur styles, so the overlay works even if the deployed Tailwind CSS bundle has not been rebuilt yet.
- Product video preview now autoplays silently in a loop, removes the central play icon, and provides a compact sound control in the card corner.
- Product video placement: moved from above the image gallery into the WooCommerce Description tab, after the product text.
- Gallery thumbnails: fixed the mobile full-width CSS override and desktop flex shrinking so thumbnail lists can scroll again.
- Mobile thumbnail swipe: thumbnail touch/pointer events no longer bubble to FlexSlider, preventing the main product image from sliding when the customer scrolls thumbnails.
- Search UX: added a close button and click-outside backdrop to the header search panel; product search results now use WooCommerce's required `ul.products` wrapper.
- Search panel close button: reserved space beside the search form so the close icon no longer overlaps the field.
- Homepage category product sections: added three optional WooCommerce category sliders configurable from WordPress Customizer. Each slot supports category selection, an optional custom title, and a product limit from 4 to 24; unselected slots stay hidden.
- Homepage category section subtitle: removed the repeated `انتخاب بر اساس دسته‌بندی` label so configured sections show only their category title.
- Single-product first-purchase offer: added a minimal `۱۰٪ تخفیف برای اولین خریدت` coupon bar after the add-to-cart area. The code is editable in Customizer and the bar stays hidden when no code is configured; customers can copy the code from the bar.
- Single-product merchandising sliders: related products and recently viewed products now use the same responsive Swiper/product-card presentation as homepage product sections, with up to 12 products.
- Wishlist experience: fixed product-card heart buttons that were missing the JavaScript selector/icon hooks, synchronized `aria-pressed`, icon, label, and header count states after AJAX, and added loading feedback.
- Wishlist account page: replaced the old/fallback presentation with a refined BajiStyle editorial layout, live saved-product count, responsive product grid, guided empty state, and animated removal without page reload.
- Wishlist routing: the custom My Account template now recognizes the standard `/my-account/wishlist/` endpoint used by the header and also supports its existing `?tab=wishlist` navigation.

## Current Task
Test the complete video flow and visually verify the updated product-page video preview:
1. WC Manager upload
2. WordPress Media Library
3. attachment ID
4. product meta
5. frontend display
6. Verify video gallery shows actual video (not poster image)
7. Verify video modal opens in true fullscreen

## Latest Changes
- Modified `woocommerce/single-product.php`: compact video preview markup and styles.
- Modified `assets/js/single-product-ajax.js`: modal now opens only from the video preview button.
- Added `tests/product-video-template.test.php`: regression check for the compact, accessible product-video preview.
- Updated `woocommerce/single-product.php`: video modal now always renders above other fixed site layers.
- Added `template-parts/home-category-products.php`: renders configured homepage category sliders with category archive links.
- Updated `inc/customizer.php`: added the `محصولات دسته‌بندی در صفحه اصلی` Customizer section with three configurable category slots.
- Updated `template-parts/product-grid.php`: added a `category` query type filtered by the WooCommerce `product_cat` slug.
- Updated `front-page.php`: renders category product sections after new arrivals and before the brand story.
- Added `tests/home-category-products.test.php`: regression coverage for Customizer controls, front-page integration, and category filtering.
- Updated `template-parts/home-category-products.php`: removed the category-selection subtitle.
- Updated `inc/customizer.php`: added `پیشنهاد صفحه محصول` and the configurable first-purchase coupon code.
- Updated `inc/woocommerce-hooks.php`: renders the coupon bar and requests up to 12 related products.
- Updated `assets/js/woocommerce.js` and `assets/css/custom.css`: added coupon copying feedback and minimal offer-bar styling.
- Added `woocommerce/single-product/related.php`: related products now render as the shared responsive product slider.
- Updated `woocommerce/single-product.php`: recently viewed products now render up to 12 items in the shared responsive product slider.
- Added `tests/single-product-merchandising.test.php`: regression coverage for the configurable coupon and both product-page sliders.
- Added `.impeccable.md`: persistent design context for BajiStyle (women aged 18-30; luxury, minimal, feminine, mobile-first retail experience).
- Updated `woocommerce/content-product.php`: connected product-card hearts to the shared AJAX wishlist controller and added accessible pressed state.
- Updated `template-parts/account/wishlist.php`: modern wishlist header, count, responsive grid, accessible live status, and actionable empty state.
- Updated `woocommerce/myaccount/my-account.php`: renders the real wishlist template and resolves both endpoint and query-tab navigation.
- Updated `assets/js/main.js`: synchronizes wishlist UI state and removes items from the account grid without reload.
- Updated `assets/css/custom.css`: added responsive editorial wishlist styling, reduced-motion support, and calm removal transitions.
- Added `tests/wishlist-experience.test.php`: regression coverage for product-card controls, account rendering, endpoint routing, empty state, and AJAX removal.

## Homepage Category Products
- Management path: WordPress Admin > Appearance > Customize > `محصولات دسته‌بندی در صفحه اصلی`.
- Three slots are available. Select a WooCommerce product category, optionally override its section title, and set the product count (4-24).
- Leaving a slot category unselected prevents that section from rendering.
- Current automated status: category regression test, product-video test, search UX test, and PHP syntax checks all pass.
- Coupon management path: WordPress Admin > Appearance > Customize > `پیشنهاد صفحه محصول`. Leaving the coupon field empty hides the offer bar.
- Current automated status: all four regression tests pass, all 63 PHP files pass syntax checks, and `assets/js/woocommerce.js` passes Node syntax validation.
- Current automated status: all five regression tests pass, all 64 PHP files pass syntax checks, and `assets/js/main.js` passes Node syntax validation.

## Language
Always communicate with Ebi in Finglish.
Never use Persian/Arabic script unless explicitly requested.


Update CLAUDE.md with everything important we discovered or changed in this session.
Include:
- what we changed
- files modified
- bugs fixed
- current status
- remaining problems
- next steps
- important server/configuration details

Do not remove existing useful project context.



# Global Instructions

- Always communicate with me in Finglish.
- Never use Persian/Arabic script unless I explicitly request it.
- Keep code, commands, paths, filenames and technical identifiers unchanged.
- Before modifying code, inspect the relevant existing implementation.
- Do not make assumptions about the project architecture.
- When working on an existing project, read CLAUDE.md first.
