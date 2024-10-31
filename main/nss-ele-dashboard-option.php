<?php 
/**
 *  Page Builder Shortcode
 *  created by nsstheme
 * @package 
 * @since 1.0
 */
/* protected */
if (!defined('ABSPATH'))
    exit;

// We check if the Elementor plugin has been installed / activated.

if (!in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))) return;

class nss_ele_addon_filter_Elementor_Widget {
 
	private static $instance = null;

	/**
	 * @since 1.0
	 */
	public static function get_instance() {
	    if ( ! self::$instance )
	       self::$instance = new self;
	    return self::$instance;
	}

	/**
	 * @since 1.0
	 */
	public function init(){
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'elementor_widget_categories' ) );
	}

	/**
	 * @since 1.0
	 */
	public function widgets_registered() {					
		//Require all PHP files in the /elementor/widgets directory
		if( class_exists('\Elementor\Widget_Base') ) 
		{
			require_once plugin_dir_path( __FILE__ ) . 'nss-ele-search-filter-addon.php';
		}
	}

	/**
	 * @since 1.0
	 */

	public function elementor_widget_categories( $elements_manager ) {
		$theme_name = wp_get_theme();
		$elements_manager->add_category(
			'nss_eleaddon_filter_category',
			[
				'title' => $theme_name->name,
				'icon' => 'eicon-search',
			]
		);  
	}
} 
nss_ele_addon_filter_Elementor_Widget::get_instance()->init();