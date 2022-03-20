<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if ( ! function_exists( 'rareradio_woocommerce_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'rareradio_woocommerce_theme_setup1', 1 );
	function rareradio_woocommerce_theme_setup1() {

		// Theme-specific parameters for WooCommerce
		add_theme_support(
			'woocommerce', array(
				'product_grid' => array( 'max_columns' => 6 ),
				// Image width for thumbnails gallery
				'gallery_thumbnail_image_width' => 150,

												// Image width for the catalog images
												// Attention! If you set this parameter - WooCommerce hide relative control from Customizer
												'thumbnail_image_width' => 600,

												// Image width for the single product image
												// Attention! If you set this parameter - WooCommerce hide relative control from Customizer
												
			)
		);

		// Next setting from the WooCommerce 3.0+ enable built-in image zoom on the single product page
		add_theme_support( 'wc-product-gallery-zoom' );

		// Next setting from the WooCommerce 3.0+ enable built-in image slider on the single product page
		add_theme_support( 'wc-product-gallery-slider' );

		// Next setting from the WooCommerce 3.0+ enable built-in image lightbox on the single product page
		add_theme_support( 'wc-product-gallery-lightbox' );

		add_filter( 'rareradio_filter_list_sidebars', 'rareradio_woocommerce_list_sidebars' );
		add_filter( 'rareradio_filter_list_posts_types', 'rareradio_woocommerce_list_post_types' );

		// Detect if WooCommerce support 'Product Grid' feature
		$product_grid = rareradio_exists_woocommerce() && function_exists( 'wc_get_theme_support' ) ? wc_get_theme_support( 'product_grid' ) : false;
		add_theme_support( 'wc-product-grid-enable', isset( $product_grid['min_columns'] ) && isset( $product_grid['max_columns'] ) );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'rareradio_woocommerce_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'rareradio_woocommerce_theme_setup3', 3 );
	function rareradio_woocommerce_theme_setup3() {
		if ( rareradio_exists_woocommerce() ) {

			// Section 'WooCommerce'
			rareradio_storage_set_array_before(
				'options', 'fonts', array_merge(
					array(
						'shop'               => array(
							'title'      => esc_html__( 'Shop', 'rareradio' ),
							'desc'       => wp_kses_data( __( 'Select theme-specific parameters to display the shop pages', 'rareradio' ) ),
							'priority'   => 80,
							'expand_url' => esc_url( rareradio_woocommerce_get_shop_page_link() ),
							'type'       => 'section',
						),

						'products_info_shop' => array(
							'title'  => esc_html__( 'Products list', 'rareradio' ),
							'desc'   => '',
							'qsetup' => esc_html__( 'General', 'rareradio' ),
							'type'   => 'info',
						),
						'shop_mode'          => array(
							'title'   => esc_html__( 'Shop style', 'rareradio' ),
							'desc'    => wp_kses_data( __( 'Select style for the products list. Attention! If the visitor has already selected the list type at the top of the page - his choice is remembered and has priority over this option', 'rareradio' ) ),
							'std'     => 'thumbs',
							'options' => array(
								'thumbs' => esc_html__( 'Grid', 'rareradio' ),
								'list'   => esc_html__( 'List', 'rareradio' ),
							),
							'qsetup'  => esc_html__( 'General', 'rareradio' ),
							'type'    => 'select',
						),
					),
					! get_theme_support( 'wc-product-grid-enable' )
					? array(
						'posts_per_page_shop' => array(
							'title' => esc_html__( 'Products per page', 'rareradio' ),
							'desc'  => wp_kses_data( __( 'How many products should be displayed on the shop page. If empty - use global value from the menu Settings - Reading', 'rareradio' ) ),
							'std'   => '',
							'type'  => 'text',
						),
						'blog_columns_shop'   => array(
							'title'      => esc_html__( 'Grid columns', 'rareradio' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used for the shop products in the grid view (from 2 to 4)?', 'rareradio' ) ),
							'dependency' => array(
								'shop_mode' => array( 'thumbs' ),
							),
							'std'        => 2,
							'options'    => rareradio_get_list_range( 2, 4 ),
							'type'       => 'select',
						),
					)
					: array(),
					array(
						'blog_animation_shop' => array(
							'title' => esc_html__( 'Products animation on the shop page', 'rareradio' ),
							'desc' => wp_kses_data( __( 'Select animation to show products on the shop page. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour!', 'rareradio' ) ),
							'std' => 'none',
							'options' => array(),
							'type' => 'select',
						),
						'shop_hover'              => array(
							'title'   => esc_html__( 'Hover style', 'rareradio' ),
							'desc'    => wp_kses_data( __( 'Hover style on the products in the shop archive', 'rareradio' ) ),
							'std'     => 'shop_buttons',
							'options' => apply_filters(
								'rareradio_filter_shop_hover', array(
									'none'         => esc_html__( 'None', 'rareradio' ),
									'shop'         => esc_html__( 'Icons', 'rareradio' ),
									'shop_buttons' => esc_html__( 'Button', 'rareradio' ),
								)
							),
							'qsetup'  => esc_html__( 'General', 'rareradio' ),
							'type'    => 'select',
						),
						'shop_pagination'         => array(
							'title'   => esc_html__( 'Pagination style', 'rareradio' ),
							'desc'    => wp_kses_data( __( 'Pagination style in the shop archive', 'rareradio' ) ),
							'std'     => 'numbers',
							'options' => apply_filters(
								'rareradio_filter_shop_pagination', array(
									'pages'    => esc_html__( 'Page numbers', 'rareradio' ),
									'more'     => esc_html__( 'Load more', 'rareradio' ),
									'infinite' => esc_html__( 'Infinite scroll', 'rareradio' ),
								)
							),
							'qsetup'  => esc_html__( 'General', 'rareradio' ),
							'type'    => 'select',
						),

						'single_info_shop'        => array(
							'title' => esc_html__( 'Single product', 'rareradio' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'single_product_layout'      => array(
							'title'      => esc_html__( 'Layout of the single product', 'rareradio' ),
							'desc'       => wp_kses_data( __( 'Select layout of the single products page', 'rareradio' ) ),
							'std'        => 'default',
							'override' => array(
								'mode'    => 'product',
								'section' => esc_html__( 'Content', 'rareradio' ),
							),
							'options'    => apply_filters(
															'rareradio_filter_woocommerce_single_product_layouts',
															array(
																'default'   => esc_html__( 'Default', 'rareradio' ),
																'stretched' => esc_html__( 'Stretched', 'rareradio' ),
															)
														),
							'type'       => 'select',
						),
						'show_related_posts_shop' => array(
							'title'  => esc_html__( 'Show related products', 'rareradio' ),
							'desc'   => wp_kses_data( __( "Show section 'Related products' on the single product page", 'rareradio' ) ),
							'std'    => 1,
							'type'   => 'checkbox',
						),
						'related_posts_shop'      => array(
							'title'      => esc_html__( 'Related products', 'rareradio' ),
							'desc'       => wp_kses_data( __( 'How many related products should be displayed on the single product page?', 'rareradio' ) ),
							'dependency' => array(
								'show_related_posts_shop' => array( 1 ),
							),
							'std'        => 4,
							'options'    => rareradio_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_shop'    => array(
							'title'      => esc_html__( 'Related columns', 'rareradio' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related products on the single product page?', 'rareradio' ) ),
							'dependency' => array(
								'show_related_posts_shop' => array( 1 ),
							),
							'std'        => 4,
							'options'    => rareradio_get_list_range( 1, 4 ),
							'type'       => 'select',
						),
					),
					rareradio_options_get_list_cpt_options( 'shop' )
				)
			);
		}
	}
}


// Move section 'Shop' inside the section 'WooCommerce' in the Customizer (if WooCommerce 3.3+ is installed)
if ( ! function_exists( 'rareradio_woocommerce_customizer_register_controls' ) ) {
	add_action( 'customize_register', 'rareradio_woocommerce_customizer_register_controls', 100 );
	function rareradio_woocommerce_customizer_register_controls( $wp_customize ) {
		if ( rareradio_exists_woocommerce() ) {
			$panel = $wp_customize->get_panel( 'woocommerce' );
			$sec   = $wp_customize->get_section( 'shop' );
			if ( is_object( $panel ) && is_object( $sec ) ) {
				$sec->panel    = 'woocommerce';
				$sec->title    = esc_html__( 'Theme-specific options', 'rareradio' );
				$sec->priority = 100;
			}
		}
	}
}


// Set theme-specific default columns number in the new WooCommerce after switch theme
if ( ! function_exists( 'rareradio_woocommerce_action_switch_theme' ) ) {
	add_action( 'after_switch_theme', 'rareradio_woocommerce_action_switch_theme' );
	function rareradio_woocommerce_action_switch_theme() {
		if ( rareradio_exists_woocommerce() ) {
			update_option( 'woocommerce_catalog_columns', apply_filters( 'rareradio_filter_woocommerce_columns', 2 ) );
		}
	}
}

// Set theme-specific default columns number in the new WooCommerce after plugin activation
if ( ! function_exists( 'rareradio_woocommerce_action_activated_plugin' ) ) {
	add_action( 'activated_plugin', 'rareradio_woocommerce_action_activated_plugin', 10, 2 );
	function rareradio_woocommerce_action_activated_plugin( $plugin, $network_activation ) {
		if ( 'woocommerce/woocommerce.php' == $plugin ) {
			update_option( 'woocommerce_catalog_columns', apply_filters( 'rareradio_filter_woocommerce_columns', 2 ) );
		}
	}
}



// Check if override options is allowed
if ( ! function_exists( 'rareradio_woocommerce_allow_override_options' ) ) {
	if ( ! RARERADIO_THEME_FREE ) {
		add_filter( 'rareradio_filter_allow_override_options', 'rareradio_woocommerce_allow_override_options', 10, 2);
	}
	function rareradio_woocommerce_allow_override_options( $allow, $post_type ) {
		return $allow || 'product' == $post_type;
	}
}


// Add section 'Products' to the Front Page option
if ( ! function_exists( 'rareradio_woocommerce_front_page_options' ) ) {
	if ( ! RARERADIO_THEME_FREE ) {
		add_filter( 'rareradio_filter_front_page_options', 'rareradio_woocommerce_front_page_options' );
	}
	function rareradio_woocommerce_front_page_options( $options ) {
		if ( rareradio_exists_woocommerce() ) {

			$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'woocommerce=1';
			$options['front_page_sections']['options'] = array_merge(
				$options['front_page_sections']['options'],
				array(
					'woocommerce' => esc_html__( 'Products', 'rareradio' ),
				)
			);
			$options                                   = array_merge(
				$options, array(

					// Front Page Sections - WooCommerce
					'front_page_woocommerce'               => array(
						'title'    => esc_html__( 'Products', 'rareradio' ),
						'desc'     => '',
						'priority' => 200,
						'type'     => 'section',
					),
					'front_page_woocommerce_layout_info'   => array(
						'title' => esc_html__( 'Layout', 'rareradio' ),
						'desc'  => '',
						'type'  => 'info',
					),
					'front_page_woocommerce_fullheight'    => array(
						'title'   => esc_html__( 'Full height', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'rareradio' ) ),
						'std'     => 0,
						'refresh' => false,
						'type'    => 'checkbox',
					),
					'front_page_woocommerce_stack'         => array(
						'title'      => esc_html__( 'Stack this section', 'rareradio' ),
						'desc'       => wp_kses_data( __( 'Add the behavior of "a stack" for this section to fix it when you scroll to the top of the screen.', 'rareradio' ) ),
						'std'        => 0,
						'refresh'    => false,
						'dependency' => array(
							'front_page_woocommerce_fullheight' => array( 1 ),
						),
						'type'       => 'checkbox',
					),
					'front_page_woocommerce_paddings'      => array(
						'title'   => esc_html__( 'Paddings', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'rareradio' ) ),
						'std'     => 'medium',
						'options' => rareradio_get_list_paddings(),
						'refresh' => false,
						'type'    => 'switch',
					),
					'front_page_woocommerce_heading_info'  => array(
						'title' => esc_html__( 'Title', 'rareradio' ),
						'desc'  => '',
						'type'  => 'info',
					),
					'front_page_woocommerce_caption'       => array(
						'title'   => esc_html__( 'Section title', 'rareradio' ),
						'desc'    => '',
						'refresh' => false, 
						'std'     => wp_kses_data( __( 'This text can be changed in the section "Products"', 'rareradio' ) ),
						'type'    => 'text',
					),
					'front_page_woocommerce_description'   => array(
						'title'   => esc_html__( 'Description', 'rareradio' ),
						'desc'    => wp_kses_data( __( "Short description after the section's title", 'rareradio' ) ),
						'refresh' => false, 
						'std'     => wp_kses_data( __( 'This text can be changed in the section "Products"', 'rareradio' ) ),
						'type'    => 'textarea',
					),
					'front_page_woocommerce_products_info' => array(
						'title' => esc_html__( 'Products parameters', 'rareradio' ),
						'desc'  => '',
						'type'  => 'info',
					),
					'front_page_woocommerce_products'      => array(
						'title'   => esc_html__( 'Type of the products', 'rareradio' ),
						'desc'    => '',
						'std'     => 'products',
						'options' => array(
							'recent_products'       => esc_html__( 'Recent products', 'rareradio' ),
							'featured_products'     => esc_html__( 'Featured products', 'rareradio' ),
							'top_rated_products'    => esc_html__( 'Top rated products', 'rareradio' ),
							'sale_products'         => esc_html__( 'Sale products', 'rareradio' ),
							'best_selling_products' => esc_html__( 'Best selling products', 'rareradio' ),
							'product_category'      => esc_html__( 'Products from categories', 'rareradio' ),
							'products'              => esc_html__( 'Products by IDs', 'rareradio' ),
						),
						'type'    => 'select',
					),
					'front_page_woocommerce_products_categories' => array(
						'title'      => esc_html__( 'Categories', 'rareradio' ),
						'desc'       => esc_html__( 'Comma separated category slugs. Used only with "Products from categories"', 'rareradio' ),
						'dependency' => array(
							'front_page_woocommerce_products' => array( 'product_category' ),
						),
						'std'        => '',
						'type'       => 'text',
					),
					'front_page_woocommerce_products_per_page' => array(
						'title' => esc_html__( 'Per page', 'rareradio' ),
						'desc'  => wp_kses_data( __( 'How many products will be displayed on the page. Attention! For "Products by IDs" specify comma separated list of the IDs', 'rareradio' ) ),
						'std'   => 3,
						'type'  => 'text',
					),
					'front_page_woocommerce_products_columns' => array(
						'title' => esc_html__( 'Columns', 'rareradio' ),
						'desc'  => wp_kses_data( __( 'How many columns will be used', 'rareradio' ) ),
						'std'   => 3,
						'type'  => 'text',
					),
					'front_page_woocommerce_products_orderby' => array(
						'title'   => esc_html__( 'Order by', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Not used with Best selling products', 'rareradio' ) ),
						'std'     => 'date',
						'options' => array(
							'date'  => esc_html__( 'Date', 'rareradio' ),
							'title' => esc_html__( 'Title', 'rareradio' ),
						),
						'type'    => 'switch',
					),
					'front_page_woocommerce_products_order' => array(
						'title'   => esc_html__( 'Order', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Not used with Best selling products', 'rareradio' ) ),
						'std'     => 'desc',
						'options' => array(
							'asc'  => esc_html__( 'Ascending', 'rareradio' ),
							'desc' => esc_html__( 'Descending', 'rareradio' ),
						),
						'type'    => 'switch',
					),
					'front_page_woocommerce_color_info'    => array(
						'title' => esc_html__( 'Colors and images', 'rareradio' ),
						'desc'  => '',
						'type'  => 'info',
					),
					'front_page_woocommerce_scheme'        => array(
						'title'   => esc_html__( 'Color scheme', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Color scheme for this section', 'rareradio' ) ),
						'std'     => 'inherit',
						'options' => array(),
						'refresh' => false,
						'type'    => 'switch',
					),
					'front_page_woocommerce_bg_image'      => array(
						'title'           => esc_html__( 'Background image', 'rareradio' ),
						'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'rareradio' ) ),
						'refresh'         => '.front_page_section_woocommerce',
						'refresh_wrapper' => true,
						'std'             => '',
						'type'            => 'image',
					),
					'front_page_woocommerce_bg_color_type'  => array(
						'title'   => esc_html__( 'Background color', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Background color for this section', 'rareradio' ) ),
						'std'     => RARERADIO_THEME_FREE ? 'custom' : 'none',
						'refresh' => false,
						'options' => array(
							'none'            => esc_html__( 'None', 'rareradio' ),
							'scheme_bg_color' => esc_html__( 'Scheme bg color', 'rareradio' ),
							'custom'          => esc_html__( 'Custom', 'rareradio' ),
						),
						'type'    => 'switch',
					),
					'front_page_woocommerce_bg_color'       => array(
						'title'      => esc_html__( 'Custom color', 'rareradio' ),
						'desc'       => wp_kses_data( __( 'Custom background color for this section', 'rareradio' ) ),
						'std'        => RARERADIO_THEME_FREE ? '#000' : '',
						'refresh'    => false,
						'dependency' => array(
							'front_page_woocommerce_bg_color_type' => array( 'custom' ),
						),
						'type'       => 'color',
					),
					'front_page_woocommerce_bg_mask'       => array(
						'title'   => esc_html__( 'Background mask', 'rareradio' ),
						'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not used', 'rareradio' ) ),
						'std'     => 1,
						'max'     => 1,
						'step'    => 0.1,
						'refresh' => false,
						'type'    => 'slider',
					),
					'front_page_woocommerce_anchor_info'   => array(
						'title' => esc_html__( 'Anchor', 'rareradio' ),
						'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu".', 'rareradio' ) )
									. '<br>'
									. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'rareradio' ) ),
						'type'  => 'info',
					),
					'front_page_woocommerce_anchor_icon'   => array(
						'title' => esc_html__( 'Anchor icon', 'rareradio' ),
						'desc'  => '',
						'std'   => '',
						'type'  => 'icon',
					),
					'front_page_woocommerce_anchor_text'   => array(
						'title' => esc_html__( 'Anchor text', 'rareradio' ),
						'desc'  => '',
						'std'   => '',
						'type'  => 'text',
					),
				)
			);
		}
		return $options;
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_woocommerce_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_woocommerce_theme_setup9', 9 );
	function rareradio_woocommerce_theme_setup9() {
		if ( rareradio_exists_woocommerce() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_woocommerce_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'rareradio_woocommerce_responsive_styles', 2000 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_woocommerce_merge_styles' );
			add_filter( 'rareradio_filter_merge_styles_responsive', 'rareradio_woocommerce_merge_styles_responsive' );
			add_filter( 'rareradio_filter_merge_scripts', 'rareradio_woocommerce_merge_scripts' );
			add_filter( 'rareradio_filter_get_post_info', 'rareradio_woocommerce_get_post_info' );
			add_filter( 'rareradio_filter_post_type_taxonomy', 'rareradio_woocommerce_post_type_taxonomy', 10, 2 );
			add_action( 'rareradio_action_override_theme_options', 'rareradio_woocommerce_override_theme_options' );
			if ( ! is_admin() ) {
				add_filter( 'rareradio_filter_detect_blog_mode', 'rareradio_woocommerce_detect_blog_mode' );
				add_filter( 'rareradio_filter_get_post_categories', 'rareradio_woocommerce_get_post_categories' );
				add_filter( 'rareradio_filter_allow_override_header_image', 'rareradio_woocommerce_allow_override_header_image' );
				add_filter( 'rareradio_filter_get_blog_title', 'rareradio_woocommerce_get_blog_title' );
				add_action( 'rareradio_action_before_post_meta', 'rareradio_woocommerce_action_before_post_meta' );
				add_action( 'pre_get_posts', 'rareradio_woocommerce_pre_get_posts' );
				add_filter( 'rareradio_filter_sidebar_control_text', 'rareradio_woocommerce_sidebar_control_text' );
				add_filter( 'rareradio_filter_sidebar_control_title', 'rareradio_woocommerce_sidebar_control_title' );
			}
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_woocommerce_tgmpa_required_plugins' );
		}

		// Add wrappers and classes to the standard WooCommerce output
		if ( rareradio_exists_woocommerce() ) {

			// Remove WOOC sidebar
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

			// Remove link around product item
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

			// Add Wishlist button
			if ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) {
				add_action( 'woocommerce_after_shop_loop_item', 'rareradio_woocommerce_add_wishlist_wrap', 19 );
				add_action( 'woocommerce_after_shop_loop_item', 'rareradio_woocommerce_add_wishlist_link', 20 );
			}

			// Remove add_to_cart button
			

			// Remove link around product category
			remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
			remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

			// Detect we are inside subcategory
			add_action( 'woocommerce_before_subcategory', 'rareradio_woocommerce_before_subcategory', 1 );
			add_action( 'woocommerce_after_subcategory', 'rareradio_woocommerce_after_subcategory', 9999 );

			// Open main content wrapper - <article>
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			add_action( 'woocommerce_before_main_content', 'rareradio_woocommerce_wrapper_start', 10 );
			// Close main content wrapper - </article>
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			add_action( 'woocommerce_after_main_content', 'rareradio_woocommerce_wrapper_end', 10 );

			// Close header section
			add_action( 'woocommerce_after_main_content', 'rareradio_woocommerce_archive_description', 1 );
			add_action( 'woocommerce_before_shop_loop', 'rareradio_woocommerce_archive_description', 5 );
			add_action( 'woocommerce_no_products_found', 'rareradio_woocommerce_archive_description', 5 );

			// Add theme specific search form
			add_filter( 'get_product_search_form', 'rareradio_woocommerce_get_product_search_form' );

			// Change text on 'Add to cart' button
			add_filter( 'woocommerce_product_add_to_cart_text', 'rareradio_woocommerce_add_to_cart_text' );
			add_filter( 'woocommerce_product_single_add_to_cart_text', 'rareradio_woocommerce_add_to_cart_text' );

			// Wrap 'Add to cart' button
			add_filter( 'woocommerce_loop_add_to_cart_link', 'rareradio_woocommerce_add_to_cart_link', 10, 3 );

			// Add list mode buttons
			add_action( 'woocommerce_before_shop_loop', 'rareradio_woocommerce_before_shop_loop', 10 );

			// Show 'No products' if no search results and display mode 'both'
			add_action( 'woocommerce_after_shop_loop', 'rareradio_woocommerce_after_shop_loop', 1 );

			// Set columns number for the products loop
			if ( ! get_theme_support( 'wc-product-grid-enable' ) ) {
				add_filter( 'loop_shop_columns', 'rareradio_woocommerce_loop_shop_columns' );
				add_filter( 'post_class', 'rareradio_woocommerce_loop_shop_columns_class' );
				add_filter( 'product_cat_class', 'rareradio_woocommerce_loop_shop_columns_class', 10, 3 );
			}
			// Open product/category item wrapper
			add_action( 'woocommerce_before_subcategory_title', 'rareradio_woocommerce_item_wrapper_start', 9 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'rareradio_woocommerce_item_wrapper_start', 9 );
			// Close featured image wrapper and open title wrapper
			add_action( 'woocommerce_before_subcategory_title', 'rareradio_woocommerce_title_wrapper_start', 20 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'rareradio_woocommerce_title_wrapper_start', 20 );

			// Add tags before title
			add_action( 'woocommerce_before_shop_loop_item_title', 'rareradio_woocommerce_title_tags', 30 );

			// Wrap product title to the link
			add_action( 'the_title', 'rareradio_woocommerce_the_title' );
			// Wrap category title to the link
			// Old way: before WooCommerce 3.2.2
			
			// New way: WooCommerce 3.2.2+
			add_action( 'woocommerce_before_subcategory_title', 'rareradio_woocommerce_before_subcategory_title', 22, 1 );
			add_action( 'woocommerce_after_subcategory_title', 'rareradio_woocommerce_after_subcategory_title', 2, 1 );

			// Close title wrapper and add description in the list mode
			add_action( 'woocommerce_after_shop_loop_item_title', 'rareradio_woocommerce_title_wrapper_end', 7 );
			add_action( 'woocommerce_after_subcategory_title', 'rareradio_woocommerce_title_wrapper_end2', 10 );
			// Close product/category item wrapper
			add_action( 'woocommerce_after_subcategory', 'rareradio_woocommerce_item_wrapper_end', 20 );
			add_action( 'woocommerce_after_shop_loop_item', 'rareradio_woocommerce_item_wrapper_end', 20 );

			// Add product ID into product meta section (after categories and tags)
			add_action( 'woocommerce_product_meta_end', 'rareradio_woocommerce_show_product_id', 10 );

			// Set columns number for the product's thumbnails
			add_filter( 'woocommerce_product_thumbnails_columns', 'rareradio_woocommerce_product_thumbnails_columns' );

			// Wrap price (WooCommerce use priority 10 to output price)
			add_action( 'woocommerce_after_shop_loop_item_title', 'rareradio_woocommerce_price_wrapper_start', 9 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'rareradio_woocommerce_price_wrapper_end', 11 );

			// Decorate price
			add_filter( 'woocommerce_get_price_html', 'rareradio_woocommerce_get_price_html' );

			// Add 'Out of stock' label
			add_action( 'rareradio_action_woocommerce_item_featured_link_start', 'rareradio_woocommerce_add_out_of_stock_label' );

			// Decorate 'Sale' label
			add_filter( 'woocommerce_sale_flash', 'rareradio_woocommerce_add_sale_percent', 10, 3 );

			// Add custom paginations to the loop
			add_action( 'woocommerce_after_shop_loop', 'rareradio_woocommerce_pagination', 9 );

			// Add WooCommerce-specific classes
			add_filter( 'body_class', 'rareradio_woocommerce_add_body_classes' );

			// Detect current shop mode
			if ( ! is_admin() ) {
				$shop_mode = rareradio_get_value_gp( 'shop_mode' );
				if ( empty( $shop_mode ) ) {
					$shop_mode = rareradio_get_value_gpc( 'rareradio_shop_mode' );
				}
				if ( empty( $shop_mode ) && rareradio_check_theme_option( 'shop_mode' ) ) {
					$shop_mode = rareradio_get_theme_option( 'shop_mode' );
				}
				if ( empty( $shop_mode ) ) {
					$shop_mode = 'thumbs';
				}
				rareradio_storage_set( 'shop_mode', $shop_mode );
			}
		}
	}
}

// Theme init priorities:
// Action 'wp'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)
if ( ! function_exists( 'rareradio_woocommerce_theme_setup_wp' ) ) {
	add_action( 'wp', 'rareradio_woocommerce_theme_setup_wp' );
	function rareradio_woocommerce_theme_setup_wp() {
		if ( rareradio_exists_woocommerce() ) {
			// Set columns number for the related products
			if ( (int) rareradio_get_theme_option( 'show_related_posts' ) == 0 || (int) rareradio_get_theme_option( 'related_posts' ) == 0 ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			} else {
				add_filter( 'woocommerce_output_related_products_args', 'rareradio_woocommerce_output_related_products_args' );
				add_filter( 'woocommerce_related_products_columns', 'rareradio_woocommerce_related_products_columns' );
				add_filter( 'woocommerce_cross_sells_columns', 'rareradio_woocommerce_related_products_columns' );
				add_filter( 'woocommerce_upsells_columns', 'rareradio_woocommerce_related_products_columns' );
			}
			// Decorate breadcrumbs
			add_filter( 'woocommerce_breadcrumb_defaults', 'rareradio_woocommerce_breadcrumb_defaults' );
			if ( is_product() && rareradio_get_theme_option( 'single_product_layout' ) == 'stretched' ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
				add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 3 );
			}
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_woocommerce_tgmpa_required_plugins' ) ) {
	
	function rareradio_woocommerce_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'woocommerce' ) && rareradio_storage_get_array( 'required_plugins', 'woocommerce', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'woocommerce', 'title' ),
				'slug'     => 'woocommerce',
				'required' => false,
			);
		}
		return $list;
	}
}


