<?php
/**
 * انواع پست سفارشی (Custom Post Types) قالب BajiStyle
 *
 * شامل CPT اسلایدر صفحه اصلی و بخش‌های ویژه (مثل کمپین‌ها و
 * بنرهای تبلیغاتی فصلی) است.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ثبت Custom Post Type اسلایدر صفحه اصلی.
 *
 * @since 1.0.0
 */
function bajistyle_register_slider_cpt() {
	$labels = array(
		'name'               => __( 'اسلایدرها', 'bajistyle' ),
		'singular_name'      => __( 'اسلایدر', 'bajistyle' ),
		'menu_name'          => __( 'اسلایدر هیرو', 'bajistyle' ),
		'add_new'            => __( 'افزودن اسلاید جدید', 'bajistyle' ),
		'add_new_item'       => __( 'افزودن اسلاید جدید', 'bajistyle' ),
		'edit_item'          => __( 'ویرایش اسلاید', 'bajistyle' ),
		'new_item'           => __( 'اسلاید جدید', 'bajistyle' ),
		'view_item'          => __( 'مشاهده اسلاید', 'bajistyle' ),
		'search_items'       => __( 'جستجوی اسلایدها', 'bajistyle' ),
		'not_found'          => __( 'اسلایدی یافت نشد', 'bajistyle' ),
		'not_found_in_trash' => __( 'اسلایدی در زباله‌دان یافت نشد', 'bajistyle' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 25,
		'menu_icon'          => 'dashicons-images-alt2',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
	);

	register_post_type( 'baji_slider', $args );
}
add_action( 'init', 'bajistyle_register_slider_cpt' );

/**
 * ثبت Custom Post Type بخش‌های ویژه (کمپین‌ها/بنرها).
 *
 * @since 1.0.0
 */
function bajistyle_register_featured_section_cpt() {
	$labels = array(
		'name'               => __( 'بخش‌های ویژه', 'bajistyle' ),
		'singular_name'      => __( 'بخش ویژه', 'bajistyle' ),
		'menu_name'          => __( 'بخش‌های ویژه', 'bajistyle' ),
		'add_new'            => __( 'افزودن بخش ویژه', 'bajistyle' ),
		'add_new_item'       => __( 'افزودن بخش ویژه جدید', 'bajistyle' ),
		'edit_item'          => __( 'ویرایش بخش ویژه', 'bajistyle' ),
		'new_item'           => __( 'بخش ویژه جدید', 'bajistyle' ),
		'view_item'          => __( 'مشاهده بخش ویژه', 'bajistyle' ),
		'search_items'       => __( 'جستجوی بخش‌های ویژه', 'bajistyle' ),
		'not_found'          => __( 'بخش ویژه‌ای یافت نشد', 'bajistyle' ),
		'not_found_in_trash' => __( 'بخش ویژه‌ای در زباله‌دان یافت نشد', 'bajistyle' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 26,
		'menu_icon'          => 'dashicons-megaphone',
		'supports'           => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'baji_featured', $args );
}
add_action( 'init', 'bajistyle_register_featured_section_cpt' );

/**
 * بارگذاری اسکریپت و استایل رسانه (Media Uploader) در صفحه ویرایش اسلاید.
 *
 * @param string $hook نام صفحه فعلی ادمین.
 * @since 1.0.0
 */
function bajistyle_slider_admin_assets( $hook ) {
	global $post_type;

	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'baji_slider' !== $post_type ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script(
		'bajistyle-slider-admin',
		BAJISTYLE_URI . '/assets/js/admin/slider-meta-box.js',
		array( 'jquery' ),
		BAJISTYLE_VERSION,
		true
	);

	wp_localize_script(
		'bajistyle-slider-admin',
		'bajistyleSliderAdmin',
		array(
			'mediaTitle'      => __( 'انتخاب تصویر موبایل', 'bajistyle' ),
			'mediaButtonText' => __( 'استفاده از این تصویر', 'bajistyle' ),
			'selectLabel'     => __( 'انتخاب تصویر موبایل', 'bajistyle' ),
			'changeLabel'     => __( 'تغییر تصویر موبایل', 'bajistyle' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'bajistyle_slider_admin_assets' );

/**
 * افزودن Meta Box برای فیلدهای اضافی اسلایدر (تصویر موبایل، دکمه، نمایش).
 *
 * @since 1.0.0
 */
function bajistyle_add_slider_meta_boxes() {
	add_meta_box(
		'bajistyle_slider_mobile_image',
		__( 'تصویر اختصاصی موبایل', 'bajistyle' ),
		'bajistyle_render_slider_mobile_image_box',
		'baji_slider',
		'side',
		'default'
	);

	add_meta_box(
		'bajistyle_slider_details',
		__( 'دکمه و نمایش اسلاید', 'bajistyle' ),
		'bajistyle_render_slider_meta_box',
		'baji_slider',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'bajistyle_add_slider_meta_boxes' );

/**
 * رندر باکس آپلود تصویر اختصاصی موبایل (سایدبار ادیتور).
 *
 * @param WP_Post $post شیء پست فعلی.
 * @since 1.0.0
 */
function bajistyle_render_slider_mobile_image_box( $post ) {
	$mobile_image_id  = get_post_meta( $post->ID, '_bajistyle_mobile_image_id', true );
	$mobile_image_url = $mobile_image_id ? wp_get_attachment_image_url( $mobile_image_id, 'medium' ) : '';
	?>
	<p class="description">
		<?php esc_html_e( 'در صورت خالی بودن، همان تصویر شاخص (دسکتاپ) با برش خودکار در موبایل نمایش داده می‌شود. برای کنترل کامل روی نمایش موبایل (مثلاً تصویر عمودی یا کادربندی متفاوت)، یک تصویر جدا آپلود کنید.', 'bajistyle' ); ?>
	</p>
	<div id="bajistyle-mobile-image-preview" style="margin-bottom:10px;">
		<img src="<?php echo esc_url( $mobile_image_url ); ?>"
			style="max-width:100%;height:auto;<?php echo $mobile_image_url ? '' : 'display:none;'; ?>" />
	</div>
	<input type="hidden" id="bajistyle_mobile_image_id" name="bajistyle_mobile_image_id" value="<?php echo esc_attr( $mobile_image_id ); ?>" />
	<button type="button" class="button" id="bajistyle-select-mobile-image">
		<?php echo $mobile_image_id ? esc_html__( 'تغییر تصویر موبایل', 'bajistyle' ) : esc_html__( 'انتخاب تصویر موبایل', 'bajistyle' ); ?>
	</button>
	<button type="button" class="button-link-delete" id="bajistyle-remove-mobile-image"
		style="margin-inline-start:8px;<?php echo $mobile_image_id ? '' : 'display:none;'; ?>">
		<?php esc_html_e( 'حذف تصویر موبایل', 'bajistyle' ); ?>
	</button>
	<p class="description" style="margin-top:10px;">
		<?php esc_html_e( 'ابعاد پیشنهادی: ۱۰۸۰ × ۱۳۵۰ پیکسل (عمودی، نسبت ۴:۵)', 'bajistyle' ); ?>
	</p>
	<?php
}

/**
 * رندر فیلدهای Meta Box اصلی اسلاید (دکمه، شدت overlay، موقعیت و تم متن).
 *
 * @param WP_Post $post شیء پست فعلی.
 * @since 1.0.0
 */
function bajistyle_render_slider_meta_box( $post ) {
	wp_nonce_field( 'bajistyle_save_slider_meta', 'bajistyle_slider_meta_nonce' );

	$button_text    = get_post_meta( $post->ID, '_bajistyle_button_text', true );
	$button_url     = get_post_meta( $post->ID, '_bajistyle_button_url', true );
	$overlay        = get_post_meta( $post->ID, '_bajistyle_overlay_opacity', true );
	$text_position  = get_post_meta( $post->ID, '_bajistyle_text_position', true );
	$text_theme     = get_post_meta( $post->ID, '_bajistyle_text_theme', true );

	// مقادیر پیش‌فرض در صورت نبود مقدار ذخیره‌شده.
	$overlay       = ( '' === $overlay ) ? '30' : $overlay;
	$text_position = $text_position ? $text_position : 'center';
	$text_theme    = $text_theme ? $text_theme : 'light';
	?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row">
					<label for="bajistyle_button_text"><?php esc_html_e( 'متن دکمه', 'bajistyle' ); ?></label>
				</th>
				<td>
					<input type="text" id="bajistyle_button_text" name="bajistyle_button_text"
						value="<?php echo esc_attr( $button_text ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'در صورت خالی بودن متن یا لینک، دکمه نمایش داده نمی‌شود.', 'bajistyle' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="bajistyle_button_url"><?php esc_html_e( 'لینک دکمه', 'bajistyle' ); ?></label>
				</th>
				<td>
					<input type="url" id="bajistyle_button_url" name="bajistyle_button_url"
						value="<?php echo esc_url( $button_url ); ?>" class="regular-text" placeholder="https://" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="bajistyle_overlay_opacity"><?php esc_html_e( 'شدت لایه تیره روی تصویر', 'bajistyle' ); ?></label>
				</th>
				<td>
					<select id="bajistyle_overlay_opacity" name="bajistyle_overlay_opacity">
						<?php
						$overlay_options = array(
							'0'  => __( 'بدون لایه تیره', 'bajistyle' ),
							'15' => __( 'خیلی کم (۱۵٪)', 'bajistyle' ),
							'30' => __( 'کم (۳۰٪) — پیش‌فرض', 'bajistyle' ),
							'45' => __( 'متوسط (۴۵٪)', 'bajistyle' ),
							'60' => __( 'زیاد (۶۰٪)', 'bajistyle' ),
						);
						foreach ( $overlay_options as $value => $label ) :
							?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $overlay, $value ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<p class="description"><?php esc_html_e( 'برای خوانایی بهتر متن روی تصاویر روشن، مقدار بیشتری انتخاب کنید.', 'bajistyle' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="bajistyle_text_position"><?php esc_html_e( 'موقعیت متن', 'bajistyle' ); ?></label>
				</th>
				<td>
					<select id="bajistyle_text_position" name="bajistyle_text_position">
						<option value="right" <?php selected( $text_position, 'right' ); ?>><?php esc_html_e( 'راست', 'bajistyle' ); ?></option>
						<option value="center" <?php selected( $text_position, 'center' ); ?>><?php esc_html_e( 'وسط (پیش‌فرض)', 'bajistyle' ); ?></option>
						<option value="left" <?php selected( $text_position, 'left' ); ?>><?php esc_html_e( 'چپ', 'bajistyle' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="bajistyle_text_theme"><?php esc_html_e( 'تم رنگی متن', 'bajistyle' ); ?></label>
				</th>
				<td>
					<select id="bajistyle_text_theme" name="bajistyle_text_theme">
						<option value="light" <?php selected( $text_theme, 'light' ); ?>><?php esc_html_e( 'روشن (برای تصاویر تیره) — پیش‌فرض', 'bajistyle' ); ?></option>
						<option value="dark" <?php selected( $text_theme, 'dark' ); ?>><?php esc_html_e( 'تیره (برای تصاویر روشن)', 'bajistyle' ); ?></option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

/**
 * ذخیره داده‌های Meta Box اسلایدر با اعتبارسنجی و nonce.
 *
 * @param int $post_id شناسه پست.
 * @since 1.0.0
 */
function bajistyle_save_slider_meta( $post_id ) {
	// بررسی nonce برای امنیت
	if ( ! isset( $_POST['bajistyle_slider_meta_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bajistyle_slider_meta_nonce'] ) ), 'bajistyle_save_slider_meta' ) ) {
		return;
	}

	// جلوگیری از ذخیره خودکار
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// بررسی دسترسی کاربر
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['bajistyle_button_text'] ) ) {
		update_post_meta(
			$post_id,
			'_bajistyle_button_text',
			sanitize_text_field( wp_unslash( $_POST['bajistyle_button_text'] ) )
		);
	}

	if ( isset( $_POST['bajistyle_button_url'] ) ) {
		update_post_meta(
			$post_id,
			'_bajistyle_button_url',
			esc_url_raw( wp_unslash( $_POST['bajistyle_button_url'] ) )
		);
	}

	if ( isset( $_POST['bajistyle_mobile_image_id'] ) ) {
		update_post_meta(
			$post_id,
			'_bajistyle_mobile_image_id',
			absint( $_POST['bajistyle_mobile_image_id'] )
		);
	}

	if ( isset( $_POST['bajistyle_overlay_opacity'] ) ) {
		$allowed_overlay = array( '0', '15', '30', '45', '60' );
		$overlay_value   = sanitize_text_field( wp_unslash( $_POST['bajistyle_overlay_opacity'] ) );
		update_post_meta(
			$post_id,
			'_bajistyle_overlay_opacity',
			in_array( $overlay_value, $allowed_overlay, true ) ? $overlay_value : '30'
		);
	}

	if ( isset( $_POST['bajistyle_text_position'] ) ) {
		$allowed_positions = array( 'right', 'center', 'left' );
		$position_value    = sanitize_text_field( wp_unslash( $_POST['bajistyle_text_position'] ) );
		update_post_meta(
			$post_id,
			'_bajistyle_text_position',
			in_array( $position_value, $allowed_positions, true ) ? $position_value : 'center'
		);
	}

	if ( isset( $_POST['bajistyle_text_theme'] ) ) {
		$allowed_themes = array( 'light', 'dark' );
		$theme_value    = sanitize_text_field( wp_unslash( $_POST['bajistyle_text_theme'] ) );
		update_post_meta(
			$post_id,
			'_bajistyle_text_theme',
			in_array( $theme_value, $allowed_themes, true ) ? $theme_value : 'light'
		);
	}
}
add_action( 'save_post_baji_slider', 'bajistyle_save_slider_meta' );
