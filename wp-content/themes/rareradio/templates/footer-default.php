<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$rareradio_footer_scheme = rareradio_get_theme_option( 'footer_scheme' );
if ( ! empty( $rareradio_footer_scheme ) && ! rareradio_is_inherit( $rareradio_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $rareradio_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/footer-socials' ) );

	// Menu
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/footer-menu' ) );

	// Copyright area
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
