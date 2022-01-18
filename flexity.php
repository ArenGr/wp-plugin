<?php
/**
 * @package Flexity
 */
/*
Plugin Name: Flexity
Description: Used by millions ...
Version: 1.0.1
Author: Ronen Landesman
License: GPLv2 or later
*/

/*
Copyright 2021-2021 Flexity.
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_spotify_tracker_plugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_spotify_tracker_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_spotify_tracker_plugin() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_spotify_tracker_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
    Inc\Init::register_services();
}