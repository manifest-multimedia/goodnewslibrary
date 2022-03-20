<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_columns     = max( 1, min( 3, count( get_option( 'sticky_posts' ) ) ) );
$rareradio_post_format = get_post_format();
$rareradio_post_format = empty( $rareradio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $rareradio_post_format );

?><div class="column-1_<?php echo esc_attr( $rareradio_columns ); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class( 'post_item post_layout_sticky post_format_' . esc_attr( $rareradio_post_format ) );
	rareradio_add_blog_animation( $rareradio_template_args );
	?>
>

	<?php
	if ( is_sticky() && is_home() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	rareradio_show_post_featured(
		array(
			'thumb_size' => rareradio_get_thumb_size( 1 == $rareradio_columns ? 'big' : ( 2 == $rareradio_columns ? 'med' : 'avatar' ) ),
		)
	);

	if ( ! in_array( $rareradio_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			rareradio_show_post_meta( apply_filters( 'rareradio_filter_post_meta_args', array(), 'sticky', $rareradio_columns ) );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div><?php

// div.column-1_X is a inline-block and new lines and spaces after it are forbidden
