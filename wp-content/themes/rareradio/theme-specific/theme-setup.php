<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'RARERADIO_THEME_FREE' ) ) {
	define( 'RARERADIO_THEME_FREE', false );
}
if ( ! defined( 'RARERADIO_THEME_FREE_WP' ) ) {
	define( 'RARERADIO_THEME_FREE_WP', false );
}

// If this theme is a part of Envato Elements
if ( ! defined( 'RARERADIO_THEME_IN_ENVATO_ELEMENTS' ) ) {
	define( 'RARERADIO_THEME_IN_ENVATO_ELEMENTS', false );
}

// If this theme uses multiple skins
if ( ! defined( 'RARERADIO_ALLOW_SKINS' ) ) {
	define( 'RARERADIO_ALLOW_SKINS', false );
}
if ( ! defined( 'RARERADIO_DEFAULT_SKIN' ) ) {
	define( 'RARERADIO_DEFAULT_SKIN', 'default' );
}



// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
//-------------------------------------------------------------------------
$GLOBALS['RARERADIO_STORAGE'] = array(

	// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
	'theme_pro_key'       => 'env-ancora',

	// Generate Personal token from Envato to automatic upgrade theme
	'upgrade_token_url'   => '//build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'      => '//rareradio.ancorathemes.com/',
	'theme_doc_url'       => '//rareradio.ancorathemes.com/doc',

	'theme_upgrade_url'   => '//upgrade.themerex.net/',

	'theme_demofiles_url' => '//demofiles.ancorathemes.com/rareradio/',
	
	'theme_rate_url'      => '//themeforest.net/download',

	'theme_custom_url' => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash',

	'theme_download_url'  => '//themeforest.net/item/rare-radio-online-music-wordpress-theme/24461451',        // Ancora

	'theme_support_url'   => '//themerex.net/support/',                    // Ancora

	'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Ancora

	'theme_privacy_url'   => '//ancorathemes.com/privacy-policy/',                   // Ancora

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'    => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'          => array(
		// By size
		'xxl'        => array( 'max' => 1679 ),
		'xl'         => array( 'max' => 1439 ),
		'lg'         => array( 'max' => 1279 ),
		'md_over'    => array( 'min' => 1024 ),
		'md'         => array( 'max' => 1023 ),
		'sm'         => array( 'max' => 767 ),
		'sm_wp'      => array( 'max' => 600 ),
		'xs'         => array( 'max' => 479 ),
		// By device
		'wide'       => array(
			'min' => 2160
		),
		'desktop'    => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook'   => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'     => array(
			'min' => 768,
			'max' => 1279,
		),
		'not_mobile' => array(
			'min' => 768
		),
		'mobile'     => array(
			'max' => 767
		),
	),
);


//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'rareradio_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'rareradio_importer_set_options', 9 );
	function rareradio_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url( rareradio_get_protocol() . ':' . rareradio_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( rareradio_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'RareRadio Demo', 'rareradio' );
			$options['files']['default']['domain_dev']  = esc_url( rareradio_get_protocol() . '://rareradio.ancorathemes.com/' );                     // Developers domain
			$options['files']['default']['domain_demo'] = esc_url( rareradio_get_protocol() . ':' . rareradio_storage_get( 'theme_demo_url' ) );   // Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			
			
			
			
			// The array with theme-specific banners, displayed during demo-content import.
			// If array with banners is empty - the banners are uploaded directly from demo-content server.
			$options['banners'] = array();
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'rareradio_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'rareradio_ocdi_set_options', 9 );
	function rareradio_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( rareradio_get_protocol() . ':' . rareradio_storage_get( 'theme_demofiles_url' ) );
			// Required plugins
			$options['required_plugins'] = array_keys( rareradio_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'RareRadio OCDI Demo', 'rareradio' );
			$options['files']['ocdi']['domain_demo'] = esc_url( 'http:' . rareradio_storage_get( 'theme_demo_url' ) );
			// If theme need more demo - just copy 'default' and change required parameter
		}
		return $options;
	}
}



// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$rareradio_theme_required_plugins_group = esc_html__( 'Core', 'rareradio' );
$rareradio_theme_required_plugins = array(
	// Section: "CORE" (required plugins)
	// DON'T COMMENT OR REMOVE NEXT LINES!
	'trx_addons'         => array(
								'title'       => esc_html__( 'ThemeREX Addons', 'rareradio' ),
								'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'rareradio' ),
								'required'    => true,
								'logo'        => 'logo.png',
								'group'       => $rareradio_theme_required_plugins_group,
							),
);

