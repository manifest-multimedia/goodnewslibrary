<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_seo = rareradio_is_on( rareradio_get_theme_option( 'seo_snippets' ) );
$rareradio_components = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class('post_item_single post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
		. ( rareradio_exists_trx_addons() ? ( rareradio_is_on( rareradio_get_theme_option( 'show_share_links' ) ) ? ' with_share' : '' ) : '' )
		
	);
	if ( $rareradio_seo ) {
		?>
		itemscope="itemscope" 
		itemprop="articleBody" 
		itemtype="//schema.org/<?php echo esc_attr( rareradio_get_markup_schema() ); ?>" 
		itemid="<?php echo esc_url( get_the_permalink() ); ?>"
		content="<?php the_title_attribute( '' ); ?>"
		<?php
	}
	?>
>
	<?php
		// Share
		if ( rareradio_is_on( rareradio_get_theme_option( 'show_share_links' ) ) ) {
			rareradio_show_share_links(
				array(
					'type'    => 'block',
					'caption' => esc_html__('Share', 'rareradio'),
					'before'  => '<span class="post_meta_item post_share post_share_top">',
					'after'   => '</span>',
				)
			);
		}
	?>
<?php

	do_action( 'rareradio_action_before_post_data' );

	// Structured data snippets
	if ( $rareradio_seo ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/seo' ) );
	}

	if ( is_singular( 'post' ) || is_singular( 'attachment' ) ) {
		$rareradio_post_thumbnail_type  = rareradio_get_theme_option( 'post_thumbnail_type' );
		$rareradio_post_header_position = rareradio_get_theme_option( 'post_header_position' );
		$rareradio_post_header_align    = rareradio_get_theme_option( 'post_header_align' );
		if ( 'default' === $rareradio_post_thumbnail_type && 'default' !== $rareradio_post_header_position ) {
			?>
			<div class="header_content_wrap header_align_<?php echo esc_attr( $rareradio_post_header_align ); ?>">
				<?php
				// Post title and meta
				if ( 'above' === $rareradio_post_header_position ) {
					rareradio_show_post_title_and_meta();
				}

				// Featured image
				rareradio_show_post_featured_image();

				// Post title and meta
				if ( 'above' !== $rareradio_post_header_position ) {
					rareradio_show_post_title_and_meta();
				}
				?>
			</div>
			<?php
		} elseif ( 'default' !== $rareradio_post_thumbnail_type && 'default' === $rareradio_post_header_position ) {
			// Post title and meta
			rareradio_show_post_title_and_meta();
		}
	}

	do_action( 'rareradio_action_before_post_content' );

	// Post content
	?>
	<div class="post_content post_content_single entry-content" itemprop="mainEntityOfPage">
		<?php
		the_content();

		do_action( 'rareradio_action_before_post_pagination' );

		wp_link_pages(
			array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'rareradio' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'rareradio' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);

		do_action( 'rareradio_action_before_post_meta' );

		// Taxonomies and share
		if ( is_single() && ! is_attachment() ) {
			// row with categories and tags
			?>
			<div class="post_bottom_row">

				<?php

				//column with tags
				?>
				<div class="post_bottom_col">
				<?php
					ob_start();
					
					// Post taxonomies
					the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">' . esc_html__( 'Tags:', 'rareradio' ) . '</span> ', '', '</span>' );

					$rareradio_tags_output = ob_get_contents();

					ob_end_clean();

					if ( ! empty( $rareradio_tags_output ) ) {

						rareradio_show_layout( $rareradio_tags_output, '<div class="post_meta post_meta_single">', '</div>' );

						do_action( 'rareradio_action_after_post_meta' );

					}
				?>
				</div>
				<?php
			?>
			</div>
			<?php
			
		}
		?>
	</div><!-- .entry-content -->


	<?php
	do_action( 'rareradio_action_after_post_content' );

	do_action( 'rareradio_action_after_post_data' );
	?>
</article>
