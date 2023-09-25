<?php

/**
 * Enqueue Script
 */
function mb_scripts() {
	if ( !is_admin() ) {
		// Custom plugins and scripts
		wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array('jquery'), NULL, true );
		wp_enqueue_script( 'masonry-js', get_stylesheet_directory_uri() . '/assets/js/masonry.min.js', array('jquery'), NULL, true );
    wp_enqueue_script( 'popup-js', get_stylesheet_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), NULL, true );
		wp_enqueue_script( 'customplugins', get_stylesheet_directory_uri() . '/assets/js/plugins.min.js', array('jquery'), NULL, true );
		wp_enqueue_script( 'customscripts', get_stylesheet_directory_uri() . '/assets/js/main.min.js', array('jquery'), NULL, true );
	}
}