// Check if WooCommerce installed and activated
if ( ! function_exists( 'rareradio_exists_woocommerce' ) ) {
	function rareradio_exists_woocommerce() {
		return class_exists( 'Woocommerce' );
		
	}
}

// Return true, if current page is any woocommerce page
if ( ! function_exists( 'rareradio_is_woocommerce_page' ) ) {
	function rareradio_is_woocommerce_page() {
		$rez = false;
		if ( rareradio_exists_woocommerce() ) {
			$rez = is_woocommerce() || is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		}
		return $rez;
	}
}

// Detect current blog mode
if ( ! function_exists( 'rareradio_woocommerce_detect_blog_mode' ) ) {
	
	function rareradio_woocommerce_detect_blog_mode( $mode = '' ) {
		if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
			$mode = 'shop';
		} elseif ( is_product() || is_cart() || is_checkout() || is_account_page() ) {
			$mode = 'shop'; 
		}
		return $mode;
	}
}

// Override options with stored page meta on 'Shop' pages
if ( ! function_exists( 'rareradio_woocommerce_override_theme_options' ) ) {
	
	function rareradio_woocommerce_override_theme_options() {
		// Remove ' || is_product()' from the condition in the next row
		// if you don't need to override theme options from the page 'Shop' on single products
		if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
			$id = rareradio_woocommerce_get_shop_page_id();
			if ( 0 < $id ) {
				// Get Theme Options from the shop page
				$shop_meta = get_post_meta( $id, 'rareradio_options', true );
				// Add (override) with current post (product) options
				if ( rareradio_storage_isset( 'options_meta' ) ) {
					$options_meta = rareradio_storage_get( 'options_meta' );
					if ( is_array( $options_meta ) ) {
						$shop_meta = array_merge( $shop_meta, rareradio_storage_get( 'options_meta' ) );
					}
				}
				rareradio_storage_set( 'options_meta', $shop_meta );
			}
		}
	}
}

