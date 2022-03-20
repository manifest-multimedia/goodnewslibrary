<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.10
 */

// Logo
if ( rareradio_is_on( rareradio_get_theme_option( 'logo_in_footer' ) ) ) {
	$rareradio_logo_image = rareradio_get_logo_image( 'footer' );
	$rareradio_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $rareradio_logo_image['logo'] ) || ! empty( $rareradio_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $rareradio_logo_image['logo'] ) ) {
					$rareradio_attr = rareradio_getimagesize( $rareradio_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $rareradio_logo_image['logo'] ) . '"'
								. ( ! empty( $rareradio_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $rareradio_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'rareradio' ) . '"'
								. ( ! empty( $rareradio_attr[3] ) ? ' ' . wp_kses_data( $rareradio_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $rareradio_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $rareradio_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
