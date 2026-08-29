<?php
/* Template Name: Terms and Conditions - BajiStyle */
get_header(); ?>

<main class="w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20" dir="rtl">

    <!-- هدر صفحه -->
    <div class="text-center mb-16">
        <span class="text-rose-500 font-medium text-sm md:text-base tracking-wider block mb-2">TERMS & CONDITIONS</span>
        <h1 class="text-3xl md:text-5xl font-extrabold text-stone-800 mb-4 tracking-tight">
            قوانین و مقررات <span class="text-rose-600">باجی‌استایل</span>
        </h1>
        <p class="text-stone-500 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
            حضور شما در وب‌سایت باجی‌استایل و ثبت سفارش، به منزله مطالعه و قبول شرایط و قوانین زیر است. لطفاً پیش از خرید، این موارد را به دقت بررسی فرمایید.
        </p>
    </div>

    <!-- بخش محتوای داینامیک (اگر در ویرایشگر وردپرس متنی بنویسید اینجا نمایش داده می‌شود) -->
    <?php if (have_posts()) : while (have_posts()) : the_post();
        if (get_the_content()) : ?>
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-stone-100 mb-10 text-stone-700 leading-loose prose max-w-none">
                <?php the_content(); ?>
            </div>
        <?php endif;
    endwhile; endif; ?>

    <!-- لیست قوانین (کارت‌های تفکیک‌شده و مرتب) -->
    <div class="space-y-6">

        <!-- کارت ۱: ثبت و پردازش سفارش -->
        <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-rose-200 transition duration-300">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg shrink-0">
                    ۱
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-stone-800">ثبت، پردازش و ارسال سفارش</h2>
            </div>
            <div class="text-stone-600 leading-relaxed space-y-3 text-sm md:text-base pr-14 text-justify">
                <p>• تمامی سفارش‌های ثبت‌شده، پس از تایید مالی وارد مرحله پردازش و بسته‌بندی در کارگاه تولیدی باجی‌استایل می‌شوند.</p>
                <p>• زمان آماده‌سازی و ارسال کالا برای **مشتریان عزیز در شهرستان بهشهر** بین ۱ تا ۲ روز کاری (از طریق پیک یا تحویل حضوری در مزون) و برای **سایر شهرهای کشور** از طریق پست پیشتاز یا تیپاکس بین ۳ تا ۶ روز کاری خواهد بود.</p>
                <p>• در صورت بروز هرگونه مشکل در موجودی پارچه یا اتمام موجودی محصول، مبلغ پرداخت‌شده در کوتاه‌ترین زمان ممکن (حداکثر ۴۸ ساعت کاری) به حساب مشتری عودت داده می‌شود.</p>
            </div>
        </section>

        <!-- کارت ۲: راهنمای سایز و پرو (مخصوص مزون لباس) -->
        <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-rose-200 transition duration-300">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg shrink-0">
                    ۲
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-stone-800">انتخاب سایز و مشخصات لباس</h2>
            </div>
            <div class="text-stone-600 leading-relaxed space-y-3 text-sm md:text-base pr-14 text-justify">
                <p>• با توجه به تفاوت قواره‌ها در مدل‌های مختلف، ملاک اصلی انتخاب سایز، **جدول راهنمای سایز** درج‌شده در صفحه هر محصول است. لطفاً پیش از ثبت سفارش، اندازه‌های خود را با جدول تطبیق دهید.</p>
                <p>• به دلیل تفاوت در نمایشگرهای مختلف (گوشی یا لپ‌تاپ) و شرایط نورپردازی در عکاسی مزون، ممکن است رنگ واقعی لباس ۱ تا ۲۰ درصد با عکس تفاوت داشته باشد که این امر طبیعی است.</p>
                <p>• در سفارش‌های اختصاصی یا شخصی‌دوزی، مسئولیت اعلام دقیق اندازه‌ها به عهده مشتری می‌باشد.</p>
            </div>
        </section>

        <!-- کارت ۳: شرایط تعویض و مرجوعی کالا (بسیار مهم برای لباس) -->
        <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-rose-200 transition duration-300">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg shrink-0">
                    ۳
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-stone-800">شرایط تعویض و مرجوعی کالا</h2>
            </div>
            <div class="text-stone-600 leading-relaxed space-y-3 text-sm md:text-base pr-14 text-justify">
                <p>• رضایت شما اولویت ماست. در صورت وجود هرگونه نقص فنی در دوخت یا پارچه، کالا تا **۴۸ ساعت پس از تحویل** با هزینه مزون قابل تعویض یا مرجوعی است.</p>
                <p>• به دلیل مسائل بهداشتی و ظرافت لباس‌های زنانه، تعویض سلیقه‌ای یا تغییر سایز تنها در صورتی امکان‌پذیر است که لباس **پرو نشده باشد، بوی عطر، بدن یا مواد شوینده نگرفته باشد و تگ (برچسب) لباس جدا نشده باشد.**</p>
                <p>• لباس‌هایی که در جشنواره‌های تخفیف فوق‌العاده خریداری می‌شوند یا سفارش‌هایی که به درخواست مشتری تغییرات اختصاصی (کوتاه کردن قد، تغییر آستین و...) روی آن‌ها اعمال شده است، شامل شرایط تعویض و مرجوعی نمی‌شوند.</p>
            </div>
        </section>

        <!-- کارت ۴: حفظ حریم خصوصی -->
        <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-rose-200 transition duration-300">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg shrink-0">
                    ۴
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-stone-800">حفظ حریم خصوصی کاربران</h2>
            </div>
            <div class="text-stone-600 leading-relaxed space-y-3 text-sm md:text-base pr-14 text-justify">
                <p>• مزون باجی‌استایل متعهد می‌شود که اطلاعات شخصی شما (نام، شماره تماس، آدرس و...) را کاملاً محرمانه تلقی کرده و صرفاً برای پردازش و ارسال سفارش‌ها از آن‌ها استفاده کند.</p>
                <p>• تمامی تراکنش‌های مالی از طریق درگاه‌های بانکی معتبر و ایمن کشور انجام می‌شود و سایت باجی‌استایل هیچ‌گونه دسترسی به اطلاعات بانکی و کارت شما ندارد.</p>
            </div>
        </section>

        <!-- کارت ۵: پشتیبانی و پاسخگویی -->
        <section class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-rose-200 transition duration-300">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg shrink-0">
                    ۵
                </div>
                <h2 class="text-xl md:text-2xl font-bold text-stone-800">پشتیبانی و حل اختلاف</h2>
            </div>
            <div class="text-stone-600 leading-relaxed space-y-3 text-sm md:text-base pr-14 text-justify">
                <p>• در صورت بروز هرگونه ابهام یا سوال، تیم پشتیبانی باجی‌استایل از طریق واتس‌اپ، اینستاگرام و شماره‌های تماس درج‌شده در صفحه «تماس با ما» پاسخگوی شما خواهد بود.</p>
                <p>• هدف ما خلق یک تجربه خرید لذت‌بخش و مطمئن برای بانوان ایرانی است و همواره تلاش می‌کنیم در فضایی دوستانه و تعاملی، بهترین خدمات را ارائه دهیم.</p>
            </div>
        </section>

    </div>

    <!-- باکس راهنمایی سریع در پایین صفحه -->
    <div class="mt-16 bg-stone-100 rounded-3xl p-8 text-center border border-stone-200">
        <h3 class="text-lg font-bold text-stone-800 mb-2">نیاز به راهنمایی بیشتری دارید؟</h3>
        <p class="text-stone-600 text-sm mb-6">قبل از ثبت سفارش می‌توانید از کارشناسان ما در مزون مشاوره سایز و استایل بگیرید.</p>
        <a href="<?php echo site_url('/contact'); ?>" class="inline-block bg-rose-600 hover:bg-rose-700 text-white font-medium px-8 py-3 rounded-xl transition shadow-sm">
            ارتباط با پشتیبانی
        </a>
    </div>

</main>

<?php get_footer(); ?>