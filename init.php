<?php  

/**
 * Plugin Name: WP mail-sending Widget
 * Plugin URI: http://prashaddey.com
 * Author: Prashad
 * Author URI: http://prashaddey.com
 * version: 2.01
 * Description: This Plugin will create a widget which will help you to create a submit form on the frontend of your website.
 * The form will not only send an email with the infos of the subscribers to your email address but also save those infos on the plugin setting page on your dashboard.
 *
**/

// Including file that creates a widget to get information about the admin
include dirname( __FILE__ ) . '/wpmwp.php';

// Including the main class for this plugin
include dirname( __FILE__ ) . '/wpwp.php';

// Plugin Activation Hook
register_activation_hook( __FILE__, 'callback_of_plugin_activation' );

// Plugin Activation function
// Creating a table for the plugin
function callback_of_plugin_activation(){
	global $wpdb;
	$table = $wpdb->prefix . 'a_wp_mail';
	$charset_collate = $wpdb->get_charset_collate();	// What does this line do? Allah knows..

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$sql = "CREATE TABLE $table (
	  id INT NOT NULL AUTO_INCREMENT,
	  name varchar(50) NOT NULL,
	  email varchar(50) NOT NULL,
	  phone varchar(20) NOT NULL,
	  UNIQUE KEY id (id)
	) $charset_collate;";
	dbDelta( $sql );

}

new WPWP;






















