<template>
	<div class="mortgage_payment_calc">
		<div class="loan-info">
			<h3>{{ tableTitle }}</h3> 
			<div class="mortgage_amount">
				<label>{{ !mortgagePaymentLabel.mortgageAmount ? "Mortgage Amount" : mortgagePaymentLabel.mortgageAmount }} ({{curr_type}})</label>
				<div class="inp_fields">
                    <input type="number" min=0 name="mortgage_amount"
					   id="mortgage_amount" v-model="mortgage_amount_def_val" :placeholder="getMortgageAmnt(mortgagePaymentLabel.mortgageAmount)"
					   class="typeNumbersField">
                </div>
			</div>
			<div class="term_in_years">
				<label>{{ !mortgagePaymentLabel.termInYears ? "Term in year" : mortgagePaymentLabel.termInYears }}</label>
				<div class="inp_fields">
                    <input type="number" min=0 name="term_in_years"
					   id="term_in_years" v-model="term_in_years_def_val" :placeholder="getTermInYears(mortgagePaymentLabel.termInYears)"
					   class="typeNumbersField">
                </div>
			</div>
			<div class="interest_rate">
				<label>{{ !mortgagePaymentLabel.interestRate ? "Interest Rate" : mortgagePaymentLabel.interestRate }} (%)</label>
				<div class="inp_fields">
                    <input type="number" min=0 name="interest_rate"
					   id="interest_rate" v-model="interest_rate_def_val" :placeholder="getInterestRate(mortgagePaymentLabel.interestRate)"
					   class="typeNumbersField">
                </div>
			</div>
			<div class="annual_property_taxes">
				<label>{{ !mortgagePaymentLabel.annualPropertyTaxes ? "Annual Property Taxes" : mortgagePaymentLabel.annualPropertyTaxes }} ({{curr_type}})</label>
				<div class="inp_fields">
                    <input type="number" min=0 name="annual_property_taxes"
					   id="annual_property_taxes" v-model="annual_property_taxes_def_val" :placeholder="getPropTaxes(mortgagePaymentLabel.annualPropertyTaxes)"
					   class="typeNumbersField">
                </div>
			</div>
			<div class="annual_property_insurance">
				<label>{{ !mortgagePaymentLabel.annualHomeInsurance ? "Annual Home Insurance" : mortgagePaymentLabel.annualHomeInsurance }} ({{curr_type}})</label>
				<div class="inp_fields">
                    <input type="number" min=0 name="annual_property_insurance"
					   id="annual_property_insurance" v-model="annual_property_insurance_def_val" :placeholder="getInsurance(mortgagePaymentLabel.annualHomeInsurance)"
					   class="typeNumbersField">
                </div>
			</div>
			<div class="mortgage_payment_pi">
				<h4><strong>Monthly Payment(PI):</strong></h4>
                <h5>{{curr_type}} {{ pi.toFixed(2) }}</h5>
			</div>
			<div class="mortgage_payment_piti">
				<h4><strong>Monthly Payment(PITI):</strong></h4>
                 <h5>{{curr_type}} {{ piti.toFixed(2) }}</h5>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: [
		'tableTitle',
		'mortgagePaymentLabel',
        'mortgagePaymentDefault',
        'currencyType'
	],
    data() {
        return {
        	mortgage_amount: 'Mortgage Amount',
            mortgage_amount_def_val: 120000,
            term_in_years: 'Term in years',
            term_in_years_def_val: 30,
            interest_rate: 'Interest rate',
            interest_rate_def_val: 12,
            annual_property_taxes: 'Annual Property Taxes',
            annual_property_taxes_def_val: 15,
            annual_property_insurance: 'Annual Property Insurance',
            annual_property_insurance_def_val: 15,
            curr_type: ''
        }
    },
    created() {
    	this.mortgage_amount = this.mortgagePaymentLabel.mortgageAmount;
    	this.mortgage_amount_def_val = this.mortgagePaymentDefault.mortgageAmountDefVal;
    	this.term_in_years = this.mortgagePaymentLabel.termInYears;
    	this.term_in_years_def_val = this.mortgagePaymentDefault.termInYearsDefVal;
    	this.interest_rate = this.mortgagePaymentLabel.interestRate;
    	this.interest_rate_def_val = this.mortgagePaymentDefault.interestRateDefVal;
    	this.annual_property_taxes = this.mortgagePaymentLabel.annualPropertyTaxes;
    	this.annual_property_taxes_def_val = this.mortgagePaymentDefault.annualPropertyTaxesDefVal;
    	this.annual_property_insurance = this.mortgagePaymentLabel.annualHomeInsurance;
        this.annual_property_insurance_def_val = this.mortgagePaymentDefault.annualHomeInsuranceDefVal;
        if(!this.currencyType) {
            this.curr_type = "$";
        } else {
            this.curr_type = this.currencyType
        }
    },
    computed: {
        pi() {
            if( this.interest_rate_def_val != 0 && this.mortgage_amount_def_val != 0 && this.term_in_years_def_val != 0 ) {
                var interest_rate_perc = parseFloat( this.interest_rate_def_val ) / 12;
                var interest_rate_ans = parseFloat( interest_rate_perc ) / 100;
                var int_rate_amnt = parseFloat(interest_rate_ans * this.mortgage_amount_def_val);
                var total_month = parseFloat( this.term_in_years_def_val ) * 12;
                var pi = int_rate_amnt / (  1 - (Math.pow((1 + interest_rate_ans), -(total_month) )));
                return pi;
            } else {
                return 0;
            }
        },
        piti() {
            if( this.interest_rate_def_val != 0 && this.mortgage_amount_def_val != 0 && this.term_in_years_def_val != 0 && ( this.annual_property_taxes_def_val != 0 || this.annual_property_insurance_def_val != 0 )) {
                var interest_rate_perc = parseFloat( this.interest_rate_def_val ) / 12;
                var interest_rate_ans = parseFloat( interest_rate_perc ) / 100;
                var int_rate_amnt = parseFloat(interest_rate_ans * this.mortgage_amount_def_val);
                var total_month = parseFloat( this.term_in_years_def_val ) * 12;
                var pi = int_rate_amnt / (  1 - (Math.pow((1 + interest_rate_ans), -(total_month) )));
                
                
                var piti = pi + ( this.annual_property_taxes_def_val / 12 ) + (this.annual_property_insurance_def_val / 12);
                return piti;
            } else {
                return 0;
            }
        }
    },
    methods: {
        getMortgageAmnt(str) {
            if(str == '') {
                return 'Mortgage Amount'
            }
            return str;
        },
        getTermInYears(str) {
            if(str == '') {
                return 'Term in Year'
            }
            return str;
        },
        getInterestRate(str) {
            if(str == '') {
                return 'Interest Rate'
            }
            return str;
        },
        getPropTaxes(str) {
            if(str == '') {
                return 'Annual Property Taxes'
            }
            return str;
        },
        getInsurance(str) {
            if(str=='') {
                return 'Annual Home Insurance'
            }
            return str;
        }
    }
}
</script>