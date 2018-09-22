<?php namespace NinjaMortgage\Classes;

class Menu {

	public static function addAdminMenuPages() {
		add_menu_page(
			__( 'Mortgage Calculator', 'ninja_mortgage' ),
			__( 'Mortgage Calc.', 'ninja_mortgage' ),
			static::managePermission(),
			'ninja-mortgage-calculator',
			array( static::class, 'renderMortgage' ),
			self::getMenuIcon(),
			36
		);
	}


	public static function managePermission() {
		return apply_filters( 'ninja_mortgage_menu_manager_permission', 'manage_options' );
	}

	public static function renderMortgage() {
		wp_enqueue_script(
			'ninja_mortgage_calc',
			NINJA_MORTGAGE_PLUGIN_DIR_URL . 'public/js/ninja_mortgage_calc.js',
			array( 'jquery' ),
			NINJA_MORTGAGE_PLUGIN_DIR_VERSION,
			true
		);

		wp_localize_script( 'ninja_mortgage_calc', 'ninja_mortgage_calc', array(
			'currencies' => self::getCurrencies()
		) );


		include NINJA_MORTGAGE_PLUGIN_DIR_PATH . 'views/admin_view.php';
	}

	public static function getMenuIcon() {
		return 'data:image/svg+xml;base64,'
		       . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 505 505"><defs><style>.cls-1{fill:#fff;}</style></defs><title>dashboard_icon</title><g id="Layer_2" data-name="Layer 2"><g id="icon"><g id="_" data-name="+"><path class="cls-1" d="M247,0H71.83A71.83,71.83,0,0,0,0,71.83V247H247ZM148.6,167.87a29.43,29.43,0,0,1-17.71,9.35v12a2.11,2.11,0,0,1-2.19,2.19h-9.25a2.22,2.22,0,0,1-2.19-2.19v-12a43.25,43.25,0,0,1-8.74-2.12,42.07,42.07,0,0,1-12-6.34,39.07,39.07,0,0,1-3.19-2.57q-.86-.82-1.2-1.23a2.08,2.08,0,0,1-.14-2.81L99,152.9a2.14,2.14,0,0,1,1.58-.82,1.7,1.7,0,0,1,1.64.62l.14.14A35.77,35.77,0,0,0,119,161.39a23.89,23.89,0,0,0,5.07.55,16.61,16.61,0,0,0,9.76-2.95,9.59,9.59,0,0,0,4.21-8.36,7,7,0,0,0-1-3.63,12.9,12.9,0,0,0-2.3-2.88,18.92,18.92,0,0,0-4-2.57q-2.74-1.4-4.52-2.19t-5.48-2.23l-4.21-1.71q-1.54-.62-4.21-1.82T108,131.49q-1.61-.93-3.87-2.43a24.05,24.05,0,0,1-3.67-2.91,42.33,42.33,0,0,1-3-3.36,16.73,16.73,0,0,1-2.43-4,27.31,27.31,0,0,1-1.44-4.56,23.81,23.81,0,0,1-.58-5.34,23.43,23.43,0,0,1,6.71-16.58,31.36,31.36,0,0,1,17.47-9.18V70.82a2.22,2.22,0,0,1,2.19-2.19h9.25a2.11,2.11,0,0,1,2.19,2.19V82.87a38.18,38.18,0,0,1,7.57,1.58,44.11,44.11,0,0,1,6,2.3,33.06,33.06,0,0,1,4.35,2.57q2.06,1.44,2.67,2t1,1a2,2,0,0,1,.34,2.6l-5.55,10a1.87,1.87,0,0,1-1.58,1.1,2.18,2.18,0,0,1-1.85-.48q-.21-.21-1-.82t-2.67-1.82a35.71,35.71,0,0,0-4-2.19,30.85,30.85,0,0,0-5.1-1.78,22.9,22.9,0,0,0-5.86-.79q-6.51,0-10.62,2.95A9.21,9.21,0,0,0,111,111.92a7.71,7.71,0,0,0,2,2.84,30.21,30.21,0,0,0,2.71,2.26,24,24,0,0,0,3.84,2.12q2.57,1.2,4.15,1.85t4.8,1.88q3.63,1.37,5.55,2.16t5.21,2.4a41.56,41.56,0,0,1,5.17,2.91,44.09,44.09,0,0,1,4.25,3.43,17.8,17.8,0,0,1,3.63,4.35,24.86,24.86,0,0,1,2.16,5.24,22.66,22.66,0,0,1,.89,6.44A26.07,26.07,0,0,1,148.6,167.87Z"/><path class="cls-1" d="M258,505H433.17A71.83,71.83,0,0,0,505,433.17V258H258Zm83.55-151.13h70a11.67,11.67,0,0,1,0,23.35h-70a11.67,11.67,0,0,1,0-23.35Zm0,36.86h70a11.67,11.67,0,0,1,0,23.35h-70a11.67,11.67,0,0,1,0-23.35Z"/><path class="cls-1" d="M0,258V433.17A71.83,71.83,0,0,0,71.83,505H247V258ZM100.7,342.4a15.36,15.36,0,1,1-15.36,15.36A15.36,15.36,0,0,1,100.7,342.4Zm-9.06,73.77h0a11.67,11.67,0,0,1,0-16.51l49.52-49.52a11.67,11.67,0,0,1,16.51,0h0a11.67,11.67,0,0,1,0,16.51l-49.52,49.52A11.67,11.67,0,0,1,91.65,416.17Zm58.82,4.46a15.36,15.36,0,1,1,15.36-15.36A15.36,15.36,0,0,1,150.46,420.63Z"/><path class="cls-1" d="M433.17,0H258V247H505V71.83A71.83,71.83,0,0,0,433.17,0ZM413.61,169.48a4.45,4.45,0,0,1-4.39,4.39H382.91V147.55H365.37v26.31H339.06a4.45,4.45,0,0,1-4.39-4.39V136.59a.91.91,0,0,1,0-.21,1,1,0,0,0,0-.21l39.4-32.48,39.4,32.48a1,1,0,0,1,.07.41Zm15.28-37.61-4.25,5.07a2.33,2.33,0,0,1-1.44.75H423a2.1,2.1,0,0,1-1.44-.48L374.14,97.67l-47.41,39.53a2.54,2.54,0,0,1-1.65.48,2.33,2.33,0,0,1-1.44-.75l-4.25-5.07a2.21,2.21,0,0,1-.48-1.61,2,2,0,0,1,.75-1.47l49.26-41a8.5,8.5,0,0,1,10.41,0l16.72,14V88.35a2.11,2.11,0,0,1,2.19-2.19h13.15a2.11,2.11,0,0,1,2.19,2.19v28l15,12.47a2,2,0,0,1,.75,1.47A2.23,2.23,0,0,1,428.89,131.86Z"/></g></g></g></svg>' );
	}

