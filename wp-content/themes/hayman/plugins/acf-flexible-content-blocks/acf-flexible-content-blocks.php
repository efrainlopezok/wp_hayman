<?php
/*
Plugin Name: ACF Flexible Content Blocks
Plugin URI:
Description: Adds flexible content blocks blow the_content();
Version: 1.0
Author: Michael W. Delaney
Author URI:
License: MIT
*/


/**
 * Define constants
 */

  if(!defined('ACFFCB_PLUGIN_DIR')) {
 		 define('ACFFCB_PLUGIN_DIR', get_stylesheet_directory().'/plugins/acf-flexible-content-blocks/');
  }
  if(!defined('ACFFCB_PLUGIN_URL')) {
 		 define('ACFFCB_PLUGIN_URL', get_stylesheet_directory_uri().'/plugins/acf-flexible-content-blocks/');
  }

	// Our default set of layouts is defined as a string which references a class so that we can filter it
	function fcb_layouts_class($s) {
		return 'MWD\ACFFCB\Layouts';
	}



	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-init.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-gamajo-template-loader.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-acffcb-template-loader.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-acffcb-fields.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-acffcb-repeaters.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-acffcb-flexible-content.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/class-acffcb-layouts.php');
	require_once(ACFFCB_PLUGIN_DIR . 'lib/template-functions.php');

	class_alias('MWD\ACFFCB\CreateBlocks', 'ACFFlexibleContentBlocks');

	add_filter( 'fcb_get_layouts', 'fcb_layouts_class' );



add_action('wp_loaded', function() {
		global $wp_query;
		$acf_flexible_content_blocks = new MWD\ACFFCB\CreateBlocks();
		if(!isset( $_GET["s"] )):	
			$acf_flexible_content_blocks->fcb_create_blocks();
		endif;
		// Enable layouts

		// Append blocks to content
		// add_filter( 'the_content', array( 'MWD\ACFFCB\CreateBlocks', 'acffcb_add_to_content' ) );

});
