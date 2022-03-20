<?php
/* ThemeREX Updater support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_trx_socials_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_trx_socials_theme_setup9', 9 );
	function rareradio_trx_socials_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_trx_socials_tgmpa_required_plugins', 8 );
		}
	}
}

// Filter to add in the required plugins list
// Priority 8 is used to add this plugin before all other plugins
if ( ! function_exists( 'rareradio_trx_socials_tgmpa_required_plugins' ) ) {
	function rareradio_trx_socials_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'trx_socials' ) && rareradio_storage_get_array( 'required_plugins', 'trx_socials', 'install' ) !== false && rareradio_is_theme_activated() ) {
			$path = rareradio_get_plugin_source_path( 'plugins/trx_socials/trx_socials.zip' );
			if ( ! empty( $path ) || rareradio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => rareradio_storage_get_array( 'required_plugins', 'trx_socials', 'title' ),
					'slug'     => 'trx_socials',
					'version'  => '1.4.2',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_socials.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'rareradio_exists_trx_socials' ) ) {
	function rareradio_exists_trx_socials() {
		return defined( 'TRX_SOCIALS_STORAGE' );
	}
}
