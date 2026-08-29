<?php
/**
 * کلاس Walker اختصاصی برای رندر منوی مگامنو
 *
 * این کلاس ساختار پیش‌فرض wp_nav_menu را گسترش می‌دهد تا آیتم‌های
 * سطح دوم منو به‌صورت پنل مگامنو با افکت‌های نرم نمایش داده شوند.
 * همچنین در صورت تنظیم تصویر اختصاصی برای آیتم منو (از طریق متای
 * سفارشی)، امکان نمایش تصویر در کنار لینک‌های زیرمنو فراهم می‌شود.
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * کلاس Walker مگامنو.
 *
 * @since 1.0.0
 */
class BajiStyle_Mega_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * شروع سطح فرزند منو (زیرمنو/مگامنو).
	 *
	 * @param string   $output آرگومان خروجی به‌صورت ارجاعی.
	 * @param int      $depth  عمق فعلی منو.
	 * @param stdClass $args   آرگومان‌های منو.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '<div class="baji-mega-menu-panel absolute top-full right-0 w-full bg-baji-white border-t border-gray-100 shadow-lg opacity-0 invisible translate-y-2 transition-all duration-300">';
			$output .= '<div class="max-w-[1800px] mx-auto px-8 py-10 grid grid-cols-4 gap-8">';
			$output .= '<ul class="baji-mega-menu-list col-span-3 grid grid-cols-3 gap-6">';
		} else {
			$output .= '<ul class="baji-submenu-list pr-4 mt-2 space-y-2">';
		}
	}

	/**
	 * پایان سطح فرزند منو.
	 *
	 * @param string   $output آرگومان خروجی به‌صورت ارجاعی.
	 * @param int      $depth  عمق فعلی منو.
	 * @param stdClass $args   آرگومان‌های منو.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( 0 === $depth ) {
			$output .= '</ul>';
			$output .= '<div class="baji-mega-menu-feature col-span-1"></div>';
			$output .= '</div></div>';
		} else {
			$output .= '</ul>';
		}
	}

	/**
	 * شروع رندر یک آیتم منو.
	 *
	 * @param string   $output آرگومان خروجی به‌صورت ارجاعی.
	 * @param WP_Post  $item   شیء آیتم منو.
	 * @param int      $depth  عمق فعلی منو.
	 * @param stdClass $args   آرگومان‌های منو.
	 * @param int      $id     شناسه آیتم منو.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );

		if ( 0 === $depth ) {
			$wrapper_class = 'baji-menu-item relative group' . ( $has_children ? ' baji-has-mega' : '' );
			$output       .= '<li class="' . esc_attr( $wrapper_class ) . '">';

			$link_class = 'baji-menu-link text-sm tracking-wider uppercase transition-colors duration-200 hover:text-baji-gold';
			$output    .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '">';
			$output    .= esc_html( $item->title );
			$output    .= '</a>';
		} else {
			$output .= '<li class="baji-submenu-item">';
			$output .= '<a href="' . esc_url( $item->url ) . '" class="text-sm text-gray-600 hover:text-baji-gold transition-colors duration-200">';
			$output .= esc_html( $item->title );
			$output .= '</a>';
		}
	}

	/**
	 * پایان رندر یک آیتم منو.
	 *
	 * @param string   $output آرگومان خروجی به‌صورت ارجاعی.
	 * @param WP_Post  $item   شیء آیتم منو.
	 * @param int      $depth  عمق فعلی منو.
	 * @param stdClass $args   آرگومان‌های منو.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}
