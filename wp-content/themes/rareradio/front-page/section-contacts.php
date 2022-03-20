<div class="front_page_section front_page_section_contacts<?php
	$rareradio_scheme = rareradio_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $rareradio_scheme ) && ! rareradio_is_inherit( $rareradio_scheme ) ) {
		echo ' scheme_' . esc_attr( $rareradio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( rareradio_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( rareradio_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$rareradio_css      = '';
		$rareradio_bg_image = rareradio_get_theme_option( 'front_page_contacts_bg_image' );
		if ( ! empty( $rareradio_bg_image ) ) {
			$rareradio_css .= 'background-image: url(' . esc_url( rareradio_get_attachment_url( $rareradio_bg_image ) ) . ');';
		}
		if ( ! empty( $rareradio_css ) ) {
			echo ' style="' . esc_attr( $rareradio_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$rareradio_anchor_icon = rareradio_get_theme_option( 'front_page_contacts_anchor_icon' );
	$rareradio_anchor_text = rareradio_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $rareradio_anchor_icon ) || ! empty( $rareradio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $rareradio_anchor_icon ) ? ' icon="' . esc_attr( $rareradio_anchor_icon ) . '"' : '' )
									. ( ! empty( $rareradio_anchor_text ) ? ' title="' . esc_attr( $rareradio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( rareradio_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' rareradio-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$rareradio_css      = '';
			$rareradio_bg_mask  = rareradio_get_theme_option( 'front_page_contacts_bg_mask' );
			$rareradio_bg_color_type = rareradio_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $rareradio_bg_color_type ) {
				$rareradio_bg_color = rareradio_get_theme_option( 'front_page_contacts_bg_color' );
			} elseif ( 'scheme_bg_color' == $rareradio_bg_color_type ) {
				$rareradio_bg_color = rareradio_get_scheme_color( 'bg_color', $rareradio_scheme );
			} else {
				$rareradio_bg_color = '';
			}
			if ( ! empty( $rareradio_bg_color ) && $rareradio_bg_mask > 0 ) {
				$rareradio_css .= 'background-color: ' . esc_attr(
					1 == $rareradio_bg_mask ? $rareradio_bg_color : rareradio_hex2rgba( $rareradio_bg_color, $rareradio_bg_mask )
				) . ';';
			}
			if ( ! empty( $rareradio_css ) ) {
				echo ' style="' . esc_attr( $rareradio_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$rareradio_caption     = rareradio_get_theme_option( 'front_page_contacts_caption' );
			$rareradio_description = rareradio_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $rareradio_caption ) || ! empty( $rareradio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $rareradio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $rareradio_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $rareradio_caption, 'rareradio_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $rareradio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $rareradio_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $rareradio_description ), 'rareradio_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$rareradio_content = rareradio_get_theme_option( 'front_page_contacts_content' );
			$rareradio_layout  = rareradio_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $rareradio_layout && ( ! empty( $rareradio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $rareradio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $rareradio_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $rareradio_content, 'rareradio_kses_content' );
				?>
				</div>
				<?php
			}

			if ( 'columns' == $rareradio_layout && ( ! empty( $rareradio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$rareradio_sc = rareradio_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $rareradio_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $rareradio_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					rareradio_show_layout( do_shortcode( $rareradio_sc ) );
				?>
				</div>
				<?php
			}

			if ( 'columns' == $rareradio_layout && ( ! empty( $rareradio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
