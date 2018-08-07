import Vue from 'vue';
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate'


import App from './components/UserCalculator.vue'

Vue.use(VeeValidate)


new Vue({
	el: "#ninja_mortgage_calculator",
	render: h => h(App)
})