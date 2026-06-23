<?php
/**
 * Renders the primary menu as Tailwind pill links, matching the static
 * fallback markup in header.php (no <li>/<ul> wrappers needed for a flat menu).
 */

class Talad_Tidthai_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		// Flat menu only — no dropdown markup.
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		// Flat menu only — no dropdown markup.
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$is_current = in_array( 'current-menu-item', $item->classes, true )
			|| in_array( 'current_page_item', $item->classes, true );

		if ( $is_current ) {
			$classes = 'px-4 py-2 rounded-full text-white';
			$style   = ' style="background:#13357a;"';
		} else {
			$classes = 'px-4 py-2 rounded-full text-gray-600 hover:bg-gray-100';
			$style   = '';
		}

		$output .= sprintf(
			'<a href="%s" class="%s"%s>%s</a>',
			esc_url( $item->url ),
			esc_attr( $classes ),
			$style,
			esc_html( $item->title )
		);
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		// No closing tag — start_el doesn't open <li>.
	}
}
