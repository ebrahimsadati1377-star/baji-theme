<?php
/**
 * توابع SEO اختصاصی قالب BajiStyle
 *
 * شامل: Canonical URLs (fallback), و بهینه‌سازی Alt Text
 *
 * NOTE: Product Schema, Breadcrumb Schema, Website Schema, Open Graph,
 * Twitter Cards → RankMath handle mikone. Agar RankMath disable shod,
 * function-ha ro uncomment kon (search: "GHEYR-E-FAAL").
 *
 * @package BajiStyle
 * @since 1.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =========================================================================
 * 1. PRODUCT SCHEMA (JSON-LD) - برای نمایش Rich Results در گوگل
 * ====================================================================== */

/**
 * خروجی Product Schema در صفحات تک محصول
 * GHEYR-E-FAAL: RankMath in ro handle mikone. Baraye enable kardan
 * in function ro uncomment kon va RankMath Schema (Product) ro disable kon.
 */
/*
function bajistyle_product_schema() {
	if ( ! is_product() ) {
		return;
	}

	global $product;
	if ( ! $product ) {
		return;
	}

	// اطلاعات پایه محصول
	$schema = array(
		'@context'    => 'https://schema.org/',
		'@type'       => 'Product',
		'name'        => $product->get_name(),
		'description' => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
		'sku'         => $product->get_sku(),
		'url'         => get_permalink( $product->get_id() ),
	);

	// تصاویر محصول
	$images = array();
	$image_id = $product->get_image_id();
	if ( $image_id ) {
		$images[] = wp_get_attachment_image_url( $image_id, 'full' );
	}
	$gallery_ids = $product->get_gallery_image_ids();
	foreach ( $gallery_ids as $gallery_id ) {
		$images[] = wp_get_attachment_image_url( $gallery_id, 'full' );
	}
	if ( ! empty( $images ) ) {
		$schema['image'] = $images;
	}

	// برند (اگر دسته‌بندی برند داری)
	$brands = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
	if ( ! empty( $brands ) ) {
		$schema['brand'] = array(
			'@type' => 'Brand',
			'name'  => $brands[0],
		);
	}

	// رتبه‌بندی و نظرات
	if ( $product->get_review_count() > 0 ) {
		$schema['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => $product->get_average_rating(),
			'reviewCount' => $product->get_review_count(),
			'bestRating'  => '5',
			'worstRating' => '1',
		);
	}

	// قیمت و موجودی
	$price = $product->get_price();
	if ( $price ) {
		$schema['offers'] = array(
			'@type'           => 'Offer',
			'url'             => get_permalink( $product->get_id() ),
			'priceCurrency'   => 'IRR',
			'price'           => $price,
			'priceValidUntil' => date( 'Y-12-31' ), // تا پایان سال
			'availability'    => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
			'itemCondition'   => 'https://schema.org/NewCondition',
		);

		// اگر تخفیف داره
		if ( $product->is_on_sale() ) {
			$regular_price = $product->get_regular_price();
			if ( $regular_price ) {
				$schema['offers']['priceSpecification'] = array(
					'@type'               => 'PriceSpecification',
					'price'               => $price,
					'priceCurrency'       => 'IRR',
					'valueAddedTaxIncluded' => true,
				);
			}
		}
	}

	// خروجی JSON-LD
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bajistyle_product_schema', 5 );
*/

/* =========================================================================
 * 2. BREADCRUMBS SCHEMA - برای نمایش مسیر در نتایج گوگل
 * ====================================================================== */

/**
 * خروجی BreadcrumbList Schema
 * GHEYR-E-FAAL: RankMath in ro handle mikone. Baraye enable kardan
 * in function ro uncomment kon va RankMath Schema (Breadcrumb) ro disable kon.
 */
/*
function bajistyle_breadcrumb_schema() {
	if ( is_front_page() ) {
		return;
	}

	$items = array();
	$position = 1;

	// صفحه اصلی
	$items[] = array(
		'@type'    => 'ListItem',
		'position' => $position++,
		'name'     => 'خانه',
		'item'     => home_url( '/' ),
	);

	// صفحه فروشگاه
	if ( is_woocommerce() ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		if ( $shop_page_id > 0 ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => get_the_title( $shop_page_id ),
				'item'     => get_permalink( $shop_page_id ),
			);
		}
	}

	// دسته‌بندی محصول
	if ( is_product_category() ) {
		$current_term = get_queried_object();
		$ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
		$ancestors = array_reverse( $ancestors );

		foreach ( $ancestors as $ancestor_id ) {
			$ancestor = get_term( $ancestor_id, 'product_cat' );
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => $ancestor->name,
				'item'     => get_term_link( $ancestor ),
			);
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => $current_term->name,
			'item'     => get_term_link( $current_term ),
		);
	}

	// صفحه محصول
	if ( is_product() ) {
		global $product;
		$terms = get_the_terms( $product->get_id(), 'product_cat' );
		if ( $terms && ! is_wp_error( $terms ) ) {
			$term = array_shift( $terms );
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $position++,
				'name'     => $term->name,
				'item'     => get_term_link( $term ),
			);
		}

		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	}

	// صفحه عادی
	if ( is_page() && ! is_front_page() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $position++,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	}

	if ( empty( $items ) ) {
		return;
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bajistyle_breadcrumb_schema', 6 );
*/

/* =========================================================================
 * 3. OPEN GRAPH TAGS - برای اشتراک‌گذاری در شبکه‌های اجتماعی
 * ====================================================================== */

