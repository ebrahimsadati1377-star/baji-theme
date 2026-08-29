<?php
/**
 * تنظیمات Customizer قالب BajiStyle
 *
 * این فایل امکان شخصی‌سازی رنگ‌ها، لوگو، متون هیرو، شبکه‌های اجتماعی
 * و سایر تنظیمات بصری قالب را از طریق پنل Customizer وردپرس فراهم می‌کند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ساخت گزینه‌های دسته‌بندی محصول برای کنترل‌های صفحه اصلی.
 *
 * @return array<int|string, string>
 */
function bajistyle_product_category_choices() {
	$choices = array( 0 => __( 'انتخاب نشده', 'bajistyle' ) );
	$terms   = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		)
	);

	if ( is_wp_error( $terms ) ) {
		return $choices;
	}

	foreach ( $terms as $term ) {
		$choices[ $term->term_id ] = $term->name;
	}

	return $choices;
}

/**
 * ثبت تنظیمات، بخش‌ها و فیلدهای Customizer.
 *
 * @param WP_Customize_Manager $wp_customize شیء مدیریت Customizer.
 * @since 1.0.0
 */
function bajistyle_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'bajistyle_single_product_promotions',
		array(
			'title'       => __( 'پیشنهاد صفحه محصول', 'bajistyle' ),
			'description' => __( 'کد تخفیف خرید اول را برای نمایش در صفحه محصولات وارد کنید.', 'bajistyle' ),
			'priority'    => 38,
		)
	);

	$wp_customize->add_setting(
		'bajistyle_first_purchase_coupon',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'bajistyle_first_purchase_coupon',
		array(
			'label'       => __( 'کد تخفیف خرید اول', 'bajistyle' ),
			'description' => __( 'با خالی گذاشتن این فیلد، نوار تخفیف نمایش داده نمی‌شود.', 'bajistyle' ),
			'section'     => 'bajistyle_single_product_promotions',
			'type'        => 'text',
		)
	);

	/* ---------------------------------------------------------------
	 * بخش: محصولات صفحه اصلی بر اساس دسته‌بندی
	 * -------------------------------------------------------------- */
	$wp_customize->add_section(
		'bajistyle_home_category_products',
		array(
			'title'       => __( 'محصولات دسته‌بندی در صفحه اصلی', 'bajistyle' ),
			'description' => __( 'تا سه دسته‌بندی را برای نمایش به صورت اسلایدر در صفحه اصلی انتخاب کنید.', 'bajistyle' ),
			'priority'    => 39,
		)
	);

	$category_choices = bajistyle_product_category_choices();

	for ( $slot = 1; $slot <= 3; $slot++ ) {
		$wp_customize->add_setting(
			'bajistyle_home_category_' . $slot,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'bajistyle_home_category_' . $slot,
			array(
				'label'   => sprintf( __( 'دسته‌بندی بخش %d', 'bajistyle' ), $slot ),
				'section' => 'bajistyle_home_category_products',
				'type'    => 'select',
				'choices' => $category_choices,
			)
		);

		$wp_customize->add_setting(
			'bajistyle_home_category_title_' . $slot,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'bajistyle_home_category_title_' . $slot,
			array(
				'label'       => sprintf( __( 'عنوان سفارشی بخش %d', 'bajistyle' ), $slot ),
				'description' => __( 'اختیاری؛ در صورت خالی بودن نام دسته‌بندی نمایش داده می‌شود.', 'bajistyle' ),
				'section'     => 'bajistyle_home_category_products',
				'type'        => 'text',
			)
		);

		$wp_customize->add_setting(
			'bajistyle_home_category_limit_' . $slot,
			array(
				'default'           => 12,
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			'bajistyle_home_category_limit_' . $slot,
			array(
				'label'       => sprintf( __( 'تعداد محصولات بخش %d', 'bajistyle' ), $slot ),
				'section'     => 'bajistyle_home_category_products',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 4,
					'max'  => 24,
					'step' => 1,
				),
			)
		);
	}

	/* ---------------------------------------------------------------
	 * بخش: رنگ‌های برند
	 * -------------------------------------------------------------- */
	$wp_customize->add_section(
		'bajistyle_brand_colors',
		array(
			'title'    => __( 'رنگ‌های برند BajiStyle', 'bajistyle' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'bajistyle_color_primary',
		array(
			'default'           => '#C9A227',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bajistyle_color_primary',
			array(
				'label'   => __( 'رنگ طلایی (اصلی)', 'bajistyle' ),
				'section' => 'bajistyle_brand_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'bajistyle_color_dark',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bajistyle_color_dark',
			array(
				'label'   => __( 'رنگ مشکی (متن/پس‌زمینه)', 'bajistyle' ),
				'section' => 'bajistyle_brand_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'bajistyle_color_cream',
		array(
			'default'           => '#F8F5EF',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'bajistyle_color_cream',
			array(
				'label'   => __( 'رنگ کرم روشن (پس‌زمینه ثانویه)', 'bajistyle' ),
				'section' => 'bajistyle_brand_colors',
			)
		)
	);

	/* ---------------------------------------------------------------
	 * بخش: بخش هیرو صفحه اصلی
	 * -------------------------------------------------------------- */
	$wp_customize->add_section(
		'bajistyle_hero_section',
		array(
			'title'    => __( 'بخش هیرو صفحه اصلی', 'bajistyle' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_title',
		array(
			'default'           => __( 'مجموعه جدید بهار و تابستان', 'bajistyle' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_title',
		array(
			'label'   => __( 'عنوان هیرو', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_subtitle',
		array(
			'default'           => __( 'ظرافت در هر جزئیات', 'bajistyle' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_subtitle',
		array(
			'label'   => __( 'زیرعنوان هیرو', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_button_text',
		array(
			'default'           => __( 'مشاهده مجموعه', 'bajistyle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_button_text',
		array(
			'label'   => __( 'متن دکمه هیرو', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_button_url',
		array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_button_url',
		array(
			'label'   => __( 'لینک دکمه هیرو', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'bajistyle_hero_image',
			array(
				'label'   => __( 'تصویر پس‌زمینه هیرو (دسکتاپ)', 'bajistyle' ),
				'section' => 'bajistyle_hero_section',
			)
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_image_mobile',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'bajistyle_hero_image_mobile',
			array(
				'label'       => __( 'تصویر پس‌زمینه هیرو (موبایل)', 'bajistyle' ),
				'description' => __( 'اختیاری. در صورت خالی بودن، همان تصویر دسکتاپ با برش خودکار در موبایل نمایش داده می‌شود. ابعاد پیشنهادی: ۱۰۸۰×۱۳۵۰', 'bajistyle' ),
				'section'     => 'bajistyle_hero_section',
			)
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_overlay_opacity',
		array(
			'default'           => '30',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_overlay_opacity',
		array(
			'label'   => __( 'شدت لایه تیره روی تصویر', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'select',
			'choices' => array(
				'0'  => __( 'بدون لایه تیره', 'bajistyle' ),
				'15' => __( 'خیلی کم (۱۵٪)', 'bajistyle' ),
				'30' => __( 'کم (۳۰٪)', 'bajistyle' ),
				'45' => __( 'متوسط (۴۵٪)', 'bajistyle' ),
				'60' => __( 'زیاد (۶۰٪)', 'bajistyle' ),
			),
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_text_position',
		array(
			'default'           => 'center',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_text_position',
		array(
			'label'   => __( 'موقعیت متن هیرو', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'select',
			'choices' => array(
				'right'  => __( 'راست', 'bajistyle' ),
				'center' => __( 'وسط', 'bajistyle' ),
				'left'   => __( 'چپ', 'bajistyle' ),
			),
		)
	);

	$wp_customize->add_setting(
		'bajistyle_hero_text_theme',
		array(
			'default'           => 'light',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control(
		'bajistyle_hero_text_theme',
		array(
			'label'   => __( 'تم رنگی متن هیرو', 'bajistyle' ),
			'section' => 'bajistyle_hero_section',
			'type'    => 'select',
			'choices' => array(
				'light' => __( 'روشن (برای تصاویر تیره)', 'bajistyle' ),
				'dark'  => __( 'تیره (برای تصاویر روشن)', 'bajistyle' ),
			),
		)
	);

	/* ---------------------------------------------------------------
	 * بخش: داستان برند
	 * -------------------------------------------------------------- */
	$wp_customize->add_section(
		'bajistyle_brand_story',
		array(
			'title'    => __( 'داستان برند', 'bajistyle' ),
			'priority' => 36,
		)
	);

	$wp_customize->add_setting(
		'bajistyle_brand_story_title',
		array(
			'default'           => __( 'داستان BajiStyle', 'bajistyle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'bajistyle_brand_story_title',
		array(
			'label'   => __( 'عنوان داستان برند', 'bajistyle' ),
			'section' => 'bajistyle_brand_story',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_brand_story_text',
		array(
			'default'           => __( 'BajiStyle با عشق به زیبایی و توجه به جزئیات متولد شد تا لحظات شما را خاص‌تر کند.', 'bajistyle' ),
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'bajistyle_brand_story_text',
		array(
			'label'   => __( 'متن داستان برند', 'bajistyle' ),
			'section' => 'bajistyle_brand_story',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_brand_story_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'bajistyle_brand_story_image',
			array(
				'label'   => __( 'تصویر داستان برند', 'bajistyle' ),
				'section' => 'bajistyle_brand_story',
			)
		)
	);

	/* ---------------------------------------------------------------
	 * بخش: شبکه‌های اجتماعی
	 * -------------------------------------------------------------- */
	$wp_customize->add_section(
		'bajistyle_social_links',
		array(
			'title'    => __( 'شبکه‌های اجتماعی', 'bajistyle' ),
			'priority' => 40,
		)
	);

	$social_networks = array(
		'instagram' => __( 'اینستاگرام', 'bajistyle' ),
		'telegram'  => __( 'تلگرام', 'bajistyle' ),
		'whatsapp'  => __( 'واتساپ', 'bajistyle' ),
		'pinterest' => __( 'پینترست', 'bajistyle' ),
	);

	foreach ( $social_networks as $network_key => $network_label ) {
		$wp_customize->add_setting(
			'bajistyle_social_' . $network_key,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'bajistyle_social_' . $network_key,
			array(
				'label'   => $network_label,
				'section' => 'bajistyle_social_links',
				'type'    => 'url',
			)
		);
	}

	/* ---------------------------------------------------------------
	 * بخش: تماس و فوتر
	 * -------------------------------------------------------------- */
	$wp_customize->add_section(
		'bajistyle_contact_info',
		array(
			'title'    => __( 'اطلاعات تماس', 'bajistyle' ),
			'priority' => 41,
		)
	);

	$wp_customize->add_setting(
		'bajistyle_contact_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'bajistyle_contact_phone',
		array(
			'label'   => __( 'شماره تماس', 'bajistyle' ),
			'section' => 'bajistyle_contact_info',
			'type'    => 'tel',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_contact_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'bajistyle_contact_email',
		array(
			'label'   => __( 'ایمیل', 'bajistyle' ),
			'section' => 'bajistyle_contact_info',
			'type'    => 'email',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_contact_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'bajistyle_contact_address',
		array(
			'label'   => __( 'آدرس', 'bajistyle' ),
			'section' => 'bajistyle_contact_info',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'bajistyle_footer_copyright',
		array(
			'default'           => __( 'تمامی حقوق برای BajiStyle محفوظ است.', 'bajistyle' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'bajistyle_footer_copyright',
		array(
			'label'   => __( 'متن کپی‌رایت فوتر', 'bajistyle' ),
			'section' => 'bajistyle_contact_info',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'bajistyle_customize_register' );

/**
 * خروجی CSS متغیرهای رنگی سفارشی‌شده توسط کاربر در Customizer.
 *
 * مقادیر رنگ به‌صورت متغیرهای CSS در head سایت چاپ می‌شوند تا
 * Tailwind و استایل سفارشی بتوانند از آن‌ها استفاده کنند.
 *
 * @since 1.0.0
 */
function bajistyle_customizer_css_vars() {
	$primary = get_theme_mod( 'bajistyle_color_primary', '#C9A227' );
	$dark    = get_theme_mod( 'bajistyle_color_dark', '#111111' );
	$cream   = get_theme_mod( 'bajistyle_color_cream', '#F8F5EF' );
	?>
	<style id="bajistyle-customizer-vars">
		:root {
			--baji-gold: <?php echo esc_html( $primary ); ?>;
			--baji-black: <?php echo esc_html( $dark ); ?>;
			--baji-cream: <?php echo esc_html( $cream ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'bajistyle_customizer_css_vars' );

/**
 * بارگذاری اسکریپت پیش‌نمایش زنده برای Customizer.
 *
 * @since 1.0.0
 */
function bajistyle_customize_preview_js() {
	wp_enqueue_script(
		'bajistyle-customizer-preview',
		BAJISTYLE_URI . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		BAJISTYLE_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'bajistyle_customize_preview_js' );