// Add WooCommerce-specific classes to the body
if ( ! function_exists( 'rareradio_woocommerce_add_body_classes' ) ) {
	
	function rareradio_woocommerce_add_body_classes( $classes ) {
		if ( is_product() ) {
			$classes[] = 'single_product_layout_' . rareradio_get_theme_option( 'single_product_layout' );
		}
		return $classes;
	}
}


// Return current page title
if ( ! function_exists( 'rareradio_woocommerce_get_blog_title' ) ) {
	
	function rareradio_woocommerce_get_blog_title( $title = '' ) {
		if ( ! rareradio_exists_trx_addons() && rareradio_exists_woocommerce() && rareradio_is_woocommerce_page() && is_shop() ) {
			$id    = rareradio_woocommerce_get_shop_page_id();
			$title = $id ? get_the_title( $id ) : esc_html__( 'Shop', 'rareradio' );
		}
		return $title;
	}
}


// Return taxonomy for current post type
if ( ! function_exists( 'rareradio_woocommerce_post_type_taxonomy' ) ) {
	
	function rareradio_woocommerce_post_type_taxonomy( $tax = '', $post_type = '' ) {
		if ( 'product' == $post_type ) {
			$tax = 'product_cat';
		}
		return $tax;
	}
}

// Return true if page title section is allowed
if ( ! function_exists( 'rareradio_woocommerce_allow_override_header_image' ) ) {
	
	function rareradio_woocommerce_allow_override_header_image( $allow = true ) {
		return is_product() ? false : $allow;
	}
}

