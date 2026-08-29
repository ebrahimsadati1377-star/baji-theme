<?php
/**
 * تمپلیت‌پارت نمایش دسته‌بندی‌های محصول - بازطراحی شده با اصول UI/UX
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

$categories = get_terms(
    array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => 0,
        'number'     => 8,
        'exclude'    => array( get_option( 'default_product_cat', 0 ) ),
    ) 
);

if ( is_wp_error( $categories ) || empty( $categories ) ) {
    return;
}
?>

<section class="baji-category-showcase" style="padding-top:15px" >
    <div class="max-w-[1400px] mx-auto px-4 md:px-8">
        
        <div class="swiper baji-category-slider">
            <div class="swiper-wrapper">
                <?php foreach ( $categories as $category ) : ?>
                    <?php
                    $thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
                    $image_url     = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'bajistyle-category' ) : '';
                    $category_link = get_term_link( $category );
                    ?>
                    
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url( $category_link ); ?>" class="block group">
                            <div class="relative overflow-hidden rounded-2xl aspect-[4/4] shadow-sm group-hover:shadow-lg transition-shadow duration-500">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
                            </div>
                            
                            <div class="text-center">
                                <h3 class="text-base md:text-lg font-medium text-gray-800 group-hover:text-baji-gold transition-colors duration-300">
                                    <?php echo esc_html( $category->name ); ?>
                                </h3>
                                <div class="w-8 h-[2px] bg-gray-200 mx-auto mt-2 group-hover:bg-baji-gold transition-colors duration-300"></div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.baji-category-slider', {
        slidesPerView: 3, // 2.2 باعث می‌شود کاربر متوجه اسلاید بعدی شود (UX)
        spaceBetween: 20,
        breakpoints: {
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 }
        }
    });
});
</script>