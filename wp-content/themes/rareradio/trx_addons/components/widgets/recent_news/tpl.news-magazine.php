<?php
/**
 * The "News Magazine" template to show post's content
 *
 * Used in the widget Recent News.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */
 
$widget_args = get_query_var('trx_addons_args_recent_news');
$style = $widget_args['style'];
$number = $widget_args['number'];
$count = $widget_args['count'];
$columns = $widget_args['columns'];
$featured = $widget_args['featured'];
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = apply_filters('trx_addons_blog_animation', '');

if ($number==$featured+1 && $number > 1 && $featured < $count && $featured!=$columns-1) {
	?><div class="post_delimiter<?php if ($columns > 1) echo ' '.esc_attr(trx_addons_get_column_class(1, 1)); ?>"></div><?php
}
if ($columns > 1 && !($featured==$columns-1 && $number>$featured+1)) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $columns)); ?>"><?php
}
?><article 
	<?php post_class( 'post_item post_layout_'.esc_attr($style)
					.' post_format_'.esc_attr($post_format)
					.' post_accented_'.($number<=$featured ? 'on' : 'off') 
					.($featured == $count && $featured > $columns ? ' post_accented_border' : '')
					); ?>
	<?php echo (!empty($animation) ? ' data-animation="'.esc_attr($animation).'"' : ''); ?>
	>

	<?php
	
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
												'thumb_size' => trx_addons_get_thumb_size($number<=$featured ? 'rp' : 'rp')
												), 'recent_news-magazine')
								);

	if ( !in_array($post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
            
            $date1 = get_the_date( 'j', get_the_ID());
			$date2 = get_the_date( 'm', get_the_ID());
            
			if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
                ?><div class="post_meta"><span class="post_date"><a href="<?php the_permalink(); ?>"><?php echo esc_html($date1) . html_entity_decode(' &mdash; ', ENT_NOQUOTES, 'UTF-8') . $date2 ; ?></a></span><?php
				?><span class="post_categories"><?php echo trx_addons_get_post_categories(); ?></span></div><?php
            }
            
            the_title( ($number<=$featured ? '<h5' : '<h6').' class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">', '</a>'.($number<=$featured ? '</h5>' : '</h6>') );

			?>
		</div><!-- .entry-header -->
		<?php
	}
?>
</article><?php

if ($columns > 1 && !($featured==$columns-1 && $featured<$number && $number<$count)) {
	?></div><?php
}
?>