<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.50
 */

$rareradio_template_args = get_query_var( 'rareradio_template_args' );
if ( is_array( $rareradio_template_args ) ) {
	$rareradio_columns    = empty( $rareradio_template_args['columns'] ) ? 2 : max( 1, $rareradio_template_args['columns'] );
	$rareradio_blog_style = array( $rareradio_template_args['type'], $rareradio_columns );
} else {
	$rareradio_blog_style = explode( '_', rareradio_get_theme_option( 'blog_style' ) );
	$rareradio_columns    = empty( $rareradio_blog_style[1] ) ? 2 : max( 1, $rareradio_blog_style[1] );
}
$rareradio_blog_id       = rareradio_get_custom_blog_id( join( '_', $rareradio_blog_style ) );
$rareradio_blog_style[0] = str_replace( 'blog-custom-', '', $rareradio_blog_style[0] );
$rareradio_expanded      = ! rareradio_sidebar_present() && rareradio_is_on( rareradio_get_theme_option( 'expand_content' ) );
$rareradio_components    = rareradio_array_get_keys_by_value( rareradio_get_theme_option( 'meta_parts' ) );

$rareradio_post_format   = get_post_format();
$rareradio_post_format   = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );

$rareradio_blog_meta     = rareradio_get_custom_layout_meta( $rareradio_blog_id );
$rareradio_custom_style  = ! empty( $rareradio_blog_meta['scripts_required'] ) ? $rareradio_blog_meta['scripts_required'] : 'none';

if ( ! empty( $rareradio_template_args['slider'] ) || $rareradio_columns > 1 || ! rareradio_is_off( $rareradio_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $rareradio_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo ( rareradio_is_off( $rareradio_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $rareradio_custom_style ) ) . '-1_' . esc_attr( $rareradio_columns );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_format_' . esc_attr( $rareradio_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $rareradio_columns )
					. ' post_layout_' . esc_attr( $rareradio_blog_style[0] )
					. ' post_layout_' . esc_attr( $rareradio_blog_style[0] ) . '_' . esc_attr( $rareradio_columns )
					. ( ! rareradio_is_off( $rareradio_custom_style )
						? ' post_layout_' . esc_attr( $rareradio_custom_style )
							. ' post_layout_' . esc_attr( $rareradio_custom_style ) . '_' . esc_attr( $rareradio_columns )
						: ''
						)
		);
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'rareradio_action_show_layout', $rareradio_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $rareradio_template_args['slider'] ) || $rareradio_columns > 1 || ! rareradio_is_off( $rareradio_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
