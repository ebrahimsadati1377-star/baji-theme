<?php
/**
 * افزودن قابلیت آپلود ویدیو به محصولات ووکامرس (BajiStyle)
 *
 * این فایل شامل:
 *  - Meta Box آپلود ویدیو در صفحه ویرایش/افزودن محصول
 *  - ذخیره شناسه پیوست (attachment ID) ویدیو در متادیتای محصول
 *  - توابع کمکی برای دسترسی به ویدیوی محصول در فرانت‌اند
 *
 * ویدیو به‌صورت مستقیم روی سرور (Media Library) آپلود می‌شود و
 * در گالری محصول به‌صورت شبیه به استوری اینستاگرام نمایش داده
 * می‌شود.
 *
 * @package BajiStyle
 * @since 1.0.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * نام متادیتای ویدیوی محصول.
 */
define( 'BAJISTYLE_PRODUCT_VIDEO_META', '_bajistyle_product_video_id' );

/**
 * افزودن Meta Box ویدیوی محصول به صفحه ویرایش محصول.
 *
 * @since 1.0.6
 */
function bajistyle_add_product_video_meta_box() {
	add_meta_box(
		'bajistyle_product_video',
		__( 'ویدیوی محصول', 'bajistyle' ),
		'bajistyle_render_product_video_meta_box',
		'product',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'bajistyle_add_product_video_meta_box' );

/**
 * رندر کردن باکس آپلود ویدیو در پنل کناری ویرایشگر محصول.
 *
 * @param WP_Post $post شیء پست (محصول) فعلی.
 * @since 1.0.6
 */
function bajistyle_render_product_video_meta_box( $post ) {
	wp_nonce_field( 'bajistyle_save_product_video', 'bajistyle_product_video_nonce' );

	$video_id   = get_post_meta( $post->ID, BAJISTYLE_PRODUCT_VIDEO_META, true );
	$video_url  = $video_id ? wp_get_attachment_url( $video_id ) : '';
	$has_video  = ! empty( $video_id );
	?>
	<p class="description">
		<?php esc_html_e( 'یک ویدیو برای نمایش در گالری محصول آپلود کنید. ویدیو در بالای گالری به‌صورت استوری اینستاگرام نمایش داده می‌شود.', 'bajistyle' ); ?>
	</p>

	<div id="bajistyle-video-preview" style="margin-bottom:10px;">
		<?php if ( $has_video ) : ?>
			<video src="<?php echo esc_url( $video_url ); ?>" controls
				style="max-width:100%;height:auto;border-radius:8px;display:block;"></video>
		<?php endif; ?>
	</div>

	<input type="hidden" id="bajistyle_product_video_id" name="bajistyle_product_video_id"
		value="<?php echo esc_attr( $video_id ); ?>" />

	<button type="button" class="button" id="bajistyle-select-video">
		<?php echo $has_video ? esc_html__( 'تغییر ویدیو', 'bajistyle' ) : esc_html__( 'انتخاب ویدیو', 'bajistyle' ); ?>
	</button>

	<button type="button" class="button-link-delete" id="bajistyle-remove-video"
		style="margin-inline-start:8px;<?php echo $has_video ? '' : 'display:none;'; ?>">
		<?php esc_html_e( 'حذف ویدیو', 'bajistyle' ); ?>
	</button>

	<p class="description" style="margin-top:10px;">
		<?php esc_html_e( 'فرمت‌های پیشنهادی: MP4، WebM. حداکثر حجم طبق تنظیمات سرور.', 'bajistyle' ); ?>
	</p>
	<?php
}

/**
 * بارگذاری اسکریپت آپلودر رسانه در صفحه ویرایش محصول.
 *
 * @param string $hook نام صفحه فعلی ادمین.
 * @since 1.0.6
 */
function bajistyle_product_video_admin_assets( $hook ) {
	global $post_type;

	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'product' !== $post_type ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_script(
		'bajistyle-product-video-admin',
		BAJISTYLE_URI . '/assets/js/admin/product-video.js',
		array( 'jquery' ),
		BAJISTYLE_VERSION,
		true
	);

	wp_localize_script(
		'bajistyle-product-video-admin',
		'bajistyleProductVideoAdmin',
		array(
			'mediaTitle'      => __( 'انتخاب ویدیوی محصول', 'bajistyle' ),
			'mediaButtonText' => __( 'استفاده از این ویدیو', 'bajistyle' ),
			'selectLabel'     => __( 'انتخاب ویدیو', 'bajistyle' ),
			'changeLabel'     => __( 'تغییر ویدیو', 'bajistyle' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'bajistyle_product_video_admin_assets' );

/**
 * ذخیره شناسه ویدیوی محصول همراه با بررسی امنیتی.
 *
 * @param int $post_id شناسه پست (محصول).
 * @since 1.0.6
 */
function bajistyle_save_product_video_meta( $post_id ) {
	// بررسی nonce
	if ( ! isset( $_POST['bajistyle_product_video_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bajistyle_product_video_nonce'] ) ), 'bajistyle_save_product_video' ) ) {
		return;
	}

	// جلوگیری از ذخیره خودکار
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// بررسی دسترسی
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// فقط برای پست‌های از نوع محصول
	if ( 'product' !== get_post_type( $post_id ) ) {
		return;
	}

	if ( isset( $_POST['bajistyle_product_video_id'] ) ) {
		$video_id = absint( $_POST['bajistyle_product_video_id'] );
		update_post_meta( $post_id, BAJISTYLE_PRODUCT_VIDEO_META, $video_id );
	}
}
add_action( 'save_post_product', 'bajistyle_save_product_video_meta' );

/**
 * دریافت شناسه ویدیوی محصول.
 *
 * @param int $product_id شناسه محصول.
 * @return int|string شناسه پیوست ویدیو یا رشته خالی.
 * @since 1.0.6
 */
function bajistyle_get_product_video_id( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_the_ID();
	}
	return get_post_meta( $product_id, BAJISTYLE_PRODUCT_VIDEO_META, true );
}

/**
 * بررسی وجود ویدیو برای محصول.
 *
 * @param int $product_id شناسه محصول.
 * @return bool true اگر ویدیو داشته باشد.
 * @since 1.0.6
 */
function bajistyle_product_has_video( $product_id = 0 ) {
	$video_id = bajistyle_get_product_video_id( $product_id );
	return ! empty( $video_id );
}

/**
 * Render the product-video preview in the Description tab.
 *
 * @param int $product_id Product ID.
 * @return void
 */
function bajistyle_render_product_video_preview( $product_id = 0 ) {
	if ( ! $product_id ) {
		$product_id = get_the_ID();
	}

	$video_id  = bajistyle_get_product_video_id( $product_id );
	$video_url = $video_id ? wp_get_attachment_url( $video_id ) : get_post_meta( $product_id, '_product_video_url', true );

	if ( empty( $video_url ) ) {
		return;
	}
	?>
	<div class="baji-product-video-story" data-video-url="<?php echo esc_url( $video_url ); ?>">
		<video class="baji-product-video-preview" autoplay playsinline muted loop preload="metadata" aria-hidden="true" tabindex="-1">
			<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
		</video>
		<button type="button" class="baji-product-video-trigger" aria-label="Watch product video"></button>
		<span class="baji-product-video-badge" aria-hidden="true"><i class="fa-solid fa-video"></i></span>
		<button type="button" class="baji-product-video-sound" aria-label="Turn on video sound" aria-pressed="false"><i class="fa-solid fa-volume-xmark"></i></button>
	</div>
	<?php
}

/**
 * Keep the standard description and append the product video when one exists.
 *
 * @return void
 */
function bajistyle_product_description_with_video() {
	woocommerce_product_description_tab();
	bajistyle_render_product_video_preview();
}

/**
 * Replace the Description tab callback with the video-aware callback.
 *
 * @param array $tabs WooCommerce product tabs.
 * @return array
 */
function bajistyle_add_video_to_description_tab( $tabs ) {
	if ( isset( $tabs['description'] ) ) {
		$tabs['description']['callback'] = 'bajistyle_product_description_with_video';
	}

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'bajistyle_add_video_to_description_tab', 99 );

/**
 * Register product video meta for REST API (so WC Manager can read/write).
 *
 * @since 1.0.7
 */
add_action( 'rest_api_init', function () {
	// Main video meta (attachment ID)
	register_meta( 'post', '_bajistyle_product_video_id', [
		'type'         => 'integer',
		'description'  => 'Product video attachment ID',
		'single'       => true,
		'show_in_rest' => true,
		'auth_callback' => function () {
			return current_user_can( 'edit_posts' );
		},
	] );

	// Fallback URL meta (for WC Manager compatibility)
	register_meta( 'post', '_product_video_url', [
		'type'         => 'string',
		'description'  => 'Product video URL (fallback)',
		'single'       => true,
		'show_in_rest' => true,
		'auth_callback' => function () {
			return current_user_can( 'edit_posts' );
		},
	] );
} );
