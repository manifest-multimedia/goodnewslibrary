<?php
/**
 * The Gallery template to display posts
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
$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );
$rareradio_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

?><div class="
<?php
if ( ! empty( $rareradio_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $rareradio_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $rareradio_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $rareradio_columns )
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $rareradio_columns )
	);
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
	data-size="
		<?php
		if ( ! empty( $rareradio_image[1] ) && ! empty( $rareradio_image[2] ) ) {
			echo intval( $rareradio_image[1] ) . 'x' . intval( $rareradio_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $rareradio_image[0] ) ) {
			echo esc_url( $rareradio_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$rareradio_image_hover = 'icon';  
if ( in_array( $rareradio_image_hover, array( 'icons', 'zoom' ) ) ) {
	$rareradio_image_hover = 'dots';
}
$rareradio_components = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );
rareradio_show_post_featured(
	array(
		'hover'         => $rareradio_image_hover,
		'no_links'      => ! empty( $rareradio_template_args['no_links'] ),
		'thumb_size'    => rareradio_get_thumb_size( strpos( rareradio_get_theme_option( 'body_style' ), 'full' ) !== false || $rareradio_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $rareradio_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $rareradio_components )
								? rareradio_show_post_meta(
									apply_filters(
										'rareradio_filter_post_meta_args', array(
											'components' => $rareradio_components,
											'seo'      => false,
											'echo'     => false,
										), $rareradio_blog_style[0], $rareradio_columns
									)
								)
								: ''
								)
							. ( empty( $rareradio_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $rareradio_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'rareradio' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
