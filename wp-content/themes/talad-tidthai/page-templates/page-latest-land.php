<?php
/**
 * Template Name: ดูล่าสุด
 */

get_header();

$latest_query = new WP_Query( array(
	'post_type'      => 'land_listing',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
?>

<section class="max-w-6xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <h1 class="text-2xl font-extrabold mb-6" style="color:#13357a;">ที่ดินล่าสุด</h1>

  <?php if ( $latest_query->have_posts() ) : ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php while ( $latest_query->have_posts() ) : $latest_query->the_post(); ?>
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
            <p class="text-xs text-gray-400 mt-1"><?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?> ที่แล้ว</p>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <p class="text-gray-400">ยังไม่มีประกาศที่ดิน</p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
