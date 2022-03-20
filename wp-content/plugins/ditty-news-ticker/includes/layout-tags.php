<?php
/**
 * Return all possible layout tags
 *
 * @since    3.0.12
 * @var      html
*/	
function ditty_layout_tags( $item_type = false, $item_value = false ) {	
	$tags = array(
		'author_avatar' => array(
			'tag' 				=> 'author_avatar',
			'description' => __( "Render the item's author avatar", 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper'			=> 'div',
				'before'			=> '',
				'after'				=> '',
				'width'				=> '',
				'height'			=> '',
				'fit'					=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'author_banner' => array(
			'tag' 				=> 'author_banner',
			'description' => __( "Render the item's author banner", 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper'			=> 'div',
				'before'			=> '',
				'after'				=> '',
				'width'				=> '',
				'height'			=> '',
				'fit'					=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'author_bio' => array(
			'tag' 				=> 'author_bio',
			'description' => __( "Render the item's author biography", 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'author_name' => array(
			'tag' 				=> 'author_name',
			'description' => __( "Render the item's author name", 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'author_screen_name' => array(
			'tag' 				=> 'author_screen_name',
			'description' => __( "Render the item's author screen name", 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'caption' => array(
			'tag' 				=> 'caption',
			'description' => __( 'Render the item caption.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'wpautop'			=> '',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'categories' => array(
			'tag' 				=> 'categories',
			'description' => __( 'Render the item categories', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'link_target' => '',
				'separator'		=> ', ',
				'class'				=> '',
			),
		),
		'content' => array(
			'tag' 				=> 'content',
			'description' => __( 'Render the item content.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 					=> 'div',
				'before'						=> '',
				'after'							=> '',
				'class'							=> '',
			),
		),
		'custom_field' => array(
			'tag' 				=> 'custom_field',
			'description' => __( 'Render a custom field for the item', 'ditty-news-ticker' ),
			'atts'				=> array(
				'id'			=> '',
				'wrapper' => 'div',
				'before'	=> '',
				'after'		=> '',
				'class'		=> '',
			),
		),
		'excerpt' => array(
			'tag' 				=> 'excerpt',
			'description' => __( 'Render the item excerpt.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 					=> 'div',
				'wpautop' 					=> false,
				'before'						=> '',
				'after'							=> '',
				'excerpt_length'		=> '200',
				'more'							=> '...',
				'more_link'					=> 'post',
				'more_link_target' 	=> '',
				'more_link_rel'			=> '',
				'more_before'				=> '',
				'more_after'				=> '',
				'class'							=> '',
			),
		),
		'icon' => array(
			'tag' 				=> 'icon',
			'description' => __( 'Render the item icon.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'image' => array(
			'tag' 				=> 'image',
			'description' => __( 'Render the item image.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper'			=> 'div',
				'before'			=> '',
				'after'				=> '',
				'width'				=> '',
				'height'			=> '',
				'fit'					=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'image_url' => array(
			'tag' 				=> 'image_url',
			'description' => __( 'Render the item image url.', 'ditty-news-ticker' ),
		),
		'permalink' => array(
			'tag' 				=> 'permalink',
			'description' => __( 'Render the item permalink.', 'ditty-news-ticker' ),
		),
		'source' => array(
			'tag' 				=> 'source',
			'description' => __( 'Render the item source.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'terms' => array(
			'tag' 				=> 'terms',
			'description' => __( 'Render the item terms', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'before'			=> '',
				'after'				=> '',
				'term'				=> '',
				'link_target' => '',
				'separator'		=> ', ',
				'class'				=> '',
			),
		),
		'time' => array(
			'tag' 				=> 'time',
			'description' => __( 'Render the item date/time.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'div',
				'format' 			=> get_option( 'date_format' ),
				'ago'					=> '',
				'ago_string' 	=> __( '%s ago', 'ditty-news-ticker' ),
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
		'title' => array(
			'tag' 				=> 'title',
			'description' => __( 'Render the item title.', 'ditty-news-ticker' ),
			'atts'				=> array(
				'wrapper' 		=> 'h3',
				'before'			=> '',
				'after'				=> '',
				'link'				=> '',
				'link_target' => '',
				'link_rel'		=> '',
				'link_before'	=> '',
				'link_after'	=> '',
				'class'				=> '',
			),
		),
	);
	$tags = apply_filters( 'ditty_layout_tags', $tags, $item_type, $item_value );
	ksort( $tags );
	return $tags;
}