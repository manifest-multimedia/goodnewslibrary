<?php
/**
 * Free Downloads - Main plugin class Loader
 * 
 * @version  3.3.1
 */

defined('ABSPATH') || exit;

require_once SOMDN_PATH . 'includes/somdn-functions.php';
require_once SOMDN_PATH . 'includes/somdn-file-functions.php';
require_once SOMDN_PATH . 'includes/somdn-downloader.php';
require_once SOMDN_PATH . 'includes/somdn-download-page.php';
require_once SOMDN_PATH . 'includes/somdn-plugin-settings.php';
require_once SOMDN_PATH . 'includes/somdn-compatibility.php';
require_once SOMDN_PATH . 'includes/somdn-meta.php';
require_once SOMDN_PATH . 'includes/somdn-doc-viewer-functions.php';
require_once SOMDN_PATH . 'includes/somdn-shortcodes.php';

require_once SOMDN_PATH . 'somdn-base-loader.php';

$pro_loader = SOMDN_PATH . 'pro/somdn-pro-loader.php';
if (file_exists($pro_loader)) require_once $pro_loader;

// Load the update file to update the database where needed
require_once SOMDN_PATH . 'includes/somdn-updates-master.php';

do_action('somdn_after_file_loader');
