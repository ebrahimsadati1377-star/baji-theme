<?php
/**
 * Blog/posts index router for BajiStyle.
 *
 * Keeps the real storefront homepage on / while routing the assigned
 * WordPress Posts page (e.g. /mag/) to the dedicated magazine layout.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If WordPress is configured to show latest posts on the site root,
// preserve the storefront homepage instead of rendering the blog index.
if ( is_front_page() ) {
	require get_template_directory() . '/front-page.php';
	return;
}

// The assigned Posts page ignores page-{slug}.php by design, so route
// the posts index explicitly to our dedicated magazine template.
require get_template_directory() . '/page-mag.php';
