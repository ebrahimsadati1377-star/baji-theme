<?php
/**
 * توابع کمکی و Template Tags قالب BajiStyle
 *
 * توابعی که در چندین فایل تمپلیت قالب استفاده می‌شوند و خروجی
 * تکراری HTML تولید می‌کنند، در این فایل متمرکز شده‌اند.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bajistyle_posted_on' ) ) {
	/**
	 * نمایش تاریخ انتشار نوشته به‌صورت قابل‌خواندن.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		echo '<span class="baji-posted-on text-sm text-gray-500">' . wp_kses_post( $time_string ) . '</span>'; // phpcs:ignore
	}
}

if ( ! function_exists( 'bajistyle_posted_by' ) ) {
	/**
	 * نمایش نام نویسنده نوشته.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_posted_by() {
		echo '<span class="baji-byline text-sm text-gray-500">' .
			esc_html__( 'نویسنده:', 'bajistyle' ) . ' ' .
			'<span class="author vcard">' .
			'<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' .
			esc_html( get_the_author() ) .
			'</a></span></span>';
	}
}

if ( ! function_exists( 'bajistyle_entry_footer' ) ) {
	/**
	 * نمایش دسته‌بندی‌ها و برچسب‌های نوشته در فوتر آن.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_entry_footer() {
		if ( 'post' !== get_post_type() ) {
			return;
		}

		$categories_list = get_the_category_list( esc_html__( '، ', 'bajistyle' ) );
		if ( $categories_list ) {
			printf(
				'<span class="baji-cat-links text-sm text-baji-gold">%1$s</span>',
				wp_kses_post( $categories_list )
			);
		}

		$tags_list = get_the_tag_list( '', esc_html__( '، ', 'bajistyle' ) );
		if ( $tags_list && ! is_wp_error( $tags_list ) ) {
			printf(
				'<span class="baji-tag-links text-sm text-gray-400 mr-4">%1$s</span>',
				wp_kses_post( $tags_list )
			);
		}
	}
}

if ( ! function_exists( 'bajistyle_pagination' ) ) {
	/**
	 * نمایش صفحه‌بندی استاندارد با استایل قالب در صفحات آرشیو.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_pagination() {
		the_posts_pagination(
			array(
				'mid_size'           => 2,
				'prev_text'          => esc_html__( '« قبلی', 'bajistyle' ),
				'next_text'          => esc_html__( 'بعدی »', 'bajistyle' ),
				'screen_reader_text' => esc_html__( 'صفحه‌بندی نوشته‌ها', 'bajistyle' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'صفحه', 'bajistyle' ) . ' </span>',
				'class'              => 'baji-pagination flex items-center justify-center gap-2 mt-12',
			)
		);
	}
}

if ( ! function_exists( 'bajistyle_star_rating' ) ) {
	/**
	 * تولید نشانگر بصری رتبه‌بندی ستاره‌ای برای استفاده عمومی (مثلاً نظرات).
	 *
	 * @param float $rating امتیاز از ۰ تا ۵.
	 * @param int   $count  تعداد رأی‌دهندگان (اختیاری).
	 * @since 1.0.0
	 */
	function bajistyle_star_rating( $rating = 0, $count = 0 ) {
		$rating       = max( 0, min( 5, (float) $rating ) );
		$full_stars   = floor( $rating );
		$has_half     = ( $rating - $full_stars ) >= 0.5;
		$empty_stars  = 5 - $full_stars - ( $has_half ? 1 : 0 );

		echo '<span class="baji-star-rating inline-flex items-center text-baji-gold" role="img" aria-label="' .
			esc_attr(
				sprintf(
					/* translators: %s: امتیاز رتبه‌بندی */
					__( 'امتیاز %s از ۵', 'bajistyle' ),
					$rating
				)
			) . '">';

		for ( $i = 0; $i < $full_stars; $i++ ) {
			echo '<span class="baji-star baji-star-full">★</span>';
		}
		if ( $has_half ) {
			echo '<span class="baji-star baji-star-half">★</span>';
		}
		for ( $i = 0; $i < $empty_stars; $i++ ) {
			echo '<span class="baji-star baji-star-empty text-gray-300">★</span>';
		}

		echo '</span>';

		if ( $count > 0 ) {
			printf(
				'<span class="baji-rating-count text-xs text-gray-400 mr-2">(%d)</span>',
				absint( $count )
			);
		}
	}
}

