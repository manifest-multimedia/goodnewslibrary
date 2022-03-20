<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

if ( get_query_var( 'rareradio_header_image' ) == '' && rareradio_trx_addons_featured_image_override( is_singular() && has_post_thumbnail() && in_array( get_post_type(), array( 'post', 'page' ) ) ) ) {
	$rareradio_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if ( ! empty( $rareradio_src[0] ) ) {
		rareradio_sc_layouts_showed( 'featured', true );
		?>
		<div class="sc_layouts_featured with_image without_content <?php echo esc_attr( rareradio_add_inline_css_class( 'background-image:url(' . esc_url( $rareradio_src[0] ) . ');' ) ); ?>"></div>
		<?php
	}
}
