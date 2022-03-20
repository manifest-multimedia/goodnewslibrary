<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.06
 */

$rareradio_header_css   = '';
$rareradio_header_image = get_header_image();
$rareradio_header_video = rareradio_get_header_video();
if ( ! empty( $rareradio_header_image ) && rareradio_trx_addons_featured_image_override( is_singular() || rareradio_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$rareradio_header_image = rareradio_get_current_mode_image( $rareradio_header_image );
}

$rareradio_header_id = rareradio_get_custom_header_id();
$rareradio_header_meta = get_post_meta( $rareradio_header_id, 'trx_addons_options', true );
if ( ! empty( $rareradio_header_meta['margin'] ) ) {
	rareradio_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( rareradio_prepare_css_value( $rareradio_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $rareradio_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $rareradio_header_id ) ) ); ?>
				<?php
				echo ! empty( $rareradio_header_image ) || ! empty( $rareradio_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'rareradio_action_show_layout', $rareradio_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
