<?php
/**
 * Plugin Name: Elementor PDF Grid Widget
 * Plugin URI: https://abdullahwp.com/elementor-pdf-grid-widget/
 * Description: A custom Elementor widget to display a grid of PDFs with thumbnails, titles, and descriptions.
 * Version: 1.0.0
 * Author: AbdullahWP
 * Author URI: https://abdullahwp.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elementor-pdf-grid
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the custom widget.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 */
function abdwp_pdf_grid_register_widget( $widgets_manager ) {
	// Require the widget class file
	require_once( __DIR__ . '/widgets/class-pdf-grid-widget.php' );

	// Register the widget
	$widgets_manager->register( new \Elementor_PDF_Grid_Widget() );
}
add_action( 'elementor/widgets/register', 'abdwp_pdf_grid_register_widget' );

/**
 * Register the frontend stylesheet used by the widget.
 */
function abdwp_pdf_grid_register_assets() {
	wp_register_style(
		'elementor-pdf-grid',
		plugins_url( 'assets/pdf-grid.css', __FILE__ ),
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'abdwp_pdf_grid_register_assets' );
add_action( 'elementor/editor/after_enqueue_styles', 'abdwp_pdf_grid_register_assets' );

/**
 * Explain the dependency when Elementor is unavailable.
 */
function abdwp_pdf_grid_dependency_notice() {
	if ( ! current_user_can( 'activate_plugins' ) || did_action( 'elementor/loaded' ) ) {
		return;
	}

	echo '<div class="notice notice-warning"><p>' . esc_html__( 'Elementor PDF Grid Widget requires Elementor to be active.', 'elementor-pdf-grid' ) . '</p></div>';
}
add_action( 'admin_notices', 'abdwp_pdf_grid_dependency_notice' );
