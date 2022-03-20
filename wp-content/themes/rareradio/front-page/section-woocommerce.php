<div class="front_page_section front_page_section_woocommerce<?php
	$rareradio_scheme = rareradio_get_theme_option( 'front_page_woocommerce_scheme' );
	if ( ! empty( $rareradio_scheme ) && ! rareradio_is_inherit( $rareradio_scheme ) ) {
		echo ' scheme_' . esc_attr( $rareradio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( rareradio_get_theme_option( 'front_page_woocommerce_paddings' ) );
	if ( rareradio_get_theme_option( 'front_page_woocommerce_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$rareradio_css      = '';
		$rareradio_bg_image = rareradio_get_theme_option( 'front_page_woocommerce_bg_image' );
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
	$rareradio_anchor_icon = rareradio_get_theme_option( 'front_page_woocommerce_anchor_icon' );
	$rareradio_anchor_text = rareradio_get_theme_option( 'front_page_woocommerce_anchor_text' );
if ( ( ! empty( $rareradio_anchor_icon ) || ! empty( $rareradio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_woocommerce"'
									. ( ! empty( $rareradio_anchor_icon ) ? ' icon="' . esc_attr( $rareradio_anchor_icon ) . '"' : '' )
									. ( ! empty( $rareradio_anchor_text ) ? ' title="' . esc_attr( $rareradio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner
	<?php
	if ( rareradio_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
		echo ' rareradio-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$rareradio_css      = '';
			$rareradio_bg_mask  = rareradio_get_theme_option( 'front_page_woocommerce_bg_mask' );
			$rareradio_bg_color_type = rareradio_get_theme_option( 'front_page_woocommerce_bg_color_type' );
			if ( 'custom' == $rareradio_bg_color_type ) {
				$rareradio_bg_color = rareradio_get_theme_option( 'front_page_woocommerce_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$rareradio_caption     = rareradio_get_theme_option( 'front_page_woocommerce_caption' );
			$rareradio_description = rareradio_get_theme_option( 'front_page_woocommerce_description' );
			if ( ! empty( $rareradio_caption ) || ! empty( $rareradio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $rareradio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $rareradio_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $rareradio_caption, 'rareradio_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description (text)
				if ( ! empty( $rareradio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $rareradio_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $rareradio_description ), 'rareradio_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
			<?php
				$rareradio_woocommerce_sc = rareradio_get_theme_option( 'front_page_woocommerce_products' );
			if ( 'products' == $rareradio_woocommerce_sc ) {
				$rareradio_woocommerce_sc_ids      = rareradio_get_theme_option( 'front_page_woocommerce_products_per_page' );
				$rareradio_woocommerce_sc_per_page = count( explode( ',', $rareradio_woocommerce_sc_ids ) );
			} else {
				$rareradio_woocommerce_sc_per_page = max( 1, (int) rareradio_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
			}
				$rareradio_woocommerce_sc_columns = max( 1, min( $rareradio_woocommerce_sc_per_page, (int) rareradio_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
				echo do_shortcode(
					"[{$rareradio_woocommerce_sc}"
									. ( 'products' == $rareradio_woocommerce_sc
											? ' ids="' . esc_attr( $rareradio_woocommerce_sc_ids ) . '"'
											: '' )
									. ( 'product_category' == $rareradio_woocommerce_sc
											? ' category="' . esc_attr( rareradio_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
											: '' )
									. ( 'best_selling_products' != $rareradio_woocommerce_sc
											? ' orderby="' . esc_attr( rareradio_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
												. ' order="' . esc_attr( rareradio_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
											: '' )
									. ' per_page="' . esc_attr( $rareradio_woocommerce_sc_per_page ) . '"'
									. ' columns="' . esc_attr( $rareradio_woocommerce_sc_columns ) . '"'
					. ']'
				);
				?>
			</div>
		</div>
	</div>
</div>
