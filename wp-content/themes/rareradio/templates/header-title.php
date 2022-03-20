<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

// Page (category, tag, archive, author) title

if ( rareradio_need_page_title() ) {
	rareradio_sc_layouts_showed( 'title', true );
	rareradio_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								rareradio_show_post_meta(
									apply_filters(
										'rareradio_filter_post_meta_args', array(
											'components' => rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) ),
											'counters'   => rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'counters' ) ),
											'seo'        => rareradio_is_on( rareradio_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$rareradio_blog_title           = rareradio_get_blog_title();
							$rareradio_blog_title_text      = '';
							$rareradio_blog_title_class     = '';
							$rareradio_blog_title_link      = '';
							$rareradio_blog_title_link_text = '';
							if ( is_array( $rareradio_blog_title ) ) {
								$rareradio_blog_title_text      = $rareradio_blog_title['text'];
								$rareradio_blog_title_class     = ! empty( $rareradio_blog_title['class'] ) ? ' ' . $rareradio_blog_title['class'] : '';
								$rareradio_blog_title_link      = ! empty( $rareradio_blog_title['link'] ) ? $rareradio_blog_title['link'] : '';
								$rareradio_blog_title_link_text = ! empty( $rareradio_blog_title['link_text'] ) ? $rareradio_blog_title['link_text'] : '';
							} else {
								$rareradio_blog_title_text = $rareradio_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $rareradio_blog_title_class ); ?>">
								<?php
								$rareradio_top_icon = rareradio_get_term_image_small();
								if ( ! empty( $rareradio_top_icon ) ) {
									$rareradio_attr = rareradio_getimagesize( $rareradio_top_icon );
									?>
									<img src="<?php echo esc_url( $rareradio_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'rareradio' ); ?>"
										<?php
										if ( ! empty( $rareradio_attr[3] ) ) {
											rareradio_show_layout( $rareradio_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $rareradio_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $rareradio_blog_title_link ) && ! empty( $rareradio_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $rareradio_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $rareradio_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						?>
						<div class="sc_layouts_title_breadcrumbs">
							<?php
							do_action( 'rareradio_action_breadcrumbs' );
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
