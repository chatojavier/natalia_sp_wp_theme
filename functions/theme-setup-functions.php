<?php
/**
 * WP Tailwind Boilerplate setup functions
 *
 * @package WP_Tailtheme
 */


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.2' );
}

/**
 * Enqueue scripts and styles.
 */
function wp_tailtheme_scripts() {
	wp_enqueue_style( 'wp-tailtheme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'wp-tailtheme-frontend-style', get_stylesheet_directory_uri() . '/assets/public/css/frontend.css', array(), _S_VERSION );
	wp_style_add_data( 'wp-tailtheme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wp-tailtheme-frontend-js', get_stylesheet_directory_uri() . '/assets/public/js/frontend.js', array(), _S_VERSION, true );
	// wp_enqueue_script( 'wp-tailtheme-navigation', get_stylesheet_directory_uri() . '/assets/public/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_tailtheme_scripts' );

// Update CSS within in Admin
function wp_tailtheme_admin_scripts() {
	wp_enqueue_style('wp-tailtheme-backend-styles', get_stylesheet_directory_uri().'/assets/public/backend.css', array(), _S_VERSION );

	wp_enqueue_script( 'wp-tailtheme-backend-js', get_stylesheet_directory_uri() . '/assets/public/backend.js', array(), _S_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'wp_tailtheme_admin_scripts' );

// Get the path to public directory
function get_public_directory_uri() {
	return get_stylesheet_directory_uri() . '/assets/public';
}

// Get the path to public images directory
function get_images_directory_uri() {
	return get_stylesheet_directory_uri() . '/assets/public/images';
}
