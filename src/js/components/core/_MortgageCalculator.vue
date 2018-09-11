<template>
	<div class="mortgage_calculator">

		<!-- Field Section -->
		<div class="mortgage_calc_fields">
            <h3>{{ tableTitle }}</h3>
			<div class="loanAmountSection">
				<label>{{ !mortgageCalcLabel.loanAmount ? "Loan Amount" : mortgageCalcLabel.loanAmount }}</label><br />
                <div class="inp_fields">
                    <span class="currency_icon">{{currencyType}}</span>
                    <input type="number" min=0 id="loanAmount" 
                            class="typeNumber"
                            name="loanAmount" 
                            v-model="loanAmount"
                            pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;"
                            v-validate="rules"
                            :class="{'error': errors.has('loanAmount') }"
                            :placeholder="getLoanAmount(mortgageCalcLabel.loanAmount)">
                </div>
                <span v-if="errors.has('loanAmount')" style="color: red;">
                    Please enter a value between 1 and 10000000
                </span>
			</div>
			<div class="downPamentSection">
				<div class="downPament">
					<label>{{ !mortgageCalcLabel.downPament ? "Down Payment" : mortgageCalcLabel.downPament }}</label><br />
					<div class="inp_fields">
                        <span class="currency_icon">{{currencyType}}</span>
                        <input type="number" min=0 id="downPament"
                                class="typeNumbers" 
                                name="downPament" 
                                :placeholder="getDownPayment(mortgageCalcLabel.downPament)"
                                v-model="downPament">
                    </div>
				</div>
				<div class="downPamentPerc">
					<label>{{ !mortgageCalcLabel.downPament ? "Down Payment" : mortgageCalcLabel.downPament }} Percentage</label>
					<div class="inp_fields">
                        <span class="currency_icon">{{currencyType}}</span>
                        <input type="number" min=0 id="downPamentPerc" 
                            class="typeNumbers"
                            name="downPamentPerc" 
                            :placeholder="getPercentage(mortgageCalcLabel.downPament)"
                            v-model="downPamentPerc">
					</div>
				</div>
			</div>
			<div class="mortgageTermSection">
				<div class="mortgageTerm">
					<label>{{ !mortgageCalcLabel.mortgageTerm ? "Mortgage Term" : mortgageCalcLabel.mortgageTerm }} Years</label>
					<div class="inp_fields">
                        <span class="years_icon">years</span>
                        <input type="number" min=0 id="mortgageTerm" 
                                class="typeNumbers"
                                name="mortgageTerm" 
                                :placeholder="getMortgageTerm(mortgageCalcLabel.mortgageTerm)"
                                v-model="mortgageTerm"
                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;"
                                v-validate="term_rule"
                                :class="{'error': errors.has('mortgageTerm') }">
                    </div>
                    <span v-if="errors.has('mortgageTerm')" style="color: red;">
	                    Please enter a value between 1 and 40
	                </span>
				</div>
				<div class="mortgageTermMonth">
					<label>{{ !mortgageCalcLabel.mortgageTerm ? "Mortgage Term" : mortgageCalcLabel.mortgageTerm }} Month</label>
					<div class="inp_fields">
                        <span class="months_icon">months</span>
                        <input type="number" min=0 id="mortgageTermMonth"
                            class="typeNumbers" 
                            name="mortgageTermMonth" 
                            :placeholder="getMortgageTermMonth(mortgageCalcLabel.mortgageTerm)"
                            v-model="mortgageTermMonth"
                            pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==3) return false;"
                            v-validate="term_rule_month"
                            :class="{'error': errors.has('mortgageTermMonth') }">
                    </div>
                    <span v-if="errors.has('mortgageTermMonth')" style="color: red;">
	                    Please enter a value between 1 and 480
	                </span>
				</div>
			</div>
			<div class="annualIntRateSection">
				<label>{{ !mortgageCalcLabel.annualInterestRate ? "Annual Interest Rate" : mortgageCalcLabel.annualInterestRate }}</label><br />
				<div class="inp_fields">
                    <span class="percentage">%</span>
                    <input type="number" min=0 id="annualInterestRate" 
                        class="typeNumber"
                        name="annualInterestRate" 
                        :placeholder="getAnnualIntRate(mortgageCalcLabel.annualInterestRate)"
                        v-model="annualInterestRate"
                        pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;"
                        v-validate="annual_int_rate_term"
                        :class="{'error': errors.has('annualInterestRate') }">
                </div>
                <span v-if="errors.has('annualInterestRate')" style="color: red;">
                    Please enter a value between 1 and 90
                </span>  
			</div>

            <!-- All Cost Section -->
            <div class="cost_section">
                <p><b>Your estimated monthly payment</b>:</p>
                <h1><span>{{ this.currencyType }}</span> {{ (monthlyPayment).toFixed(2) }}</h1>
                <p><b>Total principal paid</b>: {{ this.currencyType }} {{ principalPaid }}</p>
                <p><b>Total interest paid</b>: {{ this.currencyType }} {{ (total_interest).toFixed(2) }}</p>      
            </div>

		</div>
		<!-- End Field Section -->
      
        <div class="btns" v-if="amortizationTable==true">
            <button @click="paymentSchedule()" v-if="showAmortBtn" class="paymentBtn" :disabled="errors.any()">Payment Schedule</button>
            <button @click="hidePaymentSchedule()" v-if="!showAmortBtn" class="hidePaymentBtn" :disabled="errors.any()">Hide Payment Schedule</button>
        </div>

        <div class="ammortization_section" v-if="showTable">
            <h4>
                <strong>Amortization Schedule</strong>
            </h4>
            <div class="est_payoff">
                    <div class="start_date">
                        <label>Start Date</label>
                        <input type="date" v-model="date_us" @change="dateChangeFun()">
                    </div>
                    <div class="est_payoff_date">
                        <p>Estimated Payoff Date</p>
                        <h4 class="date_est">{{ date_selected }} {{ estPayOffDate }}</h4>
                    </div>
            </div>

            <div style="overflow-x:auto; width:100%">
                <table>
                    <thead>
                        <tr>
                          <th>Payment Date</th>
                          <th>Payment</th>
                          <th>Principal</th>
                          <th>Interest</th>
                          <th>Total Interest</th>
                          <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(entry, i) in gridData" :key="i">
                            <td v-for="(key, j) in gridColumns" :key="j">
                                {{ entry[key] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
</template>

<script>
	export default {
    props: [
        'tableTitle', 
        'mortgageCalcLabel',
        'mortgageCalcDef',
        'amortizationTable',
        'currencyType'
    ],
    data() {
        return {
            loanAmount: 0,
            downPament: 0,
            downPamentPerc: 0,
            mortgageTerm: 0,
            mortgageTermMonth: 0,
            annualInterestRate: 0,
            monthlyPayment: 0,
            principalPaid: 0,
            annualInterestRateUpd: 0,
            newValue: 0,
            date: "",
            showAmortBtn: true,
            showTable: true,
            date_us: '01/05/2017',
            gridColumns: [
                'PaymentDate', 'payment', 'principal', 'interest', 'totalInterest', 'balance'
            ],
            gridData: [],
            months: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            month: 0,
            date_selected: 0,
            year_selected: 0,
            estPayOffDate: '',
            acceptedValue: '',
            acceptedTerm: '',
            acceptedTermMonth: '',
            acceptAnnInterestRate: ''
        }
    },
    created() {
        this.loanAmount = this.mortgageCalcDef.loanAmountDefVal;
        this.downPament = this.mortgageCalcDef.downPamentDefVal;
        this.mortgageTerm = this.mortgageCalcDef.mortgageTermDefVal;
        this.annualInterestRate = this.mortgageCalcDef.annualInterestRateDefVal;
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() +  1;
        var year = today.getFullYear();
        this.month = mm;
        this.year_selected = year;
        if( dd < 10 ) {
            dd = '0' + dd;
        }
        this.date_selected= dd;
        if( mm < 10 ) {
            mm = '0' + mm;
        }
        today = mm + "/" + dd + "/" + year;
        this.date_us = today;
        // Generating Amortization Schedule
        var ann_int_rate = ( this.annualInterestRate / 12);
        ann_int_rate /= 100;
        var principalPaid = this.downPament;
        var loanAmount = this.loanAmount - this.downPament;
        this.principalPaid = loanAmount;
        this.monthlyPayment = parseFloat( ( ( loanAmount * ann_int_rate ) / ( 1 - ( 1 / Math.pow( ( 1 + ann_int_rate ), this.mortgageTermMonth ) ) ) ) );
        this.acceptedValue = 10000000;
        this.acceptedTerm = 40;
        this.acceptedTermMonth = 480;
        this.acceptAnnInterestRate = 90;
    },
    computed: {
        total_interest() {
            if( this.monthlyPayment != 0 && this.mortgageTermMonth != 0 && this.principalPaid != 0 ) {
                var total_interest = parseFloat( ( this.monthlyPayment * this.mortgageTermMonth ) - this.principalPaid );
                return total_interest;
            } else {
                return 0;
            }
        },
        rules() {
            if( !this.acceptedValue ) {
                return 'required';
            }
            return `required|max_value:${this.acceptedValue}`;
        },
        term_rule() {
            if( !this.acceptedTerm ) {
                return 'required';
            }
            return `required|max_value:${this.acceptedTerm}`;
        },
        term_rule_month() {
            if( !this.acceptedTermMonth ) {
                return 'required';
            }
            return `required|max_value:${this.acceptedTermMonth}`;
        },
        annual_int_rate_term() {
            if( !this.acceptAnnInterestRate ) {
                return 'required';
            }
            return `required|max_value:${this.acceptAnnInterestRate}`;
        }
    },
    
    watch: {
        loanAmount: function() {
            this.showTable = false;
            this.showAmortBtn = true;
            if( this.principalPaid <= 0 ) {
                this.principalPaid = this.loanAmount;
            
            }
            
            if( this.principalPaid != 0 ) {
                
                this.principalPaid = parseFloat( this.loanAmount - this.downPament );
            
            }
            if( this.annualInterestRate != 0 ) {
                this.annualInterestRateUpd = parseFloat(( this.annualInterestRate / 12 ) / 100);
            
            }
            if( this.mortgageTerm != 0 ) {
                this.mortgageTermMonth = parseFloat( this.mortgageTerm ) * 12;
            
            }
            if( this.annualInterestRateUpd != 0 && this.mortgageTermMonth != 0 && this.principalPaid != 0 ) {
                
                this.monthlyPayment = parseFloat( ( ( this.principalPaid * this.annualInterestRateUpd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.annualInterestRateUpd ), this.mortgageTermMonth ) ) ) ) );
            
            }
            if( this.loanAmount == 0 || this.loanAmount == '') {
                this.monthlyPayment = 0;
                this.principalPaid = 0;

                this.showAmortBtn = true;
            }
        },
        downPament() {
            this.showTable = false;
            this.showAmortBtn = true;
            if( this.principalPaid == 0 || this.loanAmount == '' ) {
                
                this.principalPaid = this.loanAmount;
                this.showAmortBtn = true;
            
            }
            if( this.loanAmount != 0 ) {
                this.principalPaid = parseFloat( this.loanAmount - this.downPament );
            
            }
            if( this.annualInterestRate != 0 ) {
                this.annualInterestRateUpd = parseFloat(( this.annualInterestRate / 12 ) / 100);
            
            }
            if( this.mortgageTerm != 0 ) {
                this.mortgageTermMonth = parseFloat( this.mortgageTerm ) * 12;
            
            }
            if( this.annualInterestRateUpd != 0 && this.mortgageTermMonth != 0 && this.loanAmount != 0 && this.principalPaid != 0 ) {
                this.monthlyPayment =  parseFloat( ( ( this.principalPaid * this.annualInterestRateUpd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.annualInterestRateUpd ), this.mortgageTermMonth ) ) ) ) );
            
            }

            this.downPamentPerc = ( (this.downPament / this.loanAmount ) * 100 ).toFixed(2);
        },
        mortgageTerm() {
            this.showTable = false;
            this.showAmortBtn = true;
            if( this.mortgageTerm != 0 ) {
                this.mortgageTermMonth = parseFloat( this.mortgageTerm ) * 12;
            
            }
            if( this.loanAmount != 0 ) {
                this.principalPaid = parseFloat( this.loanAmount - this.downPament );
            }
            
            if( this.annualInterestRate != 0 ) {
                this.annualInterestRateUpd = parseFloat(( this.annualInterestRate / 12 ) / 100);
            
            }
            if( this.loanAmount == 0 && this.annualInterestRateUpd == 0 ) {
                this.monthlyPayment = 0;
            
            }
            if( this.loanAmount != 0 && this.annualInterestRateUpd != 0 && this.principalPaid > 0 ) {
                this.monthlyPayment = parseFloat( ( this.principalPaid * this.annualInterestRateUpd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.annualInterestRateUpd ), this.mortgageTermMonth ) ) ) );
            
            }
            if( this.mortgageTerm == 0 || this.mortgageTerm == '' ) {
                this.monthlyPayment = 0;
                this.principalPaid = 0;
                this.showAmortBtn = true;

                this.mortgageTermMonth = 0;
            }
            
            else {
                this.monthlyPayment =  parseFloat( ( ( this.principalPaid * this.annualInterestRateUpd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.annualInterestRateUpd ), this.mortgageTermMonth ) ) ) ) );
            
            }
        },
        mortgageTermMonth() {
            this.showTable = false;
            this.showAmortBtn = true;
            if( this.mortgageTermMonth == '' ) {
                this.mortgageTerm = 0;
            }
            if( this.mortgageTermMonth != 0 ) {
                this.mortgageTerm = this.mortgageTermMonth / 12;
            }
            if( this.mortgageTermMonth == 0 || this.mortgageTermMonth == '' ) {
                this.mortgageTerm = 0;

                this.showAmortBtn = true;
            }
        },
        annualInterestRate() {
            this.showTable = false;
            this.showAmortBtn = true;
            
            this.annualInterestRateUpd = parseFloat(( this.annualInterestRate / 12 ) / 100); 
            if( this.principalPaid == 0 ) {
                this.principalPaid = this.loanAmount;
            }

            if( this.loanAmount != 0 ) {
                this.principalPaid = parseFloat( this.loanAmount - this.downPament );
            }
            
            if( this.annualInterestRate == 0 || this.annualInterestRate == '' ) {
                this.monthlyPayment = 0;
                this.principalPaid = 0;

                this.showAmortBtn = true;
            }       
            if( this.loanAmount != 0 && this.annualInterestRateUpd != 0 && this.mortgageTerm != 0 && this.principalPaid != 0) {
                this.monthlyPayment = parseFloat( ( this.principalPaid * this.annualInterestRateUpd ) / ( 1 - ( 1 / Math.pow( ( 1 + this.annualInterestRateUpd ), this.mortgageTermMonth ) ) ) ); 
            
            }
        },
        downPamentPerc() {
            if( this.loanAmount != 0 ) {

                let downPamentPerc = (this.downPamentPerc * this.loanAmount) / 100;
            }
        }
    },
    methods: {
        paymentSchedule() {
            this.showTable= true;
            this.showAmortBtn = false;
            var p;
            var i = 0;

            while( i <= this.monthlyPayment ) {

                var root_year = this.year_selected;

                this.gridData.push({
                    PaymentDate: '',
                    payment: 0,
                    principal: 0,
                    interest: 0,
                    totalInterest: 0,
                    balance: 0
                });

                p = this.principalPaid;
                var ann_int = this.annualInterestRate;
                var total_interest = 0;
                var monthIndex = this.month;

                this.gridData.forEach(element => {
                    
                    if( this.months[monthIndex] == 'Jan' || monthIndex == 12) {
                        
                        if( monthIndex == 12 ){
                            monthIndex = 0
                        }
                        
                        element.PaymentDate = this.months[monthIndex] + ' ' + ((root_year + 1).toString());
                        
                        root_year = root_year + 1;
                    } else {
                        element.PaymentDate = this.months[monthIndex]+ ' ' + ((root_year).toString());
                    }
                    
                    element.payment = (this.monthlyPayment).toFixed(3);
                    var interest = parseFloat( ( p * (  ann_int / 100 ) ) / 12 );

                    element.interest = interest.toFixed(2);
                    total_interest = (parseFloat(interest) + parseFloat(total_interest));
                    element.totalInterest = total_interest.toFixed(2);
                    element.principal = ( this.monthlyPayment - element.interest ).toFixed(2);
                    var principal_upd = ( this.monthlyPayment - element.interest );

                    if(  p - principal_upd < 1  ) {
                        var balance_final = 0;
                        element.balance = balance_final.toFixed(2);
                        this.estPayOffDate = element.PaymentDate;    
                    } 
                    else {
                        element.balance = ( p - principal_upd ).toFixed(2); 
                    }
                    
                    var balance_upd = ( p - principal_upd );
                    p = balance_upd;
                    monthIndex+=1;

                    if(monthIndex == 12) {
                        monthIndex = 0;
                    }
                });

                if( p < 1 ) {
                    return;
                }

                i = this.monthlyPayment - p;
            
            }
        },
        hidePaymentSchedule() {
            this.showTable = false;
            this.showAmortBtn = true;
            this.gridData.length = 0;
        },
        dateChangeFun() {
            var str = this.date_us;
            var month = str.substring(5, 7);
            var date = str.substring(8, 10);
            this.date_selected = date;
            this.month = parseInt(month);
            this.gridData = [];
            this.paymentSchedule();
        },
        getLoanAmount(str) {
            if(str == '') {
                str = 'Loan Amount';
            }
            return str;
        },
        getDownPayment(str) {
            if(str == '' ) {
                str = 'Down Payment';
            }
            return str;
        },
        getPercentage(x) {
            if(x == '') {
                x = 'Down Payment';
            }
            return x + ' Percentage';
        },
        getMortgageTerm(str) {
            if(str == '') {
                str = 'Mortgage Term';
            }
            return str + ' Years';
        },
        getMortgageTermMonth(str) {
            if(str == '') {
                str = 'Mortgage Term Months';
            }
            return str + ' Months';
        },
        getAnnualIntRate(str) {
            if(str == '') {
                return 'Annual Interest Rate'
            }
            return str;
        }
    }
}
</script>