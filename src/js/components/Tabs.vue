<template>
    <div class="ninja_mortgage_tabs">
            <el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
                <el-tab-pane label="Label" name="first">
                    <div v-if="calcType=='mortgage_calculator'">
                        <el-row>
                            <el-col :span="24">
                                <label>Loan Amount ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input v-model="allMortCalcTable.loanAmount" type="text"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Down Pament ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input v-model="allMortCalcTable.downPament" type="text"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Mortgage Term /Year</label>
                                <el-input v-model="allMortCalcTable.mortgageTerm" type="text"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Annual Interest Rate (%)</label>
                                <el-input v-model="allMortCalcTable.annualInterestRate" type="text"></el-input>
                            </el-col>
                        </el-row>
                    </div>

                    <div v-if="calcType=='mortgage_refinance'">
                        <el-row>
                            <el-col :span="24">
                                <label>Currently Monthly Payment ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.currentlyMonthlyPayment"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Current Loan interest rate (%)</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.loanIntRate"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Balance left on mortgage ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.balanceMortgage"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>New Interest Rate (%)</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.newIntRate"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Remaining Loan Term /Year</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.remainingLoanTerm"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>New Loan Term /Year</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.newLoanTerm"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24"> 
                                <p><strong>Cost Section</strong></p>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Points</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.points"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Application Fee ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.applicationFee"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Credit Check ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.creditCheck"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Attorney's fee (yours) ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.attorneyFeeYours"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Attorney's fee (lenders) ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.attorneyFeeLenders"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Title Search ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.titleSearch"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Title Insurance ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.titleInsurance"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Appraisal Fee ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.appraisalFee"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Inspections ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.inspections"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Local fees (taxes, transfers) ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.localFees"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Document preparation ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.documentPreparation"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Other ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.other"></el-input>
                            </el-col>
                        </el-row>
                    </div>

                    <div v-if="calcType=='mortgage_payment'">
                        <el-row>
                            <el-col :span="24">
                                <label>Mortgage Amount ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allPaymentCalcTable.mortgageAmount"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Term in Year</label>
                                <el-input type="text" v-model="allPaymentCalcTable.termInYears"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Interest Rate (%)</label>
                                <el-input type="text" v-model="allPaymentCalcTable.interestRate"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Annual Property Taxes ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allPaymentCalcTable.annualPropertyTaxes"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Annual Home Insurance ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allPaymentCalcTable.annualHomeInsurance"></el-input>
                            </el-col>
                        </el-row>
                    </div>

                </el-tab-pane>

                <el-tab-pane label="Default Values" name="second">
                    <div v-if="calcType=='mortgage_calculator'">
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allMortCalcTable.loanAmount ? "Loan Amount" : allMortCalcTable.loanAmount }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="number" min=0 
                                          name="loanAmountDefVal"
                                          class="typeNumber"
                                          placeholder="Loan Amount"
                                          v-model="allMortCalcDefVal.loanAmountDefVal"
                                          pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false"
                                          v-validate="rules"
                                          :class="{'error': errors.has('loanAmountDefVal') }"></el-input>
                                <span v-if="errors.has('loanAmountDefVal')" style="color: red;">
                                    The {{ allMortCalcTable.loanAmount }} field must be lesser than 10000000
                                </span>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allMortCalcTable.downPament ? "Down Payment" : allMortCalcTable.downPament }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="number" min=0 
                                          name="downPamentDefVal"
                                          class="typeNumber"
                                          placeholder="Down Payment"
                                          v-model="allMortCalcDefVal.downPamentDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allMortCalcTable.mortgageTerm ? "Mortgage Term" : allMortCalcTable.mortgageTerm }} /Year</label>
                                <el-input type="number" min=0 
                                          class="typeNumber"
                                          v-model="allMortCalcDefVal.mortgageTermDefVal"
                                          pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false"
                                          name="mortgageTermDefVal"
                                          v-validate="mortgageTermRules"
                                          placeholder="Mortgage Term"
                                          :class="{'error': errors.has('mortgageTermDefVal') }"></el-input>
                                <span v-if="errors.has('mortgageTermDefVal')" style="color: red;">
                                    The {{ allMortCalcTable.mortgageTerm }} field must be lesser than 40
                                </span>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allMortCalcTable.annualInterestRate ? "Annual Interest Rate" : allMortCalcTable.annualInterestRate }} (%)</label>
                                <el-input type="number" min=0 
                                          class="typeNumber"
                                          v-model="allMortCalcDefVal.annualInterestRateDefVal"
                                          pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false"
                                          name="annualInterestRateDefVal"
                                          v-validate="annIntRules"
                                          placeholder="Annual Interest Rate"
                                          :class="{'error': errors.has('annualInterestRateDefVal') }"></el-input>
                                <span v-if="errors.has('annualInterestRateDefVal')" style="color: red;">
                                    The {{ allMortCalcTable.annualInterestRate }} field must be lesser than 99
                                </span>
                            </el-col>
                        </el-row>
                    </div>


                    <div v-if="calcType=='mortgage_refinance'">
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.currentlyMonthlyPayment ? "Currently Monthly Payment" : allRefinanceCalcTable.currentlyMonthlyPayment }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.currentlyMonthlyPaymentDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.loanIntRate ? "Loan Interest Rate" : allRefinanceCalcTable.loanIntRate }} (%)</label>
                                <el-input type="text" v-model="allRefinanceDefVal.loanIntRateDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.balanceMortgage ? "Balance left on mortgage" : allRefinanceCalcTable.balanceMortgage }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.balanceMortgageDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.newIntRate ? "New Interest Rate" : allRefinanceCalcTable.newIntRate }} (%)</label>
                                <el-input type="text" v-model="allRefinanceDefVal.newIntRateDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.remainingLoanTerm ? "Remaining Loan Term" : allRefinanceCalcTable.remainingLoanTerm }} /Year</label>
                                <el-input type="text" v-model="allRefinanceDefVal.remainingLoanTermDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.newLoanTerm ? "New Loan Term" : allRefinanceCalcTable.newLoanTerm }} /Year</label>
                                <el-input type="text" v-model="allRefinanceDefVal.newLoanTermDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24"> 
                                <p><strong>Cost Section</strong></p>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.points ? "Points" : allRefinanceCalcTable.points }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.pointsDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.applicationFee ? "Application Fee" : allRefinanceCalcTable.applicationFee }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.applicationFeeDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.creditCheck ? "Credit Check" : allRefinanceCalcTable.creditCheck }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.creditCheckDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.attorneyFeeYours ? "Attorney's fee (yours)" : allRefinanceCalcTable.attorneyFeeYours }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.attorneyFeeYoursDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.attorneyFeeLenders ? "Attorney's Fee(lenders)" : allRefinanceCalcTable.attorneyFeeLenders }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.attorneyFeeLendersDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.titleSearch ? "Title Search" : allRefinanceCalcTable.titleSearch }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.titleSearchDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.titleInsurance ? "Title Insurance" : allRefinanceCalcTable.titleInsurance }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.titleInsuranceDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.appraisalFee ? "Appraisal Fee" : allRefinanceCalcTable.appraisalFee }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.appraisalFeeDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.inspections ? "Inspections" : allRefinanceCalcTable.inspections }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.inspectionsDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.localFees ? "Local Fees" : allRefinanceCalcTable.localFees }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.localFeesDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.documentPreparation ? "Document Preparation" : allRefinanceCalcTable.documentPreparation }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.documentPreparationDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.other ? "Other" : allRefinanceCalcTable.other }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allRefinanceDefVal.otherDefVal"></el-input>
                            </el-col>
                        </el-row>
                    </div>


                    <div v-if="calcType=='mortgage_payment'">
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.mortgageAmount ? "Mortgage Amount" : allPaymentCalcTable.mortgageAmount }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.mortgageAmountDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.termInYears ? "Term in Year" : allPaymentCalcTable.termInYears }}</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.termInYearsDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.interestRate ? "Interest Rate" : allPaymentCalcTable.interestRate }} (%)</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.interestRateDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.annualPropertyTaxes ? "Annual Property Taxes" : allPaymentCalcTable.annualPropertyTaxes }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.annualPropertyTaxesDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.annualHomeInsurance ? "Annual Home Insurance" : allPaymentCalcTable.annualHomeInsurance }} ({{ this.currencyType ? this.currencyType : '$' }})</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.annualHomeInsuranceDefVal"></el-input>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
                    
                <el-tab-pane label="Settings" name="third">
                    <div v-if="calcType=='mortgage_calculator'">
                        <el-row>
                            <el-col :span="24">
                                <app-input-switch
                                    label="Show Amortization Field"
                                    v-model="amortizationtable"></app-input-switch>
                            </el-col>
                            <el-col :span="12" class="select_cur_type">
                                <label><strong>Currency Sign</strong></label><br>
                                <el-input v-model="selectedCurrency"></el-input>
                            </el-col>
                        </el-row>
                    </div>
                    <div v-if="calcType=='mortgage_refinance'">
                        <el-row>
                            <el-col :span="12" class="curc_type">
                                <label><strong>Currency Sign</strong></label><br>
                                <el-input v-model="selectedCurrency"></el-input>
                            </el-col>
                        </el-row>
                    </div> 
                    <div v-if="calcType=='mortgage_payment'">
                        <el-row>
                            <el-col :span="12" class="curc_type">

                                <label><strong>Currency Sign</strong></label><br>
                                <el-input v-model="selectedCurrency"></el-input>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
