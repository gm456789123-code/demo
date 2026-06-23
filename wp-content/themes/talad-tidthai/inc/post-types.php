<?php
/**
 * Custom post types for talad-tidthai: land listings, buyer demand, testimonials.
 */

function talad_tidthai_register_post_types() {
	register_post_type( 'land_listing', array(
		'labels' => array(
			'name'          => __( 'ที่ดิน', 'talad-tidthai' ),
			'singular_name' => __( 'ที่ดิน', 'talad-tidthai' ),
			'add_new_item'  => __( 'เพิ่มประกาศที่ดิน', 'talad-tidthai' ),
			'edit_item'     => __( 'แก้ไขประกาศที่ดิน', 'talad-tidthai' ),
			'all_items'     => __( 'ที่ดินทั้งหมด', 'talad-tidthai' ),
		),
		'public'       => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-admin-multisite',
		'supports'     => array( 'title', 'editor' ),
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'land' ),
	) );

	register_post_type( 'buyer_demand', array(
		'labels' => array(
			'name'          => __( 'ความต้องการที่ดิน', 'talad-tidthai' ),
			'singular_name' => __( 'ความต้องการที่ดิน', 'talad-tidthai' ),
			'add_new_item'  => __( 'เพิ่มความต้องการ', 'talad-tidthai' ),
			'edit_item'     => __( 'แก้ไขความต้องการ', 'talad-tidthai' ),
			'all_items'     => __( 'ความต้องการทั้งหมด', 'talad-tidthai' ),
		),
		'public'       => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-location-alt',
		'supports'     => array( 'title' ),
		'has_archive'  => false,
	) );

	register_post_type( 'testimonial', array(
		'labels' => array(
			'name'          => __( 'เสียงจากผู้แนะนำ', 'talad-tidthai' ),
			'singular_name' => __( 'เสียงจากผู้แนะนำ', 'talad-tidthai' ),
			'add_new_item'  => __( 'เพิ่มรีวิว', 'talad-tidthai' ),
			'edit_item'     => __( 'แก้ไขรีวิว', 'talad-tidthai' ),
			'all_items'     => __( 'รีวิวทั้งหมด', 'talad-tidthai' ),
		),
		'public'       => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-testimonial',
		'supports'     => array( 'title' ),
		'has_archive'  => false,
	) );
}
add_action( 'init', 'talad_tidthai_register_post_types' );

function talad_tidthai_add_meta_boxes() {
	add_meta_box( 'land_listing_details', 'รายละเอียดที่ดิน', 'talad_tidthai_render_land_meta_box', 'land_listing', 'normal', 'high' );
	add_meta_box( 'buyer_demand_details', 'รายละเอียดความต้องการ', 'talad_tidthai_render_demand_meta_box', 'buyer_demand', 'normal', 'high' );
	add_meta_box( 'testimonial_details', 'รายละเอียดรีวิว', 'talad_tidthai_render_testimonial_meta_box', 'testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'talad_tidthai_add_meta_boxes' );

function talad_tidthai_render_land_meta_box( $post ) {
	wp_nonce_field( 'talad_tidthai_save_meta', 'talad_tidthai_meta_nonce' );
	$location   = get_post_meta( $post->ID, '_land_location', true );
	$price      = get_post_meta( $post->ID, '_land_price', true );
	$price_unit = get_post_meta( $post->ID, '_land_price_unit', true );
	$price_unit = $price_unit ? $price_unit : 'ล้านบาท';
	$image_url  = get_post_meta( $post->ID, '_land_image_url', true );
	?>
	<p><label>พื้นที่/จังหวัด (badge ที่แสดงบนรูป)<br>
		<input type="text" name="land_location" value="<?php echo esc_attr( $location ); ?>" class="widefat"></label></p>
	<p><label>ค่าคอมสูงสุด (ตัวเลข)<br>
		<input type="text" name="land_price" value="<?php echo esc_attr( $price ); ?>" class="widefat"></label></p>
	<p><label>หน่วย (เช่น ล้านบาท / บาท)<br>
		<input type="text" name="land_price_unit" value="<?php echo esc_attr( $price_unit ); ?>" class="widefat"></label></p>
	<p><label>URL รูปภาพ<br>
		<input type="url" name="land_image_url" value="<?php echo esc_attr( $image_url ); ?>" class="widefat"></label></p>
	<?php
}

function talad_tidthai_render_demand_meta_box( $post ) {
	wp_nonce_field( 'talad_tidthai_save_meta', 'talad_tidthai_meta_nonce' );
	$detail = get_post_meta( $post->ID, '_demand_detail', true );
	?>
	<p class="description">ชื่อเรื่อง (Title) ใช้เป็นชื่อจังหวัด/พื้นที่</p>
	<p><label>รายละเอียดความต้องการ<br>
		<textarea name="demand_detail" class="widefat" rows="3"><?php echo esc_textarea( $detail ); ?></textarea></label></p>
	<?php
}

function talad_tidthai_render_testimonial_meta_box( $post ) {
	wp_nonce_field( 'talad_tidthai_save_meta', 'talad_tidthai_meta_nonce' );
	$amount = get_post_meta( $post->ID, '_testimonial_amount', true );
	$quote  = get_post_meta( $post->ID, '_testimonial_quote', true );
	$photo  = get_post_meta( $post->ID, '_testimonial_photo_url', true );
	?>
	<p class="description">ชื่อเรื่อง (Title) ใช้เป็นชื่อผู้แนะนำ</p>
	<p><label>จำนวนเงินที่ได้รับ (ตัวเลข)<br>
		<input type="text" name="testimonial_amount" value="<?php echo esc_attr( $amount ); ?>" class="widefat"></label></p>
	<p><label>ข้อความสั้น ๆ<br>
		<textarea name="testimonial_quote" class="widefat" rows="2"><?php echo esc_textarea( $quote ); ?></textarea></label></p>
	<p><label>URL รูปภาพ<br>
		<input type="url" name="testimonial_photo_url" value="<?php echo esc_attr( $photo ); ?>" class="widefat"></label></p>
	<?php
}

function talad_tidthai_save_meta_boxes( $post_id ) {
	if ( ! isset( $_POST['talad_tidthai_meta_nonce'] ) || ! wp_verify_nonce( $_POST['talad_tidthai_meta_nonce'], 'talad_tidthai_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$text_fields = array(
		'land_location'     => '_land_location',
		'land_price'        => '_land_price',
		'land_price_unit'   => '_land_price_unit',
		'demand_detail'     => '_demand_detail',
		'testimonial_amount' => '_testimonial_amount',
		'testimonial_quote' => '_testimonial_quote',
	);
	$url_fields = array(
		'land_image_url'        => '_land_image_url',
		'testimonial_photo_url' => '_testimonial_photo_url',
	);

	foreach ( $text_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
	foreach ( $url_fields as $field => $meta_key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $meta_key, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post', 'talad_tidthai_save_meta_boxes' );
