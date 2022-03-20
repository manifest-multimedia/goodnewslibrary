<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.10
 */

// Footer sidebar
$rareradio_footer_name    = rareradio_get_theme_option( 'footer_widgets' );
$rareradio_footer_present = ! rareradio_is_off( $rareradio_footer_name ) && is_active_sidebar( $rareradio_footer_name );
if ( $rareradio_footer_present ) {
	rareradio_storage_set( 'current_sidebar', 'footer' );
	$rareradio_footer_wide = rareradio_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $rareradio_footer_name ) ) {
		dynamic_sidebar( $rareradio_footer_name );
	}
	$rareradio_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $rareradio_out ) ) {
		$rareradio_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $rareradio_out );
		$rareradio_need_columns = true;   //or check: strpos($rareradio_out, 'columns_wrap')===false;
		if ( $rareradio_need_columns ) {
			$rareradio_columns = max( 0, (int) rareradio_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $rareradio_columns ) {
				$rareradio_columns = min( 4, max( 1, rareradio_tags_count( $rareradio_out, 'aside' ) ) );
			}
			if ( $rareradio_columns > 1 ) {
				$rareradio_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $rareradio_columns ) . ' widget', $rareradio_out );
			} else {
				$rareradio_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $rareradio_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $rareradio_footer_wide ) {
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
				rareradio_show_layout( $rareradio_out );
				do_action( 'rareradio_action_after_sidebar' );
				if ( $rareradio_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $rareradio_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
