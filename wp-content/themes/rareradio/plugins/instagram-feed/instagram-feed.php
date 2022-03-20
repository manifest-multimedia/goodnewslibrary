<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_instagram_feed_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_instagram_feed_theme_setup9', 9 );
	function rareradio_instagram_feed_theme_setup9() {
		if ( rareradio_exists_instagram_feed() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_instagram_responsive_styles', 2000 );
			add_filter( 'rareradio_filter_merge_styles_responsive', 'rareradio_instagram_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_instagram_feed_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_instagram_feed_tgmpa_required_plugins' ) ) {
	
	function rareradio_instagram_feed_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'instagram-feed' ) && rareradio_storage_get_array( 'required_plugins', 'instagram-feed', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'instagram-feed', 'title' ),
				'slug'     => 'instagram-feed',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if Instagram Feed installed and activated
if ( ! function_exists( 'rareradio_exists_instagram_feed' ) ) {
	function rareradio_exists_instagram_feed() {
		return defined( 'SBIVER' );
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'rareradio_instagram_responsive_styles' ) ) {
	
	function rareradio_instagram_responsive_styles() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/instagram/instagram-responsive.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-instagram-responsive', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge responsive styles
if ( ! function_exists( 'rareradio_instagram_merge_styles_responsive' ) ) {
	
	function rareradio_instagram_merge_styles_responsive( $list ) {
		$list[] = 'plugins/instagram/instagram-responsive.css';
		return $list;
	}
}

