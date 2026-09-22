<?php
/**
 * BAJI category-aware size guide.
 *
 * @package BajiStyle
 */

defined( 'ABSPATH' ) || exit;

/**
 * Size-guide definitions by WooCommerce product category ID.
 *
 * @return array<int,array<string,mixed>>
 */
function bajistyle_size_guide_categories() {
	return array(
		23 => array(
			'name' => 'اورال',
			'icon' => 'fa-person-dress',
			'priority' => 'برای اورال، دور سینه و دور باسن را با هم مقایسه کن و سایزی را انتخاب کن که برای هر دو اندازه راحت باشد.',
			'measurements' => array(
				'دور سینه' => 'متر را از برجسته‌ترین قسمت سینه، کاملاً افقی و بدون کشیدن متر رد کن.',
				'دور کمر' => 'باریک‌ترین قسمت کمر را بدون سفت‌کردن متر اندازه بگیر.',
				'دور باسن' => 'برجسته‌ترین قسمت باسن را در حالت ایستاده اندازه بگیر.',
				'قد کل' => 'از بالاترین نقطه سرشانه تا انتهای لباس اندازه‌گیری می‌شود.',
				'فاق' => 'برای راحتی نشستن و حرکت، قد فاق را با لباس مشابهت مقایسه کن.',
			),
		),
		18 => array(
			'name' => 'اورشرت',
			'icon' => 'fa-shirt',
			'priority' => 'برای اورشرت، دور سینه اولویت دارد. اگر بین دو سایز هستی و استایل آزادتر دوست داری، سایز بزرگ‌تر انتخاب مناسب‌تری است.',
			'measurements' => array(
				'دور سینه' => 'دور برجسته‌ترین قسمت سینه را اندازه بگیر.',
				'سرشانه' => 'از انتهای یک سرشانه تا انتهای سرشانه دیگر.',
				'دور بازو' => 'پهن‌ترین قسمت بازو را بدون فشار متر بگیر.',
				'قد آستین' => 'از اتصال سرشانه تا مچ.',
				'قد لباس' => 'از بالاترین نقطه سرشانه تا پایین لباس.',
			),
		),
		333 => array(
			'name' => 'بارونی',
			'icon' => 'fa-cloud-rain',
			'priority' => 'بارونی معمولاً روی لباس دیگر پوشیده می‌شود؛ دور سینه و دور باسن را با کمی آزادی اضافه در نظر بگیر.',
			'measurements' => array(
				'دور سینه' => 'روی لباس نازک، دور برجسته‌ترین قسمت سینه را اندازه بگیر.',
				'دور باسن' => 'برای مدل‌های بلند، برجسته‌ترین قسمت باسن را هم بررسی کن.',
				'سرشانه' => 'از انتهای یک سرشانه تا سرشانه دیگر.',
				'دور بازو' => 'پهن‌ترین قسمت بازو را اندازه بگیر.',
				'قد آستین' => 'از سرشانه تا مچ.',
				'قد لباس' => 'از سرشانه تا انتهای بارونی.',
			),
		),
		107 => array(
			'name' => 'تیشرت',
			'icon' => 'fa-shirt',
			'priority' => 'برای تیشرت، دور سینه مهم‌ترین معیار است. برای فرم آزاد یا اورسایز، اندازه لباس را با تیشرتی که تنخورش را دوست داری مقایسه کن.',
			'measurements' => array(
				'دور سینه' => 'دور برجسته‌ترین قسمت سینه را اندازه بگیر.',
				'سرشانه' => 'فاصله دو سرشانه را اندازه بگیر.',
				'قد لباس' => 'از سرشانه تا پایین لباس.',
				'قد آستین' => 'از محل اتصال سرشانه تا انتهای آستین.',
			),
		),
		19 => array(
			'name' => 'دامن',
			'icon' => 'fa-person-dress',
			'priority' => 'برای دامن، دور باسن را اول بررسی کن و بعد دور کمر. اگر بین دو سایز هستی، سایزی را انتخاب کن که روی باسن راحت‌تر باشد.',
			'measurements' => array(
				'دور کمر' => 'محل قرار گرفتن کمر دامن را دور تا دور اندازه بگیر.',
				'دور باسن' => 'برجسته‌ترین قسمت باسن را اندازه بگیر.',
				'قد دامن' => 'از محل کمر تا انتهای دامن.',
			),
		),
		22 => array(
			'name' => 'ست',
			'icon' => 'fa-layer-group',
			'priority' => 'برای ست، هم بالاتنه و هم پایین‌تنه را بررسی کن؛ سایزی را انتخاب کن که برای بزرگ‌ترین اندازه بدن تو مناسب باشد.',
			'measurements' => array(
				'دور سینه' => 'برجسته‌ترین قسمت سینه.',
				'دور کمر' => 'باریک‌ترین قسمت کمر.',
				'دور باسن' => 'برجسته‌ترین قسمت باسن.',
				'دور ران' => 'پهن‌ترین قسمت ران.',
				'فاق' => 'از درز فاق تا بالای کمر شلوار.',
				'قد بالاتنه / شلوار' => 'اندازه هر تکه را با لباس مشابه مقایسه کن.',
			),
		),
		20 => array(
			'name' => 'شلوار',
			'icon' => 'fa-person',
			'priority' => 'برای شلوار، دور باسن و دور ران مهم‌تر از عدد روی برچسب هستند؛ سپس دور کمر و فاق را بررسی کن.',
			'measurements' => array(
				'دور کمر' => 'محل طبیعی قرار گرفتن کمر شلوار را اندازه بگیر.',
				'دور باسن' => 'برجسته‌ترین قسمت باسن را اندازه بگیر.',
				'دور ران' => 'پهن‌ترین قسمت ران را اندازه بگیر.',
				'فاق' => 'از محل درز فاق تا بالای کمر.',
				'قد شلوار' => 'از کمر تا پایین پاچه.',
			),
		),
		17 => array(
			'name' => 'شومیز',
			'icon' => 'fa-shirt',
			'priority' => 'برای شومیز، دور سینه معیار اصلی است. اگر پارچه کشسان نیست یا مدل جذب است، کمی آزادی برای حرکت در نظر بگیر.',
			'measurements' => array(
				'دور سینه' => 'برجسته‌ترین قسمت سینه را اندازه بگیر.',
				'سرشانه' => 'از انتهای یک سرشانه تا سرشانه دیگر.',
				'دور بازو' => 'پهن‌ترین قسمت بازو.',
				'قد آستین' => 'از سرشانه تا مچ.',
				'قد لباس' => 'از بالاترین نقطه سرشانه تا پایین شومیز.',
			),
		),
		27 => array(
			'name' => 'کراپ',
			'icon' => 'fa-shirt',
			'priority' => 'برای کراپ، دور سینه و قد لباس را حتماً بررسی کن تا میزان کوتاهی و تنخور مطابق استایل دلخواهت باشد.',
			'measurements' => array(
				'دور سینه' => 'برجسته‌ترین قسمت سینه.',
				'سرشانه' => 'فاصله دو سرشانه.',
				'قد لباس' => 'از سرشانه تا پایین کراپ.',
				'قد آستین' => 'در مدل‌های آستین‌دار، از سرشانه تا انتهای آستین.',
			),
		),
		21 => array(
			'name' => 'مانتو',
			'icon' => 'fa-person-dress',
			'priority' => 'برای مانتو، دور سینه و دور باسن را با هم بررسی کن و برای پوشیدن روی لباس زیر، کمی آزادی در نظر بگیر.',
			'measurements' => array(
				'دور سینه' => 'برجسته‌ترین قسمت سینه را اندازه بگیر.',
				'دور باسن' => 'برای مانتوهای بلند، برجسته‌ترین قسمت باسن را بررسی کن.',
				'سرشانه' => 'فاصله دو سرشانه.',
				'دور بازو' => 'پهن‌ترین قسمت بازو.',
				'قد آستین' => 'از سرشانه تا مچ.',
				'قد لباس' => 'از سرشانه تا انتهای مانتو.',
			),
		),
	);
}

