<?php
/* Template Name: About Us - BajiStyle */
get_header(); ?>

<!-- کانتینر اصلی صفحه با جهت‌گیری راست‌چین -->
<main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20" dir="rtl">

    <!-- بخش اول: Hero Section (بنر بالای صفحه) -->
    <section class="relative bg-stone-50 rounded-3xl overflow-hidden shadow-sm mb-20">
        <!-- اگر عکسی برای بک‌گراند دارید می‌توانید اینجا اضافه کنید و کلاس opacity به آن بدهید -->
        <div class="px-6 py-20 md:py-32 text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold text-stone-800 mb-6 tracking-tight">
                داستان <span class="text-rose-600">باجی‌استایل</span>
            </h1>
            <p class="text-lg md:text-2xl text-stone-600 max-w-3xl mx-auto leading-relaxed font-light">
                تلفیق هنرِ دوخت و ظرافتِ زنانه در قلب بهشهر
            </p>
        </div>
    </section>

    <!-- بخش دوم: داستان تولیدی و مزون (متن و عکس در کنار هم) -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-24">
        <div class="order-2 md:order-1 space-y-6">
            <h2 class="text-3xl md:text-4xl font-bold text-stone-800 border-r-4 border-rose-500 pr-4">
                از ایده تا تولید در شهرستان بهشهر
            </h2>
            <div class="text-stone-600 leading-loose space-y-4 text-justify">
                <p>
                    <strong>باجی‌استایل (BajiStyle)</strong> تنها یک نام برای فروش لباس نیست؛ بلکه یک خط تولید متعهد و یک مزون تخصصی پوشاک زنانه است که با هدف ارتقای سطح پوشش بانوان در شهرستان بهشهر آغاز به کار کرد.
                </p>
                <p>
                    ما با درک نیازهای روز بانوان خوش‌سلیقه، صفر تا صد مراحل کار از انتخاب مرغوب‌ترین پارچه‌ها، طراحی الگوهای مدرن و دوخت بی‌نقص را در تولیدی اختصاصی خودمان انجام می‌دهیم.
                </p>
                <!-- محتوای داینامیک وردپرس (اگر متنی در ویرایشگر برگه نوشتید اینجا نمایش داده می‌شود) -->
                <?php if (have_posts()) : while (have_posts()) : the_post();
                    the_content();
                endwhile; endif; ?>
            </div>
        </div>
        <!-- جایگاه عکس محیط مزون یا چرخ خیاطی/تولیدی -->
        <div class="order-1 md:order-2 rounded-2xl overflow-hidden shadow-xl group">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-story.webp" 
                 alt="تولیدی باجی استایل در بهشهر" 
                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                 <!-- نکته: مسیر عکس را بر اساس ساختار پوشه قالب خود اصلاح کنید -->
        </div>
    </section>

    <!-- بخش سوم: ویژگی‌ها و ارزش‌ها (3 ستونه) -->
    <section class="bg-stone-100 rounded-3xl p-8 md:p-16 mb-24">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-stone-800">چرا باجی‌استایل انتخاب شماست؟</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- ویژگی 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500">
                    <!-- آیکون قیچی/دوخت (SVG) -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-stone-800 mb-3">کیفیت تضمینی دوخت</h3>
                <p class="text-stone-500 text-sm leading-relaxed">
                    استفاده از خیاطان ماهر و کنترل کیفیت دقیق در تولیدی باجی‌استایل برای خلق یک لباس بی‌نقص.
                </p>
            </div>

            <!-- ویژگی 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500">
                    <!-- آیکون برچسب قیمت (SVG) -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-stone-800 mb-3">از تولید به مصرف</h3>
                <p class="text-stone-500 text-sm leading-relaxed">
                    حذف واسطه‌ها به ما این امکان را می‌دهد که لباس‌های باکیفیت را با قیمت واقعی و منصفانه به دست شما برسانیم.
                </p>
            </div>

            <!-- ویژگی 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center">
                <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 text-rose-500">
                    <!-- آیکون مکان (SVG) -->
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-stone-800 mb-3">اصالت در بهشهر</h3>
                <p class="text-stone-500 text-sm leading-relaxed">
                    افتخار می‌کنیم که به عنوان یک برند محلی در بهشهر، زیبایی و استایل را به بانوان شهرمان هدیه می‌دهیم.
                </p>
            </div>

        </div>
    </section>

    <!-- بخش چهارم: تماس و لوکیشن -->
    <section class="border border-stone-200 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between bg-white">
        <div class="mb-8 md:mb-0 md:w-1/2">
            <h2 class="text-2xl md:text-3xl font-bold text-stone-800 mb-4">به مزون ما سر بزنید</h2> 
            <p class="text-stone-600 mb-6">
                مشاهده کیفیت پارچه‌ها و پرو لباس‌ها از نزدیک، تجربه بهتری برای شما رقم می‌زند. منتظر حضور گرمتان در بهشهر هستیم.
            </p>
            <div class="space-y-3 text-stone-700">
                <p class="flex items-center">
                    <span class="font-bold ml-2">آدرس:</span> مازندران، بهشهر، فروشگاه فامیلی طبقه بالا
                </p>
                <p class="flex items-center">
                    <span class="font-bold ml-2">تلفن:</span> 09111599908
                </p>
                <a href="https://instagram.com/baji.style" target="_blank" class="inline-block mt-4 px-6 py-3 bg-rose-600 text-white rounded-lg font-medium hover:bg-rose-700 transition shadow-md">
                    پیج اینستاگرام ما را دنبال کنید
                </a>
            </div>
        </div>
        
        <!-- جایگاه نقشه گوگل (iframe) -->
        <div class="w-full md:w-5/12 h-64 bg-stone-200 rounded-xl overflow-hidden shadow-inner">
            <!-- کد iframe گوگل مپ خود را جایگزین این تگ کنید -->
            <div class="w-full h-full flex items-center justify-center text-stone-500">
                محل قرارگیری نقشه گوگل مزون
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>