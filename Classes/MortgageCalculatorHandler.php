<?php namespace NinjaMortgage\Classes;

class MortgageCalculatorHandler {
	protected static $selectedCalc;

	public static function handleAjaxCalls() {
		$route = sanitize_text_field( $_REQUEST['route'] );
		if ( ! current_user_can( Menu::managePermission() ) ) {
			return;
		}

		if ( $route == 'add_table' ) {
			$tableTitle     = sanitize_text_field( $_REQUEST['post_title'] );
			$calculatorType = sanitize_text_field( $_REQUEST['calculator_type'] );
			static::addTable( $tableTitle, $calculatorType );
		}

		if ( $route == 'get_tables' ) {

			$pageNumber = intval( $_REQUEST['page_number'] );
			$perPage    = intval( $_REQUEST['per_page'] );

			if ( isset( $_REQUEST['search'] ) && $_REQUEST['search'] ) {
				$search = sanitize_text_field( $_REQUEST['search'] );
			}

			static::getTables( $pageNumber, $perPage, $search );
		}

		if ( $route == 'get_table' ) {
			$tableId = intval( $_REQUEST['table_id'] );
			static::getTable( $tableId, 'ajax' );
		}


		if ( $route == 'delete_table' ) {
			$tableId = intval( $_REQUEST['table_id'] );
			static::deleteTable( $tableId );
		}

		if ( $route == 'update_table_config' ) {
			$tableId      = intval( $_REQUEST['table_id'] );
			$table_con    = wp_unslash( $_REQUEST['table_config'] );
			$table_config = json_decode( trim( stripslashes( $table_con ) ), true );

			$title = sanitize_text_field( $_REQUEST['post_title'] );

			$calculatorType = sanitize_text_field( $_REQUEST['calculator_type'] );
			static::updateTableConfig( $tableId, $table_config, $title, $calculatorType );
		}
	}

	public static function handleShortCode( $atts ) {
		$defaults = apply_filters( 'mortgage_calculator_shortcode_defaults', array(
			'id' => null
		) );

		$attributes = shortcode_atts( $defaults, $atts );

		$tableId           = $attributes['id'];
		$post              = get_post( $tableId );
		$mortgageMeta_Data = get_post_meta( $tableId, '_ninija_mortgage_table_config', true );
		if ( ! $post || ! $mortgageMeta_Data ) {
			return;
		}

		wp_enqueue_style( 'ninja_mortgage_public_css' );
		wp_enqueue_script(
			'ninja_mortgage_calculator',
			NINJA_MORTGAGE_PLUGIN_DIR_URL . 'public/js/UserShowApp.js',
			array( 'jquery' ),
			NINJA_MORTGAGE_PLUGIN_DIR_VERSION,
			true
		);


		global $mortgageCalculatorInstances;
		$mortgageCalculatorInstances[] = $tableId;
		$instanceId                    = count( $mortgageCalculatorInstances );

		wp_localize_script( 'ninja_mortgage_calculator', 'ninja_mortgage_cal_vars_' . $instanceId, array(
			'post'             => $post,
			'tableId'          => $tableId,
			'instance_id'      => $instanceId,
			'mortgageMetaData' => $mortgageMeta_Data
		) );

		return "<div class='ninja_mortgage_calculator_instance' data-instance_id='" . $instanceId
		       . "' id='ninja_mortgage_calculator_instance_" . $instanceId . "'></div>";
	}

	private static function getViewNameByDisplay( $display ) {
		$displayArray = array(
			'mortgage_calculator' => 'mortgage_calculator', //file name
			'mortgage_refinance'  => 'mortgage_refinance',
			'mortgage_payment'    => 'mortgage_payment'
		);

		$return = 'mortgage_calculator';

		if ( isset( $displayArray[ $display ] ) ) {
			$return = $displayArray[ $display ];
		}

		return apply_filters( 'mortgage_calculator_get_view_name_by_display', $return, $display );
	}