/**
 * General women's body-size reference. Centimetres.
 *
 * This is intentionally labelled as a general reference; product-specific
 * measurements always take precedence.
 *
 * @return array<int,array<string,string>>
 */
function bajistyle_general_body_size_table() {
	return array(
		34 => array( 'bust' => '80–84',  'waist' => '62–66', 'hip' => '86–90' ),
		36 => array( 'bust' => '84–88',  'waist' => '66–70', 'hip' => '90–94' ),
		38 => array( 'bust' => '88–92',  'waist' => '70–74', 'hip' => '94–98' ),
		40 => array( 'bust' => '92–96',  'waist' => '74–78', 'hip' => '98–102' ),
		42 => array( 'bust' => '96–100', 'waist' => '78–82', 'hip' => '102–106' ),
		44 => array( 'bust' => '100–104','waist' => '82–86', 'hip' => '106–110' ),
		46 => array( 'bust' => '104–108','waist' => '86–90', 'hip' => '110–114' ),
		48 => array( 'bust' => '108–112','waist' => '90–94', 'hip' => '114–118' ),
	);
}

/**
 * Resolve the most relevant configured category for a product.
 *
 * @param WC_Product|null $product Product.
 * @return array<string,mixed>
 */
function bajistyle_resolve_size_guide( $product = null ) {
	$configs = bajistyle_size_guide_categories();
	$fallback = array(
		'name' => 'لباس زنانه',
		'icon' => 'fa-ruler-combined',
		'priority' => 'اندازه‌های دقیق درج‌شده در مشخصات همین محصول را با لباس مشابهی که تنخورش برایت مناسب است مقایسه کن.',
		'measurements' => array(
			'دور سینه' => 'برجسته‌ترین قسمت سینه.',
			'دور کمر' => 'باریک‌ترین قسمت کمر.',
			'دور باسن' => 'برجسته‌ترین قسمت باسن.',
			'قد لباس' => 'از بالاترین نقطه سرشانه یا کمر تا انتهای لباس.',
		),
	);

	if ( $product instanceof WC_Product ) {
		$terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'ids' ) );
		foreach ( $terms as $term_id ) {
			if ( isset( $configs[ $term_id ] ) ) {
				$configs[ $term_id ]['term_id'] = $term_id;
				return $configs[ $term_id ];
			}
		}
	}

	if ( is_product_category() ) {
		$term = get_queried_object();
		if ( $term && isset( $configs[ (int) $term->term_id ] ) ) {
			$configs[ (int) $term->term_id ]['term_id'] = (int) $term->term_id;
			return $configs[ (int) $term->term_id ];
		}
	}

	return $fallback;
}

