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

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$mag_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 12,
		'paged'               => $paged,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
	)
);

$mag_categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 7,
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);

/**
 * Render a magazine card.
 *
 * @param WP_Post $post Post object.
 * @param string  $size Card size: large|small|grid.
 */
function bajistyle_mag_card( $post, $size = 'grid' ) {
	setup_postdata( $post );
	$categories = get_the_category( $post->ID );
	$category   = ! empty( $categories ) ? $categories[0] : null;
	?>
	<article <?php post_class( 'baji-mag-card baji-mag-card--' . esc_attr( $size ), $post->ID ); ?>>
		<a class="baji-mag-card__media" href="<?php echo esc_url( get_permalink( $post ) ); ?>" aria-label="<?php echo esc_attr( get_the_title( $post ) ); ?>">
			<?php if ( has_post_thumbnail( $post ) ) : ?>
				<?php
				echo get_the_post_thumbnail(
					$post,
					'large' === $size ? 'large' : 'medium_large',
					array(
						'class'   => 'baji-mag-card__image',
						'loading' => 'large' === $size ? 'eager' : 'lazy',
						'alt'     => get_the_title( $post ),
					)
				);
				?>
			<?php else : ?>
				<span class="baji-mag-card__placeholder"><i class="fa-regular fa-image"></i></span>
			<?php endif; ?>
			<span class="baji-mag-card__shade"></span>
			<?php if ( $category ) : ?>
				<span class="baji-mag-card__category"><?php echo esc_html( $category->name ); ?></span>
			<?php endif; ?>
		</a>

		<div class="baji-mag-card__body">
			<div class="baji-mag-card__meta">
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post ) ); ?>"><?php echo esc_html( get_the_date( '', $post ) ); ?></time>
				<span aria-hidden="true">•</span>
				<span><?php echo esc_html( get_comments_number_text( 'بدون دیدگاه', '۱ دیدگاه', '% دیدگاه', $post->ID ) ); ?></span>
			</div>

			<<?php echo 'large' === $size ? 'h2' : 'h3'; ?> class="baji-mag-card__title">
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
			</<?php echo 'large' === $size ? 'h2' : 'h3'; ?>>

			<?php if ( 'small' !== $size ) : ?>
				<p class="baji-mag-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post ), 'large' === $size ? 30 : 18, '…' ) ); ?></p>
			<?php endif; ?>

			<a class="baji-mag-card__read" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
				<span><?php esc_html_e( 'مطالعه مقاله', 'bajistyle' ); ?></span>
				<i class="fa-solid fa-arrow-left"></i>
			</a>
		</div>
	</article>
	<?php
}
?>

