<template>
    <div class="mortgage_finance_calc">
        <h3>{{ tableTitle }}</h3>


        <div class="currentlyMonthlyPaymentSection"> 
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.currentlyMonthlyPayment ? "Currently Monthly Payment" : mortgageRefinanceLabel.currentlyMonthlyPayment }} ({{currencyType}})</label><br />
                <div class="inp_fields">
                    <input type="number" min=0 id="current_monthly_payment" 
                        class="typeNumbers"
                        name="current_monthly_payment" 
                        :placeholder="getCurrentlyPayment(mortgageRefinanceLabel.currentlyMonthlyPayment)"
                        v-model="current_monthly_payment"
                        v-validate="'required'"
                        :class="{'error': errors.has('current_monthly_payment') }">
                </div>
                <span v-if="errors.has('current_monthly_payment')" style="color: red;">
                    Current loan interest rate field is required
                </span>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.loanIntRate ? "Current Loan Interest Rate" : mortgageRefinanceLabel.loanIntRate }} (%)</label><br />
                <div class="inp_fields">
                    <input type="number" min=0 id="current_loan_interest_rate"
                            class="typeNumbers" 
                            name="current_loan_interest_rate" 
                            :placeholder="getCurrentLoanRate(mortgageRefinanceLabel.loanIntRate)"
                            v-model="current_loan_interest_rate"
                            v-validate="'required'"
                            :class="{'error': errors.has('current_loan_interest_rate') }">
                </div>
                <span v-if="errors.has('current_loan_interest_rate')" style="color: red;">
                    Current loan interest rate field is required
                </span>
            </div>
        </div>

        <div class="balanceleftonMortgageSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.balanceMortgage ? "Balance Left on Mortgage" : mortgageRefinanceLabel.balanceMortgage }} ({{currencyType}})</label><br />
                <div class="inp_fields">
                    <input type="number" min=0 id="balance" 
                        name="balance" 
                        class="typeNumbers" 
                        :placeholder="getBalanceMortgage(mortgageRefinanceLabel.balanceMortgage)"
                        v-model="balance"
                        v-validate="'required'"
                        :class="{'error': errors.has('balance') }">
                </div>
                <span v-if="errors.has('balance')" style="color: red;">
                    Balance field is required
                </span>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.newIntRate ? "New Interest Rate" : mortgageRefinanceLabel.newIntRate }} (%)</label><br />
                <div class="inp_fields">
                    <input type="number" min=0 id="new_interest_rate"
                        class="typeNumbers" 
                        name="new_interest_rate" 
                        :placeholder="getNewIntRate(mortgageRefinanceLabel.newIntRate)"
                        v-model="new_interest_rate"
                        v-validate="'required'"
                        :class="{'error': errors.has('new_interest_rate') }">
                </div>
                <span v-if="errors.has('new_interest_rate')" style="color: red;">
                    New interest rate field is required
                </span>
            </div>
        </div>


        <div class="remainingLoanTermSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.remainingLoanTerm ? "Remaining Loan Term" : mortgageRefinanceLabel.remainingLoanTerm }} (/year)</label><br />
                <div class="inp_fields">
                    <input type="number" min=0 id="remaining_loan_term" 
                        name="remaining_loan_term" 
                        class="typeNumbers" 
                        :placeholder="getRemainingLoan(mortgageRefinanceLabel.remainingLoanTerm)"
                        v-model="remaining_loan_term"
                        v-validate="'required'"
                        :class="{'error': errors.has('remaining_loan_term') }">
                </div>
                <span v-if="errors.has('remaining_loan_term')" style="color: red;">
                    Remaining Loan Term field is required
                </span>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.newLoanTerm ? "New Loan Term" : mortgageRefinanceLabel.newLoanTerm }} (/year)</label><br />
                <div class="inp_fields">
                    <input type="number" min=0 id="new_loan_term"
                        class="typeNumbers" 
                        name="new_loan_term" 
                        :placeholder="getNewLoanTerm(mortgageRefinanceLabel.newLoanTerm)"
                        v-model="new_loan_term"
                        v-validate="'required'"
                        :class="{'error': errors.has('new_loan_term') }">
                </div>
                <span v-if="errors.has('new_loan_term')" style="color: red;">
                    New loan term field is required
                </span>
            </div>
        </div>

        <div> 
            <h4 class="cost_text"><strong>How much will it cost you?</strong></h4>
        </div>

        <div class="fees_section_points">
            <div class="points">
                <label>{{ !mortgageRefinanceLabel.points ? "Points" : mortgageRefinanceLabel.points }}</label>
                <input type="number" min=0 name="points"
                       id="points" v-model="points" :placeholder="getPoints(mortgageRefinanceLabel.points)"
                       v-validate="'required'" class="typeNumbers">
            </div>
            <div class="costPoint">
                <p> <b>Costs of points: {{currencyType}} {{ pointsResult }}</b> </p>
            </div>
        </div> 

        <div class="feeSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.applicationFee ? "Application Fee" : mortgageRefinanceLabel.applicationFee }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" min=0 name="application_fee"
                       id="application_fee" v-model="application_fee" :placeholder="getApplicationFee(mortgageRefinanceLabel.applicationFee)" class="typeNumbers">
                </div>
            </div>
            <div class="common">
                <label>{{ mortgageRefinanceLabel.creditCheck }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" :placeholder="getCreditCheck(mortgageRefinanceLabel.creditCheck)" v-model="credit_check" min=0 id="credit_check" name="credit_check" class="typeNumbers">
                </div>
            </div>
        </div>

        <div class="feeSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.attorneyFeeYours ? "Attorney's Fee(yours)" : mortgageRefinanceLabel.attorneyFeeYours }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" min=0 name="attorney_fee_yours"
                       id="attorney_fee_yours" v-model="attorney_fee_yours" :placeholder="getAnthonyYours(mortgageRefinanceLabel.attorneyFeeYours)" class="typeNumbers">
                </div>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.attorneyFeeLenders ? "Attorney's Fee(lenders)" : mortgageRefinanceLabel.attorneyFeeLenders }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" :placeholder="getAnthonyLenders(mortgageRefinanceLabel.attorneyFeeLenders)" v-model="attorney_fee_lenders" 
                       min=0 id="attorney_fee_lenders" name="attorney_fee_lenders" class="typeNumbers">
                </div>
            </div>
        </div>

        <div class="feeSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.titleSearch ? "Title Search" : mortgageRefinanceLabel.titleSearch }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" min=0 name="title_search"
                       id="title_search" v-model="title_search" :placeholder="getTitleSearch(mortgageRefinanceLabel.titleSearch)" class="typeNumbers">
                </div>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.titleInsurance ? "Title Insurance" : mortgageRefinanceLabel.titleInsurance }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" :placeholder="getTitleInsurance(mortgageRefinanceLabel.titleInsurance)" v-model="title_insurance" 
                       min=0 id="title_insurance" name="title_insurance" class="typeNumbers">
                </div>
            </div>
        </div>

        <div class="feeSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.appraisalFee ? "Appraisal Fee" : mortgageRefinanceLabel.appraisalFee }} ({{currencyType}}) ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" min=0 name="appraisal_fee"
                       id="appraisal_fee" v-model="appraisal_fee" :placeholder="getAppraisalFee(mortgageRefinanceLabel.appraisalFee)" class="typeNumbers">
                </div>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.inspections ? "Inspections" : mortgageRefinanceLabel.inspections }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" :placeholder="getInspections(mortgageRefinanceLabel.inspections)" v-model="inspections" 
                       min=0 id="inspections" name="inspections" class="typeNumbers">
                </div>
            </div>
        </div>

        <div class="feeSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.localFees ? "Local Fees" : mortgageRefinanceLabel.localFees }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" min=0 name="local_fees"
                       id="local_fees" v-model="local_fees" :placeholder="getLocalFees(mortgageRefinanceLabel.localFees)" class="typeNumbers">
                </div>
            </div>
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.documentPreparation ? "Document Preparation" : mortgageRefinanceLabel.documentPreparation }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" :placeholder="getDocumentPreparation(mortgageRefinanceLabel.documentPreparation)" v-model="document_preparation" 
                       min=0 id="document_preparation" name="document_preparation" class="typeNumbers">
                </div>
            </div>
        </div>

        <div class="feeSection">
            <div class="common">
                <label>{{ !mortgageRefinanceLabel.other ? "Other" : mortgageRefinanceLabel.other }} ({{currencyType}})</label>
                <div class="inp_fields">
                    <input type="number" min=0 name="other"
                       id="other" v-model="other" :placeholder="getOther(mortgageRefinanceLabel.other)" class="typeNumbers">
                </div>
            </div>
        </div>



        <!-- End Fees Section -->

        <!-- All Cost Section -->
        <div class="costs_section">
            <p><b>New Monthly Pament</b></p>
            <h1><span>{{currencyType}}</span> {{ monthly_payment.toFixed(2) }}</h1>
            <p><b>Monthly Savings</b>: {{currencyType}} {{ monthly_savings.toFixed(2) }}</p>
            <p><b>Difference in Interest</b>: {{currencyType}} {{ diff_in_interest.toFixed(2) }}</p>
            <p><b>Total cost</b>: {{currencyType}} {{ total_cost.toFixed(2) }}</p>
            <p><b>Months to recoup costs</b>: {{currencyType}} {{ months_rec_costs.toFixed(2) }}</p>
        </div>
        <!-- End Cost Section -->
    </div>
