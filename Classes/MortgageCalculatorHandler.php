<?php namespace NinjaMortgage\Classes;


class MortgageCalculatorHandler 
{
	protected static $selectedCalc;

	public static function handleAjaxCalls()
	{
		$route = sanitize_text_field( $_REQUEST['route'] );

		if ($route == 'add_table') {
			$tableTitle = sanitize_text_field($_REQUEST['post_title']); 
			$calculatorType = sanitize_text_field($_REQUEST['calculator_type']); 
			static::addTable($tableTitle, $calculatorType);
		}

		if ($route == 'get_tables') {
			$pageNumber = intval($_REQUEST['page_number']);
			$perPage 	= intval($_REQUEST['per_page']);
			static::getTables($pageNumber, $perPage);
		}

		if ($route == 'get_table') {
            $tableId = intval($_REQUEST['table_id']);
            static::getTable($tableId, 'ajax');
        }


        if ($route == 'delete_table') {
            $tableId = intval($_REQUEST['table_id']);
            static::deleteTable($tableId);
        }

        if ($route == 'update_table_config') {
            $tableId = intval($_REQUEST['table_id']);
            $table_con = wp_unslash($_REQUEST['table_config']);
            $table_config = json_decode(trim(stripslashes($table_con)), true);
			$calculatorType = sanitize_text_field($_REQUEST['calculator_type']); 
			static::updateTableConfig($tableId, $table_config, $calculatorType);
        }
	}

	public static function handleShortCode($atts)
    {
    	$defaults = apply_filters('mortgage_calculator_shortcode_defaults', array(
    		'id' => null
    	));
		
		$attributes = shortcode_atts($defaults, $atts);

		$tableId = $attributes['id'];
		$post = get_post($tableId);
		$mortgageMeta_Data = get_post_meta($tableId, '_ninija_mortgage_table_config', true);
		
		wp_enqueue_script(
			'ninja_mortgage_calculator',
			NINJA_MORTGAGE_PLUGIN_DIR_URL.'public/js/UserShowApp.js',
			array('jquery'),
			NINJA_MORTGAGE_PLUGIN_DIR_VERSION,
			true
		);

		wp_localize_script('ninja_mortgage_calculator', 'ninja_mortgage_cal_vars', array(
			'post' => $post,
			'tableId' => $tableId,
			'mortgageMetaData' => $mortgageMeta_Data
		));

	
		return "<div id='ninja_mortgage_calculator'></div>";

	}

	private static function getViewNameByDisplay( $display ) {
		$displayArray = array(
			'mortgage_calculator'   => 'mortgage_calculator', //file name
			'mortgage_refinance'	=> 'mortgage_refinance',
			'mortgage_payment'      => 'mortgage_payment'
		);

		$return       = 'mortgage_calculator';

		if ( isset( $displayArray[ $display ] ) ) {
			$return = $displayArray[ $display ];
		}

		return apply_filters( 'mortgage_calculator_get_view_name_by_display', $return, $display );
	}

	public static function addTable($tableTitle = '', $calculatorType = '')
	{
		if ( ! $tableTitle ) {
			wp_send_json_error(array(
				'message' => __( "Please Provide Table Title", 'ninja_mortgage')
			), 423);
		}
 
		if ( ! $calculatorType ) {
			wp_send_json_error(array(
				'message' => __("Please Select Calculator Type", 'ninja_mortgage')
			), 423);
		}

		$tableData = array(
			'post_title' => $tableTitle,
			'post_content' => $calculatorType,
			'post_type' => CPT::$CPTName,
			'post_status' => 'publish',
		);

		self::$selectedCalc = $calculatorType; //post_content(mortgage calculator select)

		$tableId = wp_insert_post($tableData);

		do_action('ninja_mortgage_added_new_table', $tableId);

		if (is_wp_error($tableId)) {
			wp_send_json_error(array(
				'message' => $tableId->get_error_message()
			), 423);
		}

		wp_send_json_success(array(
            'message'  => __('Table Successfully created'),
            'table_id' => $tableId
        ), 200);
	}

	public  static function getTable($tableId, $returnType = 'ajax')
	{
		$table = get_post($tableId);

		$formattedTable = (object)array(
			'ID' => $table->ID,
			'post_title' => $table->post_title,
			'CalCulatorType' => $table->post_content
		);

		$tableConfig = get_post_meta($tableId, '_ninija_mortgage_table_config', true);
		 
		 wp_send_json_success(array(
            'table'        => $formattedTable,
            'table_config' => $tableConfig,
            'MortgageCalConfig' => static::getMortgageCalConfig(),
            'demo_url' => home_url().'?ninja_mortgage_calculator_preview='.$tableId.'#ninja_mortgage_demo'
        ));
	}

	public static function getTables($pageNumber = 1 , $perPage = 10)
	{
		$offset = ($pageNumber - 1 ) * $perPage;

		$tables = get_posts(array(
			'post_type' => CPT::$CPTName,
			'offset' => $offset,
			'posts_per_page' => $perPage
		));
		
		$totalCount = wp_count_posts(CPT::$CPTName);
	
	    $formattedTables = array();

        foreach ($tables as $table) {
            $formattedTables[] = array(
                'ID'         => $table->ID,
                'post_title' => $table->post_title,
                'CalCulatorType' => $table->post_content,
                'demo_url' => home_url().'?ninja_mortgage_calculator_preview='.$table->ID.'#ninja_mortgage_demo'
            );
        }

        wp_send_json_success(array(
            'tables' => $formattedTables,
            'total' => intval($totalCount->publish)
        ), 200);
	}

