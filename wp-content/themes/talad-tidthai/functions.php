<?php
/**
 * Talad Tidthai theme bootstrap.
 */

require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/nav-walker.php';
require get_template_directory() . '/inc/referral-system.php';

function talad_tidthai_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => __( 'เมนูหลัก', 'talad-tidthai' ),
	) );
}
add_action( 'after_setup_theme', 'talad_tidthai_setup' );

function talad_tidthai_scripts() {
	wp_enqueue_style( 'talad-tidthai-google-font', 'https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600;700;800&display=swap', array(), null );

	wp_enqueue_script( 'tailwindcss', 'https://cdn.tailwindcss.com', array(), null, false );
	wp_add_inline_script( 'tailwindcss', talad_tidthai_tailwind_config() );

	wp_enqueue_style( 'talad-tidthai-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'talad_tidthai_scripts' );

function talad_tidthai_tailwind_config() {
	return "tailwind.config = {
		theme: {
			extend: {
				fontFamily: { sans: ['\"Noto Sans Thai\"', 'sans-serif'] },
				colors: { brand: { blue: '#13357a', blue2: '#1d4ed8', green: '#1aa260' } },
			},
		},
	};";
}
