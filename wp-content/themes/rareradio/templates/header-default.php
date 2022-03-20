<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_header_css   = '';
$rareradio_header_image = get_header_image();
$rareradio_header_video = rareradio_get_header_video();
if ( ! empty( $rareradio_header_image ) && rareradio_trx_addons_featured_image_override( is_singular() || rareradio_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$rareradio_header_image = rareradio_get_current_mode_image( $rareradio_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $rareradio_header_image ) || ! empty( $rareradio_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $rareradio_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $rareradio_header_image ) {
		echo ' ' . esc_attr( rareradio_add_inline_css_class( 'background-image: url(' . esc_url( $rareradio_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( rareradio_is_on( rareradio_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight rareradio-full-height';
	}
	$rareradio_header_scheme = rareradio_get_theme_option( 'header_scheme' );
	if ( ! empty( $rareradio_header_scheme ) && ! rareradio_is_inherit( $rareradio_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $rareradio_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $rareradio_header_video ) ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	if ( rareradio_get_theme_option( 'menu_style' ) == 'top' ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-navi' ) );
	}

	// Mobile header
	if ( rareradio_is_on( rareradio_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-mobile' ) );
	}

	if ( !is_single() || ( rareradio_get_theme_option( 'post_header_position' ) == 'default' && rareradio_get_theme_option( 'post_thumbnail_type' ) == 'default' ) ) {
		// Page title and breadcrumbs area
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-title' ) );

		// Display featured image in the header on the single posts
		// Comment next line to prevent show featured image in the header area
		// and display it in the post's content
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-single' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