</template>

<script>
import InputSwitch from './ui/InputFields/_InputSwitch.vue';

export default {
    name: 'tabs',
    components: {
        'app-input-switch': InputSwitch
    },
    props: [
        'calcType', 
        'allMortCalcTable', 
        'allRefinanceCalcTable', 
        'allPaymentCalcTable', 
        'allMortCalcDefVal',
        'allRefinanceDefVal',
        'allPaymentCalcTableDefVal',
        'amortTable',
        'currencyType'
    ],
    data() {
        return {
            activeName: 'first',
            mortgageTermMonth: 'Mortgage Term Month',
            acceptedValue: '',
            acceptedMortgageTermValue: '',
            acceptedAnnInt: '',
            passed: '',
            currency_types: window.ninja_mortgage_calc.currencies,
            curr_type: ''
        }
    },
    methods: {
        handleClick(tab, event) {},
        updateAmort(value) {
            this.$emit('changedAmort', value);
        },
        updateCurrency(value) {
            this.$emit('changedCurrency', value);
        }
    },
    created() {
        this.acceptedValue = 10000000;
        this.acceptedMortgageTermValue = 40;
        this.acceptedAnnInt = 90;
    },
    computed: {
        rules() {
            return `max_value:${this.acceptedValue}`;
        },
        mortgageTermRules() {
            return `max_value:${this.acceptedMortgageTermValue}`;
        },
        annIntRules() {
            return `max_value:${this.acceptedAnnInt}`
        },
        amortizationtable: {
            get() {
                return this.amortTable;
            },
            set(newValue) {
                this.updateAmort(newValue);
            }
        },
        selectedCurrency: {
            get() {
                return this.currencyType
            },
            set(newValue) {
                this.updateCurrency(newValue)
            }
        }
    }
}
</script>

<style lang="scss">
    .ninja_mortgage_tabs {
        .el-tabs {
            box-shadow: none;
        }
        
        .error {
            border-color: red;
            padding: 0px;
        }

        .typeNumber {
            width: 100%;
            padding: 3px 0px;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .select_cur_type {
            margin-top: 10px;
        }

        input {
            background-color: #fff;
        }

        @media (max-width: 600px) {
            .curc_type {
                width: 100%;
            }
            .select_cur_type {
                width: 100%;
            }
	    }   
    }
</style>
