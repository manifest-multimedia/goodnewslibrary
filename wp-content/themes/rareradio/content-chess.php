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
	$rareradio_columns    = empty( $rareradio_template_args['columns'] ) ? 1 : max( 1, min( 3, $rareradio_template_args['columns'] ) );
	$rareradio_blog_style = array( $rareradio_template_args['type'], $rareradio_columns );
} else {
	$rareradio_blog_style = explode( '_', rareradio_get_theme_option( 'blog_style' ) );
	$rareradio_columns    = empty( $rareradio_blog_style[1] ) ? 1 : max( 1, min( 3, $rareradio_blog_style[1] ) );
}
$rareradio_expanded    = ! rareradio_sidebar_present() && rareradio_is_on( rareradio_get_theme_option( 'expand_content' ) );
$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );

?><article id="post-<?php the_ID(); ?>"	data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item'
		. ' post_layout_chess'
		. ' post_layout_chess_' . esc_attr( $rareradio_columns )
		. ' post_format_' . esc_attr( $rareradio_post_format )
		. ( ! empty( $rareradio_template_args['slider'] ) ? ' slider-slide swiper-slide' : '' )
	);
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
>

	<?php
	// Add anchor
	if ( 1 == $rareradio_columns && ! is_array( $rareradio_template_args ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode( '[trx_sc_anchor id="post_' . esc_attr( get_the_ID() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" icon="' . esc_attr( rareradio_get_post_icon() ) . '"]' );
	}

	// Featured image
	$rareradio_hover = ! empty( $rareradio_template_args['hover'] ) && ! rareradio_is_inherit( $rareradio_template_args['hover'] )
						? $rareradio_template_args['hover']
						: rareradio_get_theme_option( 'image_hover' );
	rareradio_show_post_featured(
		array(
			'class'         => 1 == $rareradio_columns && ! is_array( $rareradio_template_args ) ? 'rareradio-full-height' : '',
			'hover'         => $rareradio_hover,
			'no_links'      => ! empty( $rareradio_template_args['no_links'] ),
			'show_no_image' => true,
			'thumb_ratio'   => '1:1',
			'thumb_bg'      => true,
			'thumb_size'    => rareradio_get_thumb_size(
				strpos( rareradio_get_theme_option( 'body_style' ), 'full' ) !== false
										? ( 1 < $rareradio_columns ? 'huge' : 'original' )
										: ( 2 < $rareradio_columns ? 'big' : 'huge' )
			),
		)
	);

	?>
	<div class="post_inner"><div class="post_inner_content"><div class="post_header entry-header">
		<?php
			// Sticky label
			if ( is_sticky() && ! is_paged() ) {
				?>
				<span class="post_label label_sticky"><?php esc_attr_e('sticky post', 'rareradio'); ?></span>
				<?php
			}
			do_action( 'rareradio_action_before_post_meta' );

			// Post meta
			$rareradio_components = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );
			$rareradio_post_meta  = empty( $rareradio_components ) || in_array( $rareradio_hover, array( 'border', 'pull', 'slide', 'fade' ) )
										? ''
										: rareradio_show_post_meta(
											apply_filters(
												'rareradio_filter_post_meta_args', array(
													'components' => $rareradio_components,
													'seo'  => false,
													'echo' => false,
												), $rareradio_blog_style[0], $rareradio_columns
											)
										);
			rareradio_show_layout( $rareradio_post_meta );

			do_action( 'rareradio_action_before_post_title' );

			// Post title
			if ( empty( $rareradio_template_args['no_links'] ) ) {
				the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			} else {
				the_title( '<h3 class="post_title entry-title">', '</h3>' );
			}
			?>
		</div><!-- .entry-header -->

		<div class="post_content entry-content">
			<?php
			// Post content area
			if ( empty( $rareradio_template_args['hide_excerpt'] ) && rareradio_get_theme_option( 'excerpt_length' ) > 0 ) {
				rareradio_show_post_content( $rareradio_template_args, '<div class="post_content_inner">', '</div>' );
			}
			// Post meta
			if ( in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				rareradio_show_layout( $rareradio_post_meta );
			}
			// More button
			if ( empty( $rareradio_template_args['no_links'] ) && ! in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
				rareradio_show_post_more_link( $rareradio_template_args, '<p>', '</p>' );
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
