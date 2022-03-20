<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_essential_grid_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_essential_grid_theme_setup9', 9 );
	function rareradio_essential_grid_theme_setup9() {
		if ( rareradio_exists_essential_grid() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_essential_grid_frontend_scripts', 1100 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_essential_grid_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_essential_grid_tgmpa_required_plugins' ) ) {
	
	function rareradio_essential_grid_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'essential-grid' ) && rareradio_storage_get_array( 'required_plugins', 'essential-grid', 'install' ) !== false && rareradio_is_theme_activated() ) {
			$path = rareradio_get_plugin_source_path( 'plugins/essential-grid/essential-grid.zip' );
			if ( ! empty( $path ) || rareradio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => rareradio_storage_get_array( 'required_plugins', 'essential-grid', 'title' ),
					'slug'     => 'essential-grid',
					'version'  => '3.0.12',
					'source'   => ! empty( $path ) ? $path : 'upload://essential-grid.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'rareradio_exists_essential_grid' ) ) {
	function rareradio_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined('ESG_PLUGIN_PATH');
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_essential_grid_frontend_scripts' ) ) {
	
	function rareradio_essential_grid_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/essential-grid/essential-grid.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-essential-grid', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_essential_grid_merge_styles' ) ) {
	
	function rareradio_essential_grid_merge_styles( $list ) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}

