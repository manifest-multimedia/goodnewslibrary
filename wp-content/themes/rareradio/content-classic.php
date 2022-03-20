<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_template_args = get_query_var( 'rareradio_template_args' );
if ( is_array( $rareradio_template_args ) ) {
	$rareradio_columns    = empty( $rareradio_template_args['columns'] ) ? 2 : max( 1, $rareradio_template_args['columns'] );
	$rareradio_blog_style = array( $rareradio_template_args['type'], $rareradio_columns );
} else {
	$rareradio_blog_style = explode( '_', rareradio_get_theme_option( 'blog_style' ) );
	$rareradio_columns    = empty( $rareradio_blog_style[1] ) ? 2 : max( 1, $rareradio_blog_style[1] );
}
$rareradio_expanded   = ! rareradio_sidebar_present() && rareradio_is_on( rareradio_get_theme_option( 'expand_content' ) );
$rareradio_components = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );

$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );

?><div class="
<?php
if ( ! empty( $rareradio_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( 'classic' == $rareradio_blog_style[0] ? 'column' : 'masonry_item masonry_item' ) . '-1_' . esc_attr( $rareradio_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $rareradio_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $rareradio_columns )
				. ' post_layout_' . esc_attr( $rareradio_blog_style[0] )
				. ' post_layout_' . esc_attr( $rareradio_blog_style[0] ) . '_' . esc_attr( $rareradio_columns )
	);
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
>
	<?php

	// Featured image
	$rareradio_hover = ! empty( $rareradio_template_args['hover'] ) && ! rareradio_is_inherit( $rareradio_template_args['hover'] )
						? $rareradio_template_args['hover']
						: rareradio_get_theme_option( 'image_hover' );
	rareradio_show_post_featured(
		array(
			'thumb_size' => rareradio_get_thumb_size(
				'classic' == $rareradio_blog_style[0]
						? ( strpos( rareradio_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $rareradio_columns > 2 ? 'big' : 'huge' )
								: ( $rareradio_columns > 2
									? ( $rareradio_expanded ? 'big' : 'small' )
									: ( $rareradio_expanded ? 'big' : 'big' )
									)
							)
						: ( strpos( rareradio_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $rareradio_columns > 2 ? 'masonry-big' : 'full' )
								: ( $rareradio_columns <= 2 && $rareradio_expanded ? 'masonry-big' : 'masonry' )
							)
			),
			'hover'      => $rareradio_hover,
			'no_links'   => ! empty( $rareradio_template_args['no_links'] ),
		)
	);

	if ( ! in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Sticky label
			if ( is_sticky() && ! is_paged() ) {
				?>
				<span class="post_label label_sticky"><?php esc_attr_e('sticky post', 'rareradio'); ?></span>
				<?php
			}

			do_action( 'rareradio_action_before_post_meta' );

			// Post meta
			if ( ! empty( $rareradio_components ) && ! in_array( $rareradio_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
				rareradio_show_post_meta(
					apply_filters(
						'rareradio_filter_post_meta_args', array(
							'components' => $rareradio_components,
							'seo'        => false,
						), $rareradio_blog_style[0], $rareradio_columns
					)
				);
			}

			do_action( 'rareradio_action_after_post_meta' );

			do_action( 'rareradio_action_before_post_title' );

			// Post title
			if ( empty( $rareradio_template_args['no_links'] ) ) {
				the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			} else {
				the_title( '<h4 class="post_title entry-title">', '</h4>' );
			}

			
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>

	<div class="post_content entry-content">
		<?php
		if ( empty( $rareradio_template_args['hide_excerpt'] ) && rareradio_get_theme_option( 'excerpt_length' ) > 0 ) {
			// Post content area
			rareradio_show_post_content( $rareradio_template_args, '<div class="post_content_inner">', '</div>' );
		}
		
		// Post meta
		if ( in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			if ( ! empty( $rareradio_components ) ) {
				rareradio_show_post_meta(
					apply_filters(
						'rareradio_filter_post_meta_args', array(
							'components' => $rareradio_components,
						), $rareradio_blog_style[0], $rareradio_columns
					)
				);
			}
		}
		
		// More button
		if ( empty( $rareradio_template_args['no_links'] ) && ! empty( $rareradio_template_args['more_text'] ) && ! in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
			rareradio_show_post_more_link( $rareradio_template_args, '<p>', '</p>' );
		}
		?>
	</div><!-- .entry-content -->

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
