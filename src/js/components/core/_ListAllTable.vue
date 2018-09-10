<template>
    <el-table :data="tableData"
                style="width: 100%; margin-top: 10px;"
                v-loading="tableLoading">
        
        <el-table-column 
            prop="ID"
            label="ID"
            width="60">
        </el-table-column>

        <el-table-column label="Name">
            <template slot-scope="scope">
                <router-link :to="{name: 'edit_table', params: { table_id: scope.row.ID } }">
                    {{ scope.row.post_title }}
                </router-link>
            </template>
        </el-table-column>

        <el-table-column 
            label="Caculator Type">
            <template slot-scope="scope">
                <span v-if="scope.row.CalCulatorType=='mortgage_calculator'">
                    Mortgage Calculator
                </span>
                <span v-if="scope.row.CalCulatorType=='mortgage_refinance'">
                    Mortgage Refinance
                </span>
                <span v-if="scope.row.CalCulatorType=='mortgage_payment'">
                    Mortgage Payment
                </span>
            </template>
        </el-table-column>            

        <el-table-column 
            label="ShortCode">
            <template slot-scope="scope">
                <code class="copy" :data-clipboard-text='`[ninja_mortgage_cal id="${scope.row.ID}"]`'>[ninja_mortgage_cal id="{{ scope.row.ID }}"]</code>             

            </template>
        </el-table-column>

        <el-table-column  label="Actions" width="190">
            <template slot-scope="scope">
                <router-link title="Edit" :to="{ name: 'edit_table', params: { table_id: scope.row.ID} }" class="el-button el-button--primary el-button--mini">
                    <i class="el-icon-edit"></i>
                </router-link>
                <a :href="scope.row.demo_url"  target="_blank" class="el-button el-button--info el-button--mini">
                    <i class="el-icon-view"></i>
                </a>
                <app-delete-table @delete="deleteItem(scope.row.ID)"></app-delete-table> 
            </template>
        </el-table-column>


    </el-table>
</template>


<script>
import DeleteTable from '../actions/_deleteTable.vue';
export default {
    name: 'ListAllTable',
    components: {
        'app-delete-table': DeleteTable
    },
    props: {
        tableData: {
            default: []
        },
        tableLoading: {
            default: false
        }
    },
    methods: {
        deleteItem(id) {
            this.$emit('removeTable', id);
        }
    }
}
</script>
