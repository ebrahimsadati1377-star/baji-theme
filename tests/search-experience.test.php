<?php

declare(strict_types=1);

$header = file_get_contents(__DIR__ . '/../header.php');
$search_template = file_get_contents(__DIR__ . '/../search.php');
$main_script = file_get_contents(__DIR__ . '/../assets/js/main.js');

if ($header === false || $search_template === false || $main_script === false) {
	throw new RuntimeException('Search files could not be read.');
}

function expect_search_experience(string $pattern, string $message, string $source): void {
	if (preg_match($pattern, $source) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_search_experience(
	'/id="baji-search-panel".*?id="baji-search-close"/s',
	'Search panel needs a visible close control for touch users.',
	$header
);

expect_search_experience(
	'/<div class="relative max-w-3xl mx-auto px-4 py-8" style="padding-left:\s*3\.5rem;">\s*<button[^>]*id="baji-search-close"/s',
	'Search panel must reserve space for its close button instead of covering the search field.',
	$header
);

expect_search_experience(
	'/id="baji-search-backdrop"/s',
	'Search panel needs an outside-click backdrop.',
	$header
);

expect_search_experience(
	'/const closeButton = document\.getElementById\(\s*[\'\"]baji-search-close[\'\"]\s*\).*?closeButton\.addEventListener\(\s*[\'\"]click[\'\"]\s*,\s*closePanel/s',
	'Search close control must close the panel.',
	$main_script
);

expect_search_experience(
	'/<ul class="products[^\"]*"/s',
	'Product search results must use the WooCommerce products list wrapper.',
	$search_template
);

echo "PASS: search panel and results have the required interaction structure.\n";