/**
 * Pull exact size/measurement attributes already registered on a product.
 *
 * @param WC_Product $product Product.
 * @return array<string,string>
 */
function bajistyle_product_measurement_attributes( $product ) {
	$found = array();

	if ( ! $product instanceof WC_Product ) {
		return $found;
	}

	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! is_a( $attribute, 'WC_Product_Attribute' ) ) {
			continue;
		}

		$name = wc_attribute_label( $attribute->get_name(), $product );
		if ( ! preg_match( '/سایز|اندازه|دور|قد|سرشانه|آستین|فاق/u', (string) $name ) ) {
			continue;
		}

		if ( $attribute->is_taxonomy() ) {
			$values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) );
		} else {
			$values = $attribute->get_options();
		}

		$value = implode( '، ', array_filter( array_map( 'wp_strip_all_tags', (array) $values ) ) );
		if ( '' !== $value ) {
			$found[ $name ] = $value;
		}
	}

	return $found;
}

/**
 * Render the size-guide body.
 *
 * @param WC_Product|null $product Product.
 * @param bool            $compact Compact archive mode.
 * @return void
 */
function bajistyle_render_size_guide( $product = null, $compact = false ) {
	$guide = bajistyle_resolve_size_guide( $product );
	$product_measurements = $product instanceof WC_Product ? bajistyle_product_measurement_attributes( $product ) : array();
	$table = bajistyle_general_body_size_table();
	?>
	<div class="baji-size-guide<?php echo $compact ? ' is-compact' : ''; ?>">
		<?php if ( $product_measurements ) : ?>
			<section class="baji-size-guide__exact">
				<div class="baji-size-guide__section-head">
					<span><i class="fa-solid fa-circle-check"></i></span>
					<div>
						<small>اول این بخش را ببین</small>
						<h3>اندازه‌های ثبت‌شده همین محصول</h3>
					</div>
				</div>
				<div class="baji-size-guide__exact-grid">
					<?php foreach ( $product_measurements as $label => $value ) : ?>
						<div><span><?php echo esc_html( $label ); ?></span><strong><?php echo esc_html( $value ); ?></strong></div>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="baji-size-guide__category">
			<div class="baji-size-guide__section-head">
				<span><i class="fa-solid <?php echo esc_attr( $guide['icon'] ); ?>"></i></span>
				<div>
					<small>راهنمای دسته <?php echo esc_html( $guide['name'] ); ?></small>
					<h3>چه اندازه‌هایی را بگیری؟</h3>
				</div>
			</div>
			<p class="baji-size-guide__tip"><?php echo esc_html( $guide['priority'] ); ?></p>
			<div class="baji-size-guide__measurements">
				<?php foreach ( $guide['measurements'] as $label => $description ) : ?>
					<div>
						<strong><?php echo esc_html( $label ); ?></strong>
						<span><?php echo esc_html( $description ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<?php if ( ! $compact ) : ?>
			<section class="baji-size-guide__table-section">
				<div class="baji-size-guide__section-head">
					<span><i class="fa-solid fa-table-cells"></i></span>
					<div>
						<small>اعداد به سانتی‌متر</small>
						<h3>جدول راهنمای عمومی سایز زنانه</h3>
					</div>
				</div>
				<div class="baji-size-guide__table-wrap">
					<table class="baji-size-guide__table">
						<thead>
							<tr><th>سایز</th><th>دور سینه</th><th>دور کمر</th><th>دور باسن</th></tr>
						</thead>
						<tbody>
							<?php foreach ( $table as $size => $row ) : ?>
								<tr>
									<td><strong><?php echo esc_html( $size ); ?></strong></td>
									<td><?php echo esc_html( $row['bust'] ); ?></td>
									<td><?php echo esc_html( $row['waist'] ); ?></td>
									<td><?php echo esc_html( $row['hip'] ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php endif; ?>

		<div class="baji-size-guide__note">
			<i class="fa-solid fa-circle-info"></i>
			<p><strong>ملاک نهایی انتخاب سایز:</strong> اندازه‌های درج‌شده در مشخصات همان محصول. جدول عمومی فقط برای راهنمای اولیه است و تنخور هر مدل می‌تواند متفاوت باشد.</p>
		</div>
	</div>
	<?php
}

/**
 * Product tab: shown on every product automatically.
 */
function bajistyle_add_size_guide_tab( $tabs ) {
	$tabs['baji_size_guide'] = array(
		'title'    => '<i class="fas fa-ruler-combined"></i> راهنمای سایز',
		'priority' => 22,
		'callback' => 'bajistyle_size_guide_tab_content',
	);
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'bajistyle_add_size_guide_tab', 97 );

function bajistyle_size_guide_tab_content() {
	global $product;
	bajistyle_render_size_guide( $product, false );
}

/**
 * Visible shortcut near the product purchase area.
 */
function bajistyle_product_size_guide_shortcut() {
	?>
	<a class="baji-size-guide-shortcut" href="#tab-baji_size_guide">
		<span><i class="fa-solid fa-ruler-combined"></i></span>
		<strong>راهنمای انتخاب سایز</strong>
		<small>اندازه‌گیری درست قبل از خرید</small>
		<i class="fa-solid fa-chevron-left"></i>
	</a>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'bajistyle_product_size_guide_shortcut', 24 );

/**
 * Category-specific guide on every configured product category archive.
 */
function bajistyle_category_size_guide() {
	if ( ! is_product_category() ) {
		return;
	}
	$guide = bajistyle_resolve_size_guide();
	?>
	<details class="baji-category-size-guide">
		<summary>
			<span><i class="fa-solid fa-ruler-combined"></i></span>
			<div><strong>راهنمای سایز <?php echo esc_html( $guide['name'] ); ?></strong><small>قبل از انتخاب محصول، روش اندازه‌گیری را ببین</small></div>
			<i class="fa-solid fa-chevron-down"></i>
		</summary>
		<div class="baji-category-size-guide__body">
			<?php bajistyle_render_size_guide( null, true ); ?>
		</div>
	</details>
	<?php
}
add_action( 'woocommerce_archive_description', 'bajistyle_category_size_guide', 25 );
