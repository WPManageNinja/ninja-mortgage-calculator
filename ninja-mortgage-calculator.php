<?php

defined("ABSPATH") or die;

/*
Plugin Name: Mortgage Calculator
Description: The Best Mortgage Calculator Plugin for WordPress
Version: 1.0.0
Author: WPManageNinja
Author URI: https://wpmanageninja.com
Plugin URI: https://wpmanageninja.com/products/ninja-mortgage-calculator-plugin
License: GPLv2 or later
Text Domain: ninja_mortgage
Domain Path: /languages
*/

include "load.php";
define("NINJA_MORTGAGE_PLUGIN_DIR_URL", plugin_dir_url(__FILE__));
define("NINJA_MORTGAGE_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("NINJA_MORTGAGE_PLUGIN_DIR_VERSION", plugin_dir_path(__FILE__));


class NINJAMortgageCalculator
{
	public function boot()
	{
		$this->commonHooks();
		$this->adminHooks();
		$this->publicHooks();
		$this->loadTextDomain();
	}


	public function commonHooks()
	{
		add_action('init', array('NinjaMortgage\Classes\CPT', 'register')); 
		add_action('wp_enqueue_scripts', array($this, 'enqueueScripts') );
		add_shortcode('ninja_mortgage_cal', array('NinjaMortgage\Classes\MortgageCalculatorHandler','handleShortCode') );

		add_action('init', function () {
            \NinjaMortgage\Classes\ProcessDemoPage::demoPages();
        });

	}
	
	public function adminHooks()
	{
		add_action('admin_menu', array('NinjaMortgage\Classes\Menu', 'addAdminMenuPages') );
		add_action('wp_ajax_ninja_mortgage_ajax_actions', array('NinjaMortgage\Classes\MortgageCalculatorHandler','handleAjaxCalls'));

		add_action('ninja_mortgage_added_new_table', array('NinjaMortgage\Classes\MortgageCalculatorHandler','populateDemoData') );
		add_action('ninija_mortgage_table_config_updated', array('NinjaMortgage\Classes\MortgageCalculatorHandler','deleteCache') );
	
		wp_enqueue_style('mortgage_icon_css', NINJA_MORTGAGE_PLUGIN_DIR_URL.'/public/css/admin.css');
	}


	public function publicHooks()
	{
		
	}

	public function enqueueScripts()
	{
		wp_enqueue_style('mortgage_userview_css', NINJA_MORTGAGE_PLUGIN_DIR_URL.'/public/css/styles.css');
	}


	public function loadTextDomain()
	{
		
	}
}


add_action('plugins_loaded', function(){
	$ninjaMortgageCalculator = new NINJAMortgageCalculator();
	$ninjaMortgageCalculator->boot(); 
});

	