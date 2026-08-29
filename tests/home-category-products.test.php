<?php

declare(strict_types=1);

$customizer = file_get_contents(__DIR__ . '/../inc/customizer.php');
$front_page = file_get_contents(__DIR__ . '/../front-page.php');
$product_grid = file_get_contents(__DIR__ . '/../template-parts/product-grid.php');

if ($customizer === false || $front_page === false || $product_grid === false) {
	throw new RuntimeException('Home category product files could not be read.');
}

function expect_home_categories(string $pattern, string $message, string $source): void {
	if (preg_match($pattern, $source) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_home_categories(
	'/bajistyle_home_category_products/',
	'Customizer needs a dedicated home category products section.',
	$customizer
);

expect_home_categories(
	'/for\s*\(\s*\$slot\s*=\s*1;\s*\$slot\s*<=\s*3;\s*\$slot\+\+\s*\).*?bajistyle_home_category_.*?bajistyle_home_category_title_.*?bajistyle_home_category_limit_/s',
	'Customizer must provide three configurable category slots with title and product limit.',
	$customizer
);

expect_home_categories(
	'/get_template_part\(\s*[\'\"]template-parts\/home-category-products[\'\"]\s*\)/',
	'The front page must render the configured category product sections.',
	$front_page
);

expect_home_categories(
	'/case\s+[\'\"]category[\'\"]\s*:.*?[\'\"]taxonomy[\'\"]\s*=>\s*[\'\"]product_cat[\'\"].*?[\'\"]field[\'\"]\s*=>\s*[\'\"]slug[\'\"].*?[\'\"]terms[\'\"]\s*=>\s*\$category_slug/s',
	'Product grid category queries must filter WooCommerce products by category slug.',
	$product_grid
);

echo "PASS: home product sections are configurable by WooCommerce category.\n";
