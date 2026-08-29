/**
 * تنظیمات Tailwind CSS قالب BajiStyle
 *
 * این فایل پالت رنگی برند، فونت فارسی، breakpoint های ریسپانسیو
 * و سایر تنظیمات اختصاصی Tailwind را برای قالب تعریف می‌کند.
 */

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./*.php',
		'./template-parts/**/*.php',
		'./woocommerce/**/*.php',
		'./inc/**/*.php',
		'./assets/js/**/*.js',
		'!./node_modules/**',
	],
	// قالب کاملاً RTL است؛ پیشوندهای جهتی Tailwind غیرفعال می‌مانند
	// و جهت‌دهی به‌صورت دستی با dir="rtl" در سطح <html> اعمال شده است.
	important: false,
	theme: {
		extend: {
			colors: {
				'baji-gold': '#C9A227',
				'baji-gold-light': '#E0C168',
				'baji-gold-dark': '#A8841C',
				'baji-black': '#111111',
				'baji-white': '#FFFFFF',
				'baji-cream': '#F8F5EF',
			},
			fontFamily: {
				vazir: [ 'Vazirmatn', 'Tahoma', 'sans-serif' ],
			},
			fontSize: {
				'2xs': '0.7rem',
			},
			letterSpacing: {
				widest2: '0.35em',
			},
			spacing: {
				18: '4.5rem',
				22: '5.5rem',
			},
			transitionTimingFunction: {
				'baji-ease': 'cubic-bezier(0.65, 0, 0.35, 1)',
			},
			boxShadow: {
				'baji-card': '0 4px 24px rgba(17, 17, 17, 0.06)',
				'baji-panel': '0 0 40px rgba(17, 17, 17, 0.15)',
			},
			zIndex: {
				60: '60',
				65: '65',
				70: '70',
				100: '100',
			},
			maxWidth: {
				'8xl': '1800px',
			},
			aspectRatio: {
				'4/5': '4 / 5',
				'3/4': '3 / 4',
			},
			keyframes: {
				bajiFadeUp: {
					'0%': { opacity: '0', transform: 'translateY(20px)' },
					'100%': { opacity: '1', transform: 'translateY(0)' },
				},
				bajiFadeIn: {
					'0%': { opacity: '0' },
					'100%': { opacity: '1' },
				},
			},
			animation: {
				'baji-fade-up': 'bajiFadeUp 0.7s ease-out forwards',
				'baji-fade-in': 'bajiFadeIn 0.5s ease-out forwards',
			},
		},
	},
	plugins: [
		require( '@tailwindcss/forms' ),
		require( '@tailwindcss/aspect-ratio' ),
	],
	corePlugins: {
		// از پلاگین preflight پیش‌فرض استفاده می‌شود؛ استایل‌های پایه
		// وردپرس (مثل .alignright/.alignleft) در custom.css مدیریت می‌شوند.
		preflight: true,
	},
};
