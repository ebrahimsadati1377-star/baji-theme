# راهنمای شخصی‌سازی قالب BajiStyle

---

## ۱. شخصی‌سازی رنگ‌ها

### روش اول: Customizer (پیشنهادی)

از **ظاهر ← شخصی‌سازی ← رنگ‌های برند BajiStyle**، رنگ‌ها را تغییر دهید.
تغییرات به‌صورت CSS variable اعمال می‌شوند:

```css
:root {
  --baji-gold:  #C9A227;  /* رنگ اصلی طلایی */
  --baji-black: #111111;  /* مشکی */
  --baji-cream: #F8F5EF;  /* کرم روشن */
}
```

### روش دوم: ویرایش Tailwind Config

فایل `tailwind.config.js` را ویرایش کنید:

```js
theme: {
  extend: {
    colors: {
      'baji-gold':  '#C9A227',
      'baji-black': '#111111',
      'baji-cream': '#F8F5EF',
    },
  },
},
```

سپس rebuild کنید: `npm run build:css`

---

## ۲. شخصی‌سازی فونت

### تغییر به ایران‌سنس

1. فایل‌های woff2 ایران‌سنس را در `assets/fonts/iransans/` قرار دهید.
2. فایل `assets/fonts/vazirmatn/vazirmatn.css` را ویرایش (یا یک CSS مشابه بسازید):

```css
@font-face {
  font-family: 'IRANSans';
  src: url('../iransans/IRANSansWeb.woff2') format('woff2');
  font-weight: 400;
  font-display: swap;
}
```

3. در `tailwind.config.js` نام فونت را تغییر دهید:

```js
fontFamily: {
  vazir: ['IRANSans', 'Tahoma', 'sans-serif'],
},
```

4. در `functions.php` handle فونت را به‌روزرسانی کنید.

---

## ۳. تغییر صفحه اصلی

برای حذف یا اضافه کردن بخش‌ها، فایل `front-page.php` را ویرایش کنید.
هر بخش یک `get_template_part()` جداگانه دارد:

```php
get_template_part( 'template-parts/hero-section' );       // هیرو
get_template_part( 'template-parts/category-showcase' );  // دسته‌بندی‌ها
get_template_part( 'template-parts/product-grid', null, ['query_type'=>'best_selling', 'limit'=>8] );
get_template_part( 'template-parts/brand-story' );         // داستان برند
get_template_part( 'template-parts/testimonial' );         // نظرات
```

---

## ۴. تغییر تعداد محصولات گرید

در `inc/woocommerce-hooks.php`:

```php
// تعداد محصولات در هر صفحه
function bajistyle_products_per_page() {
    return 24; // اینجا عدد را تغییر دهید
}

// تعداد ستون‌های گرید
function bajistyle_loop_columns() {
    return 4; // اینجا عدد را تغییر دهید
}
```

---

## ۵. افزودن سایدبار اختصاصی به فیلتر فروشگاه

اگر می‌خواهید ویجت‌های سفارشی در فیلتر فروشگاه داشته باشید:

1. از **ظاهر ← ابزارک‌ها** ناحیه «فیلتر فروشگاه (ووکامرس)» را پیدا کنید.
2. ویجت‌های WooCommerce (فیلتر قیمت، فیلتر لایه‌ای و غیره) را اضافه کنید.
3. در صورت فعال بودن این ناحیه، فیلترهای پیش‌فرض قالب جایگزین می‌شوند.

---

## ۶. استفاده از Child Theme

### ساخت Child Theme

1. یک پوشه جدید بسازید: `wp-content/themes/bajistyle-child/`
2. فایل `style.css` بسازید:

```css
/*
Theme Name: BajiStyle Child
Template: bajistyle
Version: 1.0.0
*/
```

3. فایل `functions.php` بسازید:

```php
<?php
add_action( 'wp_enqueue_scripts', 'bajistyle_child_enqueue' );
function bajistyle_child_enqueue() {
    wp_enqueue_style(
        'bajistyle-child-style',
        get_stylesheet_uri(),
        ['bajistyle-custom'],
        wp_get_theme()->get( 'Version' )
    );
}
```

### Override کردن تمپلیت‌ها در Child Theme

برای تغییر هر فایل، کافی است همان مسیر را در Child Theme بسازید:

```
bajistyle-child/
├── woocommerce/
│   └── single-product.php  ← override صفحه محصول
└── template-parts/
    └── hero-section.php    ← override هیرو
```

---

## مدیریت حرفه‌ای اسلایدر هیرو (موبایل و دسکتاپ)

هر اسلاید (از **اسلایدر هیرو** در پیشخوان) کنترل کامل و مستقلی روی نمایش
موبایل و دسکتاپ دارد:

### تصویر جدا برای موبایل