if ( ! function_exists( 'bajistyle_get_excerpt' ) ) {
	/**
	 * تولید خلاصه کوتاه از محتوای پست با طول دلخواه.
	 *
	 * @param int $length تعداد کلمات.
	 * @return string متن خلاصه‌شده.
	 * @since 1.0.0
	 */
	function bajistyle_get_excerpt( $length = 20 ) {
		$excerpt = get_the_excerpt();
		$excerpt = wp_trim_words( $excerpt, $length, '...' );
		return $excerpt;
	}
}

if ( ! function_exists( 'bajistyle_social_share_links' ) ) {
	/**
	 * نمایش لینک‌های اشتراک‌گذاری شبکه‌های اجتماعی برای صفحه فعلی.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_social_share_links() {
		$url   = rawurlencode( get_permalink() );
		$title = rawurlencode( get_the_title() );
		?>
		<div class="baji-social-share flex items-center gap-3">
			<a href="https://t.me/share/url?url=<?php echo esc_attr( $url ); ?>&text=<?php echo esc_attr( $title ); ?>"
				target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'اشتراک‌گذاری در تلگرام', 'bajistyle' ); ?>">
				<?php esc_html_e( 'تلگرام', 'bajistyle' ); ?>
			</a>
			<a href="https://wa.me/?text=<?php echo esc_attr( $title . ' ' . $url ); ?>"
				target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'اشتراک‌گذاری در واتساپ', 'bajistyle' ); ?>">
				<?php esc_html_e( 'واتساپ', 'bajistyle' ); ?>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'bajistyle_get_theme_color' ) ) {
	/**
	 * دریافت یکی از رنگ‌های برند تنظیم‌شده در Customizer.
	 *
	 * @param string $key نام رنگ (primary, dark, cream).
	 * @return string کد هگز رنگ.
	 * @since 1.0.0
	 */
	function bajistyle_get_theme_color( $key = 'primary' ) {
		$defaults = array(
			'primary' => '#C9A227',
			'dark'    => '#111111',
			'cream'   => '#F8F5EF',
		);

		$mod_key = 'bajistyle_color_' . $key;
		$default = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '#C9A227';

		return get_theme_mod( $mod_key, $default );
	}
}

if ( ! function_exists( 'bajistyle_comment_callback' ) ) {
	/**
	 * رندر سفارشی هر آیتم نظر با استایل قالب.
	 *
	 * @param WP_Comment $comment شیء نظر.
	 * @param array      $args    آرگومان‌های لیست نظرات.
	 * @param int        $depth   عمق نظر (برای پاسخ‌های تو در تو).
	 * @since 1.0.0
	 */
	function bajistyle_comment_callback( $comment, $args, $depth ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		?>
		<<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'baji-comment flex gap-4' ); ?>>
			<div class="baji-comment-avatar shrink-0">
				<?php echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'rounded-full' ) ); ?>
			</div>
			<div class="baji-comment-body flex-1">
				<div class="flex items-center gap-3 mb-1">
					<span class="baji-comment-author text-sm font-medium"><?php comment_author(); ?></span>
					<span class="baji-comment-date text-xs text-gray-400">
						<?php echo esc_html( get_comment_date( '', $comment ) ); ?>
					</span>
				</div>

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="baji-comment-awaiting-moderation text-xs text-baji-gold mb-2">
						<?php esc_html_e( 'دیدگاه شما پس از تأیید نمایش داده خواهد شد.', 'bajistyle' ); ?>
					</p>
				<?php endif; ?>

				<div class="baji-comment-content text-sm text-gray-600 leading-7">
					<?php comment_text(); ?>
				</div>

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'reply_text' => esc_html__( 'پاسخ', 'bajistyle' ),
							'class'      => 'baji-comment-reply-link text-xs text-baji-gold mt-2 inline-block',
						)
					)
				);
				?>
			</div>
		<?php
		// تگ بستن توسط wp_list_comments به‌صورت خودکار اضافه می‌شود.
	}
}

