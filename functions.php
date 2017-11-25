<?php 
/**
 * Child stylesheet
 *
 */
function cb_child_style() {        
    if ( ! is_admin() ) {
		wp_enqueue_style( 'cb-15zine-child',  get_stylesheet_directory_uri() . '/style.css' , array( 'cb-main-stylesheet' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'cb_child_style' );

/**
 * Child l18n
 *
 */
function cb_child_textdomain() {
    load_child_theme_textdomain( 'cubell', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'cb_child_textdomain' );