<?php
/**
 * WP Tailwind Boilerplate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Tailtheme
 */


/**
 * Load theme setup function file.
 */
require get_stylesheet_directory() . '/functions/theme-setup-functions.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_stylesheet_directory() . '/functions/template-functions.php';

/**
 * Advance Custom Fields.
 */
// require get_stylesheet_directory() . '/functions/acf.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_stylesheet_directory() . '/functions/jetpack.php';
}

/**========================
 * All-in-One WP Migration exports themes separately from wp-content. Exclude
 * the child theme's development dependencies during its theme export pass.
===========================*/
add_filter( 'ai1wm_exclude_themes_from_export', function( $exclude_filters ) {
	$exclude_filters[] = get_stylesheet_directory() . '/node_modules';

	return $exclude_filters;
} );
