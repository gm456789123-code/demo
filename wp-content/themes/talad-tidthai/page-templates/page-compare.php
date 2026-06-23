<?php
/**
 * Template Name: เปรียบเทียบ
 */

get_header();

$compare_query = new WP_Query( array(
	'post_type'      => 'land_listing',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
?>

<section class="max-w-6xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <h1 class="text-2xl font-extrabold mb-2" style="color:#13357a;">เปรียบเทียบที่ดิน</h1>
  <p class="text-sm text-gray-400 mb-6">ดูค่าคอมมิชชั่นและพื้นที่ของที่ดินทุกรายการเทียบกันในตารางเดียว</p>

  <?php if ( $compare_query->have_posts() ) : ?>
    <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
      <table class="w-full text-sm bg-white">
        <thead>
          <tr class="text-left text-gray-500 border-b border-gray-100">
            <th class="p-4">ที่ดิน</th>
            <th class="p-4">พื้นที่/จังหวัด</th>
            <th class="p-4">ค่าคอมสูงสุด</th>
          </tr>
        </thead>
        <tbody>
          <?php while ( $compare_query->have_posts() ) : $compare_query->the_post(); ?>
            <?php
            $location   = get_post_meta( get_the_ID(), '_land_location', true );
            $price      = get_post_meta( get_the_ID(), '_land_price', true );
            $price_unit = get_post_meta( get_the_ID(), '_land_price_unit', true );
            $price_unit = $price_unit ? $price_unit : 'ล้านบาท';
            ?>
            <tr class="border-b border-gray-50 last:border-0">
              <td class="p-4 font-semibold"><?php the_title(); ?></td>
              <td class="p-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold text-white" style="background:#1aa260;"><?php echo esc_html( $location ); ?></span>
              </td>
              <td class="p-4 font-extrabold" style="color:#1d4ed8;"><?php echo esc_html( $price ); ?> <?php echo esc_html( $price_unit ); ?></td>
            </tr>
          <?php endwhile; wp_reset_postdata(); ?>
        </tbody>
      </table>
    </div>
  <?php else : ?>
    <p class="text-gray-400">ยังไม่มีที่ดินให้เปรียบเทียบ</p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
