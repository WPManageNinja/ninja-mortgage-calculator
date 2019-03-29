<?php
/*
Plugin Name: Ninja Mortgage Calculator
Description: The Best Mortgage Calculator Plugin for WordPress
Version: 1.0.1
Author: WPManageNinja
Author URI: https://wpmanageninja.com
Plugin URI: https://github.com/WPManageNinja/ninja-mortgage-calculator
License: GPLv2 or later
Text Domain: ninja_mortgage
Domain Path: /languages
*/

defined("ABSPATH") or die;

include "load.php";
define("NINJA_MORTGAGE_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
define("NINJA_MORTGAGE_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("NINJA_MORTGAGE_PLUGIN_DIR_VERSION", plugin_dir_path(__FILE__));


$mortgageCalculatorInstances = array();

class NinjaMortgageCalculator
{
	public function boot()
	{
		$this->commonHooks();
		$this->adminHooks();
	}

	public function commonHooks()
	{
		add_action('init', array('NinjaMortgage\Classes\CPT', 'register')); 
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts') );

		add_action('admin_enqueue_scripts', array($this, 'adminEnqueueScripts') );

		add_shortcode('ninja_mortgage_cal', array('NinjaMortgage\Classes\MortgageCalculatorHandler','handleShortCode') );

		add_action('init', function () {
            \NinjaMortgage\Classes\ProcessDemoPage::demoPages();
        });

		add_action('init', array($this, 'loadTextDomain'));
		
	}
	
	public function adminHooks()
	{
		add_action('admin_menu', array('NinjaMortgage\Classes\Menu', 'addAdminMenuPages') );
		add_action('wp_ajax_ninja_mortgage_ajax_actions', array('NinjaMortgage\Classes\MortgageCalculatorHandler','handleAjaxCalls'));

		add_action('ninja_mortgage_added_new_table', array('NinjaMortgage\Classes\MortgageCalculatorHandler','populateDemoData') );
		add_action('ninija_mortgage_table_config_updated', array('NinjaMortgage\Classes\MortgageCalculatorHandler','deleteCache') );
	}


	public function adminEnqueueScripts()
	{
		if(isset($_GET['page']) && $_GET['page'] == 'ninja-mortgage-calculator') {
			wp_enqueue_style('mortgage_icon_css', NINJA_MORTGAGE_PLUGIN_DIR_URL.'public/css/admin.css');
		}
	}

	public function enqueueScripts()
	{
		wp_register_style('ninja_mortgage_public_css', NINJA_MORTGAGE_PLUGIN_DIR_URL.'public/css/styles.css');
	}
	
	public function loadTextDomain()
	{
		load_plugin_textdomain( 'ninja-mortgage-calculator', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}
}

add_action('plugins_loaded', function(){
	$ninjaMortgageCalculator = new NinjaMortgageCalculator();
	$ninjaMortgageCalculator->boot(); 
});

	