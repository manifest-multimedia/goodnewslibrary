<?php
/**
 * Override Theme Options on a posts and pages
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0.29
 */


// -----------------------------------------------------------------
// -- Override Theme Options
// -----------------------------------------------------------------

if ( ! function_exists( 'rareradio_options_override_init' ) ) {
	add_action( 'after_setup_theme', 'rareradio_options_override_init' );
	function rareradio_options_override_init() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', 'rareradio_options_override_add_scripts' );
			add_action( 'save_post', 'rareradio_options_override_save_options' );
			add_filter( 'rareradio_filter_override_options', 'rareradio_options_override_add_options' );
		}
	}
}


// Check if override options is allowed for specified post type
if ( ! function_exists( 'rareradio_options_allow_override' ) ) {
	function rareradio_options_allow_override( $post_type ) {
		return apply_filters( 'rareradio_filter_allow_override_options', in_array( $post_type, array( 'page', 'post' ) ), $post_type );
	}
}

// Load required styles and scripts for admin mode
if ( ! function_exists( 'rareradio_options_override_add_scripts' ) ) {
	
	function rareradio_options_override_add_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( is_object( $screen ) && rareradio_options_allow_override( ! empty( $screen->post_type ) ? $screen->post_type : $screen->id ) ) {
			wp_enqueue_style( 'fontello-icons', rareradio_get_file_url( 'css/font-icons/css/fontello.css' ), array(), null );
			wp_enqueue_script( 'jquery-ui-tabs', false, array( 'jquery', 'jquery-ui-core' ), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array( 'jquery', 'jquery-ui-core' ), null, true );
			wp_enqueue_script( 'rareradio-options', rareradio_get_file_url( 'theme-options/theme-options.js' ), array( 'jquery' ), null, true );
			wp_localize_script( 'rareradio-options', 'rareradio_dependencies', rareradio_get_theme_dependencies() );
		}
	}
}

// Add overriden options
if ( ! function_exists( 'rareradio_options_override_add_options' ) ) {
	
	function rareradio_options_override_add_options( $list ) {
		global $post_type;
		if ( rareradio_options_allow_override( $post_type ) ) {
			$list[] = array(
				sprintf( 'rareradio_override_options_%s', $post_type ),
				esc_html__( 'Theme Options', 'rareradio' ),
				'rareradio_options_override_show',
				$post_type,
				'post' == $post_type ? 'side' : 'advanced',
				'default',
			);
		}
		return $list;
	}
}

