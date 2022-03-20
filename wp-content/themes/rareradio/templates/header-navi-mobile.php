<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */
$rareradio_menu_image = rareradio_get_theme_option( 'menu_mobile_image' );
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( rareradio_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> <?php echo !empty( $rareradio_menu_image ) ? ' with_image' : ''; ?> scheme_dark">
	<?php
	if(!empty ($rareradio_menu_image)) {
		$rareradio_menu_styles = rareradio_add_inline_css_class('background-image: url('.$rareradio_menu_image.')'); ?>
		<div class="menu_mobile_image <?php echo esc_attr($rareradio_menu_styles); ?>"></div><?php
	}
	?>
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close theme_button_close"><span class="theme_button_close_icon"></span><span class="theme_button_close_text"><?php echo esc_html__('close', 'rareradio') ?></span></a>
		<?php

		// Logo
		set_query_var( 'rareradio_logo_args', array( 'type' => 'mobile' ) );
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'rareradio_logo_args', array() );

		// Mobile menu
		$rareradio_menu_mobile = rareradio_get_nav_menu( 'menu_mobile' );
		if ( empty( $rareradio_menu_mobile ) ) {
			$rareradio_menu_mobile = apply_filters( 'rareradio_filter_get_mobile_menu', '' );
			if ( empty( $rareradio_menu_mobile ) ) {
				$rareradio_menu_mobile = rareradio_get_nav_menu( 'menu_main' );
				if ( empty( $rareradio_menu_mobile ) ) {
					$rareradio_menu_mobile = rareradio_get_nav_menu();
				}
			}
		}
		if ( ! empty( $rareradio_menu_mobile ) ) {
			$rareradio_menu_mobile = str_replace(
				array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
				array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
				$rareradio_menu_mobile
			);
			if ( strpos( $rareradio_menu_mobile, '<nav ' ) === false ) {
				$rareradio_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area" itemscope="itemscope" itemtype="//schema.org/SiteNavigationElement">%s</nav>', $rareradio_menu_mobile );
			}
			rareradio_show_layout( apply_filters( 'rareradio_filter_menu_mobile_layout', $rareradio_menu_mobile ) );
		}

		// Search field
		do_action(
			'rareradio_action_search',
			array(
				'style' => 'normal',
				'class' => 'search_mobile',
				'ajax'  => false
			)
		);

		// Social icons
		rareradio_show_layout( rareradio_get_socials_links(), '<div class="socials_mobile">', '</div>' );
		?>
	</div>
</div>
