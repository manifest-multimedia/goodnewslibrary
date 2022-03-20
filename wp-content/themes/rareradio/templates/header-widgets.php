<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

// Header sidebar
$rareradio_header_name    = rareradio_get_theme_option( 'header_widgets' );
$rareradio_header_present = ! rareradio_is_off( $rareradio_header_name ) && is_active_sidebar( $rareradio_header_name );
if ( $rareradio_header_present ) {
	rareradio_storage_set( 'current_sidebar', 'header' );
	$rareradio_header_wide = rareradio_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $rareradio_header_name ) ) {
		dynamic_sidebar( $rareradio_header_name );
	}
	$rareradio_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $rareradio_widgets_output ) ) {
		$rareradio_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $rareradio_widgets_output );
		$rareradio_need_columns   = strpos( $rareradio_widgets_output, 'columns_wrap' ) === false;
		if ( $rareradio_need_columns ) {
			$rareradio_columns = max( 0, (int) rareradio_get_theme_option( 'header_columns' ) );
			if ( 0 == $rareradio_columns ) {
				$rareradio_columns = min( 6, max( 1, rareradio_tags_count( $rareradio_widgets_output, 'aside' ) ) );
			}
			if ( $rareradio_columns > 1 ) {
				$rareradio_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $rareradio_columns ) . ' widget', $rareradio_widgets_output );
			} else {
				$rareradio_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $rareradio_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $rareradio_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $rareradio_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'rareradio_action_before_sidebar' );
				rareradio_show_layout( $rareradio_widgets_output );
				do_action( 'rareradio_action_after_sidebar' );
				if ( $rareradio_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $rareradio_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