// Return shop page ID
if ( ! function_exists( 'rareradio_woocommerce_get_shop_page_id' ) ) {
	function rareradio_woocommerce_get_shop_page_id() {
		return get_option( 'woocommerce_shop_page_id' );
	}
}

// Return shop page link
if ( ! function_exists( 'rareradio_woocommerce_get_shop_page_link' ) ) {
	function rareradio_woocommerce_get_shop_page_link() {
		$url = '';
		$id  = rareradio_woocommerce_get_shop_page_id();
		if ( $id ) {
			$url = get_permalink( $id );
		}
		return $url;
	}
}

// Show categories of the current product
if ( ! function_exists( 'rareradio_woocommerce_get_post_categories' ) ) {
	
	function rareradio_woocommerce_get_post_categories( $cats = '' ) {
		if ( get_post_type() == 'product' ) {
			$cats = rareradio_get_post_terms( ', ', get_the_ID(), 'product_cat' );
		}
		return $cats;
	}
}

// Add 'product' to the list of the supported post-types
if ( ! function_exists( 'rareradio_woocommerce_list_post_types' ) ) {
	
	function rareradio_woocommerce_list_post_types( $list = array() ) {
		$list['product'] = esc_html__( 'Products', 'rareradio' );
		return $list;
	}
}

