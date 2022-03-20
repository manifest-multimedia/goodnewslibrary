<?php
/**
 * The template for homepage posts with "Portfolio" style
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

	// Show filters
	$rareradio_cat          = rareradio_get_theme_option( 'parent_cat' );
	$rareradio_post_type    = rareradio_get_theme_option( 'post_type' );
	$rareradio_taxonomy     = rareradio_get_post_type_taxonomy( $rareradio_post_type );
	$rareradio_show_filters = rareradio_get_theme_option( 'show_filters' );
	$rareradio_tabs         = array();
	if ( ! rareradio_is_off( $rareradio_show_filters ) ) {
		$rareradio_args           = array(
			'type'         => $rareradio_post_type,
			'child_of'     => $rareradio_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $rareradio_taxonomy,
			'pad_counts'   => false,
		);
		$rareradio_portfolio_list = get_terms( $rareradio_args );
		if ( is_array( $rareradio_portfolio_list ) && count( $rareradio_portfolio_list ) > 0 ) {
			$rareradio_tabs[ $rareradio_cat ] = esc_html__( 'All', 'rareradio' );
			foreach ( $rareradio_portfolio_list as $rareradio_term ) {
				if ( isset( $rareradio_term->term_id ) ) {
					$rareradio_tabs[ $rareradio_term->term_id ] = $rareradio_term->name;
				}
			}
		}
	}
	if ( count( $rareradio_tabs ) > 0 ) {
		$rareradio_portfolio_filters_ajax   = true;
		$rareradio_portfolio_filters_active = $rareradio_cat;
		$rareradio_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters rareradio_tabs rareradio_tabs_ajax">
			<ul class="portfolio_titles rareradio_tabs_titles">
				<?php
				foreach ( $rareradio_tabs as $rareradio_id => $rareradio_title ) {
					?>
					<li><a href="<?php echo esc_url( rareradio_get_hash_link( sprintf( '#%s_%s_content', $rareradio_portfolio_filters_id, $rareradio_id ) ) ); ?>" data-tab="<?php echo esc_attr( $rareradio_id ); ?>"><?php echo esc_html( $rareradio_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$rareradio_ppp = rareradio_get_theme_option( 'posts_per_page' );
			if ( rareradio_is_inherit( $rareradio_ppp ) ) {
				$rareradio_ppp = '';
			}
			foreach ( $rareradio_tabs as $rareradio_id => $rareradio_title ) {
				$rareradio_portfolio_need_content = $rareradio_id == $rareradio_portfolio_filters_active || ! $rareradio_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $rareradio_portfolio_filters_id, $rareradio_id ) ); ?>"
					class="portfolio_content rareradio_tabs_content"
					data-blog-template="<?php echo esc_attr( rareradio_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( rareradio_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $rareradio_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $rareradio_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $rareradio_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $rareradio_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $rareradio_cat ); ?>"
					data-need-content="<?php echo ( false === $rareradio_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $rareradio_portfolio_need_content ) {
						rareradio_show_portfolio_posts(
							array(
								'cat'        => $rareradio_id,
								'parent_cat' => $rareradio_cat,
								'taxonomy'   => $rareradio_taxonomy,
								'post_type'  => $rareradio_post_type,
								'page'       => 1,
								'sticky'     => $rareradio_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		rareradio_show_portfolio_posts(
			array(
				'cat'        => $rareradio_cat,
				'parent_cat' => $rareradio_cat,
				'taxonomy'   => $rareradio_taxonomy,
				'post_type'  => $rareradio_post_type,
				'page'       => 1,
				'sticky'     => $rareradio_sticky_out,
			)
		);
	}

	rareradio_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
