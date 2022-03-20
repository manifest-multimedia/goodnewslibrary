<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_revslider_theme_setup9', 9 );
	function rareradio_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_revslider_tgmpa_required_plugins' ) ) {
	
	function rareradio_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'revslider' ) && rareradio_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && rareradio_is_theme_activated() ) {
			$path = rareradio_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || rareradio_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => rareradio_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'version'  => '6.5.7',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'rareradio_exists_revslider' ) ) {
	function rareradio_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' );
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'rareradio_revslider_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',    'rareradio_revslider_importer_set_options' );
    function rareradio_revslider_importer_set_options($options=array()) {
        if ( rareradio_exists_revslider() && in_array('revslider', $options['required_plugins']) ) {
            $options['additional_options'][]    = 'revslider-global-settings';                    // Add slugs to export options for this plugin
        }
        return $options;
    }
}
