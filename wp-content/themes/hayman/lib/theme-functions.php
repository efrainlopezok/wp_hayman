<?php

/****************************************
Backend Functions
*****************************************/

/**
 * Remove Genesis Theme Settings Metaboxes
 */
function mb_remove_genesis_metaboxes( $_genesis_theme_settings_pagehook ) {
	//remove_meta_box( 'genesis-theme-settings-feeds',      $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-header',     $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-nav',        $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-comments',   $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-posts',      $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-blogpage',   $_genesis_theme_settings_pagehook, 'main' );
	//remove_meta_box( 'genesis-theme-settings-scripts',    $_genesis_theme_settings_pagehook, 'main' );
}

/**
 * Reposition Genesis Layout Metabox
 */
function mb_add_inpost_layout_box() {
	if ( ! current_theme_supports( 'genesis-inpost-layouts' ) )
		return;
	foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
		if ( post_type_supports( $type, 'genesis-layouts' ) )
			add_meta_box( 'genesis_inpost_layout_box', __( 'Layout Settings', 'genesis' ), 'genesis_inpost_layout_box', $type, 'normal', 'low' );
	}
}

/**
 * Remove Dashboard Meta Boxes
 */
function mb_remove_dashboard_widgets() {
	global $wp_meta_boxes;
	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

/**
 * Change Admin Menu Order
 */
function mb_custom_menu_order( $menu_ord ) {
	if ( !$menu_ord ) return true;
	return array(
		// 'index.php', // Dashboard
		// 'separator1', // First separator
		// 'edit.php?post_type=page', // Pages
		// 'edit.php', // Posts
		// 'upload.php', // Media
		// 'gf_edit_forms', // Gravity Forms
		// 'genesis', // Genesis
		// 'edit-comments.php', // Comments
		// 'separator2', // Second separator
		// 'themes.php', // Appearance
		// 'plugins.php', // Plugins
		// 'users.php', // Users
		// 'tools.php', // Tools
		// 'options-general.php', // Settings
		// 'separator-last', // Last separator
	);
}

/**
 * Hide Admin Areas that are not used
 */
function mb_remove_menu_pages() {
	// remove_menu_page('link-manager.php');
}

/**
 * Remove default link for images
 */
function mb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option( 'image_default_link_type', 'none' );
	}
}


/****************************************
Frontend
*****************************************/

/**
 * Load apple touch icon in header
 */
function mb_apple_touch_icon() {
	echo '<link rel="apple-touch-icon" href="' . get_stylesheet_directory_uri() . '/images/apple-touch-icon.png" />' . "\n";
}

/**
 * Footer
 */
function mb_footer() {
	echo '<div class="one-half first" id="footer-left">' . wpautop( genesis_get_option( 'footer-left', 'child-settings' ) ) . '</div>';
	echo '<div class="one-half" id="footer-right">' . wpautop( genesis_get_option( 'footer-right', 'child-settings' ) ) . '</div>';
}


/**
 * Remove Query Strings From Static Resources
 */
function mb_remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}

/**
 * Remove Read More Jump
 */
function mb_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ($offset) {
		$end = strpos( $link, '"',$offset );
	}
	if ($end) {
		$link = substr_replace( $link, '', $offset, $end-$offset );
	}
	return $link;
}

/**
 * Define custom post type capabilities for use with Members
 */
function mb_add_post_type_caps() {
	// mb_add_capabilities( 'portfolio' );
}


/****************************************
Misc Theme Functions
*****************************************/

/**
 * Unregister the superfish scripts
 */
function mb_unregister_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}

/**
 * Filter Yoast SEO Metabox Priority
 */
function mb_filter_yoast_seo_metabox() {
	return 'low';
}

//* Add Font Awesome Support
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );
}

/**
 * Footer
 */
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'mb_footer' );


/**
 * Custom Post Type Gallery
 */
add_action( 'init', 'gallery_custom_post_type' );

function gallery_custom_post_type() {

	$labels = array(
		'name' => __( 'Galleries' ),
		'singular_name' => __( 'Gallery' ),
		'all_items' => __('All Galleries'),
		'add_new' => _x('Add new Gallery', 'Gallery'),
		'add_new_item' => __('Add new Gallery'),
		'edit_item' => __('Edit Gallery'),
		'new_item' => __('New Gallery'),
		'view_item' => __('View Gallery'),
		'search_items' => __('Search in Galleries'),
		'not_found' =>  __('No Gallery found'),
		'not_found_in_trash' => __('No Gallery found in trash'),
		'parent_item_colon' => ''
	);

	$args = array (
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-format-gallery',
		'rewrite' => array('slug' => 'gallery'),
		'taxonomies' => array(  ),
		'query_var' => false,
		'menu_position' => 25,
		'supports'	=> array(  'title' )

	);

	register_post_type( 'gallery',$args);
}

/**
 * Custom Post Type Testimonials
 */
add_action( 'init', 'testimonial_custom_post_type' );

function testimonial_custom_post_type() {

	$labels = array(
		'name' => __( 'Testimonials' ),
		'singular_name' => __( 'Testimonial' ),
		'all_items' => __('All Testimonials'),
		'add_new' => _x('Add new Testimonial', 'Testimonial'),
		'add_new_item' => __('Add new Testimonial'),
		'edit_item' => __('Edit Testimonial'),
		'new_item' => __('New Testimonial'),
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search in Testimonials'),
		'not_found' =>  __('No Testimonial found'),
		'not_found_in_trash' => __('No Testimonial found in trash'),
		'parent_item_colon' => ''
	);

	$args = array (
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-testimonial',
		'rewrite' => array('slug' => 'testimonial'),
		'taxonomies' => array(  ),
		'query_var' => false,
		'menu_position' => 25,
		'supports'	=> array(  'title' )

	);

	register_post_type( 'testimonial',$args);
}