<?php namespace NinjaMortgage\Classes;

class Menu
{

	public static function addAdminMenuPages() 
	{
	 	add_menu_page(
            __( 'Mortgage Calculator', 'ninja_mortgage' ),
            __( 'Mortgage Calculator', 'ninja_mortgage' ),
            static::managePermission(),
            'ninja-mortgage-calculator.php',
            array( static::class, 'renderMortgage'),
            '',
            6
        );
	}


	public static function managePermission()
	{	
		return apply_filters('ninja_mortgage_menu_manager_permission','manage_options');
	}


	public static function renderMortgage()
	{
		wp_enqueue_script('ninja_mortgage_calc', NINJA_MORTGAGE_PLUGIN_DIR_URL.'public/js/ninja_mortgage_calc.js', array('jquery'), NINJA_MORTGAGE_PLUGIN_DIR_VERSION, true);

		include	NINJA_MORTGAGE_PLUGIN_DIR_PATH.'views/admin_view.php';

	}



	
}

 

