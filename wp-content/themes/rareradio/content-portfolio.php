<?php
/**
 * The Portfolio template to display the content
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
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
	);
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
>
<?php

// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"><?php esc_attr_e('sticky post', 'rareradio'); ?></span>
		<?php
}

	$rareradio_image_hover = ! empty( $rareradio_template_args['hover'] ) && ! rareradio_is_inherit( $rareradio_template_args['hover'] )
								? $rareradio_template_args['hover']
								: rareradio_get_theme_option( 'image_hover' );
	// Featured image
	rareradio_show_post_featured(
		array(
			'hover'         => $rareradio_image_hover,
			'no_links'      => ! empty( $rareradio_template_args['no_links'] ),
			'thumb_size'    => rareradio_get_thumb_size(
				strpos( rareradio_get_theme_option( 'body_style' ), 'full' ) !== false || $rareradio_columns < 3
								? 'masonry-big'
				: 'masonry'
			),
			'show_no_image' => true,
			'class'         => 'dots' == $rareradio_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $rareradio_image_hover ? '<div class="post_info">' . esc_html( get_the_title() ) . '</div>' : '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!