// Callback function to show override options
if ( ! function_exists( 'rareradio_options_override_show' ) ) {
	function rareradio_options_override_show( $post = false, $args = false ) {
		if ( empty( $post ) || ! is_object( $post ) || empty( $post->ID ) ) {
			global $post, $post_type;
			$mb_post_id   = $post->ID;
			$mb_post_type = $post_type;
		} else {
			$mb_post_id   = $post->ID;
			$mb_post_type = $post->post_type;
		}
		if ( rareradio_options_allow_override( $mb_post_type ) ) {
			// Load saved options
			$meta         = get_post_meta( $mb_post_id, 'rareradio_options', true );
			$tabs_titles  = array();
			$tabs_content = array();
			global $RARERADIO_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $RARERADIO_STORAGE
			foreach ( $RARERADIO_STORAGE['options'] as $k => $v ) {
				if ( ! isset( $v['override'] ) || strpos( $v['override']['mode'], $mb_post_type ) === false ) {
					continue;
				}
				if ( ! empty( $v['linked'] ) ) {
					$v['val'] = isset( $meta[ $k ] ) ? $meta[ $k ] : 'inherit';
					if ( ! empty( $v['val'] ) && ! rareradio_is_inherit( $v['val'] ) ) {
						rareradio_refresh_linked_data( $v['val'], $v['linked'] );
					}
				}
			}
			// Show fields
			foreach ( $RARERADIO_STORAGE['options'] as $k => $v ) {
				if ( ! isset( $v['override'] ) || strpos( $v['override']['mode'], $mb_post_type ) === false || 'hidden' == $v['type'] ) {
					continue;
				}
				if ( empty( $v['override']['section'] ) ) {
					$v['override']['section'] = esc_html__( 'General', 'rareradio' );
				}
				if ( ! isset( $tabs_titles[ $v['override']['section'] ] ) ) {
					$tabs_titles[ $v['override']['section'] ]  = $v['override']['section'];
					$tabs_content[ $v['override']['section'] ] = '';
				}
				$v['val']                                   = isset( $meta[ $k ] ) ? $meta[ $k ] : 'inherit';
				$tabs_content[ $v['override']['section'] ] .= rareradio_options_show_field( $k, $v, $mb_post_type );
			}
			if ( count( $tabs_titles ) > 0 ) {
				?>
				<div class="rareradio_options rareradio_options_override">
					<input type="hidden" name="override_options_nonce" value="<?php echo esc_attr( wp_create_nonce( admin_url() ) ); ?>" />
					<input type="hidden" name="override_options_post_type" value="<?php echo esc_attr( $mb_post_type ); ?>" />
					<div id="rareradio_options_tabs" class="rareradio_tabs">
						<ul>
							<?php
							$cnt = 0;
							foreach ( $tabs_titles as $k => $v ) {
								$cnt++;
								?>
								<li><a href="#rareradio_options_<?php echo esc_attr( $cnt ); ?>"><?php echo esc_html( $v ); ?></a></li>
								<?php
							}
							?>
						</ul>
						<?php
						$cnt = 0;
						foreach ( $tabs_content as $k => $v ) {
							$cnt++;
							?>
							<div id="rareradio_options_<?php echo esc_attr( $cnt ); ?>" class="rareradio_tabs_section rareradio_options_section">
								<?php rareradio_show_layout( $v ); ?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
		}
	}
}


// Save overriden options
if ( ! function_exists( 'rareradio_options_override_save_options' ) ) {
	
	function rareradio_options_override_save_options( $post_id ) {
		// verify nonce
		if ( ! wp_verify_nonce( rareradio_get_value_gp( 'override_options_nonce' ), admin_url() ) ) {
			return $post_id;
		}

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$post_type = wp_kses_data( wp_unslash( isset( $_POST['override_options_post_type'] ) ? $_POST['override_options_post_type'] : $_POST['post_type'] ) );

		// Check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type ), 'objects' );
		if ( ! empty( $post_types ) && is_array( $post_types ) ) {
			foreach ( $post_types  as $type ) {
				$capability = $type->capability_type;
				break;
			}
		}
		if ( ! current_user_can( 'edit_' . ( $capability ), $post_id ) ) {
			return $post_id;
		}

		// Save options
		$meta    = array();
		$options = rareradio_storage_get( 'options' );
		foreach ( $options as $k => $v ) {
			// Skip not overriden options
			if ( ! isset( $v['override'] ) || strpos( $v['override']['mode'], $post_type ) === false ) {
				continue;
			}
			// Skip inherited options
			if ( ! empty( $_POST[ "rareradio_options_inherit_{$k}" ] ) ) {
				continue;
			}
			// Skip hidden options
			if ( ! isset( $_POST[ "rareradio_options_field_{$k}" ] ) && 'hidden' == $v['type'] ) {
				continue;
			}
			// Get option value from POST
			$meta[ $k ] = isset( $_POST[ "rareradio_options_field_{$k}" ] )
							? rareradio_get_value_gp( "rareradio_options_field_{$k}" )
							: ( 'checkbox' == $v['type'] ? 0 : '' );
		}
		$meta = apply_filters( 'rareradio_filter_update_post_options', $meta, $post_id );

		update_post_meta( $post_id, 'rareradio_options', $meta );

		// Save separate meta options to search template pages
		if ( 'page' == $post_type ) {
			$page_template = isset( $_POST['page_template'] )
								? rareradio_get_value_gpc('page_template')
								: get_post_meta( $post_id, '_wp_page_template', true );
			if ( 'blog.php' == $page_template ) {
				update_post_meta( $post_id, 'rareradio_options_post_type', isset( $meta['post_type'] ) ? $meta['post_type'] : 'post' );
				update_post_meta( $post_id, 'rareradio_options_parent_cat', isset( $meta['parent_cat'] ) ? $meta['parent_cat'] : 0 );
			}
		}
	}
}


//------------------------------------------------------
// Extra column for posts/pages lists
// with overriden options
//------------------------------------------------------

// Create additional column
if ( ! function_exists( 'rareradio_add_options_column' ) ) {
	add_filter( 'manage_edit-post_columns', 'rareradio_add_options_column', 9 );
	add_filter( 'manage_edit-page_columns', 'rareradio_add_options_column', 9 );
	function rareradio_add_options_column( $columns ) {
		$columns['theme_options'] = esc_html__( 'Theme Options', 'rareradio' );
		return $columns;
	}
}

// Fill column with data
if ( ! function_exists( 'rareradio_fill_options_column' ) ) {
	add_filter( 'manage_post_posts_custom_column', 'rareradio_fill_options_column', 9, 2 );
	add_filter( 'manage_page_posts_custom_column', 'rareradio_fill_options_column', 9, 2 );
	function rareradio_fill_options_column( $column_name = '', $post_id = 0 ) {
		if ( 'theme_options' != $column_name ) {
			return;
		}
		$options = '';
		$props = get_post_meta( $post_id, 'rareradio_options', true);
		if ( $props ) {
			if ( is_array( $props ) && count( $props ) > 0 ) {
				foreach ( $props as $prop_name => $prop_value ) {
					if ( ! rareradio_is_inherit( $prop_value ) && rareradio_storage_get_array( 'options', $prop_name, 'type' ) != 'hidden' ) {
						$prop_title = rareradio_storage_get_array( 'options', $prop_name, 'title' );
						if ( empty( $prop_title ) ) {
							$prop_title = $prop_name;
						}
						$options .= '<div class="rareradio_options_prop_row">'
										. '<span class="rareradio_options_prop_name">' . esc_html( $prop_title ) . '</span>'
										. '&nbsp;=&nbsp;'
										. '<span class="themerex_options_prop_value">'
											. ( is_array( $prop_value )
												? esc_html__('[Complex Data]', 'rareradio')
												: '"' . esc_html( rareradio_strshort( $prop_value, 80 ) ) . '"'
												)
										. '</span>'
									. '</div>';
					}
				}
			}
		}
		rareradio_show_layout( $options, '<div class="rareradio_options_list">', '</div>' );
	}
}