// Show price of the current product in the widgets and search results
if ( ! function_exists( 'rareradio_woocommerce_get_post_info' ) ) {
	
	function rareradio_woocommerce_get_post_info( $post_info = '' ) {
		if ( get_post_type() == 'product' ) {
			global $product;
			$price_html = $product->get_price_html();
			if ( ! empty( $price_html ) ) {
				$post_info = '<div class="post_price product_price price">' . trim( $price_html ) . '</div>' . $post_info;
			}
		}
		return $post_info;
	}
}

// Show price of the current product in the search results streampage
if ( ! function_exists( 'rareradio_woocommerce_action_before_post_meta' ) ) {
	
	function rareradio_woocommerce_action_before_post_meta() {
		if ( ! is_single() && get_post_type() == 'product' ) {
			global $product;
			$price_html = $product->get_price_html();
			if ( ! empty( $price_html ) ) {
				?><div class="post_price product_price price"><?php rareradio_show_layout( $price_html ); ?></div>
				<?php
			}
		}
	}
}

// Change text of the sidebar control
if ( ! function_exists( 'rareradio_woocommerce_sidebar_control_text' ) ) {
	
	function rareradio_woocommerce_sidebar_control_text( $text ) {
		if ( ! empty( $text ) && rareradio_exists_woocommerce() && rareradio_is_woocommerce_page() ) {
			$text = esc_html__( 'Filters', 'rareradio' );
		}
		return $text;
	}
}

// Change title of the sidebar control
if ( ! function_exists( 'rareradio_woocommerce_sidebar_control_title' ) ) {
	
	function rareradio_woocommerce_sidebar_control_title( $title ) {
		if ( ! empty( $title ) && rareradio_exists_woocommerce() && rareradio_is_woocommerce_page() ) {
			$title = esc_html__( 'Filters', 'rareradio' );
		}
		return $title;
	}
}