if ( ! function_exists( 'bajistyle_breadcrumb' ) ) {
	/**
	 * نمایش breadcrumb ساده برای صفحات غیر ووکامرسی.
	 *
	 * @since 1.0.0
	 */
	function bajistyle_breadcrumb() {
		if ( is_front_page() ) {
			return;
		}
		?>
		<nav class="baji-breadcrumb text-sm text-gray-500 mb-6" aria-label="<?php esc_attr_e( 'مسیر دسترسی', 'bajistyle' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'خانه', 'bajistyle' ); ?></a>
			<span class="mx-2 text-baji-gold">/</span>
			<?php if ( is_search() ) : ?>
				<span><?php esc_html_e( 'نتایج جستجو', 'bajistyle' ); ?></span>
			<?php elseif ( is_404() ) : ?>
				<span><?php esc_html_e( 'صفحه یافت نشد', 'bajistyle' ); ?></span>
			<?php elseif ( is_archive() ) : ?>
				<span><?php the_archive_title(); ?></span>
			<?php elseif ( is_singular() ) : ?>
				<span><?php the_title(); ?></span>
			<?php endif; ?>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'bajistyle_hero_position_classes' ) ) {
	/**
	 * تولید کلاس‌های Tailwind برای موقعیت (راست/وسط/چپ) محتوای متنی هیرو.
	 *
	 * از آنجا که کل قالب RTL است، منطق چیدمان با items-start/items-end
	 * به‌صورت منطقی (نه فیزیکی) با «راست/چپ» بصری هماهنگ شده است.
	 *
	 * @param string $position یکی از مقادیر right, center, left.
	 * @return string رشته کلاس‌های CSS.
	 * @since 1.0.0
	 */
	function bajistyle_hero_position_classes( $position ) {
		$map = array(
			'right'  => 'items-start text-right',
			'center' => 'items-center text-center',
			'left'   => 'items-end text-left',
		);

		return isset( $map[ $position ] ) ? $map[ $position ] : $map['center'];
	}
}

if ( ! function_exists( 'bajistyle_hero_theme_classes' ) ) {
	/**
	 * تولید کلاس‌های Tailwind برای تم رنگی متن و دکمه هیرو.
	 *
	 * @param string $theme یکی از مقادیر light یا dark.
	 * @return array{text: string, button: string} کلاس‌های متن و دکمه.
	 * @since 1.0.0
	 */
	function bajistyle_hero_theme_classes( $theme ) {
		if ( 'dark' === $theme ) {
			return array(
				'text'   => 'text-baji-black',
				'button' => 'border-baji-black hover:bg-baji-black hover:text-baji-white',
			);
		}

		return array(
			'text'   => 'text-baji-white',
			'button' => 'border-baji-white hover:bg-baji-white hover:text-baji-black',
		);
	}
}

if ( ! function_exists( 'bajistyle_hero_overlay_style' ) ) {
	/**
	 * تولید مقدار style برای شدت لایه تیره روی تصویر هیرو.
	 *
	 * @param string|int $opacity عدد بین ۰ تا ۱۰۰ (درصد).
	 * @return string مقدار امن برای attribute style.
	 * @since 1.0.0
	 */
	function bajistyle_hero_overlay_style( $opacity ) {
		$opacity = max( 0, min( 100, absint( $opacity ) ) );
		return sprintf( 'opacity:%s', esc_attr( $opacity / 100 ) );
	}
}
