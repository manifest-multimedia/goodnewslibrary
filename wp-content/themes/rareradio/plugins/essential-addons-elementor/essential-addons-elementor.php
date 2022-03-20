<?php  
// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('rareradio_essential_addons_elementor_theme_setup9')) {
    add_action( 'after_setup_theme', 'rareradio_essential_addons_elementor_theme_setup9', 9 );
    function rareradio_essential_addons_elementor_theme_setup9() {
        if (is_admin()) {
            add_filter( 'rareradio_filter_tgmpa_required_plugins',  'rareradio_essential_addons_elementor_tgmpa_required_plugins' );
        }
    }
}
// Filter to add in the required plugins list
if ( !function_exists( 'rareradio_essential_addons_elementor_tgmpa_required_plugins' ) ) {
    
    function rareradio_essential_addons_elementor_tgmpa_required_plugins($list=array()) {
        if (rareradio_storage_isset('required_plugins', 'essential-addons-elementor')) {
            $list[] = array(
                    'name'         => esc_html__( 'Essential Addons for Elementor', 'rareradio' ),
                    'slug'         => 'essential-addons-for-elementor-lite',
                    'required'     => false
                );
        }
        return $list;
    }
}
// Check if Essential Addons for Elementor installed and activated
if ( !function_exists( 'rareradio_exists_essential_addons_elementor' ) ) {
    function rareradio_exists_essential_addons_elementor() {
        return function_exists( 'admin_menu' );
    }
}
// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_essential_addons_elementor_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',    'trx_addons_essential_addons_elementor_importer_set_options', 10, 1 );
    function trx_addons_essential_addons_elementor_importer_set_options($options=array()) {
        if ( rareradio_exists_essential_addons_elementor() && in_array('essential-addons-elementor', $options['required_plugins']) ) {
            $options['additional_options'][]    = 'eael_save_settings';                    // Add slugs to export options for this plugin
            if (is_array($options['files']) && count($options['files']) > 0) {
                foreach ($options['files'] as $k => $v) {
                    $options['files'][$k]['file_with_essential-addons-elementor'] = str_replace('name.ext', 'essential-addons-elementor.txt', $v['file_with_']);
                }
            }
        }
        return $options;
    }
}
// Check plugin in the required plugins
if ( !function_exists( 'rareradio_essential_addons_elementor_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'rareradio_filter_importer_required_plugins', 'rareradio_essential_addons_elementor_importer_required_plugins', 10, 2 );
    function rareradio_essential_addons_elementor_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'essential-addons-elementor')!==false && !rareradio_exists_essential_addons_elementor() )
            $not_installed .= '<br>' . esc_html__('Essential Addons for Elementor', 'rareradio');
        return $not_installed;
    }
}
// Add checkbox to the one-click importer
if ( !function_exists( 'rareradio_essential_addons_elementor_importer_show_params' ) ) {
    if (is_admin()) add_action( 'trx_addons_action_importer_params',    'rareradio_essential_addons_elementor_importer_show_params', 10, 1 );
    function rareradio_essential_addons_elementor_importer_show_params($importer) {
        if ( rareradio_exists_essential_addons_elementor() && in_array('essential-addons-elementor', $importer->options['required_plugins']) ) {
            $importer->show_importer_params(array(
                'slug' => 'essential-addons-elementor',
                'title' => esc_html__('Import Essential Addons for Elementor', 'rareradio'),
                'part' => 0
            ));
        }
    }
}
?>