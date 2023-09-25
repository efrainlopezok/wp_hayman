<?php
/*
Template Name: Landing Page
*/


/** Force full width layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_filter( 'body_class', 'cp_body_class' );
function cp_body_class( $classes ) {
	
	$classes[] = 'landing_page';
	return $classes;
	
}


// Custom Header
remove_action('genesis_header','sm_genesis_do_header');
add_action( 'genesis_header', 'custom_do_header' );
function custom_do_header() {
	global $wp_registered_sidebars;
	$header_options = get_field('choose_header_type','option');
	genesis_markup( array(
		'open'    => '<div %s>',
		'context' => 'title-area',
	) );
	do_action( 'genesis_site_title' );
	do_action( 'genesis_site_description' );
	
	genesis_markup( array(
		'close'    => '</div>',
		'context' => 'title-area',
	) );
	if ( ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) || has_action( 'genesis_header_right' ) ) {
		genesis_markup( array(
			'open'    => '<div %s>' . genesis_sidebar_title( 'landing-header-right' ),
			'context' => 'header-widget-area',
		) );
			do_action( 'genesis_header_right' );
			add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			dynamic_sidebar( 'header-right' );
			remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			if($header_options):
				
			endif;
		genesis_markup( array(
			'close'   => '</div>',
			'context' => 'header-widget-area',
		) );
    }
    genesis_markup( array(
        'open'    => '<div %s>' . genesis_sidebar_title( 'landing-header-right' ),
        'context' => 'header-right-area',
    ) );
    add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
    dynamic_sidebar( 'landing-header-right' );
    remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
    genesis_markup( array(
        'close'   => '</div>',
        'context' => 'header-right-area',
    ) );
}

remove_action( 'genesis_footer', 'mb_footer' );
genesis();
