<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_args = get_query_var( 'rareradio_logo_args' );

// Site logo
$rareradio_logo_type   = isset( $rareradio_args['type'] ) ? $rareradio_args['type'] : '';
$rareradio_logo_image  = rareradio_get_logo_image( $rareradio_logo_type );
$rareradio_logo_text   = rareradio_is_on( rareradio_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$rareradio_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $rareradio_logo_image['logo'] ) || ! empty( $rareradio_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $rareradio_logo_image['logo'] ) ) {
			if ( empty( $rareradio_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric( $rareradio_logo_image['logo'] ) && $rareradio_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$rareradio_attr = rareradio_getimagesize( $rareradio_logo_image['logo'] );
				echo '<img src="' . esc_url( $rareradio_logo_image['logo'] ) . '"'
						. ( ! empty( $rareradio_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $rareradio_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $rareradio_logo_text ) . '"'
						. ( ! empty( $rareradio_attr[3] ) ? ' ' . wp_kses_data( $rareradio_attr[3] ) : '' )
						. '>';
			}
		} else {
			rareradio_show_layout( rareradio_prepare_macros( $rareradio_logo_text ), '<span class="logo_text">', '</span>' );
			rareradio_show_layout( rareradio_prepare_macros( $rareradio_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
