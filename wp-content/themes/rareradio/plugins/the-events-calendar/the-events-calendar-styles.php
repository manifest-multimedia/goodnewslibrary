<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'rareradio_tribe_events_get_css' ) ) {
	add_filter( 'rareradio_filter_get_css', 'rareradio_tribe_events_get_css', 10, 2 );
	function rareradio_tribe_events_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS
.single-tribe_events .tribe-events-meta-group .tribe-events-single-section-title,			
.tribe-events-list .tribe-events-list-event-title {
	{$fonts['h3_font-family']}
}

#tribe-events .tribe-events-button,
.tribe-events-button,
.tribe-events-cal-links a,
.tribe-events-sub-nav li a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more {
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}
.tribe-events-list .tribe-events-list-separator-month,
.tribe-events-calendar thead th,
.tribe-events-schedule, .tribe-events-schedule h2,
.tribe-events .tribe-events-calendar-list__event-date-tag-weekday{
	{$fonts['h5_font-family']}
}
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title {
	{$fonts['p_font-family']}
	{$fonts['p_font-style']}
}
.tribe-events-loop .tribe-event-schedule-details,
.single-tribe_events #tribe-events-content .tribe-events-event-meta dt,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}

.tribe-common .tribe-common-h7, 
.tribe-common .tribe-common-h8,
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-title.tribe-common-h7,
.tribe-common .tribe-events-calendar-day__event-title.tribe-common-h6,
.tribe-common .tribe-events-calendar-list__event .tribe-common-h6,
.tribe-common .tribe-events-calendar-month__header-row .tribe-common-b3,
#tribe-bar-form label, .tribe-events-c-top-bar__datepicker > button,
.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-top-bar__today-button{
	{$fonts['h5_font-family']}
}

.tribe-common .tribe-common-h6,
.single-tribe_events .tribe-events-single .tribe-events-event-meta,
.tribe-events-content,
.tribe-events .datepicker .datepicker-switch,
.tribe-events .datepicker .month, 
.tribe-events .datepicker .year,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-common .tribe-common-b2,
.tribe-common--breakpoint-medium.tribe-common .tribe-common-form-control-text__input, 
.tribe-common .tribe-common-form-control-text__input,
.tribe-common .tribe-common-b3,
.tribe-common .tribe-common-h5,
.tribe-common .tribe-events-calendar-list__event .tribe-common-b2,
#tribe-bar-form input, #tribe-events-content.tribe-events-month,
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title,
#tribe-mobile-container .type-tribe_events,
.tribe-events-list-widget ol li .tribe-event-title,
.tribe-events .datepicker .day, .tribe-events .datepicker .dow{
	{$fonts['p_font-family']}
}
.tribe-events-loop .tribe-event-schedule-details,
#tribe-mobile-container .type-tribe_events .tribe-event-date-start {
	{$fonts['info_font-family']};
}
.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--prev .tribe-events-c-nav__prev-label,
.tribe-events-c-nav__list-item.tribe-events-c-nav__list-item--next .tribe-events-c-nav__next-label {
	{$fonts['button_font-family']}
}
.tribe-common .tribe-common-c-btn,
.tribe-events .tribe-events-c-view-selector__list-item-text,
.tribe-common .tribe-common-c-btn-border, 
.tribe-common a.tribe-common-c-btn-border,
.tribe-common .tribe-common-h3,
.tribe-common .tribe-common-h4,
.tribe-common .tribe-common-h8,
#tribe-bar-form button, #tribe-bar-form a,
.tribe-events-read-more{
	{$fonts['button_font-family']}
	{$fonts['button_letter-spacing']}
}



