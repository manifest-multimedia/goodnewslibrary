<?php
/* Give (donation forms) support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_give_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_give_theme_setup9', 9 );
	function rareradio_give_theme_setup9() {
		if ( rareradio_exists_give() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_give_frontend_scripts', 1100 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_give_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_give_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_give_tgmpa_required_plugins' ) ) {
	
	function rareradio_give_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'give' ) && rareradio_storage_get_array( 'required_plugins', 'give', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'give', 'title' ),
				'slug'     => 'give',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'rareradio_exists_give' ) ) {
	function rareradio_exists_give() {
		return class_exists( 'Give' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_give_frontend_scripts' ) ) {
	
	function rareradio_give_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/give/give.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-give', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_give_merge_styles' ) ) {
	
	function rareradio_give_merge_styles( $list ) {
		$list[] = 'plugins/give/give.css';
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( rareradio_exists_give() ) {
	require_once RARERADIO_THEME_DIR . 'plugins/give/give-styles.php'; }

