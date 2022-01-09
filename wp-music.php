<?php
/**
 * @package WP Music
 */
/*
Plugin Name: WP Music
Plugin URI: https://google.com/
Description: WP Music plugin
Version: 1.2.1
Author: Vipul Sharma
Author URI: https://profiles.wordpress.org/vipulsharma/
Text Domain: wp-music
Domain Path: /languages
*/

define( 'WP_MUSIC_VERSION', '1.2.1' );
define( 'WP_MUSIC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

include_once 'admin/functions.php';

include_once 'admin/meta_box.php';

include_once 'admin/plugin-activator.php';


function wp_music_plugin_activator_callback(){

	$wp_music_plugin_activator = new wp_music_plugin_activator();
	$wp_music_plugin_activator->activate_plugin();

}


register_activation_hook(__FILE__, 'wp_music_plugin_activator_callback');