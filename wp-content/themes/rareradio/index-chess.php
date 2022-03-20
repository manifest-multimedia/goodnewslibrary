<?php
/**
 * The template for homepage posts with "Chess" style
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

rareradio_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	rareradio_blog_archive_start();

	$rareradio_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$rareradio_sticky_out = rareradio_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $rareradio_stickies ) && count( $rareradio_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $rareradio_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $rareradio_sticky_out ) {
		?>
		<div class="chess_wrap posts_container">
		<?php
	}
	
	while ( have_posts() ) {
		the_post();
		if ( $rareradio_sticky_out && ! is_sticky() ) {
			$rareradio_sticky_out = false;
			?>
			</div><div class="chess_wrap posts_container">
			<?php
		}
		$rareradio_part = $rareradio_sticky_out && is_sticky() ? 'sticky' : 'chess';
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', $rareradio_part ), $rareradio_part );
	}
	?>
	</div>
	<?php

	rareradio_show_pagination();

	rareradio_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
