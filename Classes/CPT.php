<?php namespace NinjaMortgage\Classes;

class CPT 
{	
	public static $CPTName = 'ninja_mortgage_cpt';

	public static function register()
	{
		$cptArgs = array(
			'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => false,
            'show_in_menu'       => false,
            'query_var'          => false,
            'label'		=>__('Ninja Mortgage Calculator', 'ninja_mortgage')
		);
		register_post_type( self::$CPTName, $cptArgs );
	}
	
}





 