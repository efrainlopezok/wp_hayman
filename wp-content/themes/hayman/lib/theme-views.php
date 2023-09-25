<?php

/**
 * Custom queries, hooks, etc go here
 */
//* Add Font Awesome Support
add_action( 'wp_enqueue_scripts', 'enqueue_font_jlocator' );
function enqueue_font_jlocator() {
    wp_enqueue_script( 'handle-js', get_stylesheet_directory_uri() .'/assets/js/libs/handlebars.min.js', array('jquery'), NULL, true );// Validate:<script src=""></script>
    wp_enqueue_script( 'gmap-js', 'https://maps.google.com/maps/api/js?key=AIzaSyAK1uBre1l0RGmHKpvTbMwLPcrUPDfuCm8', array('jquery'), NULL, true );// Validate:<script src=""></script>
    wp_enqueue_script( 'jlocator-js', get_stylesheet_directory_uri() . '/assets/js/plugins/storeLocator/jquery.storelocator.js', array('jquery'), NULL, true );// Validate:
    // wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), NULL, true );// Validate:
}

/**
* Custom Post Type Locations
*/
add_action( 'init', 'locations_custom_post_type' );

function locations_custom_post_type() {

   $labels = array(
       'name' => __( 'Locations' ),
       'singular_name' => __( 'Location' ),
       'all_items' => __('All Locations'),
       'add_new' => _x('Add new Location', 'Location'),
       'add_new_item' => __('Add new Location'),
       'edit_item' => __('Edit Location'),
       'new_item' => __('New Location'),
       'view_item' => __('View Location'),
       'search_items' => __('Search in Locations'),
       'not_found' =>  __('No Location found'),
       'not_found_in_trash' => __('No Location found in trash'),
       'parent_item_colon' => ''
   );

   $args = array (
       'labels' => $labels,
       'public' => true,
       'has_archive' => true,
       'menu_icon' => 'dashicons-post-status',
       'rewrite' => array('slug' => 'location'),
       'taxonomies' => array(  ),
       'query_var' => false,
       'menu_position' => 25,
       'show_in_rest'       => true,
  	   'rest_base'          => 'location-api',
  	   'rest_controller_class' => 'WP_REST_Posts_Controller',
       'supports'	=> array(  'title', 'editor', 'thumbnail', 'excerpt' )

   );

   register_post_type( 'location',$args);
}

add_action( 'init', 'create_book_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_book_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'City', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'City', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search City', 'textdomain' ),
		'all_items'         => __( 'All City', 'textdomain' ),
		'parent_item'       => __( 'Parent City', 'textdomain' ),
		'parent_item_colon' => __( 'Parent City:', 'textdomain' ),
		'edit_item'         => __( 'Edit City', 'textdomain' ),
		'update_item'       => __( 'Update City', 'textdomain' ),
		'add_new_item'      => __( 'Add New City', 'textdomain' ),
		'new_item_name'     => __( 'New City Name', 'textdomain' ),
		'menu_name'         => __( 'City', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
        'query_var'         => true,
        'show_in_rest'       => true,
  		'rest_base'          => 'city_location_api',
  		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'rewrite'           => array( 'slug' => 'city-location' ),
	);

    register_taxonomy( 'city-location', array( 'location' ), $args );
}

/**
 * Filter ApiKey 
 *
 */

add_filter('acf/settings/google_api_key', function () {
    return 'AIzaSyAK1uBre1l0RGmHKpvTbMwLPcrUPDfuCm8';
});

/**
 * Locator Shortcode
 */
add_shortcode( 'locations', 'location_func' );
function location_func( $atts ){

    $out = '';
    $out .= '
    <div class="bh-sl-general">
        <div class="bh-sl-form-container">
            <form id="bh-sl-user-location" method="post" action="#">
                <div class="form-input">
                    
                    <!--<input type="text" id="bh-sl-address" name="bh-sl-address" />-->
                    <select id="bh-sl-address" name="bh-sl-address">
                        <option value="">Search location</option>
                        <option value="St. Louis Park">St. Louis Park</option>
                        <option value="Minneapolis">Minneapolis</option>
                        <option value="Golden">Golden</option>
                        <option value="Hopkins">Hopkins</option>
                        <option value="Edina">Edina</option>
                        <option value="Minnetonka">Minnetonka</option>
                        <option value="Bloomington">Bloomington</option>
                        <option value="Wayzata">Wayzata</option>
                        <option value="Eden">Eden</option>
                        <option value="Plymouth">Plymouth</option>
                        <option value="Roseville">Roseville</option>
                        <option value="St. Paul">St. Paul</option>
                        <option value="Chanhassen">Chanhassen</option>
                    </select>
                </div>

                <!--<button id="bh-sl-submit" type="submit">Submit</button>-->
            </form>
        </div>

        <div id="bh-sl-map-container" class="bh-sl-map-container">
            <div id="bh-sl-map" class="bh-sl-map"></div>
            
        </div>
    </div>';
$out .='<script>';
$out .= "jQuery( window ).load(function() {
    jQuery('#bh-sl-address').change(function() {
        jQuery(this).parent().parent().submit();
    });
    jQuery('#bh-sl-map-container').storeLocator({
        slideMap: false,
        defaultLoc: true,
        defaultLat: '44.9207462',
        defaultLng: '-93.3935366',
        dataType: 'xml',
        dataLocation: '".get_stylesheet_directory_uri()."/assets/data/locations.xml',
        selectedMarkerImg : '".get_stylesheet_directory_uri()."/assets/images/map-marker.png',
        catMarkers : {
            'Restaurant' : ['".get_stylesheet_directory_uri()."/assets/images/map-marker.png', 21, 32],
            'Cafe' : ['".get_stylesheet_directory_uri()."/assets/images/map-marker.png', 21, 32]
        }
    });
  });";
$out .='</script>';


return $out;
}