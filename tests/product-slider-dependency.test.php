<?php
/**
 * Source-level regression checks for product slider resilience.
 * Run: php tests/product-slider-dependency.test.php
 */
$root = dirname( __DIR__ );
$functions = file_get_contents( $root . '/functions.php' );
$css = file_get_contents( $root . '/assets/css/custom.css' );
$js = file_get_contents( $root . '/assets/js/main.js' );
$vendor_js = $root . '/assets/vendor/swiper/swiper-bundle.min.js';
$vendor_css = $root . '/assets/vendor/swiper/swiper-bundle.min.css';

$checks = array(
    'Local JS registration' => str_contains( $functions, "BAJISTYLE_URI . '/assets/vendor/swiper/swiper-bundle.min.js'" ),
    'Local CSS registration' => str_contains( $functions, "BAJISTYLE_URI . '/assets/vendor/swiper/swiper-bundle.min.css'" ),
    'No CDN runtime dependency' => ! str_contains( $functions, 'cdn.jsdelivr.net/npm/swiper' ),
    'Vendor JS present' => is_file( $vendor_js ) && filesize( $vendor_js ) > 100000,
    'Vendor CSS present' => is_file( $vendor_css ) && filesize( $vendor_css ) > 10000,
    'Desktop fallback' => str_contains( $css, 'Product slider no-JS fallback (desktop/tablet)' ),
    'Tablet columns' => str_contains( $css, 'repeat(4, minmax(0, 1fr)) !important' ),
    'Desktop columns' => str_contains( $css, 'repeat(6, minmax(0, 1fr)) !important' ),
    'Fallback only before initialization' => str_contains( $css, ':not(.swiper-initialized) .swiper-wrapper' ),
    'Existing Swiper logic' => str_contains( $js, 'initBajiProductSliders()' ),
);
$failures = 0;
foreach ( $checks as $name => $ok ) {
    echo ( $ok ? 'PASS ' : 'FAIL ' ) . $name . PHP_EOL;
    if ( ! $ok ) { ++$failures; }
}
exit( $failures ? 1 : 0 );