</template>

<script>
export default {
    props: [
        'tableTitle',
        'mortgageRefinanceLabel',
        'mortgageRefinanceDef',
        'currencyType'
    ],
    data() {
        return {
            current_monthly_payment: 0,
            current_loan_interest_rate: 0,
            balance: 0,
            new_interest_rate: 0,
            remaining_loan_term: 0,
            new_loan_term: 0,
            monthly_payment: 0,
            new_interest_rate_upd: 0,
            new_loan_term_upd: 0,
            monthly_savings: 0,
            points: 1,
            pointsResult: 0,
            application_fee: 0,
            credit_check: 0,
            attorney_fee_yours: 0,
            attorney_fee_lenders: 0,
            title_search: 0,
            title_insurance: 0,
            appraisal_fee: 0,
            local_fees: 0,
            inspections: 0,
            document_preparation: 0,
            other: 0,
            acceptedValue: ''
        }
    },
    created() {

        this.current_monthly_payment = this.mortgageRefinanceDef.currentlyMonthlyPaymentDefVal;
        this.current_loan_interest_rate = this.mortgageRefinanceDef.loanIntRateDefVal;
        this.balance = this.mortgageRefinanceDef.balanceMortgageDefVal;
        this.new_interest_rate = this.mortgageRefinanceDef.newIntRateDefVal;
        this.remaining_loan_term = this.mortgageRefinanceDef.remainingLoanTermDefVal;
        this.new_loan_term = this.mortgageRefinanceDef.newLoanTermDefVal;
        this.points = this.mortgageRefinanceDef.pointsDefVal;
        this.application_fee = this.mortgageRefinanceDef.applicationFeeDefVal;
        this.credit_check = this.mortgageRefinanceDef.creditCheckDefVal;
        this.attorney_fee_yours = this.mortgageRefinanceDef.attorneyFeeYoursDefVal;
        this.attorney_fee_lenders = this.mortgageRefinanceDef.attorneyFeeLendersDefVal;
        this.title_search = this.mortgageRefinanceDef.titleSearchDefVal;
        this.title_insurance = this.mortgageRefinanceDef.titleInsuranceDefVal;
        this.appraisal_fee = this.mortgageRefinanceDef.appraisalFeeDefVal;
        this.local_fees = this.mortgageRefinanceDef.localFeesDefVal;
        this.inspections = this.mortgageRefinanceDef.inspectionsDefVal;
        this.document_preparation = this.mortgageRefinanceDef.documentPreparationDefVal;
        this.other = this.mortgageRefinanceDef.otherDefVal;
        if(!this.currencyType) {
            this.currencyType = "$";
        };

        var new_interest_rate_upd = this.new_interest_rate / 12;
        var interest_rate = new_interest_rate_upd / 100;
        var new_loan_term_mnt = this.new_loan_term * 12;
        this.monthly_payment = parseFloat( ( ( this.balance * interest_rate ) / ( 1 - ( 1 / Math.pow( ( 1 + interest_rate ), new_loan_term_mnt ) ) ) ) );
        this.monthly_savings = this.current_monthly_payment - this.monthly_payment;
        let balancePoints = parseFloat(( this.balance ) / 100);
        this.pointsResult = (balancePoints * this.points);
        this.total_cost = this.pointsResult;
        this.acceptedValue = 10000000;

        
    },
    watch: {
        current_monthly_payment() {
            if( this.new_interest_rate != 0 ) {
                this.new_interest_rate_upd = parseFloat(( this.new_interest_rate / 12 )/100);
            }
            if( this.new_loan_term != 0 ) {
                this.new_loan_term_upd = parseFloat( this.new_loan_term ) * 12;
            }
            if( this.monthly_payment != 0 && this.current_monthly_payment != 0 ) {
                this.monthly_savings = parseFloat( this.current_monthly_payment - this.monthly_payment );
            
            }
            if( this.current_monthly_payment == 0 || this.current_monthly_payment == '' ) {
                this.monthly_savings = 0;
            }
        },
        balance() {
            if( this.balance == 0 || this.balance == '' ) {
                this.monthly_payment = 0;
                this.pointsResult = 0;
                this.total_cost = 0;
            }
            if( this.new_interest_rate != 0 ) {
                this.new_interest_rate_upd = parseFloat(( this.new_interest_rate / 12 )/100);
            }
            if( this.new_loan_term != 0 ) {
                this.new_loan_term_upd = parseFloat( this.new_loan_term ) * 12;
            }
            if( this.balance != 0 && this.new_interest_rate_upd != 0 ) {
                this.monthly_payment = parseFloat( ( ( this.balance * this.new_interest_rate_upd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.new_interest_rate_upd ), this.new_loan_term_upd ) ) ) ) );
                
                if( this.current_monthly_payment != 0 ) {
                    this.monthly_savings = parseFloat( this.current_monthly_payment - this.monthly_payment );
                }
            
            }
            if( this.points != 0 ) {
                let balancePoints = parseFloat(( this.balance ) / 100);
                this.pointsResult = (balancePoints * this.points);
                this.total_cost = this.pointsResult;
            }
        },
        new_interest_rate() {
                
            this.new_interest_rate_upd = parseFloat(( this.new_interest_rate / 12 )/100);
            if( this.new_loan_term != 0 ) {
                this.new_loan_term_upd = parseFloat( this.new_loan_term ) * 12;
            }
            
            if( this.balance != 0 && this.new_interest_rate_upd != 0 && this.new_loan_term_upd != 0 ) {
                this.monthly_payment = parseFloat( ( ( this.balance * this.new_interest_rate_upd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.new_interest_rate_upd ), this.new_loan_term_upd ) ) ) ) );
                if( this.current_monthly_payment != 0 ) {
                    this.monthly_savings = parseFloat( this.current_monthly_payment - this.monthly_payment );
                }
            }
            if( this.new_interest_rate == 0 || this.new_interest_rate == '' ) {
                this.monthly_savings = 0;
                this.monthly_payment = 0;
            }
        },
        new_loan_term() {
            this.new_loan_term_upd = parseFloat( this.new_loan_term ) * 12;
            if( this.new_interest_rate != 0 ) {
                this.new_interest_rate_upd = parseFloat(( this.new_interest_rate / 12 )/100);
            }
            if( this.balance != 0 && this.new_interest_rate_upd != 0 && this.new_loan_term_upd != 0 ) {
                this.monthly_payment = parseFloat( ( ( this.balance * this.new_interest_rate_upd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.new_interest_rate_upd ), this.new_loan_term_upd ) ) ) ) );
                if( this.current_monthly_payment != 0 ) {
                    this.monthly_savings = parseFloat( this.current_monthly_payment - this.monthly_payment );
                }
            }
            if( this.new_loan_term == 0 || this.new_loan_term == '' ) {
                this.monthly_savings = 0;
                this.monthly_payment = 0;
            }
        },
        points() {
            if( this.balance != 0 && this.points != 0 ) {
                let balancePoints = parseFloat(( this.balance ) / 100);
                this.pointsResult = (balancePoints * this.points);
                this.total_cost = this.pointsResult;
            }
            if( this.points == 0 || this.points == '' ) {
                this.pointsResult = 0;
                this.total_cost = 0;
            }
        }
    },
    methods: {
        getCurrentlyPayment(str) {
            if(str == '') {
                return 'Currently Monthly Payment';
            }
            return str;
        },
        getCurrentLoanRate(str) {
            if(str == '') {
                return 'Current Loan Interest Rate'
            }
            return str;
        },
        getBalanceMortgage(str) {
            if( str == '' ) {
                return 'Balance Left on Mortgage'
            }
            return str;
        },
        getNewIntRate(str) {
            if( str == '' ) {
                return 'New Interest Rate'
            }
            return str;
        },
        getRemainingLoan(str) {
            if(str=='') {
                return 'Remaining Loan Term'
            }
            return str;
        },
        getNewLoanTerm(str) {
            if(str=='') {
                return 'New Loan Term'
            }
            return str;
        },
        getPoints(str) {
            if(str=='') {
                return 'Points'
            }
            return str;
        },
        getApplicationFee(str) {
            if(str=='') {
                return 'Application Fee'
            }
            return str;
        },
        getCreditCheck(str) {
            if(str=='') {
                return 'Credit Check'
            }
            return str;
        },



        getAnthonyYours(str) {
            if(str=='') {
                return "Attorney's Fee(yours)"
            }
            return str;
        },

        getAnthonyLenders(str) {
            if(str=='') {
                return "Attorney's Fee(lenders)"
            }
            return str;
        },

        getTitleSearch(str) {
            if(str=='') {
                return 'Title Search'
            }
            return str;
        },

        getTitleInsurance(str) {
            if(str=='') {
                return 'Title Insurance'
            }
            return str;
        },

        getAppraisalFee(str) {
            if(str=='') {
                return 'Appraisal Fee'
            }
            return str;
        },

        getInspections(str) {
            if(str=='') {
                return 'Inspections'
            }
            return str;
        },

        getLocalFees(str) {
            if(str=='') {
                return 'Local Fees (Taxes, Transfers)'
            }
            return str;
        },

        getDocumentPreparation(str) {
            if(str=='') {
                return 'Document Preparation'
            }
            return str;
        },

        getOther(str) {
            if(str=='') {
                return 'Other'
            }
            return str
        }
    },
    computed: {
        total_cost: {
            get() {

                if( this.pointsResult ) {
                    return this.pointsResult + 
                            parseFloat( this.application_fee ) + 
                            parseFloat( this.credit_check ) +
                            parseFloat( this.attorney_fee_yours ) +
                            parseFloat( this.attorney_fee_lenders ) +
                            parseFloat( this.title_search ) +
                            parseFloat( this.title_insurance ) + 
                            parseFloat( this.appraisal_fee ) + 
                            parseFloat( this.inspections ) +
                            parseFloat( this.local_fees ) +
                            parseFloat( this.document_preparation ) +
                            parseFloat( this.other );
                } 
                else {
                    return 0;
                
                }

            },

            set(newValue) {}
                
        },
        months_rec_costs() {
            if( this.balance != 0 && this.monthly_savings != 0 && this.points != 0 ) {
                return parseFloat(( this.balance ) / ( this.monthly_savings * 100));
            } else {
                return 0;
                
            }
        },
        diff_in_interest() {
            if( this.current_monthly_payment != 0 && this.balance != 0 && this.remaining_loan_term != 0 && this.new_loan_term != 0 && this.monthly_payment != 0 ) {
                var old_interest_rate = ( this.current_monthly_payment * ( this.remaining_loan_term * 12 ) ) - this.balance;
                var new_interest_rate = ( this.monthly_payment * ( this.new_loan_term * 12 ) )  - this.balance;
                return (old_interest_rate - new_interest_rate);
            } else {
                return 0;
            }
        }
    }
}
</script>