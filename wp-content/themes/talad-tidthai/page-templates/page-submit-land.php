<?php
/**
 * Template Name: ส่งข้อมูลที่ดิน
 */

get_header();
?>

<section class="max-w-2xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <h1 class="text-2xl font-extrabold mb-6" style="color:#13357a;">ส่งข้อมูลที่ดิน</h1>

  <?php if ( isset( $_GET['land_submitted'] ) ) : ?>
    <?php if ( '1' === $_GET['land_submitted'] ) : ?>
      <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        ส่งข้อมูลที่ดินเรียบร้อย ทีมงานจะตรวจสอบและติดต่อกลับเร็ว ๆ นี้
      </div>
    <?php else : ?>
      <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm">
        ส่งข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if ( ! is_user_logged_in() ) : ?>
    <div class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
      <p class="text-gray-600 mb-4">ต้องเข้าสู่ระบบก่อนถึงจะส่งข้อมูลที่ดินได้ (เพื่อบันทึกว่าใครเป็นผู้แนะนำ สำหรับคำนวณค่าคอมมิชชั่น)</p>
      <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="inline-block px-5 py-2.5 rounded-full text-sm font-semibold text-white" style="background:#1d4ed8;">เข้าสู่ระบบ</a>
      <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="inline-block px-5 py-2.5 rounded-full text-sm font-semibold text-white ml-2" style="background:#1aa260;">สมัครสมาชิก</a>
    </div>
  <?php else : ?>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="p-6 rounded-2xl bg-white border border-gray-100 shadow-sm space-y-4">
      <input type="hidden" name="action" value="submit_land_listing">
      <?php wp_nonce_field( 'talad_tidthai_submit_land', 'talad_tidthai_submit_land_nonce' ); ?>

      <div>
        <label class="block text-sm font-semibold mb-1" for="land_title">ชื่อ/หัวข้อที่ดิน</label>
        <input type="text" name="land_title" id="land_title" required class="w-full px-4 py-2 rounded-lg border border-gray-200">
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1" for="land_location">พื้นที่/จังหวัด</label>
        <input type="text" name="land_location" id="land_location" required class="w-full px-4 py-2 rounded-lg border border-gray-200">
      </div>
      <div>
        <label class="block text-sm font-semibold mb-1" for="land_description">รายละเอียด</label>
        <textarea name="land_description" id="land_description" rows="5" class="w-full px-4 py-2 rounded-lg border border-gray-200"></textarea>
      </div>

      <button type="submit" class="w-full py-2.5 rounded-lg font-semibold text-white" style="background:#1aa260;">ส่งข้อมูลที่ดินเลย</button>
      <p class="text-xs text-gray-400">หลังส่งแล้ว ทีมงานจะตรวจสอบก่อนเผยแพร่ขึ้นหน้าเว็บ</p>
    </form>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
