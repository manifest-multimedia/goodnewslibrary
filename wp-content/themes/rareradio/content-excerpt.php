<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_template_args = get_query_var( 'rareradio_template_args' );
if ( is_array( $rareradio_template_args ) ) {
	$rareradio_columns    = empty( $rareradio_template_args['columns'] ) ? 1 : max( 1, $rareradio_template_args['columns'] );
	$rareradio_blog_style = array( $rareradio_template_args['type'], $rareradio_columns );
	if ( ! empty( $rareradio_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $rareradio_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $rareradio_columns ); ?>">
		<?php
	}
}
$rareradio_expanded    = ! rareradio_sidebar_present() && rareradio_is_on( rareradio_get_theme_option( 'expand_content' ) );
$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );
$rareradio_components = rareradio_array_get_keys_by_value(rareradio_get_theme_option('meta_parts'));
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_layout_excerpt post_format_' . esc_attr( $rareradio_post_format ) );
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
>
	<?php

	// Change Audio Post Format
	$post_format = str_replace('post-format-', '', get_post_format());
	if ( $post_format == 'audio' ) {
		// Title and post meta
		$rareradio_hover = ! empty( $rareradio_template_args['hover'] ) && ! rareradio_is_inherit( $rareradio_template_args['hover'] )
						? $rareradio_template_args['hover']
						: rareradio_get_theme_option( 'image_hover' );
		$rareradio_show_title = get_the_title() != '';
		$rareradio_components = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );
		$rareradio_show_meta  = ! empty( $rareradio_components ) && ! in_array( $rareradio_hover, array( 'border', 'pull', 'slide', 'fade' ) );
		if ( $rareradio_show_title || $rareradio_show_meta ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Sticky label
				if ( is_sticky() && ! is_paged() ) {
					?>
					<span class="post_label label_sticky"><?php esc_attr_e('sticky post', 'rareradio'); ?></span>
					<?php
				}
				// Post meta
				if ( $rareradio_show_meta ) {
					do_action( 'rareradio_action_before_post_meta' );
					rareradio_show_post_meta(
						apply_filters(
							'rareradio_filter_post_meta_args', array(
								'components' => $rareradio_components,
								'seo'        => false,
							), 'excerpt', 1
						)
					);
				}
				// Post title
				if ( $rareradio_show_title ) {
					do_action( 'rareradio_action_before_post_title' );
					if ( empty( $rareradio_template_args['no_links'] ) ) {
						the_title( sprintf( '<h5 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
					} else {
						the_title( '<h5 class="post_title entry-title">', '</h5>' );
					}
				}
				?>
			</div><!-- .post_header -->
			<?php
		}
	}

	// Add date to posts with media
	$post_date = '';
	$has_thumb = has_post_thumbnail();
	$post_format = str_replace('post-format-', '', get_post_format());
	$date1 = get_the_date( 'j', get_the_ID());
	$date2 = get_the_date( 'm', get_the_ID());
	if ( $post_format != 'audio' ) {
		if ($has_thumb || ($post_format == 'gallery' || $has_thumb) || $post_format == 'video') {
			if (in_array('date',explode(',', $rareradio_components))) {

				$post_date = "<div class='post_header_date'>
						<div class='post_meta'>
							<span class='post_meta_item post_date'>
								<a href=" . esc_url(get_permalink()) . ">" . esc_html($date1) . html_entity_decode(' &mdash; ', ENT_NOQUOTES, 'UTF-8') . $date2 . "</a>
							</span>
						</div>
					</div>";
			}
		}
	}

	// Featured image
	$rareradio_hover = ! empty( $rareradio_template_args['hover'] ) && ! rareradio_is_inherit( $rareradio_template_args['hover'] )
						? $rareradio_template_args['hover']
						: rareradio_get_theme_option( 'image_hover' );
	rareradio_show_post_featured(
		array(
			'no_links'   => ! empty( $rareradio_template_args['no_links'] ),
			'hover'      => $rareradio_hover,
			'thumb_size' => rareradio_get_thumb_size( strpos( rareradio_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $rareradio_expanded ? 'huge' : 'big' ) ),
			'post_date' => $post_date
		)
	);
	
	if ( $post_format != 'audio' ) {
		// Title and post meta
		$rareradio_show_title = get_the_title() != '';
		$rareradio_components = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );
		$rareradio_show_meta  = ! empty( $rareradio_components ) && ! in_array( $rareradio_hover, array( 'border', 'pull', 'slide', 'fade' ) );
		if ( $rareradio_show_title || $rareradio_show_meta ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Sticky label
				if ( is_sticky() && ! is_paged() ) {
					?>
					<span class="post_label label_sticky"><?php esc_attr_e('sticky post', 'rareradio'); ?></span>
					<?php
				}
				// Post meta
				if ($has_thumb || ($post_format == 'gallery' && $has_thumb) || $post_format == 'video') {
					if (in_array('date',explode(',', $rareradio_components))) {
						$rareradio_components = str_replace('date', '', $rareradio_components);
					}
				}
				// Post meta
				if ( $rareradio_show_meta ) {
					do_action( 'rareradio_action_before_post_meta' );
					rareradio_show_post_meta(
						apply_filters(
							'rareradio_filter_post_meta_args', array(
								'components' => $rareradio_components,
								'seo'        => false,
							), 'excerpt', 1
						)
					);
				}
				// Post title
				if ( $rareradio_show_title ) {
					do_action( 'rareradio_action_before_post_title' );
					if ( empty( $rareradio_template_args['no_links'] ) ) {
						the_title( sprintf( '<h5 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
					} else {
						the_title( '<h5 class="post_title entry-title">', '</h5>' );
					}
				}
				?>
			</div><!-- .post_header -->
			<?php
		}
	}

	// Post content
	if ( empty( $rareradio_template_args['hide_excerpt'] ) && rareradio_get_theme_option( 'excerpt_length' ) > 0 ) {
		?>
		<div class="post_content entry-content">
			<?php
			if ( rareradio_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'rareradio_action_before_full_post_content' );
					the_content( '' );
					do_action( 'rareradio_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
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
			} else {
				// Post content area
				rareradio_show_post_content( $rareradio_template_args, '<div class="post_content_inner">', '</div>' );
				// More button
				if ( empty( $rareradio_template_args['no_links'] ) && ! in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
					rareradio_show_post_more_link( $rareradio_template_args, '<p>', '</p>' );
				}
			}
			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $rareradio_template_args ) ) {
	if ( ! empty( $rareradio_template_args['slider'] ) || $rareradio_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
