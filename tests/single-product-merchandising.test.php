<?php

declare(strict_types=1);

$customizer = file_get_contents(__DIR__ . '/../inc/customizer.php');
$hooks = file_get_contents(__DIR__ . '/../inc/woocommerce-hooks.php');
$single = file_get_contents(__DIR__ . '/../woocommerce/single-product.php');
$related = file_get_contents(__DIR__ . '/../woocommerce/single-product/related.php');
$category_sections = file_get_contents(__DIR__ . '/../template-parts/home-category-products.php');

function expect_merchandising(string $pattern, string $message, string|false $source): void {
	if ($source === false || preg_match($pattern, $source) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_merchandising(
	'/bajistyle_first_purchase_coupon.*?sanitize_text_field/s',
	'Customizer must provide a sanitized first-purchase coupon code setting.',
	$customizer
);

expect_merchandising(
	'/function\s+bajistyle_first_purchase_coupon_bar(?=.*?۱۰٪ تخفیف برای اولین خریدت)(?=.*?get_theme_mod\(\s*[\'\"]bajistyle_first_purchase_coupon).*?\}/s',
	'The product page needs a first-purchase coupon bar backed by the Customizer value.',
	$hooks
);

expect_merchandising(
	'/class="[^"]*baji-copy-coupon[^"]*"[^>]*data-coupon=/s',
	'The coupon code must be exposed through an accessible copy control.',
	$hooks
);

expect_merchandising(
	'/class="[^"]*baji-related-products[^"]*".*?class="swiper baji-products-slider.*?class="swiper-wrapper".*?wc_get_template_part\(\s*[\'\"]content[\'\"]\s*,\s*[\'\"]product[\'\"]\s*\)/s',
	'Related products must use the shared product slider presentation.',
	$related
);

expect_merchandising(
	'/bajistyle_get_recently_viewed_products\(\s*get_the_ID\(\)\s*,\s*12\s*\).*?baji-recently-viewed.*?swiper baji-products-slider.*?swiper-wrapper/s',
	'Recently viewed products must use the shared product slider and retain up to 12 items.',
	$single
);

if (str_contains((string) $category_sections, 'انتخاب بر اساس دسته‌بندی')) {
	throw new RuntimeException('Homepage category sections must not show the category-selection subtitle.');
}

echo "PASS: product merchandising sections share the slider presentation.\n";