<style>
.baji-mag-page{background:#f8f7f4;min-height:100vh;color:#171717}.baji-mag-shell{width:min(1380px,calc(100% - 32px));margin:0 auto}.baji-mag-hero{padding:44px 0 34px}.baji-mag-hero__inner{display:grid;grid-template-columns:minmax(0,1fr) auto;gap:40px;align-items:end;border-bottom:1px solid #e9e5de;padding-bottom:30px}.baji-mag-kicker{display:flex;align-items:center;gap:10px;color:#b38b35;font-size:12px;font-weight:800;letter-spacing:.08em;margin-bottom:12px}.baji-mag-kicker:before{content:"";width:34px;height:2px;background:#c69b40;border-radius:10px}.baji-mag-title{font-size:clamp(32px,4vw,58px);line-height:1.15;font-weight:900;margin:0 0 14px;letter-spacing:-1.5px}.baji-mag-subtitle{max-width:720px;color:#6f6b65;line-height:2;font-size:15px;margin:0}.baji-mag-cats{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end;max-width:520px}.baji-mag-cat{display:inline-flex;align-items:center;height:38px;padding:0 15px;border:1px solid #dfdbd3;border-radius:999px;background:#fff;color:#49453f;font-size:12px;font-weight:700;transition:.2s}.baji-mag-cat:hover{border-color:#c69b40;color:#9b7428;transform:translateY(-1px)}.baji-mag-content{padding:12px 0 74px}.baji-mag-section-head{display:flex;align-items:end;justify-content:space-between;gap:20px;margin:28px 0 18px}.baji-mag-section-head__eyebrow{display:block;color:#aa812e;font-weight:800;font-size:12px;margin-bottom:6px}.baji-mag-section-head h2{font-size:26px;line-height:1.3;font-weight:900;margin:0}.baji-mag-featured{display:grid;grid-template-columns:minmax(0,1.65fr) minmax(300px,.75fr);gap:18px;margin-bottom:50px}.baji-mag-featured__side{display:grid;grid-template-rows:1fr 1fr;gap:18px}.baji-mag-card{background:#fff;border:1px solid #ebe7df;border-radius:22px;overflow:hidden;display:flex;flex-direction:column;min-width:0;transition:transform .25s ease,box-shadow .25s ease,border-color .25s ease}.baji-mag-card:hover{transform:translateY(-3px);box-shadow:0 18px 45px rgba(38,31,22,.08);border-color:#dfd7ca}.baji-mag-card__media{position:relative;display:block;overflow:hidden;background:#eeeae3}.baji-mag-card--large .baji-mag-card__media{aspect-ratio:16/9}.baji-mag-card--small{display:grid;grid-template-columns:44% 56%}.baji-mag-card--small .baji-mag-card__media{height:100%;min-height:210px}.baji-mag-card--grid .baji-mag-card__media{aspect-ratio:16/10}.baji-mag-card__image{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .55s ease}.baji-mag-card:hover .baji-mag-card__image{transform:scale(1.035)}.baji-mag-card__placeholder{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:34px;color:#b7b0a5}.baji-mag-card__shade{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.24),transparent 46%);pointer-events:none}.baji-mag-card__category{position:absolute;top:14px;right:14px;background:rgba(255,255,255,.94);backdrop-filter:blur(8px);padding:7px 11px;border-radius:999px;font-size:11px;font-weight:800;color:#4c463e}.baji-mag-card__body{padding:20px 21px 19px;display:flex;flex-direction:column;flex:1}.baji-mag-card--large .baji-mag-card__body{padding:25px 28px 24px}.baji-mag-card--small .baji-mag-card__body{padding:17px;justify-content:center}.baji-mag-card__meta{display:flex;align-items:center;gap:7px;color:#999187;font-size:11px;margin-bottom:10px}.baji-mag-card__title{font-size:19px;line-height:1.75;font-weight:900;margin:0;color:#1d1b18}.baji-mag-card--large .baji-mag-card__title{font-size:clamp(24px,2.3vw,35px);line-height:1.55}.baji-mag-card--small .baji-mag-card__title{font-size:16px;line-height:1.65}.baji-mag-card__title a{color:inherit}.baji-mag-card__title a:hover{color:#a97f2d}.baji-mag-card__excerpt{color:#706a62;font-size:13px;line-height:2;margin:12px 0 18px}.baji-mag-card--large .baji-mag-card__excerpt{font-size:14px;max-width:850px}.baji-mag-card__read{margin-top:auto;padding-top:14px;border-top:1px solid #f0ede8;display:flex;align-items:center;justify-content:space-between;color:#4b463f;font-size:12px;font-weight:800}.baji-mag-card__read i{font-size:10px;transition:transform .2s}.baji-mag-card:hover .baji-mag-card__read{color:#a97f2d}.baji-mag-card:hover .baji-mag-card__read i{transform:translateX(-4px)}.baji-mag-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}.baji-mag-pagination{display:flex;justify-content:center;margin-top:48px}.baji-mag-empty{padding:80px 20px;text-align:center;background:#fff;border:1px solid #ebe7df;border-radius:22px;color:#777}
@media(max-width:980px){.baji-mag-hero__inner{grid-template-columns:1fr}.baji-mag-cats{justify-content:flex-start;max-width:none}.baji-mag-featured{grid-template-columns:1fr}.baji-mag-featured__side{grid-template-columns:1fr 1fr;grid-template-rows:auto}.baji-mag-card--small{display:flex}.baji-mag-card--small .baji-mag-card__media{aspect-ratio:16/10;min-height:0}.baji-mag-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:640px){.baji-mag-shell{width:min(100% - 24px,1380px)}.baji-mag-hero{padding:24px 0 22px}.baji-mag-hero__inner{gap:22px;padding-bottom:22px}.baji-mag-title{font-size:34px}.baji-mag-subtitle{font-size:13px}.baji-mag-cats{flex-wrap:nowrap;overflow-x:auto;padding-bottom:5px;margin-left:-12px;padding-left:12px}.baji-mag-cat{flex:0 0 auto;height:36px}.baji-mag-content{padding-bottom:54px}.baji-mag-featured{margin-bottom:38px}.baji-mag-featured__side{grid-template-columns:1fr}.baji-mag-card--large .baji-mag-card__media{aspect-ratio:4/3}.baji-mag-card--large .baji-mag-card__body{padding:20px}.baji-mag-card--large .baji-mag-card__title{font-size:23px}.baji-mag-grid{grid-template-columns:1fr;gap:16px}.baji-mag-section-head{margin-top:20px}.baji-mag-section-head h2{font-size:22px}}
</style>

<main class="baji-mag-page">
	<section class="baji-mag-hero">
		<div class="baji-mag-shell">
			<?php bajistyle_breadcrumb(); ?>
			<div class="baji-mag-hero__inner">
				<div>
					<div class="baji-mag-kicker"><?php esc_html_e( 'مجله باجی‌استایل', 'bajistyle' ); ?></div>
					<h1 class="baji-mag-title"><?php esc_html_e( 'ایده برای استایل بهتر', 'bajistyle' ); ?></h1>
					<p class="baji-mag-subtitle"><?php esc_html_e( 'راهنمای پوشیدن، ست‌کردن و انتخاب لباس؛ از ترندهای روز تا نکته‌های کاربردی برای خرید هوشمندانه‌تر.', 'bajistyle' ); ?></p>
				</div>

				<?php if ( ! empty( $mag_categories ) ) : ?>
					<nav class="baji-mag-cats" aria-label="<?php esc_attr_e( 'دسته‌بندی‌های مجله', 'bajistyle' ); ?>">
						<?php foreach ( $mag_categories as $category ) : ?>
							<a class="baji-mag-cat" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
						<?php endforeach; ?>
					</nav>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="baji-mag-content">
		<div class="baji-mag-shell">
			<?php if ( $mag_query->have_posts() ) : ?>
				<?php
				$posts = $mag_query->posts;
				$grid_posts = $posts;
				?>

				<?php if ( 1 === $paged && ! empty( $posts ) ) : ?>
					<div class="baji-mag-section-head">
						<div>
							<span class="baji-mag-section-head__eyebrow"><?php esc_html_e( 'پیشنهاد سردبیر', 'bajistyle' ); ?></span>
							<h2><?php esc_html_e( 'برای شروع این‌ها را بخوان', 'bajistyle' ); ?></h2>
						</div>
					</div>

					<div class="baji-mag-featured">
						<?php bajistyle_mag_card( $posts[0], 'large' ); ?>

						<?php if ( isset( $posts[1] ) || isset( $posts[2] ) ) : ?>
							<div class="baji-mag-featured__side">
								<?php if ( isset( $posts[1] ) ) : bajistyle_mag_card( $posts[1], 'small' ); endif; ?>
								<?php if ( isset( $posts[2] ) ) : bajistyle_mag_card( $posts[2], 'small' ); endif; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php $grid_posts = array_slice( $posts, 3 ); ?>
				<?php endif; ?>

				<?php if ( ! empty( $grid_posts ) ) : ?>
					<div class="baji-mag-section-head">
						<div>
							<span class="baji-mag-section-head__eyebrow"><?php esc_html_e( 'جدیدترین مطالب', 'bajistyle' ); ?></span>
							<h2><?php esc_html_e( 'تازه‌های مجله', 'bajistyle' ); ?></h2>
						</div>
					</div>

					<div class="baji-mag-grid">
						<?php foreach ( $grid_posts as $post ) : ?>
							<?php bajistyle_mag_card( $post, 'grid' ); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php
				$original_wp_query = $wp_query;
				$wp_query          = $mag_query;
				?>
				<div class="baji-mag-pagination"><?php bajistyle_pagination(); ?></div>
				<?php
				$wp_query = $original_wp_query;
				wp_reset_postdata();
				?>
			<?php else : ?>
				<div class="baji-mag-empty"><?php esc_html_e( 'هنوز مقاله‌ای در مجله منتشر نشده است.', 'bajistyle' ); ?></div>
			<?php endif; ?>
		</div>
	</section>
</main>

<?php get_footer();
