<?php  
// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('rareradio_devvn_image_hotspot_theme_setup9')) {
    add_action( 'after_setup_theme', 'rareradio_devvn_image_hotspot_theme_setup9', 9 );
    function rareradio_devvn_image_hotspot_theme_setup9() {
        if (is_admin()) {
            add_filter( 'rareradio_filter_tgmpa_required_plugins',  'rareradio_devvn_image_hotspot_tgmpa_required_plugins' );
        }
    }
}
// Filter to add in the required plugins list
if ( !function_exists( 'rareradio_devvn_image_hotspot_tgmpa_required_plugins' ) ) {
    
    function rareradio_devvn_image_hotspot_tgmpa_required_plugins($list=array()) {
        if (rareradio_storage_isset('required_plugins', 'devvn-image-hotspot')) {
            $list[] = array(
                    'name'         => esc_html__( 'Image Hotspot by DevVN', 'rareradio' ),
                    'slug'         => 'devvn-image-hotspot',
                    'required'     => false
                );
        }
        return $list;
    }
}
// Check if Image Hotspot by DevVN installed and activated
if ( !function_exists( 'rareradio_exists_devvn_image_hotspot' ) ) {
    function rareradio_exists_devvn_image_hotspot() {
        return function_exists('devvn_ihotspot_meta_box');
    }
}
// Check plugin in the required plugins
if ( !function_exists( 'rareradio_devvn_image_hotspot_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'rareradio_filter_importer_required_plugins', 'rareradio_devvn_image_hotspot_importer_required_plugins', 10, 2 );
    function rareradio_devvn_image_hotspot_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'devvn-image-hotspot')!==false && !rareradio_exists_devvn_image_hotspot() )
            $not_installed .= '<br>' . esc_html__('Image Hotspot by DevVN', 'rareradio');
        return $not_installed;
    }
}
// Add checkbox to the one-click importer
if ( !function_exists( 'rareradio_devvn_image_hotspot_importer_show_params' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_params',    'rareradio_devvn_image_hotspot_importer_show_params', 10, 1 );
    function rareradio_devvn_image_hotspot_importer_show_params($importer) {
        if ( rareradio_exists_devvn_image_hotspot() && in_array('devvn-image-hotspot', $importer->options['required_plugins']) ) {
            $importer->show_importer_params(array(
                'slug' => 'devvn-image-hotspot',
                'title' => esc_html__('Import Image Hotspot by DevVN', 'rareradio'),
                'part' => 0
            ));
        }
    }
}
?>