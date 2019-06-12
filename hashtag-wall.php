<?php
/**
 * Plugin Name: Hashtag Wall
 * Description: Hashtag Wall 
 * Author:      JD-A
 * Author URI:  
 * Version:     1.0
 * Text Domain: hashtag-wall
 * Domain Path: /languages
 *
 *
 * The following code is a derivative work of the code from Chase Wiseman, which is licensed GPLv2.
 * This code is then also licensed under the terms of the GPLv2.
 */
 /**
 * The main plugin file.
 *
 * This file loads the main plugin class and gets things running.
 *
 * @since 1.0
 *
 * @package Hashtag_Wall
 */

if ( ! defined( 'WPINC' ) ) {
	die();
}
define("PPATH", plugin_dir_path( __FILE__ ));
define("PURL", plugin_dir_url( __FILE__ ));
define("ASSETS_PATH", PURL.'assets/');

require_once PPATH."vendor/autoload.php";

// plugin activation
register_activation_hook( __FILE__, 'HW_activate' );

// plugin deactivation
register_deactivation_hook( __FILE__, 'HW_deactivate' );


// plugin uninstallation
register_uninstall_hook( __FILE__, 'HW_uninstall' );


// Init Freemius.
HW_fs();

// Signal that SDK was initiated.
do_action( 'HW_fs_loaded' );

function HW_fs_settings_url() {
    return admin_url( 'admin.php?page=hashtag-wall' );
}

HW_fs()->add_filter('connect_url', 'HW_fs_settings_url');
HW_fs()->add_filter('after_skip_url', 'HW_fs_settings_url');
HW_fs()->add_filter('after_connect_url', 'HW_fs_settings_url');
HW_fs()->add_filter('after_pending_connect_url', 'HW_fs_settings_url');
