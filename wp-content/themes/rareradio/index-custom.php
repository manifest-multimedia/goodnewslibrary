<?php
/**
 * The template for homepage posts with custom style
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.50
 */

rareradio_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	$rareradio_blog_style = rareradio_get_theme_option( 'blog_style' );
	$rareradio_parts      = explode( '_', $rareradio_blog_style );
	$rareradio_columns    = ! empty( $rareradio_parts[1] ) ? max( 1, min( 6, (int) $rareradio_parts[1] ) ) : 1;
	$rareradio_blog_id    = rareradio_get_custom_blog_id( $rareradio_blog_style );
	$rareradio_blog_meta  = rareradio_get_custom_layout_meta( $rareradio_blog_id );
	if ( ! empty( $rareradio_blog_meta['margin'] ) ) {
		rareradio_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( rareradio_prepare_css_value( $rareradio_blog_meta['margin'] ) ) ) );
	}
	$rareradio_custom_style = ! empty( $rareradio_blog_meta['scripts_required'] ) ? $rareradio_blog_meta['scripts_required'] : 'none';

	rareradio_blog_archive_start();

	$rareradio_classes    = 'posts_container blog_custom_wrap' 
							. ( ! rareradio_is_off( $rareradio_custom_style )
								? sprintf( ' %s_wrap', $rareradio_custom_style )
								: ( $rareradio_columns > 1 
									? ' columns_wrap columns_padding_bottom' 
									: ''
									)
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
		$rareradio_part = $rareradio_sticky_out && is_sticky() ? 'sticky' : 'custom';
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
