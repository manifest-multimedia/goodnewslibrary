<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage RARERADIO
 * @since RARERADIO 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'rareradio_storage_get' ) ) {
	function rareradio_storage_get( $var_name, $default = '' ) {
		global $RARERADIO_STORAGE;
		return isset( $RARERADIO_STORAGE[ $var_name ] ) ? $RARERADIO_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'rareradio_storage_set' ) ) {
	function rareradio_storage_set( $var_name, $value ) {
		global $RARERADIO_STORAGE;
		$RARERADIO_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'rareradio_storage_empty' ) ) {
	function rareradio_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $RARERADIO_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $RARERADIO_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $RARERADIO_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $RARERADIO_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'rareradio_storage_isset' ) ) {
	function rareradio_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $RARERADIO_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $RARERADIO_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $RARERADIO_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $RARERADIO_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'rareradio_storage_inc' ) ) {
	function rareradio_storage_inc( $var_name, $value = 1 ) {
		global $RARERADIO_STORAGE;
		if ( empty( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = 0;
		}
		$RARERADIO_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'rareradio_storage_concat' ) ) {
	function rareradio_storage_concat( $var_name, $value ) {
		global $RARERADIO_STORAGE;
		if ( empty( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = '';
		}
		$RARERADIO_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'rareradio_storage_get_array' ) ) {
	function rareradio_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $RARERADIO_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $RARERADIO_STORAGE[ $var_name ][ $key ] ) ? $RARERADIO_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $RARERADIO_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $RARERADIO_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'rareradio_storage_set_array' ) ) {
	function rareradio_storage_set_array( $var_name, $key, $value ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$RARERADIO_STORAGE[ $var_name ][] = $value;
		} else {
			$RARERADIO_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'rareradio_storage_set_array2' ) ) {
	function rareradio_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ][ $key ] ) ) {
			$RARERADIO_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$RARERADIO_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$RARERADIO_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'rareradio_storage_merge_array' ) ) {
	function rareradio_storage_merge_array( $var_name, $key, $value ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$RARERADIO_STORAGE[ $var_name ] = array_merge( $RARERADIO_STORAGE[ $var_name ], $value );
		} else {
			$RARERADIO_STORAGE[ $var_name ][ $key ] = array_merge( $RARERADIO_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'rareradio_storage_set_array_after' ) ) {
	function rareradio_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			rareradio_array_insert_after( $RARERADIO_STORAGE[ $var_name ], $after, $key );
		} else {
			rareradio_array_insert_after( $RARERADIO_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'rareradio_storage_set_array_before' ) ) {
	function rareradio_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			rareradio_array_insert_before( $RARERADIO_STORAGE[ $var_name ], $before, $key );
		} else {
			rareradio_array_insert_before( $RARERADIO_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'rareradio_storage_push_array' ) ) {
	function rareradio_storage_push_array( $var_name, $key, $value ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $RARERADIO_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $RARERADIO_STORAGE[ $var_name ][ $key ] ) ) {
				$RARERADIO_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $RARERADIO_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'rareradio_storage_pop_array' ) ) {
	function rareradio_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $RARERADIO_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $RARERADIO_STORAGE[ $var_name ] ) && is_array( $RARERADIO_STORAGE[ $var_name ] ) && count( $RARERADIO_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $RARERADIO_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $RARERADIO_STORAGE[ $var_name ][ $key ] ) && is_array( $RARERADIO_STORAGE[ $var_name ][ $key ] ) && count( $RARERADIO_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $RARERADIO_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'rareradio_storage_inc_array' ) ) {
	function rareradio_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( empty( $RARERADIO_STORAGE[ $var_name ][ $key ] ) ) {
			$RARERADIO_STORAGE[ $var_name ][ $key ] = 0;
		}
		$RARERADIO_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'rareradio_storage_concat_array' ) ) {
	function rareradio_storage_concat_array( $var_name, $key, $value ) {
		global $RARERADIO_STORAGE;
		if ( ! isset( $RARERADIO_STORAGE[ $var_name ] ) ) {
			$RARERADIO_STORAGE[ $var_name ] = array();
		}
		if ( empty( $RARERADIO_STORAGE[ $var_name ][ $key ] ) ) {
			$RARERADIO_STORAGE[ $var_name ][ $key ] = '';
		}
		$RARERADIO_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'rareradio_storage_call_obj_method' ) ) {
	function rareradio_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $RARERADIO_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $RARERADIO_STORAGE[ $var_name ] ) ? $RARERADIO_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $RARERADIO_STORAGE[ $var_name ] ) ? $RARERADIO_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'rareradio_storage_get_obj_property' ) ) {
	function rareradio_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $RARERADIO_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $RARERADIO_STORAGE[ $var_name ]->$prop ) ? $RARERADIO_STORAGE[ $var_name ]->$prop : $default;
	}
}
