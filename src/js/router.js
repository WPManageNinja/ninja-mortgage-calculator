export default [
	{ 
		path: '/', 
		name: 'mortgage_calc_home', 
		component: require('./views/AllTables.vue') 
	},
	{
		path: '/edit_table/:table_id',
		name: 'edit_table',
		component: require('./views/EditTable.vue')
	}
];