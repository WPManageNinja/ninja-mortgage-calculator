<template>
    <app-mortgage-calc v-if="table_id && calculator_type=='mortgage_calculator'" :tableTitle="table_title"
                       :mortgageCalcLabel="mortgage_calculator_label"
                       :mortgageCalcDef="mortgage_calculator_default"
                       :amortizationTable="amortization_table"
                       :currencyType="currency_type"/>
    <app-mortgage-refinance v-else-if="table_id && calculator_type=='mortgage_refinance'" :tableTitle="table_title"
                            :mortgageRefinanceLabel="mortgage_refinance_label"
                            :mortgageRefinanceDef="mortgage_refinance_default"
                            :currencyType="currency_type"/>
    <app-mortgage-payment v-else-if="table_id && calculator_type=='mortgage_payment'" :tableTitle="table_title"
                          :mortgagePaymentLabel="mortgage_payment_label"
                          :mortgagePaymentDefault="mortgage_payment_default"
                          :currencyType="currency_type"/>
</template>

<script>
    import MortgageCalculator from './core/_MortgageCalculator.vue'
    import MortgageRefinance from './core/_MortgageRefinance.vue'
    import MortgagePayment from './core/_MortgagePayment.vue'

    export default {
        name: 'user_calculator',
        data() {
            return {
                calculator_type: '',
                table_id: 0,
                table_title: '',
                mortgage_calculator_label: {},
                mortgage_calculator_default: {},
                mortgage_refinance_label: {},
                mortgage_refinance_default: {},
                mortgage_payment_label: {},
                mortgage_payment_default: {},
                amortization_table: true,
                currency_type: '',
                instance_id: this.$parent.instance_id
            }
        },
        components: {
            'app-mortgage-calc': MortgageCalculator,
            'app-mortgage-refinance': MortgageRefinance,
            'app-mortgage-payment': MortgagePayment
        },
        created() {
            let vars = window['ninja_mortgage_cal_vars_' + this.instance_id];
            let res = vars.mortgageMetaData;
            let post = vars.post;
            this.calculator_type = post.post_content;
            this.table_id = post.ID;
            this.table_title = post.post_title;
            this.currency_type = res.currency_type;

            if (this.calculator_type === 'mortgage_calculator') {
                this.mortgage_calculator_label = res.selectedLabel;
                this.mortgage_calculator_default = res.selectedDefault;
                this.amortization_table = res.settings;
            }

            else if (this.calculator_type === 'mortgage_refinance') {
                this.mortgage_refinance_label = res.selectedLabel;
                this.mortgage_refinance_default = res.selectedDefault;
            }

            else if (this.calculator_type === 'mortgage_payment') {
                this.mortgage_payment_label = res.selectedLabel;
                this.mortgage_payment_default = res.selectedDefault;
            }
        }
    }
</script>