در سایدبار ادیتور اسلاید، باکس **«تصویر اختصاصی موبایل»** را می‌بینید.
اگر این تصویر را آپلود کنید، دقیقاً همان تصویر (نه یک crop خودکار از
تصویر شاخص) روی صفحات با عرض کمتر از ۷۶۸ پیکسل نمایش داده می‌شود.

| نوع تصویر | ابعاد پیشنهادی | نسبت |
|-----------|------------------|------|
| تصویر شاخص (دسکتاپ) | ۱۹۲۰ × ۱۰۸۰ | ۱۶:۹ (افقی) |
| تصویر موبایل (اختیاری) | ۱۰۸۰ × ۱۳۵۰ | ۴:۵ (عمودی) |

این سوییچ با `<picture>` و `<source media="...">` واقعی HTML انجام
می‌شود (نه فقط CSS)، یعنی مرورگر موبایل اصلاً فایل تصویر دسکتاپ را
دانلود نمی‌کند — سرعت بارگذاری صفحه در موبایل هم بهتر می‌شود.

اگر تصویر موبایل را خالی بگذارید، رفتار قبلی (crop خودکار تصویر دسکتاپ با
`object-cover`) ادامه پیدا می‌کند؛ یعنی این ویژگی کاملاً اختیاری است.

### شدت لایه تیره روی تصویر (Overlay)

از باکس «دکمه و نمایش اسلاید»، گزینه **«شدت لایه تیره روی تصویر»** را
برای هر اسلاید جداگانه تنظیم کنید (بدون لایه تا ۶۰٪). برای تصاویر
روشن، مقدار بیشتری انتخاب کنید تا متن روی آن خوانا بماند.

### موقعیت و تم رنگی متن

- **موقعیت متن**: راست/وسط/چپ — کنترل می‌کند بلوک عنوان و دکمه در کدام
  سمت کادر قرار بگیرد.
- **تم رنگی متن**: روشن (برای تصاویر تیره) یا تیره (برای تصاویر روشن).

این سه گزینه (overlay، موقعیت، تم) برای **هیرو ثابت** (fallback بدون
اسلاید) هم از مسیر **ظاهر ← شخصی‌سازی ← بخش هیرو صفحه اصلی** در دسترس‌اند
و همان منطق را دارند.

### نکته فنی: نقطه شکست موبایل/دسکتاپ

نقطه شکست (breakpoint) سوییچ تصویر روی ۷۶۷ پیکسل تنظیم شده (هماهنگ با
`md` در Tailwind). در صورت تغییر breakpoint در `tailwind.config.js`،
مقدار ثابت `BAJISTYLE_HERO_MOBILE_BREAKPOINT` در ابتدای
`template-parts/hero-section.php` را هم به‌روزرسانی کنید.

---

## ۷. افزودن Hook سفارشی

قالب از معماری hook-based استفاده می‌کند. در Child Theme یا افزونه اختصاصی:

```php
// اضافه کردن محتوا بعد از هیرو صفحه اصلی
add_action( 'bajistyle_after_hero', function() {
    echo '<div class="my-custom-banner">بنر سفارشی</div>';
} );

// تغییر تعداد محصولات پیشنهادی
add_filter( 'loop_shop_per_page', function() {
    return 12;
}, 30 );
```

---

## ۸. شخصی‌سازی اسکریپت‌های JS

### افزودن JS سفارشی

در Child Theme یا افزونه:

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'my-custom-script',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        ['bajistyle-main'],
        '1.0.0',
        ['in_footer' => true, 'strategy' => 'defer']
    );
} );
```

### دسترسی به API سبد خرید از JS سفارشی

```js
// باز کردن سبد کناری از اسکریپت دیگر
if ( window.bajistyleCart ) {
    window.bajistyleCart.open();
}
```

---

## ۹. Schema Markup سفارشی

برای تغییر اطلاعات برند در Schema.org:

```php
// در functions.php یا inc/woocommerce-hooks.php
add_filter( 'woocommerce_structured_data_product', function( $markup, $product ) {
    $markup['brand'] = [
        '@type' => 'Brand',
        'name'  => 'نام برند شما',
        'logo'  => 'https://example.com/logo.png',
    ];
    return $markup;
}, 20, 2 );
```

---

## ۱۰. تنظیم خبرنامه برای اتصال به Mailchimp

در `inc/newsletter.php` هوک زیر برای اتصال به سرویس‌های خارجی وجود دارد:

```php
add_action( 'bajistyle_newsletter_subscribed', function( $email ) {
    // ارسال به Mailchimp API
    $api_key = 'YOUR_MAILCHIMP_API_KEY';
    $list_id = 'YOUR_LIST_ID';
    
    wp_remote_post(
        "https://us1.api.mailchimp.com/3.0/lists/{$list_id}/members",
        [
            'headers' => [
                'Authorization' => 'apikey ' . $api_key,
                'Content-Type'  => 'application/json',
            ],
            'body' => wp_json_encode([
                'email_address' => $email,
                'status'        => 'subscribed',
            ]),
        ]
    );
} );
```
