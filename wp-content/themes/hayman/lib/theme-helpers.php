<?php

/****************************************
Theme Helpers
*****************************************/

/**
 * Add capabilities for a custom post type
 */
function mb_add_capabilities( $posttype ) {
	// gets the author role
	$role = get_role( 'administrator' );

	// adds all capabilities for a given post type to the administrator role
	$role->add_cap( 'edit_' . $posttype . 's' );
	$role->add_cap( 'edit_others_' . $posttype . 's' );
	$role->add_cap( 'publish_' . $posttype . 's' );
	$role->add_cap( 'read_private_' . $posttype . 's' );
	$role->add_cap( 'delete_' . $posttype . 's' );
	$role->add_cap( 'delete_private_' . $posttype . 's' );
	$role->add_cap( 'delete_published_' . $posttype . 's' );
	$role->add_cap( 'delete_others_' . $posttype . 's' );
	$role->add_cap( 'edit_private_' . $posttype . 's' );
	$role->add_cap( 'edit_published_' . $posttype . 's' );
}

/**
 * Shortcode to display current year and company name for copyright
 */
function mb_shortcode_copyright() {
	$copyright = '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' );
	return $copyright;
}
add_shortcode( 'copyright', 'mb_shortcode_copyright' );


/* # Header Schema
---------------------------------------------------------------------------------------------------- */
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
function custom_site_title() { 
	$logo = get_field( 'mtm_header_logo', 'option' );
	echo '<a class="retina logo" href="'.get_bloginfo('url').'" title="TI"><img src="'.$logo['url'].'" alt="logo"/></a>';
}
add_action( 'genesis_site_title', 'custom_site_title' );

remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );
//add in the new header markup - prefix the function name - here sm_ is used
add_action( 'genesis_header', 'sm_genesis_header_markup_open', 5 );
add_action( 'genesis_header', 'sm_genesis_header_markup_close', 15 );
add_action( 'genesis_header', 'sm_genesis_do_header' );
//New Header functions
function sm_genesis_header_markup_open() {
	genesis_markup( array(
		'html5'   => '<header %s>',
		'context' => 'site-header',
	) );
	// Added in content
	echo '<div class="header-ghost"></div>';
	// genesis_structural_wrap( 'header' );
}
function sm_genesis_header_markup_close() {
	// genesis_structural_wrap( 'header', 'close' );
	genesis_markup( array(
		'close'   => '</header>',
		'context' => 'site-header',
	) );
}
function sm_genesis_do_header() {
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
			'open'    => '<div %s>' . genesis_sidebar_title( 'header-right' ),
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
}

add_filter( 'genesis_attr_body', 'themeprefix_add_css_attr' );
function themeprefix_add_css_attr( $attributes ) {
	if( get_field('hero_image'))
		$attributes['class'] .= ' fixed-header';
	else	 
		$attributes['class'] .= '';
	return $attributes;
}

/* # Section Blocks on Pages
---------------------------------------------------------------------------------------------------- */
add_action('genesis_after_header','section_rows');
function section_rows() {
	
	echo do_shortcode( '[acffcb-blocks]');
}

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'content_loop' );

function content_loop() { 
	if(!have_rows('blocks')) {
		if( have_posts() ):
			while( have_posts() ):the_post(); global $post;
				the_content();
			endwhile;
		endif;
 	}
}

/* # Force Genesis Full Width on All pages
---------------------------------------------------------------------------------------------------- */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


/* # Section Blocks on Pages
---------------------------------------------------------------------------------------------------- */
add_action('genesis_before_footer','gallery_page_function', 2);

function gallery_page_function() {
	$post_object = get_field('list_of_galleries');

	if( $post_object ): 
		echo do_shortcode('[gallery_image id_gallery="'.$post_object.'"]');
	endif; 
}

/* # Admin Columns
---------------------------------------------------------------------------------------------------- */
//Gallery Admin
add_filter('manage_edit-gallery_columns', 'add_new_gallery_columns');
function add_new_gallery_columns($gallery_columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = _x('Gallery Name', 'column name'); 
    $new_columns['id'] = __('ID');
    $new_columns['images'] = __('Images');
    $new_columns['author'] = __('Author');
 
    $new_columns['date'] = _x('Date', 'column name');
 
    return $new_columns;
}

add_action('manage_gallery_posts_custom_column', 'manage_gallery_columns', 10, 2);

function manage_gallery_columns($column_name, $id) {
   global $wpdb;
   switch ($column_name) {
   case 'id':
	   echo $id;
		   break;

   case 'images':
	   // Get number of images in gallery
	   $num_images = get_field('gallery_images',$id);
	   echo count($num_images); 
	   break;
   default:
	   break;
   } // end switch
}


//Testimonial Admin
add_filter('manage_edit-testimonial_columns', 'add_new_testimonial_columns');
function add_new_testimonial_columns($testimonial_columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = _x('Testimonial Name', 'column name'); 
    $new_columns['id'] = __('ID');
    $new_columns['author'] = __('Author');
    $new_columns['date'] = _x('Date', 'column name');
 
    return $new_columns;
}

add_action('manage_testimonial_posts_custom_column', 'manage_testimonial_columns', 10, 2);

function manage_testimonial_columns($column_name, $id) {
   global $wpdb;
   switch ($column_name) {
   case 'id':
	   echo $id;
		   break;
   default:
	   break;
   } // end switch
}

genesis_register_sidebar( array(
    'id' => 'landing-header-right',
    'name' => __( 'Landing Header Right', 'genesis' ),
    'description' => __( 'Landing Header Right Widget Area', 'genesis' ),
	) );
	

