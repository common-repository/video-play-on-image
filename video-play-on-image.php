<?php
/**
 * Plugin Name: Video Play On Image
 * Plugin URI:        https://wordpress.org/plugins/video-play-on-image
 * Description: A custom Elementor widget that displays Video player On Image
 * Version:           1.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sumanta Dhank
 * Author URI:        https://itsumanta.wordpress.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sdvpi
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Make sure Elementor is active
function sdvpi_check_elementor_active(){
if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
    echo "<div class='error'><p><strong>Video Play On Image</strong> requires <strong>Elementor plugin. </strong>Please install and activate it.</p></div>";
    }
}
add_action('admin_notices', 'sdvpi_check_elementor_active');

function sdvpi_enqueue_scripts() {
	wp_enqueue_style( 'sdvpi-style', plugins_url('css/sdvpi-style.css', __FILE__) );
	
}
add_action( 'wp_enqueue_scripts', 'sdvpi_enqueue_scripts' );

function register_custom_widget_final() {
    require_once plugin_dir_path( __FILE__ ) . 'widget.php';
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new sdvpi_Custom_Widget_Final() );
}
add_action( 'elementor/widgets/widgets_registered', 'register_custom_widget_final' );
