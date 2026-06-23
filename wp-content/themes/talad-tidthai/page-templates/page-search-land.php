<?php
/**
 * Template Name: ค้นหาที่ดิน
 */

get_header();

$keyword = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

$args = array(
	'post_type'      => 'land_listing',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

if ( '' !== $keyword ) {
	$args['meta_query'] = array(
		array(
			'key'     => '_land_location',
			'value'   => $keyword,
			'compare' => 'LIKE',
		),
	);
	$args['s'] = $keyword;
}

$search_query = new WP_Query( $args );
?>

<section class="max-w-6xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <h1 class="text-2xl font-extrabold mb-6" style="color:#13357a;">ค้นหาที่ดิน</h1>

  <form method="get" class="mb-8 flex gap-3">
    <input type="text" name="q" value="<?php echo esc_attr( $keyword ); ?>" placeholder="ค้นหาด้วยจังหวัด/พื้นที่ เช่น Chiang Mai" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200">
    <button type="submit" class="px-6 py-2.5 rounded-lg font-semibold text-white" style="background:#1d4ed8;">ค้นหา</button>
  </form>

  <?php if ( $search_query->have_posts() ) : ?>
    <p class="text-sm text-gray-400 mb-4"><?php echo esc_html( $search_query->found_posts ); ?> รายการ</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php while ( $search_query->have_posts() ) : $search_query->the_post(); ?>
        <?php
        $location   = get_post_meta( get_the_ID(), '_land_location', true );
        $price      = get_post_meta( get_the_ID(), '_land_price', true );
        $price_unit = get_post_meta( get_the_ID(), '_land_price_unit', true );
        $price_unit = $price_unit ? $price_unit : 'ล้านบาท';
        $image_url  = get_post_meta( get_the_ID(), '_land_image_url', true );
        ?>
        <article class="rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-100">
          <div class="relative h-44">
            <img src="<?php echo esc_url( $image_url ); ?>" class="w-full h-full object-cover" alt="<?php the_title_attribute(); ?>">
            <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold text-white" style="background:#1aa260;"><?php echo esc_html( $location ); ?></span>
          </div>
          <div class="p-4">
            <p class="text-xs text-gray-400">ค่าคอมสูงสุด</p>
            <p class="text-2xl font-extrabold" style="color:#1d4ed8;"><?php echo esc_html( $price ); ?> <span class="text-base"><?php echo esc_html( $price_unit ); ?></span></p>
            <p class="font-semibold mt-2"><?php the_title(); ?></p>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <p class="text-gray-400">ไม่พบที่ดินที่ตรงกับคำค้นหา</p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
