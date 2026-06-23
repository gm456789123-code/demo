<?php
/**
 * Template Name: ความต้องการที่ดินทั้งหมด
 */

get_header();

$demand_query = new WP_Query( array(
	'post_type'      => 'buyer_demand',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
?>

<section class="max-w-6xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-extrabold" style="color:#13357a;">ความต้องการที่ดินทั้งหมด</h1>
    <?php $submit_land_page = get_page_by_path( 'submit-land' ); ?>
    <a href="<?php echo esc_url( $submit_land_page ? get_permalink( $submit_land_page ) : home_url( '/' ) ); ?>" class="px-4 py-2 rounded-full text-sm font-semibold text-white" style="background:#1aa260;">ส่งข้อมูลที่ดินเลย</a>
  </div>

  <?php if ( $demand_query->have_posts() ) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <?php while ( $demand_query->have_posts() ) : $demand_query->the_post(); ?>
        <?php $detail = get_post_meta( get_the_ID(), '_demand_detail', true ); ?>
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-4">
          <p class="text-xs font-semibold mb-2" style="color:#1d4ed8;">&#9679; <?php the_title(); ?></p>
          <p class="text-sm"><?php echo esc_html( $detail ); ?></p>
          <p class="text-xs text-gray-400 mt-3">อัปเดต <?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?> ที่แล้ว</p>
        </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <p class="text-gray-400">ยังไม่มีความต้องการที่ดิน</p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
