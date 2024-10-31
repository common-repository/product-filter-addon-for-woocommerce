<?php

/* protected */
if (!defined('ABSPATH'))
	exit;
	

//class init
class nss_ele_addon_style_support
{
	
	//construct
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'nss_ele_addon_styles'));
	}
	//method
	public function nss_ele_addon_styles()
	{	
		wp_register_style('nss_ele_woo_style', NSS_PRODUCT_FILTER_PLUGIN_URL.'assets/css/nss_product_filter_style.css');
		wp_enqueue_style('nss_ele_woo_style');

		wp_enqueue_script('jquery');

        wp_register_script('nss_ele_woo_script', NSS_PRODUCT_FILTER_PLUGIN_URL . 'assets/js/nss_product_filter_script.js', array('jquery'), '', TRUE);
        wp_enqueue_script('nss_ele_woo_script');

		wp_localize_script('nss_ele_woo_script', 'nssProduct_ajax', 
		array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));
	}
}
//instance
new nss_ele_addon_style_support();
