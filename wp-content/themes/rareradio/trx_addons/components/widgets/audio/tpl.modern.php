<?php
/**
 * The style "modern" of the Widget "Audio"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var( 'trx_addons_args_widget_audio' );
extract( $args );

/* Before widget (defined by themes) */
trx_addons_show_layout( $before_widget );

/* Widget title if one was input (before and after defined by themes) */
trx_addons_show_layout( $title, $before_title, $after_title );

/* Widget subtitle */
if ( ! empty( $subtitle ) ) {
	echo '<div class="widget_subtitle">' . esc_html( $subtitle ) . '</div>';
}

/* Widget body */
if ( is_array( $media ) && count( $media ) > 0 ) {

	$wrap_class = ( '1' !== $track_time ? ' hide_time' : '' )
				. ( '1' !== $track_scroll ? ' hide_scroll' : '' )
				. ( '1' !== $track_volume ? ' hide_volume' : '' )
				. ( is_array( $media ) && count( $media ) > 1 ? ' list' : '' );

    ?><div class="trx_addons_audio_wrap<?php echo esc_attr( $wrap_class ); echo esc_attr(!empty($args['type']) ? ' sc_audio_style_'.$args['type'] : ''); ?>">
        <div class="trx_addons_audio_list">
		<?php
		$i = 0;
		foreach ( $media as $item ) {
			$i++;
			$item['url']         = array_key_exists( 'url', $item ) && ! empty( $item['url'] ) ? $item['url'] : '';
			$item['embed']       = array_key_exists( 'embed', $item ) && ! empty( $item['embed'] ) ? $item['embed'] : '';
			$item['caption']     = array_key_exists( 'caption', $item ) && ! empty( $item['caption'] ) ? $item['caption'] : '';
			$item['author']      = array_key_exists( 'author', $item ) && ! empty( $item['author'] ) ? $item['author'] : '';
			$item['description'] = array_key_exists( 'description', $item ) && ! empty( $item['description'] ) ? $item['description'] : '';
			$item['link1']        = array_key_exists( 'link1', $item ) && ! empty( $item['link1'] ) ? $item['link1'] : '';
			$item['link2']        = array_key_exists( 'link2', $item ) && ! empty( $item['link2'] ) ? $item['link2'] : '';
			$item['cover']       = array_key_exists( 'cover', $item ) && ! empty( $item['cover'] ) ? $item['cover'] : '';
            ?>
				<div class="trx_addons_audio_player
				<?php
				echo ! empty( $item['cover'] ) ? ' with_cover' : ' without_cover';
				?>
				">
				<span class="audio_item_number"> <?php echo esc_html($i); ?> </span>
				<?php
					if ( ! empty( $item['cover'] ) ) {
						?><div class="img-audio" <?php echo ' style="background-image:url(' . esc_url( $item['cover'] ) . ');"'; ?>></div><?php
					}
				?>
					<div class="trx_addons_audio_player_wrap">
					<?php

					if ( ! empty( $item['author'] ) || ! empty( $item['caption'] ) ) {
						?>
						<div class="audio_info">
							<?php
							if ( ! empty( $item['author'] ) ) {
								?>
								<h6 class="audio_author"><?php echo esc_html( $item['author'] ); ?></h6>
								<?php
							}
							if ( ! empty( $item['caption'] ) ) {
								?>
								<h5 class="audio_caption"><?php echo esc_html( $item['caption'] ); ?></h5>
								<?php
							}
							if ( ! empty( $item['description'] ) ) {
								?>
								<div class="audio_description"><?php echo esc_html( $item['description'] ); ?></div>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
					<div class="audio_frame audio_<?php echo esc_attr( $item['embed'] ? 'embed' : 'local' ); ?>">
					<?php
					if ( $item['embed'] ) {
						trx_addons_show_layout( $item['embed'] );
					} elseif ( $item['url'] ) {
						$default_types = wp_get_audio_extensions();
						$type = wp_check_filetype( $item['url'], wp_get_mime_types() );
						$need_replace = false;
						if ( ! in_array( strtolower( $type['ext'] ), $default_types ) ) {
							$need_replace = true;
							$item['url_orig'] = $item['url'];
							$item['url'] .= '.mp3';
						}
						$output = do_shortcode( '[audio src="' . trim( $item['url'] ) . '"]' );
						if ( ! empty( $output ) ) {
							if ( $need_replace ) {
								$output = str_replace( $item['url'], $item['url_orig'], $output );
							}
							$output = str_replace(
											'<audio ',
											'<audio'
												. ' data-src="' . esc_url($need_replace ? $item['url_orig'] : $item['url']) . '"'
												. ' data-cover="' . esc_url($item['cover']) . '"'
												. ' data-caption="' . esc_attr($item['caption']) . '"'
												. ' data-author="' . esc_attr($item['author']) . '"'
												. ' ',
											$output );
							trx_addons_show_layout( $output );
						} else {
							?>
							<audio src="<?php echo esc_url( $item['url'] ); ?>"></audio>
							<?php
						}
					}
					?>
					</div>
					<?php
					// Link's
						if (!empty($item['link1']) && !empty($item['link2'])) {
							?><div class="audio_item_link"><?php
								?>
								<!-- Link first -->
								<a href="<?php echo esc_url($item['link1']['url']); ?>" class="audio_link"<?php
									if (!empty($item['link1']['is_external'])) echo ' target="_blank"';
									if (!empty($item['link1']['nofollow'])) echo ' rel="nofollow"';
								?>>
								<?php								
								if (!empty($item['icon1'])) {
									?><span class="audio_item_icon <?php echo esc_attr($item['icon1']); ?>">
									</span><?php
								}
								?>
								</a>
								<!-- Link second -->
								<a href="<?php echo esc_url($item['link2']['url']); ?>" class="audio_link"<?php
									if (!empty($item['link2']['is_external'])) echo ' target="_blank"';
									if (!empty($item['link2']['nofollow'])) echo ' rel="nofollow"';
								?>>
								<?php								
									if (!empty($item['icon2'])) {
										?><span class="audio_item_icon <?php echo esc_attr($item['icon2']); ?>">
										</span><?php
									}
								?>
								</a>
								</div><?php
						}
					?>
				</div>
			</div>
			<?php
		}
		?>
		</div>
	</div><?php
}

/* After widget (defined by themes) */
trx_addons_show_layout( $after_widget );
?>
