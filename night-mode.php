<?php
/**
 * Plugin Name: Night Mode
 * Description: A widget that makes webpages night-friendly
 * Version: 1.1
 * Author: David Parker
 */

define( 'NIGHT_MODE_DIR', dirname( __FILE__ ) );
define( 'NIGHT_MODE_BASENAME', plugin_basename( __FILE__ ) );

require_once NIGHT_MODE_DIR . '/includes/classes/class-night-mode-widget.php';
add_action( 'widgets_init', 'night_mode_register_night_mode_widget' );

/**
 * Registers Night Mode widget.
 */
function night_mode_register_night_mode_widget() {
	register_widget( 'Night_Mode_Widget' );
}

/**
 * Enqueues frontend style
 */
function night_mode_frontend_style() {
	wp_register_style( 'night_mode_frontend', plugins_url( 'includes/css/frontend.css', __FILE__ ), '1.1' );
	wp_enqueue_style( 'night_mode_frontend' );
}
add_action( 'wp_enqueue_scripts', 'night_mode_frontend_style' );