CSS;
		}

		if ( isset( $css['vars'] ) && isset( $args['vars'] ) ) {
			$vars         = $args['vars'];
			$css['vars'] .= <<<CSS

#tribe-bar-form .tribe-bar-submit input[type="submit"],
#tribe-bar-form button,
#tribe-bar-form a,
#tribe-events .tribe-events-button,
#tribe-bar-views .tribe-bar-views-list,
.tribe-events-button,
.tribe-events-cal-links a,
#tribe-events-footer ~ a.tribe-events-ical.tribe-events-button,
.tribe-events-sub-nav li a,
.tribe-common .tribe-events-c-ical__link,
.tribe-common .tribe-events-c-search__button {
	-webkit-border-radius: {$vars['rad']};
	    -ms-border-radius: {$vars['rad']};
			border-radius: {$vars['rad']};
}

CSS;
		}

		if ( isset( $css['colors'] ) && isset( $args['colors'] ) ) {
			$colors         = $args['colors'];
			$css['colors'] .= <<<CSS

/* Filters bar */
#tribe-bar-form {
	color: {$colors['text_dark']};
}
#tribe-bar-form input[type="text"] {
	color: {$colors['input_text']};
	background: {$colors['input_bg_color']};
	border-color: {$colors['bd_color']}!important;
}

.datepicker thead tr:first-child th:hover, .datepicker tfoot tr th:hover {
	color: {$colors['text_link']};
	background: {$colors['text_dark']};
}
.tribe-common .tribe-events-c-search__button:hover,
.tribe-common .tribe-events-c-ical__link:hover,
#tribe-bar-form .tribe-bar-submit input[type="submit"]:hover {
	color: {$colors['inverse_light']};
	background: {$colors['alter_link']};
}
#tribe-bar-form .tribe-bar-views button.tribe-bar-views-toggle {
	color: {$colors['inverse_light']};
	background: {$colors['text_hover']};
}
#tribe-bar-form .tribe-bar-views button.tribe-bar-views-toggle:hover {
	color: {$colors['inverse_light']};
	background: {$colors['alter_link']};
}
.tribe-events .tribe-events-c-search__input-control:before {
	color: {$colors['input_text']};
}
.tribe-events .tribe-events-c-search__input-control:hover:before {
	color: {$colors['input_dark']};
}
.tribe-events .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-text {
	color: {$colors['text_link']};
}

/* Content */
#tribe-events:after {
	background: {$colors['alter_bg_color']};
}
#tribe-events-content:not(.tribe-events-single),
#tribe-events-content:after {
	background: {$colors['alter_bg_color']};
}
.tribe-events-calendar thead th {
	color: {$colors['inverse_light']};
	background: {$colors['alter_link']} !important;
}
#tribe-events-content .tribe-events-calendar td,
#tribe-events-content .tribe-events-calendar th {
	border-color: {$colors['bd_color']} !important;
}
.tribe-events-calendar td div[id*="tribe-events-daynum-"],
.tribe-events-calendar td div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-othermonth {
	color: {$colors['alter_light']}!important;
	background: {$colors['bg_color_05']} !important;
}
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-daynum-"] > a {
	color: {$colors['alter_light']}!important;
	background: {$colors['bg_color_05']} !important;
}

.tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-past div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['inverse_light']};
}
.tribe-events-calendar td.tribe-events-present:before {
	border-color: {$colors['text_link']};
}
.tribe-events-calendar .tribe-events-has-events:after {
	background-color: {$colors['text']};
}
.tribe-events-calendar .mobile-active.tribe-events-has-events:after {
	background-color: {$colors['bg_color']};
}
.tribe-events-calendar td.tribe-events-othermonth.mobile-active.tribe-events-has-events:after {
	background-color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td {
	color: {$colors['text_dark']};
	background-color: {$colors['bg_color']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-present div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a,
#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['inverse_light']};
}
#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['alter_hover']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a,
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth:hover div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a {
	color: {$colors['text_light']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-present,
#tribe-events-content .tribe-events-calendar td:hover{
	color: {$colors['inverse_light']};
	background-color: {$colors['text_hover2']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth:hover div[id*="tribe-events-daynum-"],
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth:hover div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_light']};
}
#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-daynum-"],
#tribe-events-content .tribe-events-calendar td:hover div[id*="tribe-events-daynum-"] > a {
	color: {$colors['inverse_light']};
}
#tribe-events-content .tribe-events-calendar div[id*="tribe-events-event-"] h3.tribe-events-month-event-title a:hover {
	color: {$colors['text_link']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active,
#tribe-events-content .tribe-events-calendar td.mobile-active:hover {
	color: {$colors['inverse_light']};
	background-color: {$colors['text_hover2']};
}
#tribe-events-content .tribe-events-calendar td.mobile-active div[id*="tribe-events-daynum-"] {
	color: {$colors['inverse_light']};
	background-color: {$colors['text_hover2']};
}
#tribe-events-content .tribe-events-calendar td.tribe-events-othermonth.mobile-active div[id*="tribe-events-daynum-"] a,
.tribe-events-calendar .mobile-active div[id*="tribe-events-daynum-"] a {
	background-color: transparent;
	color: {$colors['bg_color']};
}
.events-archive.events-gridview #tribe-events-content table .type-tribe_events {
	border-color: {$colors['bd_color']};
}
#tribe-bar-collapse-toggle {
	color: {$colors['text_dark']};
	background-color: {$colors['alter_bg_color']};
}

