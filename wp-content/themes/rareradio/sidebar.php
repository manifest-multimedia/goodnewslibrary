<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

if ( rareradio_sidebar_present() ) {
	ob_start();
	$rareradio_sidebar_name = rareradio_get_theme_option( 'sidebar_widgets' );
	rareradio_storage_set( 'current_sidebar', 'sidebar' );
	if ( is_active_sidebar( $rareradio_sidebar_name ) ) {
		dynamic_sidebar( $rareradio_sidebar_name );
	}
	$rareradio_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $rareradio_out ) ) {
		$rareradio_sidebar_position    = rareradio_get_theme_option( 'sidebar_position' );
		$rareradio_sidebar_position_ss = rareradio_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $rareradio_sidebar_position );
			echo ' sidebar_' . esc_attr( $rareradio_sidebar_position_ss );

			if ( 'float' == $rareradio_sidebar_position_ss ) {
				echo ' sidebar_float';
			}
			$rareradio_sidebar_scheme = rareradio_get_theme_option( 'sidebar_scheme' );
			if ( ! empty( $rareradio_sidebar_scheme ) && ! rareradio_is_inherit( $rareradio_sidebar_scheme ) ) {
				echo ' scheme_' . esc_attr( $rareradio_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php
			// Single posts banner before sidebar
			rareradio_show_post_banner( 'sidebar' );
			// Button to show/hide sidebar on mobile
			if ( in_array( $rareradio_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$rareradio_title = apply_filters( 'rareradio_filter_sidebar_control_title', 'float' == $rareradio_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'rareradio' ) : '' );
				$rareradio_text  = apply_filters( 'rareradio_filter_sidebar_control_text', 'above' == $rareradio_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'rareradio' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $rareradio_title ); ?>"><?php echo esc_html( $rareradio_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'rareradio_action_before_sidebar' );
				rareradio_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $rareradio_out ) );
				do_action( 'rareradio_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
