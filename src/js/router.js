export default [
	{ 
		path: '/', 
		name: 'mortgage_calc_home', 
		component: require('./components/AllTables') 
	},
	{
		path: '/edit_table/:table_id',
		name: 'edit_table',
		component: require('./components/EditTable.vue')
	}
];