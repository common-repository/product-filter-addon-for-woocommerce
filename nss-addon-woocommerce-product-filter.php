<?php
/*
Plugin Name: Product Filter Addon for-Woocommerce
Plugin URI: http://eclippermedia.com/plugin/
Description: It is a product category search filter plugin. Which is helpful for your product sorting like category, subcategory & nested category, etc. It's must be time-consuming when you using it. 
Author: NssTheme
Version: 1.0
Author URI: https://www.linkedin.com/in/saiful5721/
Text Domain: nss-search-product
Domain Path: /languages
License: GPL2
*/

/* protected */
if (!defined('ABSPATH'))
exit;

//define
define('NSS_PRODUCT_FILTER_PLUGIN_URL', plugin_dir_url(__FILE__));

//textdomain
add_action('plugins_loaded', 'nss_load_plugin_textdomain');
function nss_load_plugin_textdomain()
{
    load_plugin_textdomain('nss-search-product', false, NSS_PRODUCT_FILTER_PLUGIN_URL . '/languages');
}
//register files
include_once("main/nss-ele-dashboard-option.php");
//script
include_once("main/nss-ele-addon-assistance.php");
//specfic id
include_once("main/nss-ele-specfic-function.php");
//step three
include_once("main/nss-ele-threestep-function.php");
//step Two
include_once("main/nss-ele-twostep-function.php");
//Step One
include_once("main/nss-ele-onestep-function.php");
