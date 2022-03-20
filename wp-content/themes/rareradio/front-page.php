<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( rareradio_is_on( rareradio_get_theme_option( 'front_page_enabled' ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$rareradio_sections = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'front_page_sections' ), 1, false );
		if ( is_array( $rareradio_sections ) ) {
			foreach ( $rareradio_sections as $rareradio_section ) {
				get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'front-page/section', $rareradio_section ), $rareradio_section );
			}
		}

		// Else if this page is blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'blog' ) );

		// Else - display native page content
	} else {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'page' ) );
	}

	// Else get index template to show posts
} else {
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'index' ) );
}

get_footer();
