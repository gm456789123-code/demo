<?php
/**
 * Phase C: referrer accounts, land submission, and commission tracking.
 *
 * MVP scope (documented in AGENTS.md):
 * - Anyone can self-register; new accounts get the "land_referrer" role.
 * - Logged-in referrers submit land via a frontend form -> creates a
 *   `land_listing` post with status "pending" and post_author = referrer.
 * - Deal status / commission amount / paid flag are set by staff/admin only,
 *   from the existing land_listing edit screen (matches "มีทีมงานมืออาชีพ
 *   ช่วยปิดดีล" — deal closing is human-verified, not automated).
 * - Referrers see their own submissions + commission status on a dashboard
 *   page (page-my-dashboard.php).
 */

// Allow self-registration; new users become referrers, not plain subscribers.
function talad_tidthai_enable_registration() {
	if ( '1' !== get_option( 'users_can_register' ) ) {
		update_option( 'users_can_register', '1' );
	}
}
add_action( 'init', 'talad_tidthai_enable_registration' );

function talad_tidthai_register_referrer_role() {
	if ( ! get_role( 'land_referrer' ) ) {
		add_role( 'land_referrer', __( 'ผู้แนะนำที่ดิน', 'talad-tidthai' ), array(
			'read'         => true,
			'edit_posts'   => false,
			'upload_files' => false,
		) );
	}
}
add_action( 'init', 'talad_tidthai_register_referrer_role' );

function talad_tidthai_assign_referrer_role( $user_id ) {
	$user = new WP_User( $user_id );
	$user->set_role( 'land_referrer' );
}
add_action( 'user_register', 'talad_tidthai_assign_referrer_role' );

/**
 * Deal/commission meta box on the land_listing edit screen (admin/staff only).
 */
function talad_tidthai_add_deal_meta_box() {
	add_meta_box( 'land_deal_details', 'สถานะดีล / ค่าคอมมิชชั่น', 'talad_tidthai_render_deal_meta_box', 'land_listing', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'talad_tidthai_add_deal_meta_box' );

function talad_tidthai_render_deal_meta_box( $post ) {
	wp_nonce_field( 'talad_tidthai_save_deal_meta', 'talad_tidthai_deal_meta_nonce' );

	$referrer_id = get_post_meta( $post->ID, '_referrer_id', true );
	$status      = get_post_meta( $post->ID, '_deal_status', true );
	$status      = $status ? $status : 'pending';
	$commission  = get_post_meta( $post->ID, '_commission_amount', true );
	$paid        = get_post_meta( $post->ID, '_commission_paid', true );

	if ( $referrer_id ) {
		$referrer = get_userdata( $referrer_id );
		echo '<p><strong>ผู้แนะนำ:</strong> ' . esc_html( $referrer ? $referrer->display_name : '#' . $referrer_id ) . '</p>';
	} else {
		echo '<p><strong>ผู้แนะนำ:</strong> เพิ่มโดย admin (ไม่มีผู้แนะนำ)</p>';
	}
	?>
	<p>
		<label for="deal_status"><strong>สถานะดีล</strong></label><br>
		<select name="deal_status" id="deal_status" class="widefat">
			<option value="pending" <?php selected( $status, 'pending' ); ?>>รอตรวจสอบ</option>
			<option value="matched" <?php selected( $status, 'matched' ); ?>>กำลังจับคู่</option>
			<option value="closed" <?php selected( $status, 'closed' ); ?>>ปิดดีลแล้ว</option>
			<option value="rejected" <?php selected( $status, 'rejected' ); ?>>ไม่ผ่าน</option>
		</select>
	</p>
	<p>
		<label for="commission_amount"><strong>ค่าคอมมิชชั่น (บาท)</strong></label><br>
		<input type="text" name="commission_amount" id="commission_amount" value="<?php echo esc_attr( $commission ); ?>" class="widefat">
	</p>
	<p>
		<label><input type="checkbox" name="commission_paid" value="1" <?php checked( $paid, '1' ); ?>> จ่ายค่าคอมมิชชั่นแล้ว</label>
	</p>
	<?php
}

function talad_tidthai_save_deal_meta( $post_id ) {
	if ( ! isset( $_POST['talad_tidthai_deal_meta_nonce'] ) || ! wp_verify_nonce( $_POST['talad_tidthai_deal_meta_nonce'], 'talad_tidthai_save_deal_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['deal_status'] ) ) {
		update_post_meta( $post_id, '_deal_status', sanitize_key( $_POST['deal_status'] ) );
	}
	if ( isset( $_POST['commission_amount'] ) ) {
		update_post_meta( $post_id, '_commission_amount', sanitize_text_field( wp_unslash( $_POST['commission_amount'] ) ) );
	}
	update_post_meta( $post_id, '_commission_paid', isset( $_POST['commission_paid'] ) ? '1' : '' );
}
add_action( 'save_post_land_listing', 'talad_tidthai_save_deal_meta' );

/**
 * Frontend "submit land" form handler — logged-in referrers only.
 */
function talad_tidthai_handle_land_submission() {
	if ( ! is_user_logged_in() ) {
		wp_die( esc_html__( 'กรุณาเข้าสู่ระบบก่อนส่งข้อมูลที่ดิน', 'talad-tidthai' ) );
	}
	if ( ! isset( $_POST['talad_tidthai_submit_land_nonce'] ) || ! wp_verify_nonce( $_POST['talad_tidthai_submit_land_nonce'], 'talad_tidthai_submit_land' ) ) {
		wp_die( esc_html__( 'คำขอไม่ถูกต้อง กรุณาลองใหม่', 'talad-tidthai' ) );
	}

	$title       = isset( $_POST['land_title'] ) ? sanitize_text_field( wp_unslash( $_POST['land_title'] ) ) : '';
	$location    = isset( $_POST['land_location'] ) ? sanitize_text_field( wp_unslash( $_POST['land_location'] ) ) : '';
	$description = isset( $_POST['land_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['land_description'] ) ) : '';

	if ( '' === $title ) {
		wp_die( esc_html__( 'กรุณากรอกชื่อ/หัวข้อที่ดิน', 'talad-tidthai' ) );
	}

	$post_id = wp_insert_post( array(
		'post_title'   => $title,
		'post_content' => $description,
		'post_status'  => 'pending',
		'post_type'    => 'land_listing',
		'post_author'  => get_current_user_id(),
	) );

	if ( ! is_wp_error( $post_id ) && $post_id ) {
		update_post_meta( $post_id, '_land_location', $location );
		update_post_meta( $post_id, '_referrer_id', get_current_user_id() );
		update_post_meta( $post_id, '_deal_status', 'pending' );
	}

	$redirect = add_query_arg( 'land_submitted', $post_id ? '1' : '0', wp_get_referer() ? wp_get_referer() : home_url( '/' ) );
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_post_submit_land_listing', 'talad_tidthai_handle_land_submission' );