/* Tooltip */
.recurring-info-tooltip,
.tribe-events-calendar .tribe-events-tooltip,
.tribe-events-week .tribe-events-tooltip,
.tribe-events-shortcode.view-week .tribe-events-tooltip,
.tribe-events-tooltip .tribe-events-arrow {
	color: {$colors['text_hover3']};
	background: {$colors['text_dark']};
}
#tribe-events-content .tribe-events-tooltip .summary { 
	color: {$colors['extra_dark']};
	background: {$colors['extra_bg_color']};
}
.tribe-events-tooltip .tribe-event-duration {
	color: {$colors['extra_dark']};
}
.tribe-events-notices {
	color: {$colors['text_dark']};
	border-color: {$colors['text_link']};
	background: {$colors['bg_color']};
}

/* Events list */
.tribe-events-list-separator-month {
	color: {$colors['text_dark']};
}
.tribe-events-list-separator-month:before {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .type-tribe_events + .type-tribe_events,
.tribe-events-day .tribe-events-day-time-slot + .tribe-events-day-time-slot + .tribe-events-day-time-slot {
	border-color: {$colors['bd_color']};
}
.tribe-events-list .tribe-events-event-cost span {
	color: {$colors['extra_dark']};
	border-color: {$colors['extra_bg_color']};
	background: {$colors['extra_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_color']};
	background-color: {$colors['alter_bg_color']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a {
	color: {$colors['alter_link']};
}
.tribe-mobile .tribe-events-loop .tribe-events-event-meta a:hover {
	color: {$colors['alter_hover']};
}
.tribe-mobile .tribe-events-list .tribe-events-venue-details {
	border-color: {$colors['alter_bd_color']};
}

.single-tribe_events #tribe-events-footer,
.tribe-events-day #tribe-events-footer,
.events-list #tribe-events-footer,
.tribe-events-map #tribe-events-footer,
.tribe-events-photo #tribe-events-footer {
	border-color: {$colors['bd_color']};	
}

/* Events day */
.tribe-events-day .tribe-events-day-time-slot h5,
.tribe-events-day .tribe-events-day-time-slot .tribe-events-day-time-slot-heading {
	color: {$colors['extra_dark']};
	background: {$colors['extra_bg_color']};
}



/* Single Event */
.single-tribe_events .tribe-events-venue-map {
	color: {$colors['alter_text']};
	border-color: {$colors['alter_bd_hover']};
	background: {$colors['alter_bg_hover']};
}
.single-tribe_events .tribe-events-schedule .tribe-events-cost {
	color: {$colors['text_dark']};
}
.single-tribe_events .type-tribe_events {
	border-color: {$colors['bd_color']};
}



/*--------new----*/

.tribe-common .tribe-common-anchor-thin-alt:hover,
.tribe-common .tribe-common-anchor-thin-alt:focus,
.tribe-common .tribe-common-anchor-thin-alt:active,
.tribe-events-c-top-bar__datepicker > button,
.tribe-events .tribe-events-calendar-month__day--current .tribe-events-calendar-month__day-date-link,
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"],
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a {
	color: {$colors['text_link']};
}

.tribe-common .tribe-common-anchor-thin-alt,
.tribe-common .tribe-common-anchor-thin-alt:focus{
    border-color: {$colors['text_dark']};
}
.tribe-events .datepicker .day.active,
.tribe-events .tribe-events-c-events-bar__search-button:before,
.tribe-events .tribe-events-c-view-selector__button:before,
.tribe-events .datepicker .year.active,
.tribe-events .datepicker .month.active:hover,
.tribe-events .datepicker .month.active, .tribe-events .datepicker .month.active.focused{
    background-color: {$colors['text_link']};
}

.tribe-events-calendar-day-nav button:hover,
.tribe-events-calendar-list-nav button:hover,
.tribe-events-c-top-bar__datepicker > button:focus,
.tribe-events-c-top-bar__datepicker > button:hover{
    color: {$colors['text_dark']}!important;
}

.tribe-events .tribe-events-calendar-month__multiday-event-bar-inner {	
	 background-color: {$colors['alter_bg_color']};
}

.tribe-common .tribe-common-c-loader__dot:not(.tribe-events-header__messages),

.tribe-common--breakpoint-medium.tribe-events .tribe-events-c-view-selector--tabs .tribe-events-c-view-selector__list-item--active .tribe-events-c-view-selector__list-item-link:after{
    background-color: {$colors['text_link']};
}

.tribe-common .tribe-events-calendar-month__day--past .tribe-common-h4{
	color: {$colors['text_light']};
}

.tribe-common .tribe-events-calendar-month__day--current .tribe-common-h4{
	color: {$colors['text_link']};
}

.tribe-events .tribe-events-calendar-month__multiday-event-bar-inner .tribe-common-h8{
    color: {$colors['text_dark']};
}

.tribe-events-calendar-month__calendar-event-tooltip-title > a,
.tribe-common .tribe-events-calendar-day__event-title.tribe-common-h6 > a,
.tribe-common .tribe-events-calendar-list__event .tribe-common-h6 > a{
	color: {$colors['text_dark']};
}
.tribe-events-calendar-month__calendar-event-tooltip-title > a:hover,
.tribe-common .tribe-events-calendar-day__event-title.tribe-common-h6 > a:hover,
.tribe-common .tribe-events-calendar-list__event .tribe-common-h6 > a:hover{
	color: {$colors['text_link']};
}
.tribe-common .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-common .tribe-events-calendar-day__event-datetime,
.tribe-common .tribe-events-calendar-day__event-header address,
.tribe-common .tribe-events-calendar-day__event-description,
.tribe-common .tribe-events-calendar-list__event-header address,
.tribe-common .tribe-events-calendar-list__event-description,
.tribe-events-calendar-month__calendar-event-tooltip-description{
    color: {$colors['text']};
}
.tribe-common .tribe-events-calendar-list__event-datetime,
.tribe-events .tribe-events-calendar-month__calendar-event-tooltip-datetime,
.tribe-events .tribe-events-calendar-list__event-date-tag-weekday,
.tribe-events .tribe-events-calendar-day__event-datetime{
	color: {$colors['text_dark']};
}
.tribe-common .tribe-events-c-nav__list-item .tribe-events-c-nav__prev,
.tribe-common .tribe-events-c-nav__list-item .tribe-events-c-nav__next {
  	color: {$colors['text_dark']};
}
.tribe-common .tribe-events-c-nav__list-item .tribe-events-c-nav__prev:hover,
.tribe-common .tribe-events-c-nav__list-item .tribe-events-c-nav__next:hover {
  	color: {$colors['text_link']};
}
.tribe-events .tribe-events-calendar-month__header-column-title {
	color: {$colors['text_dark']};
}

.single-tribe_events .tribe-events-single .tribe-events-event-meta,
.tribe-events-content{
	color: {$colors['text']};
}

.tribe-events-meta-group .tribe-events-single-section-title{
	color: {$colors['text_dark']};
}

.tribe-events .tribe-events-calendar-month__day-cell--selected,
.tribe-events .tribe-events-calendar-month__day-cell--selected:focus,
.tribe-events .tribe-events-calendar-month__day-cell--selected:hover,
.tribe-events .tribe-events-calendar-month__mobile-events-icon--event{
	background-color: {$colors['text_link']};
}

CSS;
		}

		return $css;
	}
}

