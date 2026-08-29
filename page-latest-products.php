<?php
/* Template Name: Latest Products - BajiStyle */
get_header(); ?>

<main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20" dir="rtl">
    
    <!-- هدر صفحه -->
    <div class="text-center mb-12 md:mb-16">
        <h1 class="text-2xl md:text-5xl font-extrabold text-stone-800 mb-3 tracking-tight">جدیدترین‌های باجی‌استایل</h1>
        <p class="text-stone-500 text-sm md:text-lg">تازه‌ترین طراحی‌ها و دوخت‌های مزون ما</p>
    </div>

    <!-- گرید محصولات (۲ ستون در موبایل، ۳ ستون تبلت، ۴ ستون دسکتاپ) -->
<div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10 md:gap-x-10 md:gap-y-16">        
        <?php
        // تنظیمات کوئری به همراه قابلیت صفحه‌بندی (Pagination)
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 12, // تعداد محصول در هر بارگذاری
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post_status'    => 'publish',
            'paged'          => $paged
        );
        $loop = new WP_Query( $args );

        if ( $loop->have_posts() ) :
            while ( $loop->have_posts() ) : $loop->the_post(); 
                global $product; 
                ?>
                
                <!-- کارت محصول (کاملا مینیمال و شیک) -->
                <div class="product-card group flex flex-col" style="
    padding-bottom: 20px;
">
                    
                    <!-- بخش تصویر -->
                    <a href="<?php the_permalink(); ?>" class="block relative rounded-2xl overflow-hidden aspect-[3/4] mb-3 bg-stone-100">
                        
                        <!-- تگ جدید (کوچک و ظریف برای موبایل و دسکتاپ) -->
                        <div class="baji-sale-badge absolute top-3 right-3 z-10 bg-baji-black text-baji-gold text-xs tracking-widest px-3 py-1 uppercase">
                            جدید
                        </div>

                        <?php 
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail(
                                'bajistyle-product-grid',
                                array(
                                    'class'    => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105',
                                    'loading'  => 'lazy',
                                    'decoding' => 'async',
                                    'sizes'    => '(max-width: 767px) 50vw, (max-width: 1023px) 33vw, 25vw',
                                )
                            );
                        } else {
                            echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" class="w-full h-full object-cover">';
                        }
                        ?>
                        
                        <!-- هاله رنگی و سبد خرید هنگام هاور -->
                        <div class="absolute inset-0 bg-stone-900/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>

                    <!-- بخش اطلاعات محصول -->
    <div class="mt-3 space-y-1 text-center">
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block">
            <h3 class="text-sm font-medium text-gray-800 hover:text-black transition-colors">
                <?php echo wp_kses_post($product->get_title()); ?>
            </h3>
            
            <div class="text-sm font-semibold text-gray-900 mt-1">
                <!-- بخش قیمت (تخفیف از اینجا حذف شد) -->
                <?php echo $product->get_price_html(); ?>
            </div>
        </a>
        
    </div>
                </div>

            <?php endwhile;
        else :
            if($paged == 1) {
                echo '<div class="col-span-full text-center py-12 text-stone-500">در حال حاضر محصول جدیدی وجود ندارد.</div>';
            }
        endif;
        ?>

    </div>

    <!-- بخش دکمه بارگذاری بیشتر -->
    <?php 
    $next_page_url = get_next_posts_page_link( $loop->max_num_pages );
    if ( $next_page_url ) : 
    ?>
    <div class="text-center mt-12 md:mt-16" id="load-more-container">
        <button id="load-more-btn" data-next-url="<?php echo esc_url( $next_page_url ); ?>" class="inline-flex items-center justify-center px-8 py-3 bg-stone-800 text-white hover:bg-rose-600 rounded-xl text-sm md:text-base font-medium transition-all duration-300 shadow-md hover:shadow-lg">
            نمایش محصولات بیشتر
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>
    <?php endif; 
    wp_reset_postdata(); 
    ?>

</main>

<!-- اسکریپت AJAX برای بارگذاری محصولات بدون رفرش -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    if(!loadMoreBtn) return;

    loadMoreBtn.addEventListener('click', async function(e) {
        e.preventDefault();
        const btn = this;
        const nextUrl = btn.getAttribute('data-next-url');
        
        if(!nextUrl) return;

        // تغییر ظاهر دکمه هنگام لودینگ
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="animate-pulse">در حال بارگذاری...</span>';
        btn.classList.add('opacity-75', 'cursor-not-allowed', 'pointer-events-none');

        try {
            // دریافت کدهای صفحه بعد
            const response = await fetch(nextUrl);
            const html = await response.text();
            
            // پردازش کدهای دریافت شده
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // استخراج محصولات جدید و دکمه جدید
            const newProducts = doc.querySelectorAll('.product-card');
            const grid = document.getElementById('product-grid');
            
            // اضافه کردن محصولات با یک تاخیر کوچک برای افکت زیباتر
            newProducts.forEach((product, index) => {
                product.style.opacity = '0';
                grid.appendChild(product);
                setTimeout(() => {
                    product.style.transition = 'opacity 0.5s ease';
                    product.style.opacity = '1';
                }, index * 100); // ظاهر شدن آبشاری
            });

            // بروزرسانی دکمه بارگذاری
            const newBtn = doc.getElementById('load-more-btn');
            if(newBtn) {
                btn.setAttribute('data-next-url', newBtn.getAttribute('data-next-url'));
                btn.innerHTML = originalText;
                btn.classList.remove('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
            } else {
                // اگر صفحه دیگری وجود نداشت، دکمه مخفی شود
                document.getElementById('load-more-container').style.display = 'none';
            }

        } catch(error) {
            console.error('خطا در دریافت محصولات:', error);
            btn.innerHTML = 'خطا! دوباره تلاش کنید';
            btn.classList.remove('opacity-75', 'cursor-not-allowed', 'pointer-events-none');
            setTimeout(() => { btn.innerHTML = originalText; }, 3000);
        }
    });
});
</script>

<?php get_footer(); ?>