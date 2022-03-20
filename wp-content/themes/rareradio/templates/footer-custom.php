<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.10
 */

$rareradio_footer_id = rareradio_get_custom_footer_id();
$rareradio_footer_meta = get_post_meta( $rareradio_footer_id, 'trx_addons_options', true );
if ( ! empty( $rareradio_footer_meta['margin'] ) ) {
	rareradio_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( rareradio_prepare_css_value( $rareradio_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $rareradio_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $rareradio_footer_id ) ) ); ?>
						<?php
						$rareradio_footer_scheme = rareradio_get_theme_option( 'footer_scheme' );
						if ( ! empty( $rareradio_footer_scheme ) && ! rareradio_is_inherit( $rareradio_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $rareradio_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'rareradio_action_show_layout', $rareradio_footer_id );
	?>
</footer><!-- /.footer_wrap -->
