<?php
/**
 * Template Name: เสียงจากผู้แนะนำทั้งหมด
 */

get_header();

$testimonial_query = new WP_Query( array(
	'post_type'      => 'testimonial',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );
?>

<section class="max-w-6xl mx-auto px-4 lg:px-8 mt-12 mb-16">
  <h1 class="text-2xl font-extrabold mb-6" style="color:#13357a;">เสียงจากผู้แนะนำที่ดินของเรา</h1>

  <?php if ( $testimonial_query->have_posts() ) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while ( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); ?>
        <?php
        $amount = get_post_meta( get_the_ID(), '_testimonial_amount', true );
        $quote  = get_post_meta( get_the_ID(), '_testimonial_quote', true );
        $photo  = get_post_meta( get_the_ID(), '_testimonial_photo_url', true );
        ?>
        <article class="rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-100">
          <div class="relative h-48">
            <img src="<?php echo esc_url( $photo ); ?>" class="w-full h-full object-cover" alt="<?php the_title_attribute(); ?>">
            <div class="absolute bottom-0 left-0 right-0 bg-white/95 p-2 m-2 rounded-lg">
              <p class="text-[11px] text-gray-500"><?php bloginfo( 'name' ); ?> ขอบคุณให้คุณ</p>
              <p class="text-sm font-bold" style="color:#13357a;"><?php the_title(); ?></p>
              <p class="text-xs" style="color:#1aa260;">ได้รับค่าตอบแทน <?php echo esc_html( number_format_i18n( (float) $amount ) ); ?> บาท</p>
            </div>
          </div>
          <div class="p-4">
            <p class="text-sm text-gray-600"><?php echo esc_html( $quote ); ?></p>
            <p class="font-extrabold mt-2" style="color:#1d4ed8;"><?php echo esc_html( number_format_i18n( (float) $amount ) ); ?> บาท</p>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  <?php else : ?>
    <p class="text-gray-400">ยังไม่มีรีวิว</p>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