	public static function addTable( $tableTitle = '', $calculatorType = '' ) {
		if ( ! $tableTitle ) {
			wp_send_json_error( array(
				'message' => __( "Please Provide Table Title", 'ninja_mortgage' )
			), 423 );
		}

		if ( ! $calculatorType ) {
			wp_send_json_error( array(
				'message' => __( "Please Select Calculator Type", 'ninja_mortgage' )
			), 423 );
		}

		$tableData = array(
			'post_title'   => $tableTitle,
			'post_content' => $calculatorType,
			'post_type'    => CPT::$CPTName,
			'post_status'  => 'publish',
		);

		self::$selectedCalc = $calculatorType; //post_content(mortgage calculator select)

		$tableId = wp_insert_post( $tableData );

		do_action( 'ninja_mortgage_added_new_table', $tableId );

		if ( is_wp_error( $tableId ) ) {
			wp_send_json_error( array(
				'message' => $tableId->get_error_message()
			), 423 );
		}

		wp_send_json_success( array(
			'message'  => __( 'Table Successfully created' ),
			'table_id' => $tableId
		), 200 );
	}

	public static function getTable( $tableId, $returnType = 'ajax' ) {
		$table = get_post( $tableId );

		$formattedTable = (object) array(
			'ID'             => $table->ID,
			'post_title'     => $table->post_title,
			'CalCulatorType' => $table->post_content
		);

		$tableConfig = get_post_meta( $tableId, '_ninija_mortgage_table_config', true );
		
		wp_send_json_success( array(
			'table'             => $formattedTable,
			'table_config'      => $tableConfig,
			'MortgageCalConfig' => static::getMortgageCalConfig(),
			'demo_url'          => home_url() . '?ninja_mortgage_calculator_preview=' . $tableId
			                       . '#ninja_mortgage_demo'
		) );
	}

	public static function getTables( $pageNumber = 1, $perPage = 10, $search = '' ) {
		$offset = ( $pageNumber - 1 ) * $perPage;

		$tables = get_posts( array(
			'post_type'      => CPT::$CPTName,
			'offset'         => $offset,
			'posts_per_page' => $perPage
		) );

		$totalCount = wp_count_posts( CPT::$CPTName );

		$formattedTables = array();

		foreach ( $tables as $table ) {
			$formattedTables[] = array(
				'ID'             => $table->ID,
				'post_title'     => $table->post_title,
				'CalCulatorType' => $table->post_content,
				'demo_url'       => home_url() . '?ninja_mortgage_calculator_preview=' . $table->ID
				                    . '#ninja_mortgage_demo'
			);
		}

		wp_send_json_success( array(
			'tables' => $formattedTables,
			'total'  => intval( $totalCount->publish )
		), 200 );
	}

	public static function deleteTable( $tableId ) {
		delete_post_meta( $tableId, '_ninija_mortgage_table_config' );
		wp_delete_post( $tableId );
		wp_send_json_success( array(
			'message' => __( 'The Table successfully deleted!', 'ninja_mortgage' )
		), 200 );
	}

	public static function updateTableConfig( $tableId, $table_config, $title, $calculatorType ) {
		$UpdateMortgageCalculator = array(
			'ID'           => $tableId,
			'post_title'   => $title,
			'post_content' => $calculatorType
		);

		wp_update_post( $UpdateMortgageCalculator );
		update_post_meta( $tableId, '_ninija_mortgage_table_config', $table_config );

		do_action( 'ninija_mortgage_table_config_updated', $tableId, $table_config );

		$tableConfig = get_post_meta( $tableId, '_ninija_mortgage_table_config', true );

		wp_send_json_success( array(
			'message'     => __( 'Table Content has been updated', 'ninja_mortgage' ),
			'updatedData' => $tableConfig,
		) );
	}

	public static function populateDemoData( $tableId ) //add meta label etc
	{
		update_post_meta( $tableId, '_ninija_mortgage_table_config', static::getMortgageCalConfig() );
	}

