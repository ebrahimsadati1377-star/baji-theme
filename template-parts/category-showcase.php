<?php
/** Product category showcase. @package BajiStyle */
if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WooCommerce' ) ) { return; }
$categories = get_terms(array(
    'taxonomy'=>'product_cat','hide_empty'=>true,'parent'=>0,
    'exclude'=>array(get_option('default_product_cat',0)),
    'orderby'=>'menu_order','order'=>'ASC',
));
if ( is_wp_error($categories) || empty($categories) ) { return; }
?>
<section class="baji-category-showcase" aria-labelledby="baji-category-title">
<style id="baji-category-navigation-refresh">
.baji-category-showcase{padding:22px 0 28px;background:#fff}.baji-category-showcase__head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px}.baji-category-showcase__title{margin:0;font-size:18px;font-weight:900;color:#211b1b;letter-spacing:-.02em}.baji-category-showcase__hint{font-size:11px;color:#8c7b78}.baji-category-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.baji-category-card{position:relative;display:block;overflow:hidden;border-radius:15px;background:#f3e4da;aspect-ratio:1.85/1;text-decoration:none!important;box-shadow:0 3px 12px rgba(61,35,31,.07);isolation:isolate;transition:transform .2s ease,box-shadow .2s ease}.baji-category-card:active{transform:scale(.985)}.baji-category-card__image{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;transition:transform .35s ease}.baji-category-card:hover .baji-category-card__image{transform:scale(1.035)}.baji-category-card__shade{position:absolute;inset:0;background:linear-gradient(90deg,rgba(31,20,18,.56) 0%,rgba(31,20,18,.27) 48%,rgba(31,20,18,.03) 100%);z-index:1}.baji-category-card__content{position:absolute;z-index:2;inset:0;display:flex;align-items:center;justify-content:space-between;gap:8px;padding:13px 14px;color:#fff}.baji-category-card__name{font-size:16px;font-weight:900;line-height:1.35;text-shadow:0 1px 5px rgba(0,0,0,.22)}.baji-category-card__arrow{width:27px;height:27px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.94);color:#8f3f55;font-size:11px;box-shadow:0 2px 8px rgba(0,0,0,.12);flex:0 0 auto}.baji-category-card:last-child:nth-child(odd){grid-column:1/-1;aspect-ratio:3.8/1}@media(min-width:768px){.baji-category-showcase{padding:30px 0 38px}.baji-category-showcase__head{margin-bottom:20px}.baji-category-showcase__title{font-size:25px}.baji-category-grid{grid-template-columns:repeat(4,minmax(0,1fr));gap:18px}.baji-category-card{border-radius:20px;aspect-ratio:1.75/1}.baji-category-card:last-child:nth-child(odd){grid-column:auto;aspect-ratio:1.75/1}.baji-category-card__content{padding:18px 20px}.baji-category-card__name{font-size:20px}.baji-category-card__arrow{width:34px;height:34px;font-size:13px}}
</style>
<div class="max-w-[1400px] mx-auto px-4 md:px-8">
<div class="baji-category-showcase__head"><h2 id="baji-category-title" class="baji-category-showcase__title"><?php esc_html_e('دسته‌بندی محصولات','bajistyle'); ?></h2><span class="baji-category-showcase__hint"><?php esc_html_e('سریع‌تر انتخاب کن','bajistyle'); ?></span></div>
<div class="baji-category-grid" role="list">
<?php foreach($categories as $category):
$thumbnail_id=get_term_meta($category->term_id,'thumbnail_id',true);
$image_url=$thumbnail_id?wp_get_attachment_image_url($thumbnail_id,'large'):wc_placeholder_img_src('woocommerce_thumbnail');
if(107===(int)$category->term_id || 'tshirt'===$category->slug || 'تیشرت'===$category->name){$image_url='https://bajistyle.ir/wp-content/uploads/2026/09/baji-category-tshirt.png?v=2645';}
if(27===(int)$category->term_id || 'کراپ'===$category->name){$image_url='https://bajistyle.ir/wp-content/uploads/2026/09/baji-category-crop-1.png?v=2648';}
if(19===(int)$category->term_id || 'دامن'===$category->name){$image_url='https://bajistyle.ir/wp-content/uploads/2026/09/baji-category-skirt.png?v=2652';}
if(23===(int)$category->term_id || 'اورال'===$category->name){$image_url='https://bajistyle.ir/wp-content/uploads/2026/09/baji-category-overall.png?v=2654';}
$category_link=get_term_link($category);if(is_wp_error($category_link)){continue;}
?>
<a href="<?php echo esc_url($category_link); ?>" class="baji-category-card" role="listitem" aria-label="<?php echo esc_attr(sprintf(__('مشاهده دسته %s','bajistyle'),$category->name)); ?>"><img class="baji-category-card__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>" loading="lazy" decoding="async"><span class="baji-category-card__shade" aria-hidden="true"></span><span class="baji-category-card__content"><strong class="baji-category-card__name"><?php echo esc_html($category->name); ?></strong><i class="fa-solid fa-arrow-left baji-category-card__arrow" aria-hidden="true"></i></span></a>
<?php endforeach; ?>
</div></div></section>
