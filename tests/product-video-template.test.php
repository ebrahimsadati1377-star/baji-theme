<?php

declare(strict_types=1);

$template = file_get_contents(__DIR__ . '/../woocommerce/single-product.php');
$video_module = file_get_contents(__DIR__ . '/../inc/product-video.php');
$product_script = file_get_contents(__DIR__ . '/../assets/js/single-product-ajax.js');

if ($template === false || $video_module === false || $product_script === false) {
	throw new RuntimeException('Product video files could not be read.');
}

function expect_video_template(string $pattern, string $message, string $template): void {
	if (preg_match($pattern, $template) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_video_template(
	'/<button[^>]*class="[^"]*baji-product-video-trigger[^"]*"[^>]*aria-label=/s',
	'Product video preview needs an accessible, dedicated open button.',
	$video_module
);

expect_video_template(
	'/<video[^>]*preload="metadata"[^>]*aria-hidden="true"/s',
	'Product video preview should load metadata only and stay decorative until opened.',
	$video_module
);

expect_video_template(
	'/<video[^>]*autoplay[^>]*muted[^>]*loop[^>]*preload="metadata"/s',
	'Product video preview should play silently in a loop before the customer opens it.',
	$video_module
);

expect_video_template(
	'/<button[^>]*class="[^"]*baji-product-video-sound[^"]*"[^>]*aria-label=/s',
	'Product video preview needs a dedicated sound control without opening the modal.',
	$video_module
);

expect_video_template(
	'/function bajistyle_product_description_with_video\(\).*?woocommerce_product_description_tab\(\);.*?bajistyle_render_product_video_preview\(\);/s',
	'Product video must render inside the product description tab after its description.',
	$video_module
);

expect_video_template(
	'/add_filter\(\s*[\'\"]woocommerce_product_tabs[\'\"],\s*[\'\"]bajistyle_add_video_to_description_tab[\'\"]/',
	'Description tab callback must be replaced with the video-aware callback.',
	$video_module
);

expect_video_template(
	'/\.baji-product-video-story\s*\{[^}]*max-width:\s*280px[^}]*aspect-ratio:\s*4\s*\/\s*5/s',
	'Product video preview needs a compact, consistent card ratio on product pages.',
	$template
);

expect_video_template(
	'/@media \(min-width: 768px\).*?\.flex-control-thumbs li\s*\{[^}]*flex:\s*0 0 auto/s',
	'Desktop gallery thumbnails must not shrink instead of scrolling.',
	$template
);

expect_video_template(
	'/\.flex-control-thumbs li\s*\{[^}]*width:\s*100%[^}]*\}.*?@media \(max-width: 767px\).*?\.flex-control-thumbs li\s*\{[^}]*width:\s*72px[^}]*flex:\s*0 0 72px/s',
	'Mobile gallery thumbnail width must override the generic full-width thumbnail rule.',
	$template
);

expect_video_template(
	'/\.flex-control-thumbs\s*\{[^}]*touch-action:\s*pan-x[^}]*overscroll-behavior-x:\s*contain/s',
	'Mobile gallery thumbnail list must explicitly accept horizontal touch scrolling.',
	$template
);

expect_video_template(
	'/const productGalleryThumbs = document\.querySelector\([^)]*flex-control-thumbs.*?touchmove.*?stopPropagation\(\)/s',
	'Gallery slider must not capture touch gestures that begin on thumbnail scrolling.',
	$product_script
);

$gallery_start = strpos($template, '<div class="baji-product-gallery-wrapper');
$gallery_end = strpos($template, "do_action( 'woocommerce_before_single_product_summary' )", $gallery_start ?: 0);

if ($gallery_start === false || $gallery_end === false || str_contains(substr($template, $gallery_start, $gallery_end - $gallery_start), 'baji-product-video-story')) {
	throw new RuntimeException('Product video preview must not render above the gallery.');
}

expect_video_template(
	'/id="baji-video-story-modal"[^>]*style="[^"]*z-index:\s*2147483647[^"]*"/s',
	'Product video modal must sit above fixed navigation, headers, and promotional banners.',
	$template
);

expect_video_template(
	'/class="[^"]*bg-black\/70[^"]*backdrop-blur-md[^"]*"[^>]*id="baji-video-modal-backdrop"/s',
	'Product video modal must darken and blur the page behind the open video.',
	$template
);

expect_video_template(
	'/id="baji-video-modal-backdrop"[^>]*style="[^"]*backdrop-filter:\s*blur\(16px\)[^"]*"/s',
	'Product video modal backdrop must blur the page even when the Tailwind build is stale.',
	$template
);

echo "PASS: product video preview has a compact and accessible presentation.\n";
