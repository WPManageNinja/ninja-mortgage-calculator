<template>
<div class="ninja_mortgage_cal">

	<!-- Header -->
        <div class="header">
            <div style="display: flex; justify-content: space-between;">
                <div style="flex: 1">
                    <h1>{{ post_title }}
                        <span>
                            <code class="copy_shortcode" :data-clipboard-text='`[ninja_mortgage_cal id="${table_id}"]`'>
								[ninja_mortgage_cal id="{{table_id}}"]
							</code>
                        </span>
                    </h1>
                </div>
                <div class="table_action_btn">
                    <el-button class="common_btn" @click="updateTableConfig" type="success" size="mini">
                        Update
                    </el-button>
                    <a :href="demo_url" target="_blank" style="color: #fff; text-decoration: none;">
                        <el-button class="common_btn" type="primary" size="mini">Preview</el-button>
                    </a>
                </div>
            </div>
        </div>


	<el-row>
		<el-col class="fields">
			<div class="calc_title">
				<h2>Calculator Title:</h2>
				<el-input placeholder="Title" class="recipe_title" v-model="post_title"></el-input>
			</div>
			<div class="calc_preview_section">
				<h2 v-if="calc_type==='mortgage_payment'">Mortgage Payment Calculator</h2>
				<h2 v-if="calc_type==='mortgage_calculator'">Mortgage Calculator</h2>
				<h2 v-if="calc_type==='mortgage_refinance'">Mortgage Refinance Calculator</h2>

				<div class="change_type">
					<el-select v-model="calc_type" placeholder="Calculator Type">
						<el-option
								v-for="(type, i) in calc_types"
								:key="i"
								:label="type.label"
								:value="type.value">
							</el-option>
					</el-select>
				</div>
				
				<div v-if="calc_type=='mortgage_calculator'"  style="margin-top: 20px">
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_mort_calc_table.loanAmount ? "Loan Amount" : all_mort_calc_table.loanAmount }} </label>
							<el-input type="text" 
									placeholder="Loan Amount"  
									v-model="all_mort_calc_table.loanAmount" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_mort_calc_table.downPament ? "Down Pament" : all_mort_calc_table.downPament }}</label>
							<el-input type="text" 
									placeholder="Down Pament" 
									v-model="all_mort_calc_table.downPament" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_mort_calc_table.downPament ? "Down Pament" : all_mort_calc_table.downPament }} Percentage</label>
							<el-input type="text" 
									:placeholder="getDownPamentPerc(all_mort_calc_table.downPament)" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_mort_calc_table.mortgageTerm ? "Mortgage Term" : all_mort_calc_table.mortgageTerm }} Years</label>
							<el-input type="text" 
									:placeholder="getMortgageTerm(all_mort_calc_table.mortgageTerm)" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_mort_calc_table.mortgageTerm ? "Mortgage Term" : all_mort_calc_table.mortgageTerm }} Months</label>
							<el-input type="text" 
									:placeholder="getMortgageTermMonth(all_mort_calc_table.mortgageTerm)" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_mort_calc_table.annualInterestRate ? "Annual Interest Rate" : all_mort_calc_table.annualInterestRate }}</label>
							<el-input type="text" 
									disabled 
									v-model="all_mort_calc_table.annualInterestRate" 
									placeholder="Annual Interest Rate"></el-input>
						</el-col>
					</el-row>
				</div>

				<div v-if="calc_type==='mortgage_refinance'">
					<el-row :gutter="15" style="margin-top: 20px">
						<el-col :span="24">
							<label>{{ !all_refinance_calc_table.currentlyMonthlyPayment ? "Currently Monthly Payment" : all_refinance_calc_table.currentlyMonthlyPayment }}</label>
							<el-input type="text"
									placeholder="Current Monthly Payment" 
									v-model="all_refinance_calc_table.currentlyMonthlyPayment" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.loanIntRate ? "Current Loan Interest Rate" : all_refinance_calc_table.loanIntRate }}</label>
							<el-input type="text" 
									placeholder="Current Loan Interest Rate" 
									v-model="all_refinance_calc_table.loanIntRate" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.balanceMortgage ? "Balance Left on Mortgage" : all_refinance_calc_table.balanceMortgage }}</label>
							<el-input type="text" 
									placeholder="Balance Left on Mortgage" 
									v-model="all_refinance_calc_table.balanceMortgage" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.newIntRate ? "New Interest Rate" : all_refinance_calc_table.newIntRate }}</label>
							<el-input type="text" 
									placeholder="New Interest Rate" 
									v-model="all_refinance_calc_table.newIntRate"
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.remainingLoanTerm ? "Remaining Loan Term" : all_refinance_calc_table.remainingLoanTerm }}</label>
							<el-input type="text" 
									placeholder="Remaining Loan Term" 
									v-model="all_refinance_calc_table.remainingLoanTerm" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_refinance_calc_table.newLoanTerm ? "New Loan Term" : all_refinance_calc_table.newLoanTerm }}</label>
							<el-input type="text" 
									placeholder="New Loan Term" 
									v-model="all_refinance_calc_table.newLoanTerm" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<p><strong>How much will it cost you?</strong></p>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.points ? "Points" : all_refinance_calc_table.points }}</label>
							<el-input type="text" 
									placeholder="Points"
									v-model="all_refinance_calc_table.points" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<p>Costs of points: $0.00</p>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.applicationFee ? "Application Fee" : all_refinance_calc_table.applicationFee }}</label>
							<el-input type="text" 
									placeholder="Application Fee"
									v-model="all_refinance_calc_table.applicationFee" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.creditCheck ? "Credit Check" : all_refinance_calc_table.creditCheck }}</label>
							<el-input type="text" 
									placeholder="Credit Check"
									v-model="all_refinance_calc_table.creditCheck" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.attorneyFeeYours ? "Attorney's fee (yours)" : all_refinance_calc_table.attorneyFeeYours }}</label>
							<el-input type="text" 
									placeholder="Attorney's fee (yours)"
									v-model="all_refinance_calc_table.attorneyFeeYours" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.attorneyFeeLenders ? "Attorney's Fee(lenders)" : all_refinance_calc_table.attorneyFeeLenders }}</label>
							<el-input type="text" 
									placeholder="Attorney's Fee(lenders)"
									v-model="all_refinance_calc_table.attorneyFeeLenders" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.titleSearch ? "Title Search" : all_refinance_calc_table.titleSearch }}</label>
							<el-input type="text" 
									placeholder="Title Search"
									v-model="all_refinance_calc_table.titleSearch" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.titleInsurance ? "Title Insurance" : all_refinance_calc_table.titleInsurance }}</label>
							<el-input type="text" 
									placeholder="Title Insurance"
									v-model="all_refinance_calc_table.titleInsurance"
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.appraisalFee ? "Appraisal Fee" : all_refinance_calc_table.appraisalFee }}</label>
							<el-input type="text"
									placeholder="Appraisal Fee" 
									v-model="all_refinance_calc_table.appraisalFee"
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.inspections ? "Inspections" : all_refinance_calc_table.inspections }}</label>
							<el-input type="text" 
									placeholder="Inspections"
									v-model="all_refinance_calc_table.inspections" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.localFees ? "Local Fees" : all_refinance_calc_table.localFees }}</label>
							<el-input type="text" 
									placeholder="Local Fees"
									v-model="all_refinance_calc_table.localFees" 
									disabled></el-input>
						</el-col>
						<el-col :span="12">
							<label>{{ !all_refinance_calc_table.documentPreparation ? "Document Preparation" : all_refinance_calc_table.documentPreparation }}</label>
							<el-input type="text" 
									placeholder="Document Preparation"
									v-model="all_refinance_calc_table.documentPreparation" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_refinance_calc_table.other ? "Other" : all_refinance_calc_table.other }}</label>
							<el-input type="text" 
									placeholder="Other"
									v-model="all_refinance_calc_table.other" 
									disabled></el-input>
						</el-col>
					</el-row>
				</div>


				<div v-if="calc_type==='mortgage_payment'">
					<el-row :gutter="15" style="margin-top: 20px">
						<el-col :span="24">
							<label>{{ !all_payment_calc_table.mortgageAmount ? "Mortgage Amount" : all_payment_calc_table.mortgageAmount }}</label>
							<el-input type="text" 
									placeholder="Mortgage Amount"
									v-model="all_payment_calc_table.mortgageAmount" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_payment_calc_table.termInYears ? "Term in Years" : all_payment_calc_table.termInYears }}</label>
							<el-input type="text"
									placeholder="Term in Years"
									v-model="all_payment_calc_table.termInYears" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_payment_calc_table.interestRate ? "Interest Rate" : all_payment_calc_table.interestRate }}</label>
							<el-input type="text" 
									placeholder="Interest Rate"
									v-model="all_payment_calc_table.interestRate" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_payment_calc_table.annualPropertyTaxes ? "Annual Property Taxes" : all_payment_calc_table.annualPropertyTaxes }}</label>
							<el-input type="text" 
									placeholder="Annual Property Taxes"
									v-model="all_payment_calc_table.annualPropertyTaxes" 
									disabled></el-input>
						</el-col>
					</el-row>
					<el-row :gutter="15">
						<el-col :span="24">
							<label>{{ !all_payment_calc_table.annualHomeInsurance ? "Annual Home Insurance" : all_payment_calc_table.annualHomeInsurance }}</label>
							<el-input type="text" 
									placeholder="Annual Home Insurance"
									v-model="all_payment_calc_table.annualHomeInsurance" 
									disabled></el-input>
						</el-col>
					</el-row>
				</div>
			</div>
		</el-col>
		<el-col :span="7" class="tabs_col">
			<!-- Tabs Component -->
			<app-tabs :calcType="calc_type" 
					  :allMortCalcTable="all_mort_calc_table" 
					  :allRefinanceCalcTable="all_refinance_calc_table"
					  :allPaymentCalcTable="all_payment_calc_table"
					  :allMortCalcDefVal="all_mort_calc_table_def_val"
					  :allRefinanceDefVal="all_refinance_calc_table_def_val"
					  :allPaymentCalcTableDefVal="all_payment_calc_table_def_val"
					  :amortTable="amort_res"
					  :currencyType="currency_type"
					  @changedAmort="updateAmort"
					  @changedCurrency="updateCurrency"></app-tabs>
		</el-col>
	</el-row>
