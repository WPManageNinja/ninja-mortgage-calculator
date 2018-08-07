<?php namespace NinjaMortgage\Classes;


class ProcessDemoPage 
{
	public static function demoPages()
	{	
		if( isset( $_GET['ninja_mortgage_calculator_preview'] ) && $_GET['ninja_mortgage_calculator_preview'] ) {
			if(current_user_can(Menu::managePermission()) ){
				$tableId = intval( $_GET['ninja_mortgage_calculator_preview'] );
				static::renderPreview($tableId);
			}
		}
	}

	public static function renderPreview($tableId)
	{
		$table = get_post( $tableId );

		if($table){
			if ($table->post_content == 'mortgage_calculator') {
				$CalculatorName = 'Mortgage Calculator';
			} elseif ($table->post_content == 'mortgage_refinance') {
				$CalculatorName = 'Mortgage Refinance';
			} elseif($table->post_content == 'mortgage_payment') {
				$CalculatorName = 'Mortgage Payment';
			}

			static::loadDefaultPageTemplate();

			add_action('pre_get_posts', function($query){
				self::pre_get_posts($query);
			}, 100, 1);
			
			add_filter( 'post_thumbnail_html', '__return_empty_string' );

			add_filter( 'get_the_excerpt', function ( $content ) {
				return '';
			} );
			
			add_filter( 'the_title', function ( $title ) use ( $table ) {
				return in_the_loop() ? $table->post_title : $title;
			}, 100, 1 );

			add_filter( 'the_content', function ( $content ) use ( $table, $CalculatorName ) {
				if ( in_the_loop() ) {
				    
				    $custom_content = __( $CalculatorName .' '. 'Demo Preview ( ID: ', 'ninja_mortgage');
				    
					$content = '<div id="mortgage_calculator_demo" style="text-align: center" class="mortgage_demo"><h3>'.$custom_content.$table->ID.' )</h3></div><hr />';
					$content .= '[ninja_mortgage_cal id=' . $table->ID . ']';
				}

				return $content;
			} );
		}
	}

	private static function loadDefaultPageTemplate()
	{
		add_filter('template_include', function( $original ) {
			return locate_template( array( 'page.php', 'single.php', 'index.php' ) );
		});
	}

	/**
	 * Set the posts to one
	 *
	 * @param  WP_Query $query
	 *
	 * @return void
	 */
	public static function pre_get_posts( $query ) {
		if ( $query->is_main_query() ) {
			$query->set( 'posts_per_page', 1 );
		}
	}
}