	public static function getCurrencies() {
		$currencies = array(
			array(
				'value' => '$',
				'label' => 'USD (US$)'
			),
			array(
				'value' => '€',
				'label' => 'EUR (€)'
			),
			array(
				'value' => '¥',
				'label' => 'JPY (¥)'
			),
			array(
				'value' => '£',
				'label' => 'GBP (£)'
			),
			array(
				'value' => 'A$',
				'label' => 'AUD (A$)'
			),
			array(
				'value' => 'C$',
				'label' => 'CAD (C$)'
			),
			array(
				'value' => 'Fr',
				'label' => 'CHF (Fr)'
			),
			array(
				'value' => 'NZ$',
				'label' => 'NZD (NZ$)'
			),
			array(
				'value' => 'HK$',
				'label' => 'HKD (HK$)'
			),
			array(
				'value' => '₩',
				'label' => 'KRW (₩)'
			),
			array(
				'value' => '₺',
				'label' => 'TRY (₺)'
			),
			array(
				'value' => '₽',
				'label' => 'RUB (₽)'
			),
			array(
				'value' => '₹',
				'label' => 'INR (₹)'
			),
			array(
				'value' => 'R$',
				'label' => 'BRL (R$)'
			),
			array(
				'value' => 'R',
				'label' => 'ZAR (R)'
			),
			array(
				'value' => '৳',
				'label' => 'BDT (৳)'
			),
			array(
				'value' => '₪',
				'label' => 'ILS (₪)'
			),
			array(
				'value' => 'ரூ',
				'label' => 'LKR (ரூ)'
			)
		);
		
		return apply_filters('ninja_mortgage_currencies', $currencies);
	}
}