</div>
</template>

<script>
import Tabs from '../components/Tabs.vue'
import Clipboard from 'clipboard'
export default {
		name: 'editTable',
		components: {
			'app-tabs': Tabs
		},
		data() {
			return {
				table_id: this.$route.params.table_id,
				table: {},
				post_title: '',
				calc_type: '',
				tableConfig:'',
				activeName: '',
				amort_res: 'no',
				currency_type: '',
				ammortization_table: '',
				MortgageCalConfig: {},
				settings: {},
				all_mort_calc_table: {
					loanAmount: 'Loan Amount', 
					downPament: 'Down Pament',
					mortgageTerm: 'Mortgage Term', 
					annualInterestRate: 'Annual Interest Rate'
				},
				all_mort_calc_table_def_val: {
					loanAmountDefVal: 120000,
					downPamentDefVal: 20000,
					mortgageTermDefVal: 30,
					annualInterestRateDefVal: 12
				},
				all_refinance_calc_table: {
					currentlyMonthlyPayment: 'Currently Monthly Pament', 
					loanIntRate: 'Current loan interest rate',
					balanceMortgage: 'Balance left on mortgage',
					newIntRate: 'New Interest Rate', 
					remainingLoanTerm: 'Remaining Loan Term',
					newLoanTerm: 'New Loan Term',
					points: 'Points',
					applicationFee: 'Application Fee',
					creditCheck: 'Credit Check', 
					attorneyFeeYours: 'Attorney\'s Fee(yours)',
					attorneyFeeLenders: 'Attorney\'s Fee(lenders)',
					titleSearch: 'Title Search', 
					titleInsurance: 'Title Insurance',
					appraisalFee: 'Appraisal Fee',
					inspections: 'Inspections',
					localFees: 'Local Fees (Taxes, Transfers)',
					documentPreparation: 'Document Preparation',
					other: 'Other'
				},
				all_refinance_calc_table_def_val: {
					currentlyMonthlyPaymentDefVal: 1200,
					loanIntRateDefVal: 25,
					balanceMortgageDefVal: 25000,
					newIntRateDefVal: 15,
					remainingLoanTermDefVal: 20,
					newLoanTermDefVal: 26,
					pointsDefVal: 1,
					applicationFeeDefVal: 0,
					creditCheckDefVal: 0, 
					attorneyFeeYoursDefVal: 0,
					attorneyFeeLendersDefVal: 0,
					titleSearchDefVal: 0, 
					titleInsuranceDefVal: 0,
					appraisalFeeDefVal: 0,
					inspectionsDefVal: 0,
					localFeesDefVal: 0,
					documentPreparationDefVal: 0,
					otherDefVal: 0
				},
				all_payment_calc_table: {
					mortgageAmount: 'Mortgage Amount',
					termInYears: 'Term in Years',
					interestRate: 'Interest Rate', 
					annualHomeInsurance: 'Annual Home Insurance',
					annualPropertyTaxes: 'Annual Property Taxes'
				},
				all_payment_calc_table_def_val: {
					mortgageAmountDefVal: 2500,
					termInYearsDefVal: 5,
					interestRateDefVal: 25,
					annualHomeInsuranceDefVal: 3500,
					annualPropertyTaxesDefVal: 1500
				},
				calc_types: [
                {
                    value: 'mortgage_calculator',
                    label: 'Mortgage Calculator'
                }, 
                {
                    value: 'mortgage_refinance',
                    label: 'Mortgage Refinance Calculator'
                }, 
                {
                    value: 'mortgage_payment',
                    label: 'Mortgage Payment Calculator'
                }
            ],
			updatedData: {},
			bool: false,
			demo_url: ''
			}
		},
		methods: {
			fetchTable() {
				jQuery.get(ajaxurl, {
					action: 'ninja_mortgage_ajax_actions',
					route: 'get_table',
					table_id: this.table_id
				}).then(
					(response) => {
						console.log(response)
						if(response.data.table_config.CalCulatorType) {
							this.calc_type = response.data.table_config.CalCulatorType;
						} else {
							this.calc_type = response.data.table.CalCulatorType;
						}
						
						this.post_title = response.data.table.post_title;
						this.demo_url = response.data.demo_url;
						this.currency_type = response.data.table_config.currency_type;

						if(this.calc_type == 'mortgage_calculator' ) {
							
							if(response.data.table_config.selectedLabel) {
								this.all_mort_calc_table = response.data.table_config.selectedLabel;
							}

							if(response.data.table_config.selectedDefault) {
								this.all_mort_calc_table_def_val = response.data.table_config.selectedDefault;
							}

							if(response.data.table_config.settings) {
								var amortization_table = response.data.table_config.settings;
								if( amortization_table == true ) {
									this.amort_res = 'yes';
								}
								else {
									this.amort_res = 'no';
								}
							}

						}
						else if(this.calc_type == 'mortgage_refinance') {
							
							if(response.data.table_config.selectedLabel) {
								this.all_refinance_calc_table = response.data.table_config.selectedLabel;
							}

							if(response.data.table_config.selectedDefault) {
								this.all_refinance_calc_table_def_val = response.data.table_config.selectedDefault;
							}

						}

						else if(this.calc_type == 'mortgage_payment') {
							
							if(response.data.table_config.selectedLabel) {
								this.all_payment_calc_table = response.data.table_config.selectedLabel;
							}

							if(response.data.table_config.selectedDefault) {
								this.all_payment_calc_table_def_val = response.data.table_config.selectedDefault;
							}

						}
					}
				).fail(
	                error => {
	                    console.log(error)
	                }
            	)
			},

			updateTableConfig() {

				this.bool = true;

				if( this.calc_type === 'mortgage_calculator' ) {
					var selected_label = this.all_mort_calc_table;
					var selected_default = this.all_mort_calc_table_def_val;
					var amort_table = this.ammortization_table;
				}
				else if( this.calc_type === 'mortgage_refinance' ) {
					var selected_label = this.all_refinance_calc_table;
					var selected_default = this.all_refinance_calc_table_def_val;
				}
				else {
					var selected_label = this.all_payment_calc_table;
					var selected_default = this.all_payment_calc_table_def_val;
				}

				this.updatedData = {
					selectedLabel: selected_label ,
					selectedDefault: selected_default,
					settings: amort_table,
					currency_type: this.currency_type
				}

				let updateTableAjaxData = {
					action: 'ninja_mortgage_ajax_actions',
                    route: 'update_table_config',
                    table_id: this.table_id,
					table_config: JSON.stringify(this.updatedData),
					post_title: this.post_title,
					calculator_type: this.calc_type
				}
				jQuery.post(ajaxurl, updateTableAjaxData).then(response => {
					console.log(response)
                    this.$notify.success({
                        title: 'Updated',
                        message: response.data.message
					});
					if( this.calc_type == 'mortgage_calculator' ) {
						this.all_mort_calc_table = response.data.updatedData.selectedLabel;
						this.all_mort_calc_table_def_val = response.data.updatedData.selectedDefault;
					}
					else if( this.calc_type == 'mortgage_refinance' ) {
						this.all_refinance_calc_table = response.data.updatedData.selectedLabel;
						this.all_refinance_calc_table_def_val = response.data.updatedData.selectedDefault
					}
					else if( this.calc_type == 'mortgage_payment' ) {
						this.all_payment_calc_table = response.data.updatedData.selectedLabel;
						this.all_payment_calc_table_def_val = response.data.updatedData.selectedDefault
					}
                })
			},
			updateAmort(ammortization) {
				this.amort_res = ammortization;
				if(ammortization == 'yes') {
					this.ammortization_table = true;
				}
				else if(ammortization == 'no') {
					this.ammortization_table = false;
				}
			},
			updateCurrency(currency) {
				this.currency_type = currency;
				console.log(this.currency_type)
			},
            clipboardRender(){
                var clipboard = new Clipboard('.copy_shortcode');
                clipboard.on('success', (e) => {
                    this.$message({
                        message: 'Copied to Clipboard!',
                        type: 'success'
                    })
                })
            },
            getDownPamentPerc(x) {
            	return x + ' Percentage'
            },
            getMortgageTerm(str) {
            	if(str === '') {
            		return 'Mortgage Term Years'
            	}
            	return str + ' Years';
            },
            getMortgageTermMonth(str) {
            	if(str === '') {
            		return 'Mortgage Term Months'
            	}
            	return str + ' Months'
            }
		},
		created() {
			this.fetchTable();
			this.clipboardRender();
		}
	}
