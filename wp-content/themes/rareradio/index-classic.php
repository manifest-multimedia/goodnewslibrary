<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

rareradio_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	rareradio_blog_archive_start();

	$rareradio_classes    = 'posts_container '
						. ( substr( rareradio_get_theme_option( 'blog_style' ), 0, 7 ) == 'classic'
							? 'columns_wrap columns_padding_bottom'
							: 'masonry_wrap'
							);
	$rareradio_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$rareradio_sticky_out = rareradio_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $rareradio_stickies ) && count( $rareradio_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $rareradio_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $rareradio_sticky_out ) {
		if ( rareradio_get_theme_option( 'first_post_large' ) && ! is_paged() && ! in_array( rareradio_get_theme_option( 'body_style' ), array( 'fullwide', 'fullscreen' ) ) ) {
			the_post();
			get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', 'excerpt' ), 'excerpt' );
		}

		?>
		<div class="<?php echo esc_attr( $rareradio_classes ); ?>">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $rareradio_sticky_out && ! is_sticky() ) {
			$rareradio_sticky_out = false;
			?>
			</div><div class="<?php echo esc_attr( $rareradio_classes ); ?>">
			<?php
		}
		$rareradio_part = $rareradio_sticky_out && is_sticky() ? 'sticky' : 'classic';
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
