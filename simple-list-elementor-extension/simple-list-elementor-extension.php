<?php
/**
 * Plugin Name: Simple List Elementor Extension
 * Description: Elementor extension plugin
 * Version:     1.0
 * Author:      konovalchuk573
 * Text Domain: simple-list-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Elementor widget
 */
function register_simple_list_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/simple-list-widget.php' );

	$widgets_manager->register( new \Simple_List_Widget() );

}
add_action( 'elementor/widgets/register', 'register_simple_list_widget' );

/**
 * Register style for Elementor widget
 */
function elementor_widget_dependencies() {

	wp_register_style( 'list-style', plugins_url( 'assets/css/style.css', __FILE__ ) );

}
add_action( 'wp_enqueue_scripts', 'elementor_widget_dependencies' );

/**
 * Create new widget category
 */
function add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'simple-list-category',
		[
			'title' => esc_html__( 'Simple List Category', 'simple-list-elementor' ),
			'icon' => 'fa fa-plug',
		]
	);

}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );