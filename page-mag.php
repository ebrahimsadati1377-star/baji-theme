<?php
/**
 * صفحه اختصاصی مجله باجی‌استایل برای برگه /mag/
 *
 * @package BajiStyle
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$mag_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => (int) get_option( 'posts_per_page', 10 ),
		'paged'               => $paged,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

$blog_categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 6,
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);
?>

<main class="baji-blog-home bg-baji-cream min-h-screen">
	<section class="pt-10 md:pt-16 pb-8 md:pb-12">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<?php bajistyle_breadcrumb(); ?>

			<div class="mt-8 md:mt-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
				<div class="max-w-3xl">
					<div class="flex items-center gap-3 mb-3">
						<span class="w-8 md:w-12 h-[2px] bg-baji-gold rounded-full"></span>
						<span class="text-baji-gold text-xs md:text-sm font-bold tracking-[0.18em] uppercase"><?php esc_html_e( 'BajiStyle Magazine', 'bajistyle' ); ?></span>
					</div>
					<h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 leading-tight tracking-tight"><?php esc_html_e( 'مجله باجی‌استایل', 'bajistyle' ); ?></h1>
					<p class="mt-4 text-sm md:text-base lg:text-lg text-gray-500 leading-8 max-w-2xl"><?php esc_html_e( 'راهنمای انتخاب لباس، ایده‌های استایل، ترندهای روز و نکته‌هایی برای اینکه هوشمندانه‌تر و خوش‌استایل‌تر خرید کنید.', 'bajistyle' ); ?></p>
				</div>

				<?php if ( ! empty( $blog_categories ) ) : ?>
					<nav class="flex flex-wrap gap-2 lg:max-w-xl" aria-label="<?php esc_attr_e( 'دسته‌بندی‌های مجله', 'bajistyle' ); ?>">
						<?php foreach ( $blog_categories as $category ) : ?>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="inline-flex items-center rounded-full border border-gray-200 bg-white px-4 py-2 text-xs md:text-sm font-semibold text-gray-700 hover:border-baji-gold hover:text-baji-gold transition-colors duration-200"><?php echo esc_html( $category->name ); ?></a>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="pb-16 md:pb-24">
		<div class="max-w-[1400px] mx-auto px-4 md:px-8">
			<?php if ( $mag_query->have_posts() ) : ?>
				<?php $first_post = true; ?>
				<?php while ( $mag_query->have_posts() ) : $mag_query->the_post(); ?>
					<?php if ( $first_post ) : ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'group relative overflow-hidden rounded-[28px] md:rounded-[36px] bg-gray-900 shadow-sm mb-10 md:mb-14' ); ?>>
							<a href="<?php the_permalink(); ?>" class="grid lg:grid-cols-[1.2fr_0.8fr] min-h-[430px] md:min-h-[520px]">
								<div class="relative min-h-[300px] lg:min-h-full overflow-hidden bg-gray-200">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large', array( 'class' => 'absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]', 'loading' => 'eager', 'fetchpriority' => 'high', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
									<?php else : ?>
										<div class="absolute inset-0 bg-gradient-to-br from-gray-200 via-stone-100 to-amber-50"></div>
									<?php endif; ?>
									<span class="absolute top-5 right-5 bg-white/90 backdrop-blur-md text-gray-800 px-4 py-2 rounded-full text-xs font-bold shadow-sm"><?php esc_html_e( 'منتخب مجله', 'bajistyle' ); ?></span>
								</div>
								<div class="flex flex-col justify-center p-7 sm:p-9 md:p-12 lg:p-14 text-white">
									<?php $featured_categories = get_the_category(); ?>
									<?php if ( ! empty( $featured_categories ) ) : ?><span class="text-baji-gold text-xs font-bold mb-4"><?php echo esc_html( $featured_categories[0]->name ); ?></span><?php endif; ?>
									<h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-snug mb-5 group-hover:text-baji-gold transition-colors duration-300"><?php the_title(); ?></h2>
									<p class="text-sm md:text-base text-white/70 leading-8 line-clamp-3 mb-7"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '...' ) ); ?></p>
									<div class="flex items-center justify-between gap-4 pt-6 border-t border-white/10">
										<time class="text-xs md:text-sm text-white/60" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
										<span class="inline-flex items-center gap-2 text-sm font-bold"><?php esc_html_e( 'مطالعه مقاله', 'bajistyle' ); ?><i class="fa-solid fa-arrow-left text-xs transition-transform duration-300 group-hover:-translate-x-1"></i></span>
									</div>
								</div>
							</a>
						</article>

						<div class="flex items-end justify-between gap-4 mb-6 md:mb-8">
							<div><span class="text-baji-gold text-xs font-bold"><?php esc_html_e( 'تازه‌ترین مطالب', 'bajistyle' ); ?></span><h2 class="text-2xl md:text-3xl font-black text-gray-900 mt-2"><?php esc_html_e( 'برای استایل بهتر بخوانید', 'bajistyle' ); ?></h2></div>
						</div>
						<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
						<?php $first_post = false; ?>
					<?php else : ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col' ); ?>>
							<a href="<?php the_permalink(); ?>" class="relative block aspect-[16/10] overflow-hidden bg-gray-100">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105', 'loading' => 'lazy', 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
								<?php else : ?>
									<div class="w-full h-full bg-gradient-to-br from-gray-100 via-white to-amber-50 flex items-center justify-center"><i class="fa-regular fa-newspaper text-3xl text-gray-300"></i></div>
								<?php endif; ?>
								<?php $card_categories = get_the_category(); ?>
								<?php if ( ! empty( $card_categories ) ) : ?><span class="absolute top-4 right-4 bg-white/90 backdrop-blur-md text-baji-gold px-3 py-1.5 rounded-full text-[11px] font-bold shadow-sm"><?php echo esc_html( $card_categories[0]->name ); ?></span><?php endif; ?>
							</a>
							<div class="p-5 md:p-6 flex flex-col flex-grow">
								<time class="text-[11px] md:text-xs text-gray-400 mb-3" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<h2 class="text-lg md:text-xl font-black text-gray-900 leading-7 line-clamp-2 mb-3 group-hover:text-baji-gold transition-colors duration-300"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="text-sm text-gray-500 leading-7 line-clamp-3 mb-6"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '...' ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-sm font-bold text-gray-700 group-hover:text-baji-gold transition-colors duration-300"><span><?php esc_html_e( 'ادامه مطلب', 'bajistyle' ); ?></span><i class="fa-solid fa-arrow-left text-xs transition-transform duration-300 group-hover:-translate-x-1"></i></a>
							</div>
						</article>
					<?php endif; ?>
				<?php endwhile; ?>

				<?php if ( ! $first_post ) : ?></div><?php endif; ?>

				<?php
				$original_wp_query = $wp_query;
				$wp_query = $mag_query;
				?>
				<div class="mt-12 md:mt-16 flex justify-center"><?php bajistyle_pagination(); ?></div>
				<?php
				$wp_query = $original_wp_query;
				wp_reset_postdata();
				?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer();
