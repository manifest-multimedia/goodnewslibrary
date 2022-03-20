<?php
/* WPBakery PageBuilder Extensions Bundle support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_vc_extensions_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_vc_extensions_theme_setup9', 9 );
	function rareradio_vc_extensions_theme_setup9() {
		if ( rareradio_exists_vc() && rareradio_exists_vc_extensions() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_vc_extensions_frontend_scripts', 1100 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_vc_extensions_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_vc_extensions_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_vc_extensions_tgmpa_required_plugins' ) ) {
	
	function rareradio_vc_extensions_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'vc-extensions-bundle' ) && rareradio_storage_get_array( 'required_plugins', 'vc-extensions-bundle', 'install' ) !== false && rareradio_is_theme_activated() ) {
			$path = rareradio_get_plugin_source_path( 'plugins/vc-extensions-bundle/vc-extensions-bundle.zip' );
			if ( ! empty( $path ) || rareradio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => rareradio_storage_get_array( 'required_plugins', 'vc-extensions-bundle', 'title' ),
					'slug'     => 'vc-extensions-bundle',
					'source'   => ! empty( $path ) ? $path : 'upload://vc-extensions-bundle.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if VC Extensions installed and activated
if ( ! function_exists( 'rareradio_exists_vc_extensions' ) ) {
	function rareradio_exists_vc_extensions() {
		return class_exists( 'Vc_Manager' ) && class_exists( 'VC_Extensions_CQBundle' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_vc_extensions_frontend_scripts' ) ) {
	
	function rareradio_vc_extensions_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/vc-extensions-bundle/vc-extensions-bundle.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-vc-extensions-bundle', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_vc_extensions_merge_styles' ) ) {
	
	function rareradio_vc_extensions_merge_styles( $list ) {
		$list[] = 'plugins/vc-extensions-bundle/vc-extensions-bundle.css';
		return $list;
	}
}