// Enqueue WooCommerce custom styles
if ( ! function_exists( 'rareradio_woocommerce_frontend_scripts' ) ) {
	
	function rareradio_woocommerce_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/woocommerce/woocommerce.css' );
			if ( '' != $rareradio_url && rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
				wp_enqueue_style( 'rareradio-woocommerce', $rareradio_url, array(), null );
			}
			$rareradio_url = rareradio_get_file_url( 'plugins/woocommerce/woocommerce.js' );
			if ( '' != $rareradio_url && rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
				wp_enqueue_script( 'rareradio-woocommerce', $rareradio_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Enqueue WooCommerce responsive styles
if ( ! function_exists( 'rareradio_woocommerce_responsive_styles' ) ) {
	
	function rareradio_woocommerce_responsive_styles() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/woocommerce/woocommerce-responsive.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-woocommerce-responsive', $rareradio_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'rareradio_woocommerce_merge_styles' ) ) {
	function rareradio_woocommerce_merge_styles( $list ) {
		$list[] = 'plugins/woocommerce/woocommerce.css';
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'rareradio_woocommerce_merge_styles_responsive' ) ) {
	
	function rareradio_woocommerce_merge_styles_responsive( $list ) {
		$list[] = 'plugins/woocommerce/woocommerce-responsive.css';
		return $list;
	}
}

// Merge custom scripts
if ( ! function_exists( 'rareradio_woocommerce_merge_scripts' ) ) {
	
	function rareradio_woocommerce_merge_scripts( $list ) {
		$list[] = 'plugins/woocommerce/woocommerce.js';
		return $list;
	}
}



// Add WooCommerce specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( ! function_exists( 'rareradio_woocommerce_list_sidebars' ) ) {
	
	function rareradio_woocommerce_list_sidebars( $list = array() ) {
		$list['woocommerce_widgets'] = array(
			'name'        => esc_html__( 'WooCommerce Widgets', 'rareradio' ),
			'description' => esc_html__( 'Widgets to be shown on the WooCommerce pages', 'rareradio' ),
		);
		return $list;
	}
}




// Decorate WooCommerce output: Loop
//------------------------------------------------------------------------

// Add query vars to set products per page
if ( ! function_exists( 'rareradio_woocommerce_pre_get_posts' ) ) {
	
	function rareradio_woocommerce_pre_get_posts( $query ) {
		if ( ! $query->is_main_query() ) {
			return;
		}
		if ( $query->get( 'wc_query' ) == 'product_query' ) {
			$ppp = get_theme_mod( 'posts_per_page_shop', 0 );
			if ( $ppp > 0 ) {
				$query->set( 'posts_per_page', $ppp );
			}
		}
	}
}


// Add custom paginations to the loop
if ( ! function_exists( 'rareradio_woocommerce_pagination' ) ) {
	
	function rareradio_woocommerce_pagination() {
		$pagination = rareradio_get_theme_option('shop_pagination');
		if ( in_array( $pagination, array( 'more', 'infinite' ) ) ) {
			rareradio_show_pagination(
				array(
					'pagination'   => $pagination,
					'class_prefix' => 'woocommerce'
				)
			);
		}
	}
}


// Before main content
if ( ! function_exists( 'rareradio_woocommerce_wrapper_start' ) ) {
	
	
	function rareradio_woocommerce_wrapper_start() {
		if ( is_product() || is_cart() || is_checkout() || is_account_page() ) {
			?>
			<article class="post_item_single post_type_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo esc_attr( ! rareradio_storage_empty( 'shop_mode' ) ? rareradio_storage_get( 'shop_mode' ) : 'thumbs' ); ?>">
				<div class="list_products_header">
			<?php
			rareradio_storage_set( 'woocommerce_list_products_header', true );
		}
	}
}

// After main content
if ( ! function_exists( 'rareradio_woocommerce_wrapper_end' ) ) {
	
	
	function rareradio_woocommerce_wrapper_end() {
		if ( is_product() || is_cart() || is_checkout() || is_account_page() ) {
			?>
			</article><!-- /.post_item_single -->
			<?php
		} else {
			?>
			</div><!-- /.list_products -->
			<?php
		}
	}
}

// Close header section
if ( ! function_exists( 'rareradio_woocommerce_archive_description' ) ) {
	
	
	
	function rareradio_woocommerce_archive_description() {
		if ( rareradio_storage_get( 'woocommerce_list_products_header' ) ) {
			?>
			</div><!-- /.list_products_header -->
			<?php
			rareradio_storage_set( 'woocommerce_list_products_header', false );
			remove_action( 'woocommerce_after_main_content', 'rareradio_woocommerce_archive_description', 1 );
		} elseif ( ! is_singular() ) {
			get_template_part( apply_filters( 'rareradio_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
		}
	}
}

// Add list mode buttons
if ( ! function_exists( 'rareradio_woocommerce_before_shop_loop' ) ) {
	
	function rareradio_woocommerce_before_shop_loop() {
		?>
		<div class="rareradio_shop_mode_buttons"><form action="<?php echo esc_url( rareradio_get_current_url() ); ?>" method="post"><input type="hidden" name="rareradio_shop_mode" value="<?php echo esc_attr( rareradio_storage_get( 'shop_mode' ) ); ?>" /><a href="#" class="woocommerce_thumbs icon-union-28" title="<?php esc_attr_e( 'Show products as thumbs', 'rareradio' ); ?>"></a><a href="#" class="woocommerce_list icon-union-29" title="<?php esc_attr_e( 'Show products as list', 'rareradio' ); ?>"></a></form></div><!-- /.rareradio_shop_mode_buttons -->
		<?php
	}
}

// Show 'No products' if no search results and display mode 'both'
if ( ! function_exists( 'rareradio_woocommerce_after_shop_loop' ) ) {
	
	function rareradio_woocommerce_after_shop_loop() {
		if ( ! have_posts() && 'products' != woocommerce_get_loop_display_mode() ) {
			wc_get_template( 'loop/no-products-found.php' );
		}
	}
}

// Number of columns for the shop streampage
if ( ! function_exists( 'rareradio_woocommerce_loop_shop_columns' ) ) {
	
	function rareradio_woocommerce_loop_shop_columns( $cols ) {
		return max( 2, min( 4, rareradio_get_theme_option( 'blog_columns' ) ) );
	}
}

// Add column class into product item in shop streampage
if ( ! function_exists( 'rareradio_woocommerce_loop_shop_columns_class' ) ) {
	
	
	function rareradio_woocommerce_loop_shop_columns_class( $classes, $class = '', $cat = '' ) {
		global $woocommerce_loop;
		if ( is_product() ) {
			if ( ! empty( $woocommerce_loop['columns'] ) ) {
				$classes[] = ' column-1_' . esc_attr( $woocommerce_loop['columns'] );
			}
		} elseif ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
			$classes[] = ' column-1_' . esc_attr( max( 2, min( 4, rareradio_get_theme_option( 'blog_columns' ) ) ) );
		}
		return $classes;
	}
}

// Detect when we are in a subcategory: start category
if ( ! function_exists( 'rareradio_woocommerce_before_subcategory' ) ) {
	
	function rareradio_woocommerce_before_subcategory( $cat = '' ) {
		rareradio_storage_set( 'in_product_category', $cat );
	}
}

// Detect when we are in a subcategory: end category
if ( ! function_exists( 'rareradio_woocommerce_after_subcategory' ) ) {
	
	function rareradio_woocommerce_after_subcategory( $cat = '' ) {
		rareradio_storage_set( 'in_product_category', false );
	}
}
	

// Open item wrapper for categories and products
if ( ! function_exists( 'rareradio_woocommerce_item_wrapper_start' ) ) {
	
	
	function rareradio_woocommerce_item_wrapper_start( $cat = '' ) {
		rareradio_storage_set( 'in_product_item', true );
		$hover = rareradio_get_theme_option( 'shop_hover' );
		?>
		<div class="post_item post_layout_<?php
			echo esc_attr( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()
				? rareradio_storage_get( 'shop_mode' )
				: 'thumbs'
			);
			?>"
			<?php rareradio_add_blog_animation(); ?>
		>
			<div class="post_featured hover_<?php echo esc_attr( $hover ); ?>">
				<?php do_action( 'rareradio_action_woocommerce_item_featured_start' ); ?>
				<a href="<?php echo esc_url( is_object( $cat ) ? get_term_link( $cat->slug, 'product_cat' ) : get_permalink() ); ?>">
				<?php
				do_action( 'rareradio_action_woocommerce_item_featured_link_start' );
	}
}

// Open item wrapper for categories and products
if ( ! function_exists( 'rareradio_woocommerce_open_item_wrapper' ) ) {
	
	
	function rareradio_woocommerce_title_wrapper_start( $cat = '' ) {
				do_action( 'rareradio_action_woocommerce_item_featured_link_end' );
		?>
				</a>
				<?php
				$hover = rareradio_get_theme_option( 'shop_hover' );
				if ( 'none' != $hover ) {
					?>
					<div class="mask"></div>
					<?php
					rareradio_hovers_add_icons( $hover, array( 'cat' => $cat ) );
				}
				do_action( 'rareradio_action_woocommerce_item_featured_end' );
				?>
			</div><!-- /.post_featured -->
			<div class="post_data">
				<div class="post_data_inner">
					<div class="post_header entry-header">
					<?php
					do_action( 'rareradio_action_woocommerce_item_header_start' );
	}
}


// Display product's tags before the title
if ( ! function_exists( 'rareradio_woocommerce_title_tags' ) ) {
	
	function rareradio_woocommerce_title_tags() {
		global $product;
		rareradio_show_layout( wc_get_product_tag_list( $product->get_id(), ', ', '<div class="post_tags product_tags">', '</div>' ) );
	}
}

// Wrap product title to the link
if ( ! function_exists( 'rareradio_woocommerce_the_title' ) ) {
	
	function rareradio_woocommerce_the_title( $title ) {
		if ( rareradio_storage_get( 'in_product_item' ) && get_post_type() == 'product' ) {
			$title = '<a href="' . esc_url(get_permalink()) . '">' . esc_html( $title ) . '</a>';
		}
		return $title;
	}
}

// Wrap category title to the link: open tag
if ( ! function_exists( 'rareradio_woocommerce_before_subcategory_title' ) ) {
	
	function rareradio_woocommerce_before_subcategory_title( $cat ) {
		if ( rareradio_storage_get( 'in_product_item' ) && is_object( $cat ) ) {
			?>
			<a href="<?php echo esc_url( get_term_link( $cat->slug, 'product_cat' ) ); ?>">
			<?php
		}
	}
}

// Wrap category title to the link: close tag
if ( ! function_exists( 'rareradio_woocommerce_after_subcategory_title' ) ) {
	
	function rareradio_woocommerce_after_subcategory_title( $cat ) {
		if ( rareradio_storage_get( 'in_product_item' ) && is_object( $cat ) ) {
			?>
			</a>
			<?php
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( ! function_exists( 'rareradio_woocommerce_title_wrapper_end' ) ) {
	
	function rareradio_woocommerce_title_wrapper_end() {
			do_action( 'rareradio_action_woocommerce_item_header_end' );
		?>
			</div><!-- /.post_header -->
		<?php
		if ( rareradio_storage_get( 'shop_mode' ) == 'list' && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) && ! is_product() ) {
			?>
			<div class="post_content entry-content"><?php rareradio_show_layout( get_the_excerpt() ); ?></div>
			<?php
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( ! function_exists( 'rareradio_woocommerce_title_wrapper_end2' ) ) {
	
	function rareradio_woocommerce_title_wrapper_end2( $category ) {
			do_action( 'rareradio_action_woocommerce_item_header_end' );
		?>
			</div><!-- /.post_header -->
		<?php
		if ( rareradio_storage_get( 'shop_mode' ) == 'list' && is_shop() && ! is_product() ) {
			?>
			<div class="post_content entry-content"><?php rareradio_show_layout( $category->description ); ?></div><!-- /.post_content -->
			<?php
		}
	}
}

// Close item wrapper for categories and products
if ( ! function_exists( 'rareradio_woocommerce_close_item_wrapper' ) ) {
	
	
	function rareradio_woocommerce_item_wrapper_end( $cat = '' ) {
		?>
				</div><!-- /.post_data_inner -->
			</div><!-- /.post_data -->
		</div><!-- /.post_item -->
		<?php
		rareradio_storage_set( 'in_product_item', false );
	}
}

// Change text on 'Add to cart' button
if ( ! function_exists( 'rareradio_woocommerce_add_to_cart_text' ) ) {
    function rareradio_woocommerce_add_to_cart_text( $text = '' ) {
        global $product;
        return is_object( $product ) && $product->is_in_stock()
        && 'grouped' !== $product->get_type()
        && ( 'external' !== $product->get_type() || $product->get_button_text() == '' )
            ? esc_html__( 'Buy now', 'rareradio' )
            : $text;
    }
}

// Wrap 'Add to cart' button
if ( ! function_exists( 'rareradio_woocommerce_add_to_cart_link' ) ) {
	
	function rareradio_woocommerce_add_to_cart_link( $html, $product = false, $args = array() ) {
		return rareradio_is_off( rareradio_get_theme_option( 'shop_hover' ) ) ? sprintf( '<div class="add_to_cart_wrap">%s</div>', $html ) : $html;
	}
}


// Add wrap for buttons 'Compare' and 'Add to wishlist'
if ( ! function_exists( 'rareradio_woocommerce_add_wishlist_wrap' ) ) {
	
	function rareradio_woocommerce_add_wishlist_wrap() {
		if ( function_exists( 'YITH_WCWL' ) ) {
			?><div class="yith_buttons_wrap"><?php
		}
	}
}

// Add button 'Add to wishlist'
if ( ! function_exists( 'rareradio_woocommerce_add_wishlist_link' ) ) {
	
	function rareradio_woocommerce_add_wishlist_link() {
		if ( function_exists( 'YITH_WCWL' ) ) {
			YITH_WCWL()->wcwl_init->print_button();
			?></div><?php
		}
	}
}


// Add label 'out of stock'
if ( ! function_exists( 'rareradio_woocommerce_add_out_of_stock_label' ) ) {
	
	function rareradio_woocommerce_add_out_of_stock_label() {
		global $product;
		$cat = rareradio_storage_get( 'in_product_category' );
		if ( empty($cat) || ! is_object($cat) ) {
			if ( is_object( $product ) && ! $product->is_in_stock() ) {
				?>
				<span class="outofstock_label"><?php esc_html_e( 'Out of stock', 'rareradio' ); ?></span>
				<?php
			}
		}
	}
}


// Add label with sale percent instead standard 'Sale'
if ( ! function_exists( 'rareradio_woocommerce_add_sale_percent' ) ) {
	
	function rareradio_woocommerce_add_sale_percent( $label, $post = '', $product = '' ) {
		$percent = '';
		if ( is_object( $product ) ) {
			if ( 'variable' === $product->get_type() ) {
				$prices  = $product->get_variation_prices();
				if ( ! is_array( $prices['regular_price'] ) && ! is_array( $prices['sale_price'] ) && $prices['regular_price'] > $prices['sale_price'] ) {
					$percent = round( ( $prices['regular_price'] - $prices['sale_price'] ) / $prices['regular_price'] * 100 );
				}
			} else {
				$price = $product->get_price_html();
				$prices = explode( '<ins', $price );
				if ( count( $prices ) > 1 ) {
					$prices[1] = '<ins' . $prices[1];
					$price_old = rareradio_parse_num( $prices[0] );
					$price_new = rareradio_parse_num( $prices[1] );
					if ( $price_old > 0 && $price_old > $price_new ) {
						$percent = round( ( $price_old - $price_new ) / $price_old * 100 );
					}
				}
			}
		}
		return ! empty( $percent ) ? '<span class="onsale">-' . esc_html( $percent ) . '%</span>' : $label;
	}
}


// Wrap price - start (WooCommerce use priority 10 to output price)
if ( ! function_exists( 'rareradio_woocommerce_price_wrapper_start' ) ) {
	
	function rareradio_woocommerce_price_wrapper_start() {
		if ( rareradio_storage_get( 'shop_mode' ) == 'thumbs' && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) && ! is_product() ) {
			global $product;
			$price_html = $product->get_price_html();
			if ( '' != $price_html ) {
				?>
				<div class="price_wrap">
				<?php
			}
		}
	}
}


// Wrap price - start (WooCommerce use priority 10 to output price)
if ( ! function_exists( 'rareradio_woocommerce_price_wrapper_end' ) ) {
	
	function rareradio_woocommerce_price_wrapper_end() {
		if ( rareradio_storage_get( 'shop_mode' ) == 'thumbs' && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) && ! is_product() ) {
			global $product;
			$price_html = $product->get_price_html();
			if ( '' != $price_html ) {
				?>
				</div><!-- /.price_wrap -->
				<?php
			}
		}
	}
}


// Decorate price
if ( ! function_exists( 'rareradio_woocommerce_get_price_html' ) ) {
	
	function rareradio_woocommerce_get_price_html( $price = '' ) {
		if ( ! is_admin() && ! empty( $price ) ) {
			$sep = get_option( 'woocommerce_price_decimal_sep' );
			if ( empty( $sep ) ) {
				$sep = '.';
			}
			$price = preg_replace( '/([0-9,]+)(\\' . trim( $sep ) . ')([0-9]{2})/', '\\1<span class="decimals_separator">\\2</span><span class="decimals">\\3</span>', $price );
		}
		return $price;
	}
}


// Decorate breadcrumbs
if ( ! function_exists( 'rareradio_woocommerce_breadcrumb_defaults' ) ) {
	
	function rareradio_woocommerce_breadcrumb_defaults( $args ) {
		$args['delimiter'] = '<span class="woocommerce-breadcrumb-delimiter"></span>';
		$args['before']    = '<span class="woocommerce-breadcrumb-item">';
		$args['after']     = '</span>';
		return $args;
	}
}

		



// Decorate WooCommerce output: Single product
//------------------------------------------------------------------------

// Add Product ID for the single product
if ( ! function_exists( 'rareradio_woocommerce_show_product_id' ) ) {
	
	function rareradio_woocommerce_show_product_id() {
		$authors = wp_get_post_terms( get_the_ID(), 'pa_product_author' );
		if ( is_array( $authors ) && count( $authors ) > 0 ) {
			echo '<span class="product_author">' . esc_html__( 'Author: ', 'rareradio' );
			$delim = '';
			foreach ( $authors as $author ) {
				echo  esc_html( $delim ) . '<span>' . esc_html( $author->name ) . '</span>';
				$delim = ', ';
			}
			echo '</span>';
		}
		echo '<span class="product_id">' . esc_html__( 'Product ID: ', 'rareradio' ) . '<span>' . get_the_ID() . '</span></span>';
	}
}

// Number columns for the product's thumbnails
if ( ! function_exists( 'rareradio_woocommerce_product_thumbnails_columns' ) ) {
	
	function rareradio_woocommerce_product_thumbnails_columns( $cols ) {
		return 4;
	}
}

// Set products number for the related products
if ( ! function_exists( 'rareradio_woocommerce_output_related_products_args' ) ) {
	
	function rareradio_woocommerce_output_related_products_args( $args ) {
		$args['posts_per_page'] = (int) rareradio_get_theme_option( 'show_related_posts' )
										? max( 0, min( 9, rareradio_get_theme_option( 'related_posts' ) ) )
										: 0;
		$args['columns']        = max( 1, min( 4, rareradio_get_theme_option( 'related_columns' ) ) );
		return $args;
	}
}

// Set columns number for the related products
if ( ! function_exists( 'rareradio_woocommerce_related_products_columns' ) ) {
	
	
	
	function rareradio_woocommerce_related_products_columns( $columns = 0 ) {
		$columns = max( 1, min( 4, rareradio_get_theme_option( 'related_columns' ) ) );
		return $columns;
	}
}

// Filter price step
if ( ! function_exists( 'rareradio_woocommerce_price_filter_widget_step' ) ) {
    add_filter('woocommerce_price_filter_widget_step', 'rareradio_woocommerce_price_filter_widget_step');
    function rareradio_woocommerce_price_filter_widget_step( $step = '' ) {
        $step = 1;
        return $step;
    }
}


// Decorate WooCommerce output: Widgets
//------------------------------------------------------------------------

// Search form
if ( ! function_exists( 'rareradio_woocommerce_get_product_search_form' ) ) {
	
	function rareradio_woocommerce_get_product_search_form( $form ) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url( home_url( '/' ) ) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__( 'Search for products &hellip;', 'rareradio' ) . '" value="' . get_search_query() . '" name="s" /><button class="search_button" type="submit">' . esc_html__( 'Search', 'rareradio' ) . '</button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( rareradio_exists_woocommerce() ) {
	require_once RARERADIO_THEME_DIR . 'plugins/woocommerce/woocommerce-styles.php';
}

// Placeholder for review form
add_filter( 'woocommerce_product_review_comment_form_args' , 'review_placeholder', 20, 1 );
function review_placeholder( $comment_form ) {
	$commenter = wp_get_current_commenter();
	$comment_form['fields']['author'] = '<div class="radio_form_row"><input id="author" placeholder="' . esc_attr('Your Name', 'rareradio') . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></div>';
	$comment_form['fields']['email'] = 	'<div class="radio_form_row"><input id="email" placeholder="' . esc_attr('Your Email', 'rareradio') . '" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></div>';
		
		$comment_form['comment_field'] =	'<div class="radio_form_row"><textarea id="comment" placeholder="' . esc_attr('Your Review', 'rareradio') . '" name="comment" cols="45" rows="8" required></textarea></div>';
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
				$comment_form['comment_field'] .= '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'rareradio' ) . '</label><select name="rating" id="rating" required>
					<option value="">' . esc_html__( 'Rate&hellip;', 'rareradio' ) . '</option>
					<option value="5">' . esc_html__( 'Perfect', 'rareradio' ) . '</option>
					<option value="4">' . esc_html__( 'Good', 'rareradio' ) . '</option>
					<option value="3">' . esc_html__( 'Average', 'rareradio' ) . '</option>
					<option value="2">' . esc_html__( 'Not that bad', 'rareradio' ) . '</option>
					<option value="1">' . esc_html__( 'Very poor', 'rareradio' ) . '</option>
				</select></div>';
		}
	return $comment_form;
}
