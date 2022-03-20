<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

get_header();

while ( have_posts() ) {
	the_post();

	// Prepare theme-specific vars:

	// Full post loading
	$full_post_loading        = rareradio_get_value_gp( 'action' ) == 'full_post_loading';

	// Prev post loading
	$prev_post_loading        = rareradio_get_value_gp( 'action' ) == 'prev_post_loading';

	// Position of the related posts
	$rareradio_related_position = rareradio_get_theme_option( 'related_position' );

	// Type of the prev/next posts navigation
	$rareradio_posts_navigation = rareradio_get_theme_option( 'posts_navigation' );
	$rareradio_prev_post        = false;

	if ( 'scroll' == $rareradio_posts_navigation ) {
		$rareradio_prev_post = get_previous_post( true );         // Get post from same category
		if ( ! $rareradio_prev_post ) {
			$rareradio_prev_post = get_previous_post( false );    // Get post from any category
			if ( ! $rareradio_prev_post ) {
				$rareradio_posts_navigation = 'links';
			}
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $rareradio_prev_post ) ) {
		rareradio_storage_set_array( 'options_meta', 'post_thumbnail_type', 'default' );
		if ( rareradio_get_theme_option( 'post_header_position' ) != 'below' ) {
			rareradio_storage_set_array( 'options_meta', 'post_header_position', 'above' );
		}
		rareradio_sc_layouts_showed( 'featured', false );
		rareradio_sc_layouts_showed( 'title', false );
		rareradio_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $rareradio_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', get_post_format() ), get_post_format() );

	// If related posts should be inside the content
	if ( strpos( $rareradio_related_position, 'inside' ) === 0 ) {
		$rareradio_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'rareradio_action_related_posts' );
		$rareradio_related_content = ob_get_contents();
		ob_end_clean();

		$rareradio_related_position_inside = max( 0, min( 9, rareradio_get_theme_option( 'related_position_inside' ) ) );
		if ( 0 == $rareradio_related_position_inside ) {
			$rareradio_related_position_inside = mt_rand( 1, 9 );
		}
		
		$rareradio_p_number = 0;
		$rareradio_related_inserted = false;
		for ( $i = 0; $i < strlen( $rareradio_content ) - 3; $i++ ) {
			if ( $rareradio_content[ $i ] == '<' && $rareradio_content[ $i + 1 ] == 'p' && in_array( $rareradio_content[ $i + 2 ], array( '>', ' ' ) ) ) {
				$rareradio_p_number++;
				if ( $rareradio_related_position_inside == $rareradio_p_number ) {
					$rareradio_related_inserted = true;
					$rareradio_content = ( $i > 0 ? substr( $rareradio_content, 0, $i ) : '' )
										. $rareradio_related_content
										. substr( $rareradio_content, $i );
				}
			}
		}
		if ( ! $rareradio_related_inserted ) {
			$rareradio_content .= $rareradio_related_content;
		}

		rareradio_show_layout( $rareradio_content );
	}

	// Author bio
	if ( rareradio_get_theme_option( 'show_author_info' ) == 1
		&& ! is_attachment()
		&& get_the_author_meta( 'description' )
		&& ( 'scroll' != $rareradio_posts_navigation || rareradio_get_theme_option( 'posts_navigation_scroll_hide_author' ) == 0 )
		&& ( ! $full_post_loading || rareradio_get_theme_option( 'open_full_post_hide_author' ) == 0 )
	) {
		do_action( 'rareradio_action_before_post_author' );
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/author-bio' ) );
		do_action( 'rareradio_action_after_post_author' );
	}

	// Related posts
	if ( 'below_content' == $rareradio_related_position
		&& ( 'scroll' != $rareradio_posts_navigation || rareradio_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || rareradio_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'rareradio_action_related_posts' );
	}

	// If comments are open or we have at least one comment, load up the comment template.
	$rareradio_comments_number = get_comments_number();
	if ( comments_open() || $rareradio_comments_number > 0 ) {
		if ( rareradio_get_value_gp( 'show_comments' ) == 1 || ( ! $full_post_loading && ( 'scroll' != $rareradio_posts_navigation || rareradio_get_theme_option( 'posts_navigation_scroll_hide_comments' ) == 0 || rareradio_check_url( '#comment' ) ) ) ) {
			do_action( 'rareradio_action_before_comments' );
			comments_template();
			do_action( 'rareradio_action_after_comments' );
		} else {
			?>
			<div class="show_comments_single">
				<a href="<?php echo esc_url( add_query_arg( array( 'show_comments' => 1 ), get_comments_link() ) ); ?>" class="theme_button show_comments_button">
					<?php
					if ( $rareradio_comments_number > 0 ) {
						echo esc_html( sprintf( _n( 'Show comment', 'Show comments ( %d )', $rareradio_comments_number, 'rareradio' ), $rareradio_comments_number ) );
					} else {
						esc_html_e( 'Leave a comment', 'rareradio' );
					}
					?>
				</a>
			</div>
			<?php
		}
	}

	if ( 'scroll' == $rareradio_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $rareradio_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $rareradio_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $rareradio_prev_post ) ); ?>">
		</div>
		<?php
	}
}

get_footer();
