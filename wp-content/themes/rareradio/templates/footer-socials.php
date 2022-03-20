<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.10
 */


// Socials
if ( rareradio_is_on( rareradio_get_theme_option( 'socials_in_footer' ) ) ) {
	$rareradio_output = rareradio_get_socials_links();
	if ( '' != $rareradio_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php rareradio_show_layout( $rareradio_output ); ?>
			</div>
		</div>
		<?php
	}
}
