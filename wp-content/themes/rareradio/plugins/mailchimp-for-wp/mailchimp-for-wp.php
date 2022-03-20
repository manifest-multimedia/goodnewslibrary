<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_mailchimp_theme_setup9', 9 );
	function rareradio_mailchimp_theme_setup9() {
		if ( rareradio_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_mailchimp_frontend_scripts', 1100 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_mailchimp_tgmpa_required_plugins' ) ) {
	
	function rareradio_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && rareradio_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'rareradio_exists_mailchimp' ) ) {
	function rareradio_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_mailchimp_frontend_scripts' ) ) {
	
	function rareradio_mailchimp_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-mailchimp', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_mailchimp_merge_styles' ) ) {
	
	function rareradio_mailchimp_merge_styles( $list ) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( rareradio_exists_mailchimp() ) {
	require_once RARERADIO_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp-styles.php'; }

