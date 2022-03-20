<?php
/* Tribe Events Calendar support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if ( ! function_exists( 'rareradio_tribe_events_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'rareradio_tribe_events_theme_setup1', 1 );
	function rareradio_tribe_events_theme_setup1() {
		add_filter( 'rareradio_filter_list_sidebars', 'rareradio_tribe_events_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'rareradio_tribe_events_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'rareradio_tribe_events_theme_setup3', 3 );
	function rareradio_tribe_events_theme_setup3() {
		if ( rareradio_exists_tribe_events() ) {

			// Section 'Tribe Events'
			rareradio_storage_merge_array(
				'options', '', array_merge(
					array(
						'events' => array(
							'title' => esc_html__( 'Events', 'rareradio' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the events pages', 'rareradio' ) ),
							'type'  => 'section',
						),
					),
					rareradio_options_get_list_cpt_options( 'events' )
				)
			);
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_tribe_events_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_tribe_events_theme_setup9', 9 );
	function rareradio_tribe_events_theme_setup9() {
		if ( rareradio_exists_tribe_events() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_tribe_events_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'rareradio_tribe_events_responsive_styles', 2000 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_tribe_events_merge_styles' );
			add_filter( 'rareradio_filter_merge_styles_responsive', 'rareradio_tribe_events_merge_styles_responsive' );
			add_filter( 'rareradio_filter_post_type_taxonomy', 'rareradio_tribe_events_post_type_taxonomy', 10, 2 );
			if ( ! is_admin() ) {
				add_filter( 'rareradio_filter_detect_blog_mode', 'rareradio_tribe_events_detect_blog_mode' );
				add_filter( 'rareradio_filter_get_post_categories', 'rareradio_tribe_events_get_post_categories' );
				add_filter( 'rareradio_filter_get_post_date', 'rareradio_tribe_events_get_post_date' );
			}
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_tribe_events_tgmpa_required_plugins' );
		}

	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_tribe_events_tgmpa_required_plugins' ) ) {
	
	function rareradio_tribe_events_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'the-events-calendar' ) && rareradio_storage_get_array( 'required_plugins', 'the-events-calendar', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'the-events-calendar', 'title' ),
				'slug'     => 'the-events-calendar',
				'required' => false,
			);
		}
		return $list;
	}
}


// Remove 'Tribe Events' section from Customizer
if ( ! function_exists( 'rareradio_tribe_events_customizer_register_controls' ) ) {
	add_action( 'customize_register', 'rareradio_tribe_events_customizer_register_controls', 100 );
	function rareradio_tribe_events_customizer_register_controls( $wp_customize ) {
		$wp_customize->remove_panel( 'tribe_customizer' );
	}
}


// Check if Tribe Events is installed and activated
if ( ! function_exists( 'rareradio_exists_tribe_events' ) ) {
	function rareradio_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}

// Return true, if current page is any tribe_events page
if ( ! function_exists( 'rareradio_is_tribe_events_page' ) ) {
	function rareradio_is_tribe_events_page() {
		$rez = false;
		if ( rareradio_exists_tribe_events() ) {
			if ( ! is_search() ) {
				$rez = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
			}
		}
		return $rez;
	}
}

// Detect current blog mode
if ( ! function_exists( 'rareradio_tribe_events_detect_blog_mode' ) ) {
	
	function rareradio_tribe_events_detect_blog_mode( $mode = '' ) {
		if ( rareradio_is_tribe_events_page() ) {
			$mode = 'events';
		}
		return $mode;
	}
}

// Return taxonomy for current post type
if ( ! function_exists( 'rareradio_tribe_events_post_type_taxonomy' ) ) {
	
	function rareradio_tribe_events_post_type_taxonomy( $tax = '', $post_type = '' ) {
		if ( rareradio_exists_tribe_events() && Tribe__Events__Main::POSTTYPE == $post_type ) {
			$tax = Tribe__Events__Main::TAXONOMY;
		}
		return $tax;
	}
}

// Show categories of the current event
if ( ! function_exists( 'rareradio_tribe_events_get_post_categories' ) ) {
	
	function rareradio_tribe_events_get_post_categories( $cats = '' ) {
		if ( get_post_type() == Tribe__Events__Main::POSTTYPE ) {
			$cats = rareradio_get_post_terms( ', ', get_the_ID(), Tribe__Events__Main::TAXONOMY );
		}
		return $cats;
	}
}

// Return date of the current event
if ( ! function_exists( 'rareradio_tribe_events_get_post_date' ) ) {
	
	function rareradio_tribe_events_get_post_date( $dt = '' ) {
		if ( get_post_type() == Tribe__Events__Main::POSTTYPE ) {
			$dt = tribe_events_event_schedule_details( get_the_ID(), '', '' );
		}
		return $dt;
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_tribe_events_frontend_scripts' ) ) {
	
	function rareradio_tribe_events_frontend_scripts() {
		if ( rareradio_is_tribe_events_page() ) {
			if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
				$rareradio_url = rareradio_get_file_url( 'plugins/the-events-calendar/the-events-calendar.css' );
				if ( '' != $rareradio_url ) {
					wp_enqueue_style( 'rareradio-tribe-events', $rareradio_url, array(), null );
				}
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'rareradio_tribe_events_responsive_styles' ) ) {
	
	function rareradio_tribe_events_responsive_styles() {
		if ( rareradio_is_tribe_events_page() ) {
			if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
				$rareradio_url = rareradio_get_file_url( 'plugins/the-events-calendar/the-events-calendar-responsive.css' );
				if ( '' != $rareradio_url ) {
					wp_enqueue_style( 'rareradio-tribe-events-responsive', $rareradio_url, array(), null );
				}
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_tribe_events_merge_styles' ) ) {
	
	function rareradio_tribe_events_merge_styles( $list ) {
		$list[] = 'plugins/the-events-calendar/the-events-calendar.css';
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'rareradio_tribe_events_merge_styles_responsive' ) ) {
	
	function rareradio_tribe_events_merge_styles_responsive( $list ) {
		$list[] = 'plugins/the-events-calendar/the-events-calendar-responsive.css';
		return $list;
	}
}



// Add Tribe Events specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( ! function_exists( 'rareradio_tribe_events_list_sidebars' ) ) {
	
	function rareradio_tribe_events_list_sidebars( $list = array() ) {
		$list['tribe_events_widgets'] = array(
			'name'        => esc_html__( 'Tribe Events Widgets', 'rareradio' ),
			'description' => esc_html__( 'Widgets to be shown on the Tribe Events pages', 'rareradio' ),
		);
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( rareradio_exists_tribe_events() ) {
	require_once RARERADIO_THEME_DIR . 'plugins/the-events-calendar/the-events-calendar-styles.php'; 
}