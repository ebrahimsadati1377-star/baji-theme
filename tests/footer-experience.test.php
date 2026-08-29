<?php

declare(strict_types=1);

$footer = file_get_contents(__DIR__ . '/../footer.php');

if ($footer === false) {
	throw new RuntimeException('Footer template could not be read.');
}

function expect_footer(string $pattern, string $message, string $source): void {
	if (preg_match($pattern, $source) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_footer(
	'/class="[^"]*baji-footer-editorial[^"]*".*?baji-footer-wordmark.*?baji-footer-grid/s',
	'Footer needs a clear editorial brand statement and restrained content grid.',
	$footer
);

expect_footer(
	'/<nav[^>]*aria-label=.*?baji-footer-menu/s',
	'Footer navigation must be semantic and labelled.',
	$footer
);

expect_footer(
	'/bajistyle_contact_phone.*?bajistyle_contact_email.*?bajistyle_contact_address/s',
	'Footer must preserve configurable contact details.',
	$footer
);

expect_footer(
	'/baji-footer-trust.*?<img[^>]*loading="lazy"[^>]*width=/s',
	'Trust marks need a quiet dedicated area and stable lazy-loaded image dimensions.',
	$footer
);

if (preg_match('/<footer\b.*?<\/footer>/s', $footer, $match) !== 1) {
	throw new RuntimeException('Footer element is missing.');
}

if (preg_match('/href=["\']#["\']/', $match[0]) === 1) {
	throw new RuntimeException('Footer must not contain dead placeholder links.');
}

echo "PASS: footer is semantic, configurable, and free of dead links.\n";
