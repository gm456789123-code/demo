<?php
/**
 * Template Name: แดชบอร์ดของฉัน
 */

get_header();

$status_labels = array(
	'pending'  => array( 'รอตรวจสอบ', 'bg-gray-100 text-gray-600' ),
	'matched'  => array( 'กำลังจับคู่', 'bg-yellow-100 text-yellow-700' ),
	'closed'   => array( 'ปิดดีลแล้ว', 'bg-green-100 text-green-700' ),
	'rejected' => array( 'ไม่ผ่าน', 'bg-red-100 text-red-700' ),
);
?>

<section class="max-w-4xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <h1 class="text-2xl font-extrabold mb-2" style="color:#13357a;">แดชบอร์ดของฉัน</h1>

  <?php if ( ! is_user_logged_in() ) : ?>
    <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm text-center mt-6">
      <p class="text-gray-600 mb-4">ต้องเข้าสู่ระบบก่อนถึงจะดูแดชบอร์ดได้</p>
      <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="inline-block px-5 py-2.5 rounded-full text-sm font-semibold text-white" style="background:#1d4ed8;">เข้าสู่ระบบ</a>
    </div>
  <?php else : ?>
    <?php
    $current_user = wp_get_current_user();
    $my_listings  = new WP_Query( array(
        'post_type'      => 'land_listing',
        'author'         => $current_user->ID,
        'post_status'    => array( 'publish', 'pending', 'draft' ),
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    $total_paid = 0;
    $total_pending = 0;
    ?>
    <p class="text-gray-500 mb-6">สวัสดีคุณ <?php echo esc_html( $current_user->display_name ); ?> — รายการที่ดินที่คุณส่งมา</p>

    <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'submit-land' ) ) ); ?>" class="inline-block mb-6 px-5 py-2.5 rounded-full text-sm font-semibold text-white" style="background:#1aa260;">ส่งข้อมูลที่ดินเพิ่ม</a>

    <?php if ( $my_listings->have_posts() ) : ?>
      <div class="space-y-3">
        <?php while ( $my_listings->have_posts() ) : $my_listings->the_post(); ?>
          <?php
          $status     = get_post_meta( get_the_ID(), '_deal_status', true );
          $status     = $status ? $status : 'pending';
          $label      = isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : $status_labels['pending'];
          $commission = get_post_meta( get_the_ID(), '_commission_amount', true );
          $paid       = get_post_meta( get_the_ID(), '_commission_paid', true );

          if ( '1' === $paid && $commission ) {
              $total_paid += (float) str_replace( ',', '', $commission );
          } elseif ( $commission ) {
              $total_pending += (float) str_replace( ',', '', $commission );
          }
          ?>
          <div class="p-4 rounded-xl bg-white border border-gray-100 shadow-sm flex items-center justify-between gap-4">
            <div>
              <p class="font-semibold"><?php the_title(); ?></p>
              <p class="text-xs text-gray-400"><?php echo esc_html( get_post_meta( get_the_ID(), '_land_location', true ) ); ?></p>
            </div>
            <div class="text-right">
              <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?php echo esc_attr( $label[1] ); ?>"><?php echo esc_html( $label[0] ); ?></span>
              <?php if ( $commission ) : ?>
                <p class="text-sm font-bold mt-1" style="color:#1d4ed8;"><?php echo esc_html( number_format_i18n( (float) str_replace( ',', '', $commission ) ) ); ?> บาท</p>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>

      <div class="mt-8 grid grid-cols-2 gap-4">
        <div class="p-4 rounded-xl bg-green-50 border border-green-100">
          <p class="text-xs text-gray-500">ได้รับแล้ว</p>
          <p class="text-xl font-extrabold text-green-700"><?php echo esc_html( number_format_i18n( $total_paid ) ); ?> บาท</p>
        </div>
        <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-100">
          <p class="text-xs text-gray-500">รอจ่าย</p>
          <p class="text-xl font-extrabold text-yellow-700"><?php echo esc_html( number_format_i18n( $total_pending ) ); ?> บาท</p>
        </div>
      </div>
    <?php else : ?>
      <p class="text-gray-400">ยังไม่เคยส่งข้อมูลที่ดิน</p>
    <?php endif; ?>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
