<?php

declare(strict_types=1);

$card = file_get_contents(__DIR__ . '/../woocommerce/content-product.php');
$account = file_get_contents(__DIR__ . '/../woocommerce/myaccount/my-account.php');
$wishlist = file_get_contents(__DIR__ . '/../template-parts/account/wishlist.php');
$script = file_get_contents(__DIR__ . '/../assets/js/main.js');

function expect_wishlist(string $pattern, string $message, string|false $source): void {
	if ($source === false || preg_match($pattern, $source) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_wishlist(
	'/<button(?=.*?class="[^"]*baji-quick-wishlist[^"]*")(?=.*?data-product-id=)(?=.*?aria-pressed=).*?>/s',
	'Every product card wishlist button must be wired to AJAX and expose its pressed state.',
	$card
);

expect_wishlist(
	'/class="[^"]*baji-wishlist-icon[^"]*"/s',
	'Product card heart icons need the shared state hook used by JavaScript.',
	$card
);

expect_wishlist(
	'/case\s+[\'\"]wishlist[\'\"]\s*:.*?get_template_part\(\s*[\'\"]template-parts\/account\/wishlist[\'\"]\s*\)/s',
	'The custom account dashboard must render the real wishlist template.',
	$account
);

expect_wishlist(
	'/is_wc_endpoint_url\(\s*[\'\"]wishlist[\'\"]\s*\).*?[\'\"]wishlist[\'"]/s',
	'The account page must recognize the wishlist endpoint used by the header link.',
	$account
);

expect_wishlist(
	'/(?=.*?baji-wishlist-header)(?=.*?baji-wishlist-total)(?=.*?data-wishlist-grid)(?=.*?data-wishlist-empty)/s',
	'Wishlist page needs a modern count header, product grid, and reusable empty state.',
	$wishlist
);

expect_wishlist(
	'/closest\(\s*[\'\"]\.baji-account-wishlist[\'\"]\s*\).*?data\.data\.added.*?data-wishlist-grid/s',
	'Removing an item on the wishlist page must update the visible grid without a reload.',
	$script
);

echo "PASS: wishlist controls and account experience stay synchronized.\n";
