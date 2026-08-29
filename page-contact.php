<?php
/* Template Name: Contact Us - BajiStyle */
get_header(); ?>

<main class="w-full max-w-5xl mx-auto px-4 py-16" dir="rtl">
    
    <!-- عنوان صفحه -->
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-stone-800 mb-4">تماس با باجی‌استایل</h1>
        <p class="text-stone-500">برای مشاوره، سفارش دوخت و هماهنگی پرو، در کنار شما هستیم.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        
        <!-- سمت راست: اطلاعات تماس -->
        <div class="space-y-8">
            <div class="bg-stone-50 p-8 rounded-2xl border border-stone-100">
                <h2 class="text-2xl font-bold text-stone-800 mb-6">راه‌های ارتباطی</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <span class="text-rose-500 ml-4 text-xl">📍</span>
                        <div>
                            <h4 class="font-bold text-stone-700">آدرس مزون:</h4>
                            <p class="text-stone-600">بهشهر، بلوار هاشمی نژاد،فروشگاه فامیلی طبقه بالا</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <span class="text-rose-500 ml-4 text-xl">📞</span>
                        <div>
                            <h4 class="font-bold text-stone-700">تلفن تماس:</h4>
                            <p class="text-stone-600">09111599908</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="text-rose-500 ml-4 text-xl">🕒</span>
                        <div>
                            <h4 class="font-bold text-stone-700">ساعات کاری:</h4>
                            <p class="text-stone-600">شنبه تا پنجشنبه: ۱۰ صبح الی ۸ شب</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- لینک شبکه‌های اجتماعی -->
            <div class="flex gap-4">
                <a href="#" class="bg-stone-800 text-white px-6 py-3 rounded-lg hover:bg-rose-600 transition">اینستاگرام ما</a>
                <a href="#" class="bg-stone-200 text-stone-700 px-6 py-3 rounded-lg hover:bg-stone-300 transition">واتس‌اپ</a>
            </div>
        </div>

        <!-- سمت چپ: فرم تماس (استفاده از شورت‌کد فرم‌ساز) -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-stone-100">
            <h2 class="text-2xl font-bold text-stone-800 mb-6">ارسال پیام مستقیم</h2>
            
            <!-- اینجا شورت‌کد فرم خود را قرار دهید (مثلاً Contact Form 7) -->
            <?php echo do_shortcode('[contact-form-7 id="bea86db" title="تماس با ما"]'); ?>
            
            <p class="text-xs text-stone-400 mt-4 text-center">
                تیم باجی‌استایل در کمتر از ۲۴ ساعت به پیام شما پاسخ می‌دهد.
            </p>
        </div>

    </div>
</main>

<?php get_footer(); ?>