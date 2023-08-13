<?php
/**
 * @package WooThanks
 * @version 1.0.0
 */
/*
Plugin Name: WooThanks
Plugin URI: http://urldev.com/woothanks/
Description: This pluging will increase your website functionalty to select custom "WooCommerce Thank You" page. When a customer complete their order then this plugin will redirect to your selected custom thank you page. Use these short codes to show Customer & Order details. Shortcodes: [wct_customer_first_name], [wct_order_overview], [wct_order_details], [wct_customer_details] & [wct_hero_img] your img url [/wct_hero_img]
Version: 1.0.0
Author: urlDev
Author URI: http://urldev.com/
Text Domain: woothanks
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there! I\'m just a plugin, not much I can do when called directly.';
	exit;
}
// SETUP
if ( !class_exists( 'WooCommerce' ) ) {
    echo 'Hi there! To use this plugin you must have to activate WooCommerce Plugin First.';
	exit;
}

// INCLUDES
include('includes/activate.php');
include('includes/customizer-api.php');
include('includes/woothanks-redirect.php');
include('shortcode.php');

// HOOKS
register_activation_hook('__FILE__', 'woothanks_activate');
add_action('customize_register', 'woothanks_customization');
add_action('template_redirect', 'woothanks_redirect');
add_action('init', 'urldev_hero_img_shortcode_init');

// SHORT CODE
add_shortcode('wct_customer_first_name', 'woothanks_customer_firstname');
add_shortcode('wct_order_overview', 'woothanks_order_overview');
add_shortcode('wct_order_details', 'woothanks_order_details');
add_shortcode('wct_customer_details', 'woothanks_customer_details');

function urldev_hero_img_shortcode_init()
{
    add_shortcode('wct_hero_img', 'urldev_hero_img_shortcode');
}

// Rename order status 'Completed' to 'Order Shipped'
// add_filter( 'wc_order_statuses', 'urldev_wc_renaming_order_status' );
// function urldev_wc_renaming_order_status( $order_statuses ) {
//     foreach ( $order_statuses as $key => $status ) {
//         if ( 'wc-completed' === $key ) 
//             $order_statuses['wc-completed'] = _x( 'Order Shipped', 'Order status', 'woocommerce' );
//     }
//     return $order_statuses;
// }
 
//Rename order status in the bulk actions dropdown on main order list
// add_filter( 'gettext', 'urldev_change_login_form_register_keyword', 20, 3);
// function urldev_change_login_form_register_keyword( $text ) {
//     if( is_admin()) {
//         $text = str_ireplace( 'Change status to completed',  'Change status to order shipped',  $text );
//     }
//     return $text;
// }