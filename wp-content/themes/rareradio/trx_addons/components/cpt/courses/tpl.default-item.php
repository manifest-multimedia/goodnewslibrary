<?php
/**
 * The style "default" of the Courses
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_courses');


$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

if (!empty($args['type'])) {
	if (strpos($args['type'], 'modern')) {
		$post_type = str_replace('sc_courses_', '', $args['type']);
	} else {
		$post_type = '';
	}
} else {
	$post_type = '';
}



if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'], !empty($args['columns_tablet']) ? $args['columns_tablet'] : '', !empty($args['columns_mobile']) ? $args['columns_mobile'] : '')); ?>"><?php
}
?>
<div data-post-id="<?php the_ID(); ?>" class="sc_courses_item trx_addons_hover trx_addons_hover_style_links"<?php trx_addons_add_blog_animation('courses', $args); ?>>
	<?php
	if (has_post_thumbnail() && $post_type != 'default modern') {
		?><div class="sc_courses_item_image"><?php
			trx_addons_get_template_part('templates/tpl.featured.php',
										'trx_addons_args_featured',
										apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_courses_item_thumb',
														'hover' => 'zoomin',
														'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size($args['columns'] > 2 ? 'medium' : 'huge'), 'courses-default')
														),
														'courses-default'
													)
										);
            ?>
            <?php
                if( $post_type != 'default modern' ) {
                    ?><span class="sc_courses_item_categories"><?php trx_addons_show_layout(trx_addons_get_post_terms(' ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY)); ?></span><?php
				}
				if( $post_type != 'default modern' ) {
					?><div class="sc_courses_item_meta">
						<?php
							if (!empty($meta['time'])) {
								?><div class="sc_courses_item_meta_time"><?php echo esc_html($meta['time']); ?></div><?php
							}
						?>
						<div class="sc_courses_item_meta_date"><?php
							$dt = $meta['date'];
							echo sprintf($dt < date('Y-m-d') ? esc_html__('%s', 'rareradio') : esc_html__('%s', 'rareradio'), '<span class="sc_courses_item_date">' . date_i18n(get_option('date_format'), strtotime($dt)) . '</span>');
						?></div>
						<a href="<?php
							echo !empty($meta['product']) && (int) $meta['product'] > 0
									? esc_url(get_permalink($meta['product']))
									: esc_url(get_permalink());
						?>"><?php
							$price = explode('/', $meta['price']);
							echo esc_html($price[0]) . (!empty($price[1]) ? '<span class="sc_courses_item_period">'.$price[1].'</span>' : '');
						?></a>
					</div><?php
				}
            ?>
		</div><?php
    }
    $image = '';
    $image = trx_addons_get_attachment_url( 
        get_post_thumbnail_id( get_the_ID() ), 
        apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('huge'))
        );
    if (has_post_thumbnail() && $post_type == 'default modern') {
		?><div class="sc_courses_item_image" <?php echo ' style="background-image: url('.esc_url($image).');"'; ?>></div><?php
    }
	?><div class="sc_courses_item_info">
		<div class="sc_courses_item_header">
            <?php
                if( $post_type == 'default modern' ) {
                    ?><span class="sc_courses_item_categories"><?php trx_addons_show_layout(trx_addons_get_post_terms(' ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY)); ?></span><?php
                }
            ?>
			<h5 class="sc_courses_item_title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
			<div class="sc_courses_item_meta">
				<a href="<?php the_permalink(); ?>">
					<span class="sc_courses_item_meta_item sc_courses_item_meta_date"><?php
						$dt = $meta['date'];
						echo sprintf($dt < date('Y-m-d') ? esc_html__('Started on %s', 'rareradio') : esc_html__('Starting %s', 'rareradio'), '<span class="sc_courses_item_date">' . date_i18n(get_option('date_format'), strtotime($dt)) . '</span>');
					?></span>
					<span class="sc_courses_item_meta_item sc_courses_item_meta_duration"><?php echo esc_html__('Duration ', 'rareradio'); ?><span class="sc_courses_item_date"><?php echo esc_html($meta['duration']); ?></span></span>
				</a>
			</div>
		</div>
		<?php if ( ! empty($meta['price'])) { ?>
			<div class="sc_courses_item_price">
				<a href="<?php
					echo !empty($meta['product']) && (int) $meta['product'] > 0
							? esc_url(get_permalink($meta['product']))
							: esc_url(get_permalink());
				?>"><?php
					$price = explode('/', $meta['price']);
					echo esc_html($price[0]) . (!empty($price[1]) ? '<span class="sc_courses_item_period">'.$price[1].'</span>' : '');
				?></a>
			</div>
		<?php }  ?>
			
		<?php
		if (!empty($meta['product']) && (int) $meta['product'] > 0) {
			?><a href="<?php the_permalink($meta['product']); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button sc_button_default sc_button_size_normal sc_courses_item_button', 'sc_courses', $args)); ?>"><?php esc_html_e('Buy Now', 'rareradio'); ?></a><?php
		}
	?></div><?php
	// Old style: hover block with info and buttons
	if (false) {
		?>
		<div class="trx_addons_hover_mask"></div>
		<div class="trx_addons_hover_content">
			<h4 class="trx_addons_hover_title"><?php the_title(); ?></h4>
			<?php
			if (($excerpt = get_the_excerpt()) != '') {
				?><div class="trx_addons_hover_text"><?php echo esc_html($excerpt); ?></div><?php
			}
			if (!empty($args['more_text']) || (!empty($meta['product']) && (int) $meta['product'] > 0)) {
				?><div class="trx_addons_hover_links"><?php
					if (!empty($args['more_text'])) {
						?><a href="<?php the_permalink(); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'trx_addons_hover_link', 'sc_courses', $args)); ?>"><?php echo esc_html($args['more_text']); ?></a><?php
					}
					if (!empty($meta['product']) && (int) $meta['product'] > 0) {
						?><a href="<?php the_permalink($meta['product']); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'trx_addons_hover_link2', 'sc_courses', $args)); ?>"><?php esc_html_e('Buy Now', 'rareradio'); ?></a><?php
					}
				?></div><?php
			}
		?></div><?php
	}
	// /Old style
?></div><?php
if (!empty($args['slider']) || $args['columns'] > 1) {
	?></div><?php
}