<?php  
// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('rareradio_ditty_news_ticker_theme_setup9')) {
    add_action( 'after_setup_theme', 'rareradio_ditty_news_ticker_theme_setup9', 9 );
    function rareradio_ditty_news_ticker_theme_setup9() {
        if (is_admin()) {
            add_filter( 'rareradio_filter_tgmpa_required_plugins',  'rareradio_ditty_news_ticker_tgmpa_required_plugins' );
        }
    }
}
// Filter to add in the required plugins list
if ( !function_exists( 'rareradio_ditty_news_ticker_tgmpa_required_plugins' ) ) {
    
    function rareradio_ditty_news_ticker_tgmpa_required_plugins($list=array()) {
        if (rareradio_storage_isset('required_plugins', 'ditty-news-ticker')) {
            $list[] = array(
                    'name'         => esc_html__( 'Ditty News Ticker', 'rareradio' ),
                    'slug'         => 'ditty-news-ticker',
                    'required'     => false
                );
        }
        return $list;
    }
}
// Check if Ditty News Ticker installed and activated
if ( !function_exists( 'rareradio_exists_ditty_news_ticker' ) ) {
    function rareradio_exists_ditty_news_ticker() {
        return function_exists('mtphr_dnt_strings');
    }
}
// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_ditty_news_ticker_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',    'trx_addons_ditty_news_ticker_importer_set_options', 10, 1 );
    function trx_addons_ditty_news_ticker_importer_set_options($options=array()) {
        if ( rareradio_exists_ditty_news_ticker() && in_array('ditty-news-ticker', $options['required_plugins']) ) {
            $options['additional_options'][]    = 'mtphr_%';                    // Add slugs to export options for this plugin
            $options['additional_options'][]    = 'widget_mtphr-dnt-widget'; 
            if (is_array($options['files']) && count($options['files']) > 0) {
                foreach ($options['files'] as $k => $v) {
                    $options['files'][$k]['file_with_ditty-news-ticker'] = str_replace('name.ext', 'ditty-news-ticker.txt', $v['file_with_']);
                }
            }
        }
        return $options;
    }
}
// Check plugin in the required plugins
if ( !function_exists( 'rareradio_ditty_news_ticker_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'rareradio_filter_importer_required_plugins', 'rareradio_ditty_news_ticker_importer_required_plugins', 10, 2 );
    function rareradio_ditty_news_ticker_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'ditty-news-ticker')!==false && !rareradio_exists_ditty_news_ticker() )
            $not_installed .= '<br>' . esc_html__('Ditty News Ticker', 'rareradio');
        return $not_installed;
    }
}
// Add checkbox to the one-click importer
if ( !function_exists( 'rareradio_ditty_news_ticker_importer_show_params' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_params',    'rareradio_ditty_news_ticker_importer_show_params', 10, 1 );
    function rareradio_ditty_news_ticker_importer_show_params($importer) {
        if ( rareradio_exists_ditty_news_ticker() && in_array('ditty-news-ticker', $importer->options['required_plugins']) ) {
            $importer->show_importer_params(array(
                'slug' => 'ditty-news-ticker',
                'title' => esc_html__('Import Ditty News Ticker', 'rareradio'),
                'part' => 0
            ));
        }
    }
}
?>