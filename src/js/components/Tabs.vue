<template>
    <div class="ninja_mortgage_tabs">
            <el-tabs v-model="activeName" @tab-click="handleClick">
                <el-tab-pane label="Label" name="first">
                    <div v-if="calcType=='mortgage_calculator'">
                        <el-row>
                            <el-col :span="24">
                                <label>Loan Amount</label>
                                <el-input v-model="allMortCalcTable.loanAmount" type="text"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Down Pament</label>
                                <el-input v-model="allMortCalcTable.downPament" type="text"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Mortgage Term Years</label>
                                <el-input v-model="allMortCalcTable.mortgageTerm" type="text"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Annual Interest Rate</label>
                                <el-input v-model="allMortCalcTable.annualInterestRate" type="text"></el-input>
                            </el-col>
                        </el-row>
                    </div>

                    <div v-if="calcType=='mortgage_refinance'">
                        <el-row>
                            <el-col :span="24">
                                <label>Currently Monthly Payment</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.currentlyMonthlyPayment"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Current Loan interest rate</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.loanIntRate"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Balance left on mortgage</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.balanceMortgage"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>New Interest Rate</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.newIntRate"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Remaining Loan Term </label>
                                <el-input type="text" v-model="allRefinanceCalcTable.remainingLoanTerm"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>New Loan Term </label>
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
                                <label>Application Fee</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.applicationFee"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Credit Check</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.creditCheck"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Attorney's fee (yours)</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.attorneyFeeYours"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Attorney's fee (lenders)</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.attorneyFeeLenders"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Title Search</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.titleSearch"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Title Insurance</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.titleInsurance"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Appraisal Fee</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.appraisalFee"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Inspections</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.inspections"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Local fees (taxes, transfers)</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.localFees"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Document preparation</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.documentPreparation"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Other</label>
                                <el-input type="text" v-model="allRefinanceCalcTable.other"></el-input>
                            </el-col>
                        </el-row>
                    </div>

                    <div v-if="calcType=='mortgage_payment'">
                        <el-row>
                            <el-col :span="24">
                                <label>Mortgage Amount</label>
                                <el-input type="text" v-model="allPaymentCalcTable.mortgageAmount"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Term in Years</label>
                                <el-input type="text" v-model="allPaymentCalcTable.termInYears"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Interest Rate</label>
                                <el-input type="text" v-model="allPaymentCalcTable.interestRate"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Annual Property Taxes</label>
                                <el-input type="text" v-model="allPaymentCalcTable.annualPropertyTaxes"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>Annual Home Insurance</label>
                                <el-input type="text" v-model="allPaymentCalcTable.annualHomeInsurance"></el-input>
                            </el-col>
                        </el-row>
                    </div>

                </el-tab-pane>

                <el-tab-pane label="Default Values" name="second">
                    <div v-if="calcType=='mortgage_calculator'">
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allMortCalcTable.loanAmount ? "Loan Amount" : allMortCalcTable.loanAmount }}</label>
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
                                <label>{{ !allMortCalcTable.downPament ? "Down Payment" : allMortCalcTable.downPament }}</label>
                                <el-input type="number" min=0 
                                          name="downPamentDefVal"
                                          class="typeNumber"
                                          placeholder="Down Payment"
                                          v-model="allMortCalcDefVal.downPamentDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allMortCalcTable.mortgageTerm ? "Mortgage Term" : allMortCalcTable.mortgageTerm }}</label>
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
                                <label>{{ !allMortCalcTable.annualInterestRate ? "Annual Interest Rate" : allMortCalcTable.annualInterestRate }}</label>
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
                                <label>{{ !allRefinanceCalcTable.currentlyMonthlyPayment ? "Currently Monthly Payment" : allRefinanceCalcTable.currentlyMonthlyPayment }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.currentlyMonthlyPaymentDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.loanIntRate ? "Loan Interest Rate" : allRefinanceCalcTable.loanIntRate }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.loanIntRateDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.balanceMortgage ? "Balance left on mortgage" : allRefinanceCalcTable.balanceMortgage }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.balanceMortgageDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.newIntRate ? "New Interest Rate" : allRefinanceCalcTable.newIntRate }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.newIntRateDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.remainingLoanTerm ? "Remaining Loan Term" : allRefinanceCalcTable.remainingLoanTerm }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.remainingLoanTermDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.newLoanTerm ? "New Loan Term" : allRefinanceCalcTable.newLoanTerm }}</label>
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
                                <label>{{ !allRefinanceCalcTable.applicationFee ? "Application Fee" : allRefinanceCalcTable.applicationFee }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.applicationFeeDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.creditCheck ? "Credit Check" : allRefinanceCalcTable.creditCheck }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.creditCheckDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.attorneyFeeYours ? "Attorney's fee (yours)" : allRefinanceCalcTable.attorneyFeeYours }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.attorneyFeeYoursDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.attorneyFeeLenders ? "Attorney's Fee(lenders)" : allRefinanceCalcTable.attorneyFeeLenders }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.attorneyFeeLendersDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.titleSearch ? "Title Search" : allRefinanceCalcTable.titleSearch }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.titleSearchDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.titleInsurance ? "Title Insurance" : allRefinanceCalcTable.titleInsurance }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.titleInsuranceDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.appraisalFee ? "Appraisal Fee" : allRefinanceCalcTable.appraisalFee }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.appraisalFeeDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.inspections ? "Inspections" : allRefinanceCalcTable.inspections }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.inspectionsDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.localFees ? "Local Fees" : allRefinanceCalcTable.localFees }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.localFeesDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.documentPreparation ? "Document Preparation" : allRefinanceCalcTable.documentPreparation }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.documentPreparationDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allRefinanceCalcTable.other ? "Other" : allRefinanceCalcTable.other }}</label>
                                <el-input type="text" v-model="allRefinanceDefVal.otherDefVal"></el-input>
                            </el-col>
                        </el-row>
                    </div>


                    <div v-if="calcType=='mortgage_payment'">
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.mortgageAmount ? "Mortgage Amount" : allPaymentCalcTable.mortgageAmount }}</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.mortgageAmountDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.termInYears ? "Term in Years" : allPaymentCalcTable.termInYears }}</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.termInYearsDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.interestRate ? "Interest Rate" : allPaymentCalcTable.interestRate }}</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.interestRateDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.annualPropertyTaxes ? "Annual Property Taxes" : allPaymentCalcTable.annualPropertyTaxes }}</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.annualPropertyTaxesDefVal"></el-input>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <label>{{ !allPaymentCalcTable.annualHomeInsurance ? "Annual Home Insurance" : allPaymentCalcTable.annualHomeInsurance }}</label>
                                <el-input type="text" v-model="allPaymentCalcTableDefVal.annualHomeInsuranceDefVal"></el-input>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
                    
                <el-tab-pane label="Settings" name="third">
                    <div v-if="calcType=='mortgage_calculator'">
                        <el-row>
                            <el-col :span="8">
                                <label>Show Amortization Field</label>
                                <el-switch
                                v-model="amortizationtable"
                                active-value="yes"
                                inactive-value="no">
                                </el-switch>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
</template>

<script>

export default {
    name: 'tabs',
    props: [
            'calcType', 
            'allMortCalcTable', 
            'allRefinanceCalcTable', 
            'allPaymentCalcTable', 
            'allMortCalcDefVal',
            'allRefinanceDefVal',
            'allPaymentCalcTableDefVal',
            'amortTable'
           ],
    data() {
        return {
            activeName: 'first',
            mortgageTermMonth: 'Mortgage Term Month',
            acceptedValue: '',
            acceptedMortgageTermValue: '',
            acceptedAnnInt: '',
            passed: ''
        }
    },
    methods: {
        handleClick(tab, event) {},
        updateAmort(value) {
            this.$emit('changedAmort', value);
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
        }
    }
}
</script>

<style lang="scss">
    .ninja_mortgage_tabs {
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
    }
</style>