	public static function getMortgageCalConfig() {
		if ( self::$selectedCalc == 'mortgage_calculator' ) {

			return array(

				'selectedLabel' => array(
					'loanAmount'         => __( 'Loan Amount', 'ninja_mortgage' ),
					'downPament'         => __( 'Down Payment', 'ninja_mortgage' ),
					'mortgageTerm'       => __( 'Mortgage Term', 'ninja_mortgage' ),
					'annualInterestRate' => __( 'Annual Interest Rate', 'ninja_mortgage' ),
				),

				'selectedDefault' => array(
					'loanAmountDefVal'         => 120000,
					'downPamentDefVal'         => 20000,
					'mortgageTermDefVal'       => 30,
					'annualInterestRateDefVal' => 12
				),

				'settings' => false,
				
				'currency_type' => '$'
			);

		} elseif ( self::$selectedCalc == 'mortgage_refinance' ) {

			return array(
				'selectedLabel' => array(
					'currentlyMonthlyPayment' => __( 'Currently Monthly Payment', 'ninja_mortgage' ),
					'loanIntRate'             => __( 'Current Loan interest rate', 'ninja_mortgage' ),
					'balanceMortgage'         => __( 'Balance left on mortgage', 'ninja_mortgage' ),
					'newIntRate'              => __( 'New Interest Rate', 'ninja_mortgage' ),
					'remainingLoanTerm'       => __( 'Remaining Loan Term', 'ninja_mortgage' ),
					'newLoanTerm'             => __( 'New Loan Term', 'ninja_mortgage' ),
					'points'                  => __( 'Points', 'ninja_mortgage' ),
					'applicationFee'          => __( 'Application Fee', 'ninja_mortgage' ),
					'creditCheck'             => __( 'Credit Check', 'ninja_mortgage' ),
					'attorneyFeeYours'        => __( 'Attorney\'s Fee(yours)', 'ninja_mortgage' ),
					'attorneyFeeLenders'      => __( 'Attorney\'s Fee(lenders)', 'ninja_mortgage' ),
					'titleSearch'             => __( 'Title Search', 'ninja_mortgage' ),
					'titleInsurance'          => __( 'Title Insurance', 'ninja_mortgage' ),
					'appraisalFee'            => __( 'Appraisal Fee', 'ninja_mortgage' ),
					'inspections'             => __( 'Inspections', 'ninja_mortgage' ),
					'localFees'               => __( 'Local Fees (Taxes, Transfers)', 'ninja_mortgage' ),
					'documentPreparation'     => __( 'Document Preparation', 'ninja_mortgage' ),
					'other'                   => __( 'Other', 'ninja_mortgage' )
				),

				'selectedDefault' => array(
					'currentlyMonthlyPaymentDefVal' => 1200,
					'loanIntRateDefVal'             => 25,
					'balanceMortgageDefVal'         => 25000,
					'newIntRateDefVal'              => 15,
					'remainingLoanTermDefVal'       => 20,
					'newLoanTermDefVal'             => 26,
					'pointsDefVal'                  => 1,
					'applicationFeeDefVal'          => 0,
					'creditCheckDefVal'             => 0,
					'attorneyFeeYoursDefVal'        => 0,
					'attorneyFeeLendersDefVal'      => 0,
					'titleSearchDefVal'             => 0,
					'titleInsuranceDefVal'          => 0,
					'appraisalFeeDefVal'            => 0,
					'inspectionsDefVal'             => 0,
					'localFeesDefVal'               => 0,
					'documentPreparationDefVal'     => 0,
					'otherDefVal'                   => 0
				),
				
				'currency_type' => '$'

			);

		} elseif ( self::$selectedCalc == 'mortgage_payment' ) {

			return array(

				'selectedLabel' => array(
					'mortgageAmount'      => __( 'Mortgage Amount', 'ninja_mortgage' ),
					'termInYears'         => __( 'Term in year', 'ninja_mortgage' ),
					'interestRate'        => __( 'Interest Rate', 'ninja_mortgage' ),
					'annualPropertyTaxes' => __( 'Annual Property Taxes', 'ninja_mortgage' ),
					'annualHomeInsurance' => __( 'Annual Home Insurance', 'ninja_mortgage' )
				),

				'selectedDefault' => array(
					'mortgageAmountDefVal'      => 2500,
					'termInYearsDefVal'         => 5,
					'interestRateDefVal'        => 25,
					'annualHomeInsuranceDefVal' => 3500,
					'annualPropertyTaxesDefVal' => 1500
				),

				'currency_type' => '$'
			);
		}
	}
}