<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.14
 */
$rareradio_header_video = rareradio_get_header_video();
$rareradio_embed_video  = '';
if ( ! empty( $rareradio_header_video ) && ! rareradio_is_from_uploads( $rareradio_header_video ) ) {
	if ( rareradio_is_youtube_url( $rareradio_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $rareradio_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php rareradio_show_layout( rareradio_get_embed_video( $rareradio_header_video ) ); ?></div>
		<?php
	}
}
