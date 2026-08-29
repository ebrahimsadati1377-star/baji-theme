=== BajiStyle ===
Contributors: bajistyle
Tags: e-commerce, woocommerce, rtl-language-support, custom-logo, custom-menu, featured-images, translation-ready, custom-colors, full-width-template
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 8.1
WC requires at least: 8.0
WC tested up to: 9.0
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

قالب وردپرس لوکس و برندمحور برای فروشگاه‌های آنلاین پوشاک زنانه، کاملاً RTL و فارسی.

== Description ==

BajiStyle یک قالب وردپرس/ووکامرس حرفه‌ای و لوکس است که به‌صورت اختصاصی برای فروشگاه‌های آنلاین پوشاک زنانه فارسی‌زبان طراحی شده است.

**ویژگی‌های اصلی:**
* طراحی کاملاً RTL و فارسی
* مینیمال و لوکس با فاصله‌گذاری حرفه‌ای
* هدر شفاف با تغییر پس‌زمینه هنگام اسکرول
* منوی مگامنو پیشرفته با Walker اختصاصی
* اسلایدر هیرو با Custom Post Type
* سبد خرید کشویی (Slide-out Cart) با AJAX
* سیستم علاقه‌مندی‌ها (Wishlist) بدون افزونه
* آخرین محصولات بازدیدشده (کوکی محور)
* صفحه فروشگاه با فیلتر پیشرفته (دسته‌بندی، قیمت، رنگ، سایز)
* صفحه محصول با گالری بزرگ و زوم تصویر
* داشبورد حساب کاربری سفارشی
* فرم خبرنامه با AJAX و ذخیره در دیتابیس
* انیمیشن‌های نرم با IntersectionObserver
* Tailwind CSS با پالت رنگی قابل شخصی‌سازی از Customizer
* کاملاً ریسپانسیو برای تمام دستگاه‌ها
* پشتیبانی از Gutenberg و بلوک‌های پیشرفته
* پشتیبانی از Child Theme
* بهینه‌سازی سئو با Schema Markup (brand field)
* امنیت بالا (nonce، sanitization، validation، escape)

== Installation ==

1. پوشه `bajistyle` را به مسیر `/wp-content/themes/` آپلود کنید.
2. از مسیر **ظاهر > پوسته‌ها** قالب BajiStyle را فعال کنید.
3. افزونه WooCommerce را نصب و فعال کنید.
4. از **ظاهر > شخصی‌سازی** رنگ‌ها، هیرو و اطلاعات تماس را تنظیم کنید.
5. از **ظاهر > منوها** منوهای اصلی، موبایل و فوتر را تنظیم کنید.
6. فایل‌های فونت وزیرمتن (woff2) را در `assets/fonts/vazirmatn/` قرار دهید.

برای راهنمای کامل به `documentation/installation-guide.md` مراجعه کنید.

== Frequently Asked Questions ==

= آیا این قالب به افزونه خاصی نیاز دارد؟ =
خیر. فقط WooCommerce لازم است. تمام قابلیت‌ها توکار هستند.

= چطور Tailwind را rebuild کنم؟ =
در پوشه قالب: `npm install` سپس `npm run build`

= آیا از Child Theme پشتیبانی می‌شود؟ =
بله. به‌طور کامل.

== Changelog ==

= 1.0.0 =
* انتشار اولیه قالب BajiStyle

== Credits ==
* فونت وزیرمتن: رستی کردار — مجوز SIL OFL 1.1
* Tailwind CSS — مجوز MIT
