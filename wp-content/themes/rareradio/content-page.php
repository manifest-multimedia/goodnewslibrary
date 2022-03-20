<?php
/**
 * The default template to display the content of the single page
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

$rareradio_seo = rareradio_is_on( rareradio_get_theme_option( 'seo_snippets' ) );
?>

<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
									<?php
									post_class( 'post_item_single post_type_page' );
									if ( $rareradio_seo ) {
										?>
		itemscope="itemscope" 
		itemprop="mainEntityOfPage" 
		itemtype="//schema.org/<?php echo esc_attr( rareradio_get_markup_schema() ); ?>" 
		itemid="<?php echo esc_url( get_the_permalink() ); ?>"
		content="<?php the_title_attribute( '' ); ?>"
										<?php
									}
									?>
>

	<?php
	do_action( 'rareradio_action_before_post_data' );

	// Structured data snippets
	if ( $rareradio_seo ) {
		get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'templates/seo' ) );
	}

	// Now featured image used as header's background
	// Uncomment next rows (or remove false from the condition) to show featured image for the pages
	if ( false && ! rareradio_sc_layouts_showed( 'featured' ) && strpos( get_the_content(), '[trx_widget_banner]' ) === false ) {
		do_action( 'rareradio_action_before_post_featured' );
		rareradio_show_post_featured();
		do_action( 'rareradio_action_after_post_featured' );
	}

	do_action( 'rareradio_action_before_post_content' );
	?>

	<div class="post_content entry-content">
		<?php
			the_content();

			wp_link_pages(
				array(
					'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'rareradio' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'rareradio' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				)
			);
			?>
	</div><!-- .entry-content -->

	<?php
	do_action( 'rareradio_action_after_post_content' );

	do_action( 'rareradio_action_after_post_data' );
	?>

</article>
