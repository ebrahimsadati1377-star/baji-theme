/**
 * تنظیمات Webpack برای باندل‌سازی فایل‌های جاوااسکریپت ماژولار قالب BajiStyle
 *
 * فایل‌های منبع (قابل ویرایش) در assets/js/src/ قرار دارند. خروجی
 * build در assets/js/ (همان مسیری که functions.php با wp_enqueue_script
 * بارگذاری می‌کند) قرار می‌گیرد و همان نام فایل اصلی (main.js،
 * navigation.js و غیره) را حفظ می‌کند. فایل‌های assets/js/*.js که از
 * ابتدا در مخزن وجود دارند، آخرین خروجی build هستند و مستقیماً نیز
 * قابل استفاده‌اند (نیازی به اجرای build برای راه‌اندازی اولیه قالب نیست).
 *
 * هر فایل JS قالب به‌صورت مستقل (entry جداگانه) باندل می‌شود تا
 * بارگذاری شرطی آن‌ها در functions.php (مثلاً فقط در صفحات ووکامرس)
 * همچنان ممکن باشد.
 */

const path = require( 'path' );

module.exports = ( env, argv ) => {
	const isProduction = argv.mode === 'production';

	return {
		entry: {
			main: './assets/js/src/main.js',
			navigation: './assets/js/src/navigation.js',
			woocommerce: './assets/js/src/woocommerce.js',
			animations: './assets/js/src/animations.js',
			cart: './assets/js/src/cart.js',
			checkout: './assets/js/src/checkout.js',
		},
		output: {
			path: path.resolve( __dirname, 'assets/js' ),
			filename: '[name].js',
			clean: false,
			module: true,
			library: {
				type: 'module',
			},
		},
		experiments: {
			outputModule: true,
		},
		devtool: isProduction ? false : 'source-map',
		mode: isProduction ? 'production' : 'development',
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					use: {
						loader: 'babel-loader',
						options: {
							presets: [
								[
									'@babel/preset-env',
									{
										targets: '> 1%, last 2 versions, not dead',
									},
								],
							],
						},
					},
				},
			],
		},
		optimization: {
			minimize: isProduction,
		},
		externals: {
			jquery: 'jQuery',
		},
	};
};
