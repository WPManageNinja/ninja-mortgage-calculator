<template>
    <el-dialog
        title="Add New Mortgage Table"
        :visible.sync="addTableModal"
        @close="closeModal"
        width="60%">
        <label for="new_table_name">Table Name</label>
        <el-input id="new_table_name" type="text" placeholder="Your Table Name" v-model="table_name"></el-input> 
        <div class="select_calc_type">
            <app-input-dropdown
                pcHolder="Select Calculator Type"
                v-model="selectedCalc"
                :optionTypes="calc_types"
                label="Calculator Type"></app-input-dropdown>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="addTableModal = false">Cancel</el-button>
            <el-button type="primary" @click="addNewTable" v-loading="addingTableAjax">Add New</el-button>
        </span>
    </el-dialog>
</template>


<script>
import InputDropDown from '../ui/InputFields/_inputDropdown.vue';

export default {
    name: 'AddTable',
    components: {
        'app-input-dropdown': InputDropDown
    },
    data() {
        return {
            table_name: '',
            selectedCalc: ''
        }
    },
    props: {
        calc_types: {
            default: []
        },
        addTableModal: {
            default: false
        },
        addingTableAjax: {
            default: false
        }
    },
    methods: {
        addNewTable() {
            var newData = {
                tableName: this.table_name,
                selectedCalc: this.selectedCalc
            };
            this.$emit('addNewTable', newData)
        },
        closeModal() {
            this.$emit('close');
        }
    }

}
</script>

<style>
.select_calc_type {
    width: 50%;
}
</style>
