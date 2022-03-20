<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$rareradio_copyright_scheme = rareradio_get_theme_option( 'copyright_scheme' );
if ( ! empty( $rareradio_copyright_scheme ) && ! rareradio_is_inherit( $rareradio_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $rareradio_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$rareradio_copyright = rareradio_get_theme_option( 'copyright' );
			if ( ! empty( $rareradio_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$rareradio_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $rareradio_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$rareradio_copyright = rareradio_prepare_macros( $rareradio_copyright );
				// Display copyright
				echo wp_kses( nl2br( $rareradio_copyright ), 'rareradio_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