// Section: "PAGE BUILDERS"
$rareradio_theme_required_plugins_group = esc_html__( 'Page Builders', 'rareradio' );
$rareradio_theme_required_plugins['elementor'] = array(
	'title'       => esc_html__( 'Elementor', 'rareradio' ),
	'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'rareradio' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $rareradio_theme_required_plugins_group,
);
$rareradio_theme_required_plugins['gutenberg'] = array(
	'title'       => esc_html__( 'Gutenberg', 'rareradio' ),
	'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'rareradio' ),
	'required'    => false,
	'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
	'logo'        => 'logo.png',
	'group'       => $rareradio_theme_required_plugins_group,
);
if ( ! RARERADIO_THEME_FREE ) {
	$rareradio_theme_required_plugins['js_composer']          = array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'rareradio' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'rareradio' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.jpg',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['vc-extensions-bundle'] = array(
		'title'       => esc_html__( 'WPBakery PageBuilder extensions bundle', 'rareradio' ),
		'description' => esc_html__( "Many shortcodes for the WPBakery PageBuilder", 'rareradio' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
}

// Section: "E-COMMERCE"
$rareradio_theme_required_plugins_group = esc_html__( 'E-Commerce', 'rareradio' );
$rareradio_theme_required_plugins['woocommerce']              = array(
	'title'       => esc_html__( 'WooCommerce', 'rareradio' ),
	'description' => esc_html__( "Connect the store to your website and start selling now", 'rareradio' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $rareradio_theme_required_plugins_group,
);
$rareradio_theme_required_plugins['elegro-payment']              = array(
    'title'       => esc_html__( 'elegro Crypto Payment', 'rareradio' ),
    'description' => '',
    'required'    => false,
    'logo'        => 'logo.png',
    'group'       => $rareradio_theme_required_plugins_group,
);
$rareradio_theme_required_plugins['mailchimp-for-wp'] = array(
	'title'       => esc_html__( 'MailChimp for WP', 'rareradio' ),
	'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'rareradio' ),
	'required'    => false,
	'logo'        => 'logo.png',
	'group'       => $rareradio_theme_required_plugins_group,
);

// Section: "EVENTS & TIMELINES"
$rareradio_theme_required_plugins_group = esc_html__( 'Events and Appointments', 'rareradio' );
if ( ! RARERADIO_THEME_FREE ) {
	$rareradio_theme_required_plugins['mp-timetable']           = array(
		'title'       => esc_html__( 'MP Time Table', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['the-events-calendar']    = array(
		'title'       => esc_html__( 'The Events Calendar', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
}

// Section: "CONTENT"
$rareradio_theme_required_plugins_group = esc_html__( 'Content', 'rareradio' );
$rareradio_theme_required_plugins['contact-form-7'] = array(
	'title'       => esc_html__( 'Contact Form 7', 'rareradio' ),
	'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'rareradio' ),
	'required'    => false,
	'logo'        => 'logo.jpg',
	'group'       => $rareradio_theme_required_plugins_group,
);
if ( ! RARERADIO_THEME_FREE ) {
	$rareradio_theme_required_plugins['essential-grid']             = array(
		'title'       => esc_html__( 'Essential Grid', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['revslider']                  = array(
		'title'       => esc_html__( 'Revolution Slider', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['essential-addons-elementor']          = array(
		'title'       => esc_html__( 'Essential Addons for Elementor', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
}

// Section: "OTHER"
$rareradio_theme_required_plugins_group = esc_html__( 'Other', 'rareradio' );
if ( ! RARERADIO_THEME_FREE ) {
	$rareradio_theme_required_plugins['give']          = array(
		'title'       => esc_html__( 'Give', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['devvn-image-hotspot']          = array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.jpg',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['ditty-news-ticker']          = array(
		'title'       => esc_html__( 'Ditty News Ticker', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.png',
		'group'       => $rareradio_theme_required_plugins_group,
	);
	$rareradio_theme_required_plugins['trx_socials']          = array(
		'title'       => esc_html__( 'ThemeREX Socials', 'rareradio' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'logo.jpg',
		'group'       => $rareradio_theme_required_plugins_group,
	);
    $rareradio_theme_required_plugins['trx_updater']          = array(
        'title'       => esc_html__( 'ThemeREX Updater', 'rareradio' ),
        'description' => '',
        'required'    => false,
        'logo'        => 'logo.png',
        'group'       => $rareradio_theme_required_plugins_group,
    );
}

// Add plugins list to the global storage
$GLOBALS['RARERADIO_STORAGE']['required_plugins'] = $rareradio_theme_required_plugins;



// THEME-SPECIFIC BLOG LAYOUTS
//----------------------------------------------
$rareradio_theme_blog_styles = array(
	'excerpt' => array(
		'title'   => esc_html__( 'Standard', 'rareradio' ),
		'archive' => 'index-excerpt',
		'item'    => 'content-excerpt',
		'styles'  => 'excerpt',
	),
	'classic' => array(
		'title'   => esc_html__( 'Classic', 'rareradio' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'classic',
	),
);
if ( ! RARERADIO_THEME_FREE ) {
	$rareradio_theme_blog_styles['masonry']   = array(
		'title'   => esc_html__( 'Masonry', 'rareradio' ),
		'archive' => 'index-classic',
		'item'    => 'content-classic',
		'columns' => array( 2, 3 ),
		'styles'  => 'masonry',
	);
	$rareradio_theme_blog_styles['portfolio'] = array(
		'title'   => esc_html__( 'Portfolio', 'rareradio' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio',
		'columns' => array( 2, 3, 4 ),
		'styles'  => 'portfolio',
	);
	$rareradio_theme_blog_styles['gallery']   = array(
		'title'   => esc_html__( 'Gallery', 'rareradio' ),
		'archive' => 'index-portfolio',
		'item'    => 'content-portfolio-gallery',
		'columns' => array( 2, 3, 4 ),
		'styles'  => array( 'portfolio', 'gallery' ),
	);
	$rareradio_theme_blog_styles['chess']     = array(
		'title'   => esc_html__( 'Chess', 'rareradio' ),
		'archive' => 'index-chess',
		'item'    => 'content-chess',
		'columns' => array( 1, 2, 3 ),
		'styles'  => 'chess',
	);
}

// Add list of blog styles to the global storage
$GLOBALS['RARERADIO_STORAGE']['blog_styles'] = $rareradio_theme_blog_styles;


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'rareradio_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'rareradio_customizer_theme_setup1', 1 );
	function rareradio_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		rareradio_storage_set(
			'settings', array(

				'duplicate_options'      => 'child',                    // none  - use separate options for the main and the child-theme
																		// child - duplicate theme options from the main theme to the child-theme only
																		// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'      => 'auto',                     // Refresh method for preview area in the Appearance - Customize:
																		// auto - refresh preview area on change each field with Theme Options
																		// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'max_load_fonts'         => 5,                          // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'     => true,                       // Place 'comment' field after the 'name' and 'email'

				'show_author_avatar'     => true,                       // Display author's avatar in the post meta

				'icons_selector'         => 'internal',                 // Icons selector in the shortcodes:
																		//  standard VC (very slow) or Elementor's icons selector (not support images and svg)
																		// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'             => 'icons',                    // Type of icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present icons
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'           => 'icons',                    // Type of socials icons (if 'icons_selector' is 'internal'):
																		// icons  - use font icons to present social networks
																		// images - use images from theme's folder trx_addons/css/icons.png
																		// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'      => true,                       // Check if exists a .min version of .css and .js and return path to it
																		// instead the path to the original file
																		// (if debug_mode is on and modification time of the original file < time of the .min file)

				'autoselect_menu'        => true,                      // Show any menu if no menu selected in the location 'main_menu'
																		// (for example, the theme is just activated)

				'disable_jquery_ui'      => false,                      // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'      => true,                       // Load script "Media Elements" to play video and audio

				'tgmpa_upload'           => false,                      // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'         => false,                      // Allow to use theme-specific image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'       => true,                       // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'       => false,                      // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																		// In the Page Options this styles are present always
																		// (can be removed if filter 'rareradio_filter_allow_fullscreen' return false)

				'attachments_navigation' => false,                      // Add arrows on the single attachment page to navigate to the prev/next attachment

				'gutenberg_safe_mode'    => array(),                    // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'gutenberg_add_context'  => false,                      // Add context to the Gutenberg editor styles with our method (if true - use if any problem with editor styles) or use native Gutenberg way via add_editor_style() (if false - used by default)

				'allow_gutenberg_blocks' => true,                       // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'   => true,                       // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx'        => 'replace',                  // Add our breakpoints to the Responsive section of each element
																		// 'add' - add our breakpoints after Elementor's
																		// 'replace' - add our breakpoints instead Elementor's
																		// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		rareradio_storage_set(
			'load_fonts', array(
				// Font-face packed with theme
				array(
					'name'   => 'Syne',
					'family' => 'sans-serif',
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		rareradio_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags
		// Attention! Font name in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		
		
		

		rareradio_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'rareradio' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '1.285714rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5555em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '5.142857rem',
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => '1.1944em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.37em',
					'margin-bottom'   => '1.045em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '4.285714rem',
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => '1.2em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.74em',
					'margin-bottom'   => '1.24em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '3.428571rem',
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => '1.2083em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.65em',
					'margin-bottom'   => '1.09em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '2.571428rem',
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => '1.1944em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.79em',
					'margin-bottom'   => '1.53em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '2.142857rem',
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => '1.2333em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.6em',
					'margin-bottom'   => '1.02em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '1.714285rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.3333em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
					'margin-top'      => '1.95em',
					'margin-bottom'   => '1.24em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'rareradio' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '1.8em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '18px',
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => 'normal',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.06em',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'rareradio' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'rareradio' ),
					'font-family'     => 'Syne',
					'font-size'       => '1em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => 'normal', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'rareradio' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'rareradio' ),
					'font-family'     => 'Syne',
					'font-size'       => '12px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '900',
					'font-style'      => 'normal',
					'line-height'     => 'normal',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.06em',
					'margin-top'      => '',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'rareradio' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '1.285714rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.27778em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'rareradio' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'rareradio' ),
					'font-family'     => '"Syne",sans-serif',
					'font-size'       => '1.285714rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.4444em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0',
				),
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		rareradio_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'rareradio' ),
					'description' => esc_html__( 'Colors of the main content area', 'rareradio' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'rareradio' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'rareradio' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'rareradio' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'rareradio' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'rareradio' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'rareradio' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'rareradio' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'rareradio' ),
				),
			)
		);
		rareradio_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'rareradio' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'rareradio' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'rareradio' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'rareradio' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'rareradio' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'rareradio' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'rareradio' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'rareradio' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'rareradio' ),
					'description' => esc_html__( 'Color of the plain text inside this block', 'rareradio' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'rareradio' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'rareradio' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'rareradio' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'rareradio' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'rareradio' ),
					'description' => esc_html__( 'Color of the links inside this block', 'rareradio' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'rareradio' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'rareradio' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'rareradio' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'rareradio' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'rareradio' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'rareradio' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'rareradio' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'rareradio' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'rareradio' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'rareradio' ),
				),
			)
		);
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'rareradio' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff',
					'bd_color'         => '#E5E8EB',

					// Text and links colors
					'text'             => '#404344',
					'text_light'       => '#B3B6B8',
					'text_dark'        => '#000000',
					'text_link'        => '#624BFF',
					'text_hover'       => '#000000',
					'text_link2'       => '#624BFF',
					'text_hover2'      => '#F7BA45',
					'text_link3'       => '#DE2607',
					'text_hover3'      => '#adadad',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F5F5F5',
					'alter_bg_hover'   => '#D8DEE3',
					'alter_bd_color'   => '#E5E8EB',
					'alter_bd_hover'   => '#ffffff',
					'alter_text'       => '#404344',
					'alter_light'      => '#B3B6B8',
					'alter_dark'       => '#000000',
					'alter_link'       => '#624BFF',
					'alter_hover'      => '#000000',
					'alter_link2'      => '#f5f5f5',
					'alter_hover2'     => '#e5e8eb',
					'alter_link3'      => '#de2607',
					'alter_hover3'     => '#7E8283',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000',
					'extra_bg_hover'   => '#ffffff',
					'extra_bd_color'   => '#29292B',
					'extra_bd_hover'   => '#E5E8EB',
					'extra_text'       => '#404344',
					'extra_light'      => '#ffffff',
					'extra_dark'       => '#FFFFFF',
					'extra_link'       => '#DE2607',
					'extra_hover'      => '#FFFFFF',
					'extra_link2'      => '#f7ba45',
					'extra_hover2'     => '#44B931',
					'extra_link3'      => '#ffffff',
					'extra_hover3'     => '#ffffff',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#FFFFFF',
					'input_bg_hover'   => '#FFFFFF',
					'input_bd_color'   => '#E5E8EB',
					'input_bd_hover'   => '#D8DEE3',
					'input_text'       => '#B3B6B8',
					'input_light'      => '#ffffff',
					'input_dark'       => '#000000',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#ffffff',
					'inverse_bd_hover' => '#ffffff',
					'inverse_text'     => '#000000',
					'inverse_light'    => '#ffffff',
					'inverse_dark'     => '#000000',
					'inverse_link'     => '#624BFF',
					'inverse_hover'    => '#000000',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'rareradio' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#000000',
					'bd_color'         => '#2F2F33',

					// Text and links colors
					'text'             => '#ADADAD',
					'text_light'       => '#818588',
					'text_dark'        => '#FFFFFF',
					'text_link'        => '#FFFFFF',
					'text_hover'       => '#F7BA45',
					'text_link2'       => '#624BFF',
					'text_hover2'      => '#F7BA45',
					'text_link3'       => '#ffffff',
					'text_hover3'      => '#404344',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#1C1C1F',
					'alter_bg_hover'   => '#29292B',
					'alter_bd_color'   => '#ffffff',
					'alter_bd_hover'   => '#ffffff',
					'alter_text'       => '#ADADAD',
					'alter_light'      => '#818588',
					'alter_dark'       => '#FFFFFF',
					'alter_link'       => '#624BFF',
					'alter_hover'      => '#000000',
					'alter_link2'      => '#ffffff',
					'alter_hover2'     => '#e5e8eb',
					'alter_link3'      => '#de2607',
					'alter_hover3'     => '#7E8283',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#FFFFFF',
					'extra_bg_hover'   => '#ffffff',
					'extra_bd_color'   => '#ffffff',
					'extra_bd_hover'   => '#E5E8EB',
					'extra_text'       => '#000000',
					'extra_light'      => '#ffffff',
					'extra_dark'       => '#000000',
					'extra_link'       => '#F7BA45',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#de2607',
					'extra_hover2'     => '#44B931',
					'extra_link3'      => '#ffffff',
					'extra_hover3'     => '#ffffff',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#FFFFFF',
					'input_bg_hover'   => '#000000',
					'input_bd_color'   => '#FFFFFF',
					'input_bd_hover'   => '#29292B',
					'input_text'       => '#B3B6B8',
					'input_light'      => '#ffffff',
					'input_dark'       => '#000000',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#ffffff',
					'inverse_bd_hover' => '#ffffff',
					'inverse_text'     => '#FFFFFF',
					'inverse_light'    => '#ffffff',
					'inverse_dark'     => '#FFFFFF',
					'inverse_link'     => '#624BFF',
					'inverse_hover'    => '#ffffff',
				),
			),
		);
		rareradio_storage_set( 'schemes', $schemes );
		rareradio_storage_set( 'schemes_original', $schemes );
		
		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		rareradio_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		rareradio_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_05'       => array(
					'color' => 'bg_color',
					'alpha' => 0.5,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_hover2_02' => array(
					'color' => 'alter_hover2',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_bg_color_08' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.8,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Parameters to set order of schemes in the css
		rareradio_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		rareradio_storage_set(
			'theme_thumbs', apply_filters(
				'rareradio_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'rareradio-thumb-huge'        => array(
						'size'  => array( 1170, 658, true ),
						'title' => esc_html__( 'Huge image', 'rareradio' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'rareradio-thumb-big'         => array(
						'size'  => array( 1600, 903, true ),
						'title' => esc_html__( 'Large image', 'rareradio' ),
						'subst' => 'trx_addons-thumb-big',
					),

					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'rareradio-thumb-med'         => array(
						'size'  => array( 370, 208, true ),
						'title' => esc_html__( 'Medium image', 'rareradio' ),
						'subst' => 'trx_addons-thumb-medium',
					),

					// Small square image (for avatars in comments, etc.)
					'rareradio-thumb-tiny'        => array(
						'size'  => array( 90, 90, true ),
						'title' => esc_html__( 'Small square avatar', 'rareradio' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Image (for Recent Posts)
					'rareradio-thumb-rp'        => array(
						'size'  => array( 540, 300, true ),
						'title' => esc_html__( 'Recent Posts', 'rareradio' ),
						'subst' => 'trx_addons-thumb-rp',
					),
					// Image (for related posts)
					'rareradio-thumb-rel'        => array(
						'size'  => array( 780, 540, true ),
						'title' => esc_html__( 'Related Posts', 'rareradio' ),
						'subst' => 'trx_addons-thumb-rel',
					),
					// Square image (for services light)
					'rareradio-thumb-sl'        => array(
						'size'  => array( 500, 500, true ),
						'title' => esc_html__( 'Services Light', 'rareradio' ),
						'subst' => 'trx_addons-thumb-sl',
					),
					// Square image (for services light)
					'rareradio-thumb-sqb'        => array(
						'size'  => array( 1500, 1500, true ),
						'title' => esc_html__( 'Services Light Big Square', 'rareradio' ),
						'subst' => 'trx_addons-thumb-sqb',
					),
					// Image (for caption image)
					'rareradio-thumb-cpim'        => array(
						'size'  => array( 570, 422, true ),
						'title' => esc_html__( 'Caption Image', 'rareradio' ),
						'subst' => 'trx_addons-thumb-cpim',
					),
					// Image (for team default)
					'rareradio-thumb-team'        => array(
						'size'  => array( 1200, 1036, true ),
						'title' => esc_html__( 'Team Default', 'rareradio' ),
						'subst' => 'trx_addons-thumb-team',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'rareradio-thumb-masonry-big' => array(
						'size'  => array( 760, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'rareradio' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'rareradio-thumb-masonry'     => array(
						'size'  => array( 370, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'rareradio' ),
						'subst' => 'trx_addons-thumb-masonry',
					),
				)
			)
		);
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'rareradio_create_theme_options' ) ) {

	function rareradio_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'rareradio' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( rareradio_storage_get( 'schemes' ) ) < 2;

		rareradio_storage_set(

			'options', array(

				// 'Logo & Site Identity'
				//---------------------------------------------
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'rareradio' ),
					'desc'     => '',
					'priority' => 10,
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'rareradio' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'rareradio' ) ),
					'class'    => 'rareradio_column-1_2 rareradio_new_row',
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'rareradio' ) ),
					'class'    => 'rareradio_column-1_2',
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_zoom'                     => array(
					'title'   => esc_html__( 'Logo zoom', 'rareradio' ),
					'desc'    => wp_kses(
									__( 'Zoom the logo (set 1 to leave original size).', 'rareradio' )
									. ' <br>'
									. __( 'Attention! For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header.', 'rareradio' )
									. ' <br>'
									. __( 'In this case maximum size of logo depends on the actual size of the picture.', 'rareradio' ), 'rareradio_kses_content'
								),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'rareradio' ) ),
					'class'      => 'rareradio_column-1_2',
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'rareradio' ) ),
					'class' => 'rareradio_column-1_2 rareradio_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'rareradio' ) ),
					'class'      => 'rareradio_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'rareradio' ) ),
					'class' => 'rareradio_column-1_2 rareradio_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'rareradio' ) ),
					'class'      => 'rareradio_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'image',
				),



				// 'General settings'
				//---------------------------------------------
				'general'                       => array(
					'title'    => esc_html__( 'General', 'rareradio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'rareradio' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'rareradio' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => rareradio_get_list_body_styles( false ),
					'type'     => 'select',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'rareradio' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1230,
					'min'        => 1000,
					'max'        => 1600,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page',               // SASS variable's name to preview changes 'on fly'
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'page_boxed_extra'             => array(
					'title'      => esc_html__( 'Boxed page extra spaces', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Width of the extra side space on boxed pages', 'rareradio' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'std'        => 60,
					'min'        => 0,
					'max'        => 150,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page_boxed_extra',   // SASS variable's name to preview changes 'on fly'
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'rareradio' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'rareradio' ),
					
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Remove margins', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Remove margins above and below the content area', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'type'     => 'checkbox',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_position_ss'       => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'rareradio' ),
					'desc'     => wp_kses_data( __( "Select position to move sidebar (if it's not hidden) on the small screen - above or below the content", 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_ss_single'
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'rareradio' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'rareradio' ) ),
					'std'        => 390,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'rareradio' ) ),
					'std'        => 40,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'rareradio' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'rareradio' ) ),
					'std'        => 0,
					'min'        => 0,
					'max'        => 20,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'rareradio' ),
					'desc'  => '',
					'type'  => RARERADIO_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'rareradio' ) ),
					'std'   => 0,
					'type'  => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'privacy_text' => array(
					"title" => esc_html__("Text with Privacy Policy link", 'rareradio'),
					"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'rareradio') ),
					"std"   => wp_kses( __( 'I agree that my submitted data is being collected and stored.', 'rareradio'), 'rareradio_kses_content' ),
					"type"  => "text"
				),



				// 'Header'
				//---------------------------------------------
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'rareradio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'std'      => 'default',
					'options'  => rareradio_get_list_header_footer_types(),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'rareradio' ), 'rareradio_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => 'header-custom-elementor-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'menu_info'                     => array(
					'title' => esc_html__( 'Main menu', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Select main menu style, position and other parameters', 'rareradio' ) ),
					'type'  => RARERADIO_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_style'                    => array(
					'title'    => esc_html__( 'Menu position', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position of the main menu', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'std'      => 'top',
					'options'  => array(
						'top'   => esc_html__( 'Top', 'rareradio' ),
					),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 0,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'rareradio' ) ),
					'std'   => 1,
					'type'  => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_image'               => array(
					'title'      => esc_html__( 'Menu mobile image', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select menu mobile image', 'rareradio' ) ),
					'dependency' => array(
						'menu_mobile_fullscreen' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'rareradio' ),
					'desc'  => '',
					'type'  => RARERADIO_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'rareradio' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'std'      => 0,
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'rareradio' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'rareradio' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'rareradio' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'rareradio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'rareradio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'rareradio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'rareradio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'rareradio' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),



				// 'Footer'
				//---------------------------------------------
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'rareradio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rareradio' ),
					),
					'std'      => 'default',
					'options'  => rareradio_get_list_header_footer_types(),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'rareradio' ), 'rareradio_kses_content' ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rareradio' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => 'footer-custom-elementor-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rareradio' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rareradio' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => rareradio_get_list_range( 0, 4 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'rareradio' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'rareradio' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'rareradio' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'rareradio' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'rareradio' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! rareradio_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'rareradio' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'AncoraThemes &copy; {Y}. All rights reserved.', 'rareradio' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),



				// 'Mobile version'
				//---------------------------------------------
				'mobile'                        => array(
					'title'    => esc_html__( 'Mobile', 'rareradio' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 55,
					'type'     => 'section',
				),

				'mobile_header_info'            => array(
					'title' => esc_html__( 'Header on the mobile device', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_mobile'            => array(
					'title'    => esc_html__( 'Header style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => rareradio_get_list_header_footer_types( true ),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_mobile'           => array(
					'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'rareradio' ), 'rareradio_kses_content' ),
					'dependency' => array(
						'header_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_mobile'        => array(
					'title'    => esc_html__( 'Header position', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_sidebar_info'           => array(
					'title' => esc_html__( 'Sidebar on the mobile device', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_mobile'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on mobile devices', 'rareradio' ) ),
					'dependency' => array(
						'sidebar_position_mobile' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_mobile'         => array(
					'title'   => esc_html__( 'Expand content', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden on mobile devices', 'rareradio' ) ),
					'refresh' => false,
					'dependency' => array(
						'sidebar_position_mobile' => array( 'hide', 'inherit' ),
					),
					'std'     => 'inherit',
					'options'  => rareradio_get_list_checkbox_values( true ),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'mobile_footer_info'           => array(
					'title' => esc_html__( 'Footer on the mobile device', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'footer_type_mobile'           => array(
					'title'    => esc_html__( 'Footer style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use on mobile devices: the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => rareradio_get_list_header_footer_types( true ),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style_mobile'          => array(
					'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
					'desc'       => wp_kses( __( 'Select custom footer from Layouts Builder', 'rareradio' ), 'rareradio_kses_content' ),
					'dependency' => array(
						'footer_type_mobile' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets_mobile'        => array(
					'title'      => esc_html__( 'Footer widgets', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'rareradio' ) ),
					'dependency' => array(
						'footer_type_mobile' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns_mobile'        => array(
					'title'      => esc_html__( 'Footer columns', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'rareradio' ) ),
					'dependency' => array(
						'footer_type_mobile'    => array( 'default' ),
						'footer_widgets_mobile' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => rareradio_get_list_range( 0, 6 ),
					'type'       => 'select',
				),



				// 'Blog'
				//---------------------------------------------
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'rareradio' ) ),
					'priority' => 70,
					'type'     => 'panel',
				),


				// Blog - Posts page
				//---------------------------------------------
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'rareradio' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'rareradio' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'rareradio' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'rareradio' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'rareradio' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'rareradio' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'rareradio' ),
						'fullpost' => esc_html__( 'Full post', 'rareradio' ),
					),
					'type'       => 'switch',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'rareradio' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 43,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'rareradio' ) ),
					'std'     => 2,
					'options' => rareradio_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'rareradio' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => esc_html__( 'Page numbers', 'rareradio' ),
						'links'    => esc_html__( 'Older/Newest', 'rareradio' ),
						'more'     => esc_html__( 'Load more', 'rareradio' ),
						'infinite' => esc_html__( 'Infinite scroll', 'rareradio' ),
					),
					'type'       => 'select',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Post animation', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => '',
					'options'    => array(),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style'     => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => rareradio_get_list_header_footer_types( true ),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'rareradio' ), 'rareradio_kses_content' ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_blog'         => array(
					'title'   => esc_html__( 'Sidebar position', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar', 'rareradio' ) ),
					'std'     => 'right',
					'options' => array(),
					'qsetup'     => esc_html__( 'General', 'rareradio' ),
					'type'    => 'switch',
				),
				'sidebar_position_ss_blog'  => array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'rareradio' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'      => 'inherit',
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'rareradio' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'rareradio' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'rareradio' ) ),
					'refresh' => false,
					'std'     => 'inherit',
					'options'  => rareradio_get_list_checkbox_values( true ),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'rareradio' ),
					'desc'  => wp_kses_data( __( "Select or upload an image used as placeholder for posts without a featured image. Placeholder is used on the blog stream page only (no placeholder in single post), and only in those styles of it where non-using featured image doesn't seem appropriate.", 'rareradio' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'rareradio' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'rareradio' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'rareradio' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'rareradio' ),
					),
					'type'    => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'rareradio' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'rareradio' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=1|views=0|likes=0|comments=0|author=0|share=0|edit=0',
					'options'    => rareradio_get_list_meta_parts(),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checklist',
				),


				// Blog - Single posts
				//---------------------------------------------
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'rareradio' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_single'            => array(
					'title'    => esc_html__( 'Header style', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => rareradio_get_list_header_footer_types( true ),
					'type'     => RARERADIO_THEME_FREE || ! rareradio_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_single'           => array(
					'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
					'desc'       => wp_kses( __( 'Select custom header from Layouts Builder', 'rareradio' ), 'rareradio_kses_content' ),
					'dependency' => array(
						'header_type_single' => array( 'custom' ),
					),
					'std'        => 'inherit',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_single'        => array(
					'title'    => esc_html__( 'Header position', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'rareradio' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'rareradio' ) ),
					'std'     => 'hide',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'options' => array(),
					'type'    => 'switch',
				),
				'sidebar_position_ss_single'=> array(
					'title'    => esc_html__( 'Sidebar position on the small screen', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select position to move sidebar on the single posts on the small screen - above or below the content', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'rareradio' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_single'           => array(
					'title'   => esc_html__( 'Expand content', 'rareradio' ),
					'desc'    => wp_kses_data( __( 'Expand the content width on the single posts if the sidebar is hidden', 'rareradio' ) ),
					'refresh' => false,
					'std'     => '1',
					'options'  => rareradio_get_list_checkbox_values( true ),
					'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),

				'blog_single_title_info'      => array(
					'title' => esc_html__( 'Featured image and title', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'hide_featured_on_single'       => array(
					'title'    => esc_html__( 'Hide featured image on the single post', 'rareradio' ),
					'desc'     => wp_kses_data( __( "Hide featured image on the single post's pages", 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page,post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'post_thumbnail_type'      => array(
					'title'      => esc_html__( 'Type of post thumbnail', 'rareradio' ),
					'desc'       => wp_kses_data( __( "Select type of post thumbnail on the single post's pages", 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 ),
					),
					'std'        => 'boxed',
					'options'    => array(
						'fullwidth'   => esc_html__( 'Fullwidth', 'rareradio' ),
						'boxed'       => esc_html__( 'Boxed', 'rareradio' ),
						'default'     => esc_html__( 'Default', 'rareradio' ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_position'          => array(
					'title'      => esc_html__( 'Post header position', 'rareradio' ),
					'desc'       => wp_kses_data( __( "Select post header position on the single post's pages", 'rareradio' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 )
					),
					'std'        => 'under',
					'options'    => array(
						'above'      => esc_html__( 'Above the post thumbnail', 'rareradio' ),
						'under'      => esc_html__( 'Under the post thumbnail', 'rareradio' ),
						'default'    => esc_html__( 'Default', 'rareradio' ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_align'             => array(
					'title'      => esc_html__( 'Align of the post header', 'rareradio' ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'post_header_position' => array( 'on_thumb' ),
					),
					'std'        => 'mc',
					'options'    => array(
						'ts' => esc_html__('Top Stick Out', 'rareradio'),
						'tl' => esc_html__('Top Left', 'rareradio'),
						'tc' => esc_html__('Top Center', 'rareradio'),
						'tr' => esc_html__('Top Right', 'rareradio'),
						'ml' => esc_html__('Middle Left', 'rareradio'),
						'mc' => esc_html__('Middle Center', 'rareradio'),
						'mr' => esc_html__('Middle Right', 'rareradio'),
						'bl' => esc_html__('Bottom Left', 'rareradio'),
						'bc' => esc_html__('Bottom Center', 'rareradio'),
						'br' => esc_html__('Bottom Right', 'rareradio'),
						'bs' => esc_html__('Bottom Stick Out', 'rareradio'),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'rareradio' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'rareradio' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'rareradio' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),
				'meta_parts_single'             => array(
					'title'      => esc_html__( 'Post meta', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'rareradio' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'rareradio' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=1|date=0|views=0|likes=0|comments=1|author=1|share=0|edit=0',
					'options'    => rareradio_get_list_meta_parts(),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'rareradio' ) ),
					'std'   => 1,
					'type'  => ! rareradio_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'rareradio' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'rareradio' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'rareradio' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'rareradio' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'std'      => 1,
					'type'     => 'checkbox',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'classic',
					'options'    => array(
						'classic' => esc_html__( 'Classic', 'rareradio' ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'inside'        => esc_html__( 'Inside the content (fullwidth)', 'rareradio' ),
						'inside_left'   => esc_html__( 'At left side of the content', 'rareradio' ),
						'inside_right'  => esc_html__( 'At right side of the content', 'rareradio' ),
						'below_content' => esc_html__( 'After the content', 'rareradio' ),
						'below_page'    => esc_html__( 'After the content & sidebar', 'rareradio' ),
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'related_position_inside'       => array(
					'title'      => esc_html__( 'Before # paragraph', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Before what paragraph should related posts appear? If 0 - randomly.', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'inside_left', 'inside_right' ),
					),
					'std'        => 2,
					'options'    => rareradio_get_list_range( 0, 9 ),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 3,
					'min'        => 1,
					'max'        => 9,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'slider',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page?', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_position' => array( 'inside', 'below_content', 'below_page' ),
					),
					'std'        => 3,
					'options'    => rareradio_get_list_range( 1, 3 ),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider'                => array(
					'title'      => esc_html__( 'Use slider layout', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Use slider layout in case related posts count is more than columns count', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 0,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'related_slider_controls'       => array(
					'title'      => esc_html__( 'Slider controls', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Show arrows in the slider', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'none',
					'options'    => array(
						'none'    => esc_html__('None', 'rareradio'),
						'side'    => esc_html__('Side', 'rareradio'),
						'outside' => esc_html__('Outside', 'rareradio'),
						'top'     => esc_html__('Top', 'rareradio'),
						'bottom'  => esc_html__('Bottom', 'rareradio')
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
				),
				'related_slider_pagination'       => array(
					'title'      => esc_html__( 'Slider pagination', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Show bullets after the slider', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 'bottom',
					'options'    => array(
						'none'    => esc_html__('None', 'rareradio'),
						'bottom'  => esc_html__('Bottom', 'rareradio')
					),
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_slider_space'          => array(
					'title'      => esc_html__( 'Space', 'rareradio' ),
					'desc'       => wp_kses_data( __( 'Space between slides', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'rareradio' ),
					),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
						'related_slider' => array( 1 ),
					),
					'std'        => 30,
					'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'text',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),



				// 'Colors'
				//---------------------------------------------
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'rareradio' ),
					'desc'     => '',
					'priority' => 300,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'rareradio' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'rareradio' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'rareradio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rareradio' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'rareradio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rareradio' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'rareradio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rareradio' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'rareradio' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'rareradio' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'rareradio' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'rareradio' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'rareradio' ),
					'desc'        => '',
					'std'         => '$rareradio_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Use huge priority to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);



		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			//---------------------------------------------
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'rareradio' ),
				'desc'     => '',
				'priority' => 200,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'rareradio' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'rareradio' ) )
						. '<br>'
						. wp_kses_data( __( 'Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'rareradio' ) ),
				'type'  => 'section',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'rareradio' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'rareradio' ) )
						. '<br>'
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'rareradio' ) ),
				'class'   => 'rareradio_column-1_3 rareradio_new_row',
				'refresh' => false,
				'std'     => '$rareradio_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= rareradio_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( rareradio_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( __( 'Font %s', 'rareradio' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'rareradio' ),
				'desc'    => '',
				'class'   => 'rareradio_column-1_3 rareradio_new_row',
				'refresh' => false,
				'std'     => '$rareradio_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'rareradio' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'rareradio' ) )
							: '',
				'class'   => 'rareradio_column-1_3',
				'refresh' => false,
				'std'     => '$rareradio_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'rareradio' ),
					'serif'      => esc_html__( 'serif', 'rareradio' ),
					'sans-serif' => esc_html__( 'sans-serif', 'rareradio' ),
					'monospace'  => esc_html__( 'monospace', 'rareradio' ),
					'cursive'    => esc_html__( 'cursive', 'rareradio' ),
					'fantasy'    => esc_html__( 'fantasy', 'rareradio' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'rareradio' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'rareradio' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'rareradio' ) )
							: '',
				'class'   => 'rareradio_column-1_3',
				'refresh' => false,
				'std'     => '$rareradio_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = rareradio_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( __( '%s settings', 'rareradio' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses( sprintf( __( 'Font settings of the "%s" tag.', 'rareradio' ), $tag ), 'rareradio_kses_content' ),
				'type'  => 'section',
			);

			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				// Skip property 'text-decoration' for the main text
				if ( 'text-decoration' == $css_prop && 'p' == $tag ) {
					continue;
				}

				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'rareradio' ),
						'100'     => esc_html__( '100 (Light)', 'rareradio' ),
						'200'     => esc_html__( '200 (Light)', 'rareradio' ),
						'300'     => esc_html__( '300 (Thin)', 'rareradio' ),
						'400'     => esc_html__( '400 (Normal)', 'rareradio' ),
						'500'     => esc_html__( '500 (Semibold)', 'rareradio' ),
						'600'     => esc_html__( '600 (Semibold)', 'rareradio' ),
						'700'     => esc_html__( '700 (Bold)', 'rareradio' ),
						'800'     => esc_html__( '800 (Black)', 'rareradio' ),
						'900'     => esc_html__( '900 (Black)', 'rareradio' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'rareradio' ),
						'normal'  => esc_html__( 'Normal', 'rareradio' ),
						'italic'  => esc_html__( 'Italic', 'rareradio' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'rareradio' ),
						'none'         => esc_html__( 'None', 'rareradio' ),
						'underline'    => esc_html__( 'Underline', 'rareradio' ),
						'overline'     => esc_html__( 'Overline', 'rareradio' ),
						'line-through' => esc_html__( 'Line-through', 'rareradio' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'rareradio' ),
						'none'       => esc_html__( 'None', 'rareradio' ),
						'uppercase'  => esc_html__( 'Uppercase', 'rareradio' ),
						'lowercase'  => esc_html__( 'Lowercase', 'rareradio' ),
						'capitalize' => esc_html__( 'Capitalize', 'rareradio' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'class'      => 'rareradio_column-1_5',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$rareradio_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		rareradio_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			rareradio_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'rareradio' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'rareradio' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! rareradio_check_url( 'customize.php' ) ) {
			rareradio_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'rareradio' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'rareradio' ) ),
					'class'    => 'rareradio_column-1_2 rareradio_new_row',
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'rareradio' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'rareradio_options_get_list_cpt_options' ) ) {
	function rareradio_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'rareradio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'rareradio' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'rareradio' ) ),
				'std'      => 'inherit',
				'options'  => rareradio_get_list_body_styles( true ),
				'type'     => 'select',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'rareradio' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'rareradio' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'rareradio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'rareradio' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
				'std'     => 'inherit',
				'options' => rareradio_get_list_header_footer_types( true ),
				'type'    => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select custom layout to display the site header on the %s pages', 'rareradio' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'rareradio' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to display the site header on the %s pages', 'rareradio' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'rareradio' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'rareradio' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'rareradio' ),
					1         => esc_html__( 'Yes', 'rareradio' ),
					0         => esc_html__( 'No', 'rareradio' ),
				),
				'type'    => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'rareradio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				'title'   => sprintf( __( 'Sidebar position on the %s list', 'rareradio' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the %s list', 'rareradio' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_{$cpt}"=> array(
				'title'    => sprintf( __( 'Sidebar position on the %s list on the small screen', 'rareradio' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'rareradio' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_{$cpt}"        => array(
				'title'      => sprintf( esc_html__( 'Sidebar widgets on the %s list', 'rareradio' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select sidebar to show on the %s list', 'rareradio' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => sprintf( __( 'Sidebar position on the single post', 'rareradio' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( __( 'Select position to show sidebar on the single posts of the %s', 'rareradio' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_ss_single_{$cpt}"=> array(
				'title'    => esc_html__( 'Sidebar position on the single post on the small screen', 'rareradio' ),
				'desc'     => wp_kses_data( __( 'Select position to move sidebar on the small screen - above or below the content', 'rareradio' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => sprintf( esc_html__( 'Sidebar widgets on the single post', 'rareradio' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( __( 'Select widgets to show in the sidebar on the single posts of the %s', 'rareradio' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content', 'rareradio' ),
				'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'rareradio' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => rareradio_get_list_checkbox_values( true ),
				'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
			),
			"expand_content_single_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content on the single post', 'rareradio' ),
				'desc'    => wp_kses_data( __( 'Expand the content width on the single post if the sidebar is hidden', 'rareradio' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options'  => rareradio_get_list_checkbox_values( true ),
				'type'     => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'rareradio' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'rareradio' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'rareradio' ) ),
				'std'     => 'inherit',
				'options' => rareradio_get_list_header_footer_types( true ),
				'type'    => RARERADIO_THEME_FREE ? 'hidden' : 'switch',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'rareradio' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'rareradio' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => RARERADIO_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'rareradio' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'rareradio' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'rareradio' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'rareradio' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => rareradio_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'rareradio' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'rareradio' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'checkbox',
			),
			
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'rareradio_options_get_list_choises' ) ) {
	add_filter( 'rareradio_filter_options_get_list_choises', 'rareradio_options_get_list_choises', 10, 2 );
	function rareradio_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = rareradio_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = rareradio_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = rareradio_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = rareradio_get_list_schemes( 'color_scheme' != $id );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = rareradio_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_ss' ) === 0 ) {
				$list = rareradio_get_list_sidebars_positions_ss( strpos( $id, 'sidebar_position_ss_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = rareradio_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = rareradio_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = rareradio_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = rareradio_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = rareradio_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = rareradio_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = rareradio_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = rareradio_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = rareradio_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = rareradio_array_merge( array( 0 => esc_html__( '- Select category -', 'rareradio' ) ), rareradio_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = rareradio_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = rareradio_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = rareradio_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}
