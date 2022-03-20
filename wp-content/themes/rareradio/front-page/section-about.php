<div class="front_page_section front_page_section_about<?php
	$rareradio_scheme = rareradio_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $rareradio_scheme ) && ! rareradio_is_inherit( $rareradio_scheme ) ) {
		echo ' scheme_' . esc_attr( $rareradio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( rareradio_get_theme_option( 'front_page_about_paddings' ) );
	if ( rareradio_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$rareradio_css      = '';
		$rareradio_bg_image = rareradio_get_theme_option( 'front_page_about_bg_image' );
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
	$rareradio_anchor_icon = rareradio_get_theme_option( 'front_page_about_anchor_icon' );
	$rareradio_anchor_text = rareradio_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $rareradio_anchor_icon ) || ! empty( $rareradio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $rareradio_anchor_icon ) ? ' icon="' . esc_attr( $rareradio_anchor_icon ) . '"' : '' )
									. ( ! empty( $rareradio_anchor_text ) ? ' title="' . esc_attr( $rareradio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( rareradio_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' rareradio-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$rareradio_css           = '';
			$rareradio_bg_mask       = rareradio_get_theme_option( 'front_page_about_bg_mask' );
			$rareradio_bg_color_type = rareradio_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $rareradio_bg_color_type ) {
				$rareradio_bg_color = rareradio_get_theme_option( 'front_page_about_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$rareradio_caption = rareradio_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $rareradio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $rareradio_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $rareradio_caption, 'rareradio_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$rareradio_description = rareradio_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $rareradio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $rareradio_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $rareradio_description ), 'rareradio_kses_content' ); ?></div>
				<?php
			}

			// Content
			$rareradio_content = rareradio_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $rareradio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $rareradio_content ) ? 'filled' : 'empty'; ?>">
				<?php
					$rareradio_page_content_mask = '%%CONTENT%%';
				if ( strpos( $rareradio_content, $rareradio_page_content_mask ) !== false ) {
					$rareradio_content = preg_replace(
						'/(\<p\>\s*)?' . $rareradio_page_content_mask . '(\s*\<\/p\>)/i',
						sprintf(
							'<div class="front_page_section_about_source">%s</div>',
							apply_filters( 'the_content', get_the_content() )
						),
						$rareradio_content
					);
				}
					rareradio_show_layout( $rareradio_content );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
