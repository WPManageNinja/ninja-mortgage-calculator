import Vue from 'vue';
import App from './components/UserCalculator.vue'
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate);

jQuery(document).ready(function () {
	let calculators = jQuery('.ninja_mortgage_calculator_instance');
    calculators.each((index, calc) => {
    	let instanceId = jQuery(calc).data('instance_id');
    	let elementId = '#ninja_mortgage_calculator_instance_'+instanceId;
        new Vue({
            el: elementId,
            data: {
                instance_id: instanceId
            },
            render: h => h(App)
        });
	});
});