</script>


<style lang="scss">

.ninja_mortgage_cal {

	.header {
        font-size: 20px;
	    padding-bottom: 10px;
	    background: #fff;
	    margin-top: -20px;
	    padding-top: 22px;
	    margin-right: -20px;
	    margin-left: -20px;
	    padding-left: 24px;
        .table_action_btn {
            padding-top: 11px;
            padding-right: 23px;
            .el-button--mini, .el-button--mini.is-round {
                padding: 7px 15px; 
            }
        }
    }


	.inputFields {
		width: 100%;
		margin: 0 auto;
		margin-right: 8px;
	}

	.title {
		float: left;
	}
	.copy_shortcode {
		cursor: pointer;
	}

	.change_type {
		float: right;
		margin-top: -36px;
		.el-select {
			.el-input__inner {
				background-color: #fff;	
			} 
		}
	}

	.tabs_col {
    	width: 31.16667%;
		background: #fff;
		padding: 20px;
		margin-top: 19px;
		margin-left: 17px;
		box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
	}

	.common_btn {
		margin: 0 !important;
	}

	.fields {
		width: 67.6%;
		.calc_title {
			background: #fff;
			margin-top: 18px;
			padding: 16px;
			box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
		}
		.calc_preview_section {
			padding: 20px;
			margin-top: 18px;
			background: #fff;
			box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
		}
	}

	.fields h2{
		margin-top: 0;
	}

	.el-message--success {
        z-index: 999999!important;
        top: 5px;
    }

	@media (min-width: 768px) and (max-width: 1024px) {
		.fields {
			width: 100%;
		}
		.tabs_col {
			width: 100%;
			margin-left: 0px;
		}
	}

	@media (max-width: 600px) {
		.fields {
			width: 100%;
		}
		.tabs_col {
			width: 100%;
			margin-left: 0px;
		}
	}

	@media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
		.fields {
			width: 100%;
		}
		.tabs_col {
			width: 100%;
			margin-left: 0px;
		}
	}

}

</style>