/**
 * خروجی Open Graph و Twitter Card tags
 * GHEYR-E-FAAL: RankMath in ro handle mikone. Baraye enable kardan
 * in function ro uncomment kon va RankMath Open Graph ro disable kon.
 */
/*
function bajistyle_social_meta_tags() {
	// عنوان
	$title = wp_get_document_title();

	// توضیحات
	$description = '';
	if ( is_product() ) {
		global $product;
		$description = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		$description = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_trim_words( $post->post_content, 30 );
	}

	if ( empty( $description ) ) {
		$description = get_bloginfo( 'description' );
	}
	$description = wp_strip_all_tags( $description );
	$description = substr( $description, 0, 160 );

	// تصویر
	$image = '';
	if ( is_product() ) {
		global $product;
		$image_id = $product->get_image_id();
		if ( $image_id ) {
			$image = wp_get_attachment_image_url( $image_id, 'full' );
		}
	} elseif ( is_singular() && has_post_thumbnail() ) {
		$image = get_the_post_thumbnail_url( null, 'full' );
	}

	if ( empty( $image ) ) {
		$image = BAJISTYLE_URI . '/screenshot.png'; // تصویر پیش‌فرض
	}

	$url = '';
	if ( is_singular() ) {
		$url = get_permalink();
	} elseif ( is_archive() || is_tax() ) {
		$url = get_term_link( get_queried_object() );
	} else {
		$url = home_url( $_SERVER['REQUEST_URI'] );
	}

	// Open Graph Tags
	echo '<meta property="og:locale" content="fa_IR" />' . "\n";
	echo '<meta property="og:type" content="' . ( is_product() ? 'product' : 'website' ) . '" />' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . "\n";

	// قیمت محصول برای Open Graph
	if ( is_product() ) {
		global $product;
		$price = $product->get_price();
		if ( $price ) {
			echo '<meta property="product:price:amount" content="' . esc_attr( $price ) . '" />' . "\n";
			echo '<meta property="product:price:currency" content="IRR" />' . "\n";
		}
	}

	// Twitter Card Tags
	echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />' . "\n";
	echo '<meta name="twitter:image" content="' . esc_url( $image ) . '" />' . "\n";
}
add_action( 'wp_head', 'bajistyle_social_meta_tags', 7 );
*/

/* =========================================================================
 * 4. CANONICAL URLs - جلوگیری از محتوای تکراری
 * ====================================================================== */

/**
 * خروجی Canonical URL
 */
function bajistyle_canonical_url() {
	// اگر Yoast یا Rank Math نصب است، کاری نکن
	if ( class_exists( 'WPSEO_Frontend' ) || class_exists( 'RankMath' ) ) {
		return;
	}

	$canonical = '';

	if ( is_singular() ) {
		$canonical = get_permalink();
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$canonical = get_term_link( get_queried_object() );
	} elseif ( is_front_page() ) {
		$canonical = home_url( '/' );
	} elseif ( is_home() ) {
		$canonical = get_permalink( get_option( 'page_for_posts' ) );
	}

	if ( ! empty( $canonical ) && ! is_wp_error( $canonical ) ) {
		echo '<link rel="canonical" href="' . esc_url( $canonical ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'bajistyle_canonical_url', 8 );

/* =========================================================================
 * 5. OPTIMIZED ALT TEXT - بهینه‌سازی متن جایگزین تصاویر
 * ====================================================================== */

/**
 * بهینه‌سازی خودکار Alt Text برای تصاویر محصول
 */
function bajistyle_optimize_product_image_alt( $attr, $attachment, $size ) {
	// فقط برای صفحات محصول
	if ( ! is_product() ) {
		return $attr;
	}

	global $product;
	if ( ! $product ) {
		return $attr;
	}

	// اگر Alt خالی است، از نام محصول استفاده کن
	if ( empty( $attr['alt'] ) ) {
		$product_name = $product->get_name();
		$attr['alt'] = sprintf( '%s - %s', $product_name, get_bloginfo( 'name' ) );
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'bajistyle_optimize_product_image_alt', 10, 3 );

/* =========================================================================
 * 6. WEBSITE SCHEMA - اطلاعات کلی وب‌سایت
 * ====================================================================== */

/**
 * خروجی Website و Organization Schema در صفحه اصلی
 * GHEYR-E-FAAL: RankMath in ro handle mikone. Baraye enable kardan
 * in function ro uncomment kon va RankMath Schema ro disable kon.
 */
/*
function bajistyle_website_schema() {
	if ( ! is_front_page() ) {
		return;
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type' => 'WebSite',
				'@id'   => home_url( '/#website' ),
				'url'   => home_url( '/' ),
				'name'  => get_bloginfo( 'name' ),
				'description' => get_bloginfo( 'description' ),
				'potentialAction' => array(
					'@type'       => 'SearchAction',
					'target'      => array(
						'@type'       => 'EntryPoint',
						'urlTemplate' => home_url( '/?s={search_term_string}' ),
					),
					'query-input' => 'required name=search_term_string',
				),
			),
			array(
				'@type' => 'Organization',
				'@id'   => home_url( '/#organization' ),
				'name'  => get_bloginfo( 'name' ),
				'url'   => home_url( '/' ),
				'logo'  => array(
					'@type' => 'ImageObject',
					'url'   => get_site_icon_url(),
				),
			),
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'bajistyle_website_schema', 4 );
*/
