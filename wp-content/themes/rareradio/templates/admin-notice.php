<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.1
 */

$rareradio_theme_obj = wp_get_theme();
?>
<div class="rareradio_admin_notice rareradio_welcome_notice update-nag">
	<?php
	// Theme image
	$rareradio_theme_img = rareradio_get_file_url( 'screenshot.jpg' );
	if ( '' != $rareradio_theme_img ) {
		?>
		<div class="rareradio_notice_image"><img src="<?php echo esc_url( $rareradio_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'rareradio' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="rareradio_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'rareradio' ),
				$rareradio_theme_obj->name . ( RARERADIO_THEME_FREE ? ' ' . __( 'Free', 'rareradio' ) : '' ),
				$rareradio_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="rareradio_notice_text">
		<p class="rareradio_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $rareradio_theme_obj->description ) );
			?>
		</p>
		<p class="rareradio_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'rareradio' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="rareradio_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=rareradio_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'rareradio' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" class="rareradio_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="rareradio_hide_notice_text"><?php esc_html_e( 'Dismiss', 'rareradio' ); ?></span></a>
	</div>
</div>
