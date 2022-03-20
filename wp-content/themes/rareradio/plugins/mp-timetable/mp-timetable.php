<?php
/* MP Timetable support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_mptt_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_mptt_theme_setup9', 9 );
	function rareradio_mptt_theme_setup9() {
		if ( rareradio_exists_mptt() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_mptt_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'rareradio_mptt_responsive_styles', 2000 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_mptt_merge_styles' );
			add_filter( 'rareradio_filter_merge_styles_responsive', 'rareradio_mptt_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_mptt_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_mptt_tgmpa_required_plugins' ) ) {
	
	function rareradio_mptt_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'mp-timetable' ) && rareradio_storage_get_array( 'required_plugins', 'mp-timetable', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'mp-timetable', 'title' ),
				'slug'     => 'mp-timetable',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin is installed and activated
if ( ! function_exists( 'rareradio_exists_mp_timetable' ) ) {
	function rareradio_exists_mptt() {
		return class_exists( 'Mp_Time_Table' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_mptt_frontend_scripts' ) ) {
	
	function rareradio_mptt_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/mp-timetable/mp-timetable.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-mptt', $rareradio_url, array(), null );
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'rareradio_mptt_responsive_styles' ) ) {
	
	function rareradio_mptt_responsive_styles() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/mp-timetable/mp-timetable-responsive.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-mptt-responsive', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_mptt_merge_styles' ) ) {
	
	function rareradio_mptt_merge_styles( $list ) {
		$list[] = 'plugins/mp-timetable/mp-timetable.css';
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'rareradio_mptt_merge_styles_responsive' ) ) {
	
	function rareradio_mptt_merge_styles_responsive( $list ) {
		$list[] = 'plugins/mp-timetable/mp-timetable-responsive.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( rareradio_exists_mptt() ) {
	require_once RARERADIO_THEME_DIR . 'plugins/mp-timetable/mp-timetable-styles.php'; }


// Change events to timetable
function rareradio_mptt_change_post_type_event( $args ) {
		$args['labels']['name'] = esc_html__( 'Timetable', 'rareradio' );
	return $args;
}
add_filter( 'mptt_register_post_type_event', 'rareradio_mptt_change_post_type_event', 10 );