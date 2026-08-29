<?php

declare(strict_types=1);

$front = file_get_contents(__DIR__ . '/../front-page.php');
$template = file_get_contents(__DIR__ . '/../template-parts/product-stories.php');
$functions = file_get_contents(__DIR__ . '/../functions.php');
$script = file_get_contents(__DIR__ . '/../assets/js/product-stories.js');

function expect_product_stories(string $pattern, string $message, string|false $source): void {
	if ($source === false || preg_match($pattern, $source) !== 1) {
		throw new RuntimeException($message);
	}
}

expect_product_stories(
	'/template-parts\/product-stories.*?template-parts\/hero-section/s',
	'Product stories must render directly above the homepage hero.',
	$front
);

expect_product_stories(
	'/(?=.*?_bajistyle_product_video_id)(?=.*?_product_video_url)(?=.*?posts_per_page[\'\"]?\s*=>\s*12)/s',
	'Stories must query up to 12 products with either supported video meta field.',
	$template
);

expect_product_stories(
	'/<button(?=.*?class="[^"]*baji-product-story-trigger[^"]*")(?=.*?data-video-url=)(?=.*?data-product-url=).*?>/s',
	'Each story needs an accessible trigger with its video and product destinations.',
	$template
);

expect_product_stories(
	'/id="baji-product-stories-viewer".*?role="dialog".*?aria-modal="true".*?baji-story-progress/s',
	'The story viewer must be an accessible modal with progress UI.',
	$template
);

expect_product_stories(
	'/wp_enqueue_script\(\s*[\'\"]bajistyle-product-stories[\'\"].*?product-stories\.js/s',
	'The theme must enqueue the dedicated product stories controller.',
	$functions
);

expect_product_stories(
	'/(?=.*?function\s+openStory)(?=.*?function\s+showStory)(?=.*?ended.*?showStory)/s',
	'Story playback must open, navigate, and advance after each video ends.',
	$script
);

expect_product_stories(
	'/querySelector\(\s*[\'\"]button\[data-story-close\][\'\"]\s*\)\.focus\(\)/',
	'Opening the story viewer must move focus to its close button.',
	$script
);

echo "PASS: homepage product stories use uploaded product videos above the hero.\n";