	public static function deleteTable($tableId)
	{
		delete_post_meta($tableId, '_ninija_mortgage_table_config');	
		wp_delete_post($tableId);
		wp_send_json_success(array(
            'message' => __('The Table successfully deleted!', 'ninja_mortgage')
        ), 200);
	}

	public static function updateTableConfig($tableId, $table_config, $calculatorType)
	{
		$UpdateMortgageCalculator = array(
	      'ID'           => $tableId,
	      'post_content' => $calculatorType
		);

		wp_update_post( $UpdateMortgageCalculator );
		update_post_meta($tableId, '_ninija_mortgage_table_config', $table_config);

		do_action('ninija_mortgage_table_config_updated', $tableId, $table_config);

		$tableConfig = get_post_meta($tableId, '_ninija_mortgage_table_config', true);

		wp_send_json_success(array(
            'message' => __('Table Content has been updated', 'ninja_mortgage'),
            'updatedData' => $tableConfig,
        ));
	}

	public static function populateDemoData($tableId) //add meta label etc
    {
        update_post_meta($tableId, '_ninija_mortgage_table_config', static::getMortgageCalConfig());
    }

    public static function getMortgageCalConfig()
    {	
    	if ( self::$selectedCalc == 'mortgage_calculator' ) {

    		return array(
			
				'selectedLabel' => array(
	                'loanAmount' 	     => 'Loan Amount',
	                'downPament'	     => 'Down Payment',
	                'mortgageTerm'	     => 'Mortgage Term',
	                'annualInterestRate' => 'Annual Interest Rate',
	            ),

				'selectedDefault' => array(
					'loanAmountDefVal' 		  => 120000,
					'downPamentDefVal'		  => 20000,
					'mortgageTermDefVal'	  => 30,
					'annualInterestRateDefVal'=> 12
				),
					
				'settings' => false
			);

    	} elseif( self::$selectedCalc == 'mortgage_refinance' ) {

    		return array(

    			'selectedLabel' => array(
					'currentlyMonthlyPayment' => 'Currently Monthly Payment',
					'loanIntRate' 			  => 'Current Loan interest rate',
					'balanceMortgage'		  => 'Balance left on mortgage',
					'newIntRate' 			  => 'New Interest Rate',
					'remainingLoanTerm'		  => 'Remaining Loan Term',
					'newLoanTerm' 			  => 'New Loan Term',
					'points'				  => 'Points',
					'applicationFee' 		  => 'Application Fee',
					'creditCheck' 			  => 'Credit Check', 
					'attorneyFeeYours'        => 'Attorney\'s Fee(yours)',
					'attorneyFeeLenders'      => 'Attorney\'s Fee(lenders)',
					'titleSearch'             => 'Title Search', 
					'titleInsurance' 		  => 'Title Insurance',
					'appraisalFee' 			  => 'Appraisal Fee',
					'inspections'			  => 'Inspections',
					'localFees'               => 'Local Fees (Taxes, Transfers)',
					'documentPreparation'     => 'Document Preparation',
					'other'                   => 'Other'
				),
				
				'selectedDefault' => array(
					'currentlyMonthlyPaymentDefVal'=> 1200,
					'loanIntRateDefVal'			   => 25,
					'balanceMortgageDefVal'		   => 25000,
					'newIntRateDefVal'			   => 15,
					'remainingLoanTermDefVal'	   => 20,
					'newLoanTermDefVal'			   => 26,
					'pointsDefVal' 				   => 1,
					'applicationFeeDefVal' 		   => 0,
					'creditCheckDefVal'			   => 0, 
					'attorneyFeeYoursDefVal'	   => 0,
					'attorneyFeeLendersDefVal' 	   => 0,
					'titleSearchDefVal'			   => 0, 
					'titleInsuranceDefVal' 		   => 0,
					'appraisalFeeDefVal'           => 0,
					'inspectionsDefVal'			   => 0,
					'localFeesDefVal' 			   => 0,
					'documentPreparationDefVal'    => 0,
					'otherDefVal'                  => 0
				)

    		);

    	} elseif( self::$selectedCalc == 'mortgage_payment' ) {

    		return array(

    			'selectedLabel' => array(
					'mortgageAmount' 	  => 'Mortgage Amount',
					'termInYears' 		  => 'Term in years',
					'interestRate' 		  => 'Interest Rate',
					'annualPropertyTaxes' => 'Annual Property Taxes',
					'annualHomeInsurance' => 'Annual Home Insurance'
				),

				'selectedDefault' => array(
					'mortgageAmountDefVal'	   => 2500,
					'termInYearsDefVal'		   => 5,
					'interestRateDefVal'	   => 25,
					'annualHomeInsuranceDefVal'=> 3500,
					'annualPropertyTaxesDefVal'=> 1500
				)
    		);
    	}
	}
}
