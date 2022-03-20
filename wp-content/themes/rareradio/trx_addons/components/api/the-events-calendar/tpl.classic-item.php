<?php
/**
 * The style "classic" of the Events
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.51
 */

$args = get_query_var('trx_addons_args_sc_events');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
$start_time = tribe_get_start_date( null, false, 'g.i' );
$end_time = tribe_get_end_date( null, false, 'g.i' );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}
if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'], !empty($args['columns_tablet']) ? $args['columns_tablet'] : '', !empty($args['columns_mobile']) ? $args['columns_mobile'] : '')); ?>"><?php
}
?>
<div class="sc_events_item trx_addons_hover trx_addons_hover_style_links">
	<?php
	if (has_post_thumbnail()) {
		do_action( 'trx_addons_action_sc_events_item_before_featured', $args );
		trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
														
														'class' => 'sc_events_item_thumb',
														'thumb_size' => apply_filters('trx_addons_filter_thumb_size',
																			trx_addons_get_thumb_size(
																				$args['columns'] > 2 
																					? 'medium' 
																					: 'big'
																			),
																			'events-'.$args['type']
																		),
														), 'events-'.$args['type'])
								);
		do_action( 'trx_addons_action_sc_events_item_after_featured', $args );
	}
	?>
	<div class="sc_events_item_info">
		<div class="sc_events_item_header">
            <div class="sc_events_tribe-venue"> <?php echo tribe_get_venue() ?> </div>
			<h6 class="sc_events_item_title"><a href="<?php the_permalink(); ?>" class="trx_addons_hover_title_link"><?php the_title(); ?></a></h6>

			<?php if ( ! has_post_thumbnail() ) { ?>
				<div class="sc_events_item_meta_b">
					<span class="sc_events_item_meta_item sc_events_item_meta_date"><?php
						$dt = tribe_get_start_date(null, true, 'Y-m-d');
						$dt2 = tribe_get_end_date(null, true, 'Y-m-d');
						echo sprintf( $dt < date('Y-m-d') 
										? esc_html__('Started on %1$s to %2$s', 'rareradio') 
										: esc_html__('Starting %1$s to %2$s', 'rareradio'),
									'<span class="sc_events_item_date_b sc_events_item_date_start">' . date_i18n(get_option('date_format'), strtotime($dt)) . '</span>',
									'<span class="sc_events_item_date_b sc_events_item_date_end">' . date_i18n(get_option('date_format'), strtotime($dt2)) . '</span>'
									);
					?></span>
				</div>
				<div class="sc_events_item_price_b"><?php echo tribe_get_formatted_cost(); ?></div>
			<?php } ?>

			<?php if (($excerpt = get_the_excerpt()) != '') { ?>
				<div class="sc_events_item_text"><?php echo esc_html($excerpt); ?></div>
			<?php } ?>
			
			<?php if ( has_post_thumbnail() ) { ?>
            <div class="sc_events_item_meta">
                <div>
                    <span class="tribe-events-abbr tribe-events-start-time published dtstart" title="<?php esc_attr( $end_ts ) ?>">
                        <?php echo esc_html($time_formatted); ?>
                    </span>
                </div>
				<div class="sc_events_item_meta_item sc_events_item_meta_date"><?php
					$dt = tribe_get_start_date(null, true, 'Y-m-d');
					$dt2 = tribe_get_end_date(null, true, 'Y-m-d');
					echo sprintf( $dt < date('Y-m-d') 
									? esc_html__('%1$s', 'rareradio') 
									: esc_html__('%1$s', 'rareradio'),
								'<span class="sc_events_item_date sc_events_item_date_start">' . date_i18n(get_option('date_format'), strtotime($dt)) . '</span>',
								'<span class="sc_events_item_date sc_events_item_date_end">' . date_i18n(get_option('date_format'), strtotime($dt2)) . '</span>'
								);
				?></div>
                <div class="sc_events_item_price"><?php echo tribe_get_formatted_cost(); ?></div>
			</div>
			<?php } ?>
			<?php
				// Share
				if ( true ) {
					rareradio_show_share_links(
						array(
							'type'    => 'block',
							'caption' => esc_html__(' ', 'rareradio'),
							'before'  => '<div class="post_event_share">',
							'after'   => '</div>',
						)
					);
				}
			?>
		</div>
	</div>
</div><?php
if (!empty($args['slider']) || $args['columns'] > 1) {
	?></div><?php
}
