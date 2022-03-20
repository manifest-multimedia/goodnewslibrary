<?php
/* elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'rareradio_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'rareradio_elegro_payment_theme_setup9', 9 );
	function rareradio_elegro_payment_theme_setup9() {
		if ( rareradio_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'rareradio_elegro_payment_frontend_scripts', 1100 );
			add_filter( 'rareradio_filter_merge_styles', 'rareradio_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'rareradio_filter_tgmpa_required_plugins', 'rareradio_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'rareradio_elegro_payment_tgmpa_required_plugins' ) ) {
	function rareradio_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( rareradio_storage_isset( 'required_plugins', 'woocommerce' ) && rareradio_storage_isset( 'required_plugins', 'elegro-payment' ) && rareradio_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => rareradio_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'rareradio_exists_elegro_payment' ) ) {
	function rareradio_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'rareradio_elegro_payment_frontend_scripts' ) ) {
	function rareradio_elegro_payment_frontend_scripts() {
		if ( rareradio_is_on( rareradio_get_theme_option( 'debug_mode' ) ) ) {
			$rareradio_url = rareradio_get_file_url( 'plugins/elegro-payment/elegro-payment.css' );
			if ( '' != $rareradio_url ) {
				wp_enqueue_style( 'rareradio-elegro-payment', $rareradio_url, array(), null );
			}
		}
	}
}


// Merge custom styles
if ( ! function_exists( 'rareradio_elegro_payment_merge_styles' ) ) {
	function rareradio_elegro_payment_merge_styles( $list ) {
		$list[] = 'plugins/elegro-payment/elegro-payment.css';
		return $list;
	}
}
