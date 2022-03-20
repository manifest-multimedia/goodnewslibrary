<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$date1 = get_the_date( 'j', get_the_ID());
$date2 = get_the_date( 'm', get_the_ID());
$rareradio_link        = get_permalink();
$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $rareradio_post_format ) ); ?>>
	<?php
	rareradio_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'rareradio_filter_related_thumb_size', rareradio_get_thumb_size( (int) rareradio_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'rel' ) ),
			'show_no_image' => rareradio_get_no_image() != '',
		)
	);
	?>
	<div class="post_header entry-header">
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<div class="post_meta">
				<a href="<?php echo esc_url( $rareradio_link ); ?>" class="post_meta_item post_date"><?php echo esc_html($date1) . html_entity_decode(' &mdash; ', ENT_NOQUOTES, 'UTF-8') . $date2 ; ?></a>
			</div>
			<?php
		}
		?>
		<h5 class="post_title entry-title"><a href="<?php echo esc_url( $rareradio_link ); ?>"><?php the_title(); ?></a></h5>
	</div>
</div>
