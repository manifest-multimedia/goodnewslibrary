<?php
/**
 * The style "default" of the Portfolio
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

$args = get_query_var('trx_addons_args_sc_portfolio');

$query_args = array(
// Attention! Parameter 'suppress_filters' is damage WPML-queries!
	'post_type' => TRX_ADDONS_CPT_PORTFOLIO_PT,
	'post_status' => 'publish',
	'ignore_sticky_posts' => true,
);
if (empty($args['ids'])) {
	$query_args['posts_per_page'] = $args['count'];
	if (!trx_addons_is_off($args['pagination']) && $args['page'] > 1) {
		$query_args['paged'] = $args['page'];
	} else {
		$query_args['offset'] = $args['offset'];
	}
}
$query_args = trx_addons_query_add_sort_order($query_args, $args['orderby'], $args['order']);
$query_args = trx_addons_query_add_posts_and_cats($query_args, $args['ids'], TRX_ADDONS_CPT_PORTFOLIO_PT, $args['cat'], TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
$query = new WP_Query( $query_args );
if ($query->found_posts > 0) {
	if ($args['count'] > $query->found_posts) $args['count'] = $query->found_posts;
	if ($args['columns'] < 1) $args['columns'] = $args['count'];
	$args['columns'] = max(1, min(12, (int) $args['columns']));
	if (!empty($args['columns_tablet'])) $args['columns_tablet'] = max(1, min(12, (int) $args['columns_tablet']));
	if (!empty($args['columns_mobile'])) $args['columns_mobile'] = max(1, min(12, (int) $args['columns_mobile']));
	$args['slider'] = $args['slider'] > 0 && $args['count'] > $args['columns'];
	$args['slides_space'] = max(0, (int) $args['slides_space']);
	?><div <?php if (!empty($args['id'])) echo ' id="'.esc_attr($args['id']).'"'; ?>
		class="sc_portfolio sc_portfolio_<?php 
			echo esc_attr($args['type']);
			if (!empty($args['class'])) echo ' '.esc_attr($args['class']); 
			?>"<?php
		if (!empty($args['css'])) echo ' style="'.esc_attr($args['css']).'"';
		?>><?php

		trx_addons_sc_show_titles('sc_portfolio', $args);
		
		if ($args['slider']) {
			trx_addons_sc_show_slider_wrap_start('sc_portfolio', $args);
		} else if ($args['columns'] > 1) {
			?><div class="sc_portfolio_columns_wrap sc_item_columns sc_item_posts_container <?php
				echo esc_attr(trx_addons_get_columns_wrap_class());
				if ( $args['type'] != 'list' ) {
					echo ' columns_padding_bottom'
						. esc_attr( trx_addons_add_columns_in_single_row( $args['columns'], $query ) );
				}
			?>"><?php
		} else {
			?><div class="sc_portfolio_content sc_item_content sc_item_posts_container"><?php
		}	

		while ( $query->have_posts() ) { $query->the_post();
			trx_addons_get_template_part(array(
											TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.'.trx_addons_esc($args['type']).'-item.php',
											TRX_ADDONS_PLUGIN_CPT . 'portfolio/tpl.default-item.php'
											),
											'trx_addons_args_sc_portfolio',
											$args
										);
		}

		wp_reset_postdata();
	
		?></div><?php

		if ($args['slider']) {
			trx_addons_sc_show_slider_wrap_end('sc_portfolio', $args);
		}

		trx_addons_sc_show_pagination('sc_portfolio', $args, $query);
		
		trx_addons_sc_show_links('sc_portfolio', $args);

	?></div><!-- /.sc_portfolio --><?php
}
?>