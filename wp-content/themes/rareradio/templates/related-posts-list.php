<?php
/**
 * The template 'Style 4' to displaying related posts
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.54
 */

$rareradio_link        = get_permalink();
$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );

?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $rareradio_post_format ) ); ?>>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $rareradio_link ); ?>"><?php the_title(); ?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $rareradio_link ); ?>" class="post_meta_item post_date"><span class="icon-clock"></span><?php echo wp_kses_data( rareradio_get_date() ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
