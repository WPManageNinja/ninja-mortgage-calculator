<template> 
    <div class="ninja_mortgage_editor">
        <div class="editor_header">
            <div class="section_header">
                <h1>All Mortgage Tables</h1>
            </div>
            <div class="section_action">
                <el-button size="mini" type="primary" @click="addTableModal = true">Add Table</el-button>
            </div>
        </div>
    
        <hr>


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
                    <router-link title="Edit" :to="{ name: 'edit_table', params: { table_id: scope.row.ID} }">
                        <i class="el-icon-edit"></i>
                    </router-link>
                    <a :href="scope.row.demo_url"  target="_blank" class="el-button el-button--info el-button--mini">
                        <i class="el-icon-view"></i>
                    </a>
                    <app-delete-table @delete="deleteItem(scope.row.ID)"></app-delete-table> 
                </template>
            </el-table-column>


        </el-table>

        <!-- Dialog -->
        <el-dialog
            title="Add New Mortgage Table"
            :visible.sync="addTableModal"
            width="60%">
                <label for="new_table_name">Table Name</label>
                <el-input id="new_table_name" type="text" placeholder="Your Table Name" v-model="table_name"></el-input>
                <el-select v-model="selectCalculator" placeholder="Select Calculator Type" style="margin-top: 10px">
                    <el-option v-for="(type, i) in calc_types"
							:key="i"
							:label="type.label"
							:value="type.value" >
                    </el-option>
                </el-select>
                <span slot="footer" class="dialog-footer">
                    <el-button @click="addTableModal = false">Cancel</el-button>
                    <el-button type="primary" @click="addNewTable" v-loading="addingTableAjax">Add New</el-button>
                </span>
            </el-dialog>

            <!-- Pagination -->
            <div v-if="total > per_page">
                <el-pagination background
                                        layout="prev, pager, next"
                                        :page-size="per_page"
                                        :current-page="page_number"
                                        @current-change="changePage"
                                        :total="total"
                                        :open-delay="300">
                </el-pagination>
            </div>
    </div>
</template>

<script>
import DeleteTable from './deleteTable.vue';
import Clipboard from 'clipboard';

export default {
    name: 'all_mortgage_tables',
    components: {
        'app-delete-table': DeleteTable
    },
    data() {
        return {
            addingTableAjax: false,
            addTableModal: false,
            tableLoading: false,
            calc_types: [
                {
                    value: 'mortgage_calculator',
                    label: 'Mortgage Calculator'
                }, 
                {
                    value: 'mortgage_refinance',
                    label: 'Mortgage Refinance Calculator'
                }, 
                {
                    value: 'mortgage_payment',
                    label: 'Mortgage Payment Calculator'
                }
            ],
            tableData: [],
            table_name: '',
            selectCalculator: '',
            per_page: 10,
            page_number: 1,
            total: 0
        }
    },
    methods: {

        addNewTable() {
            this.addingTableAjax = true;
            jQuery.post(ajaxurl, {
                action: 'ninja_mortgage_ajax_actions',
                route: 'add_table',
                post_title: this.table_name,
                calculator_type: this.selectCalculator
            }).then(
                response => {
                    this.$notify.success({
                        title: 'Success',
                        message: response.data.message
                    });
                    this.$router.push({
                        name: 'edit_table',
                        params: {
                            table_id: response.data.table_id
                        }
                    })
                }
            ).fail(
                error => {
                    this.$notify.error({
                        title: 'Error',
                        message: error.responseJSON.data.message
                    });
                }
            ).always(
                () => {
                    this.addTableModal = false;
                    this.addingTableAjax = false;
                }
            )
           

        },
        
        fetchTables() {
            this.tableLoading = true;
            jQuery.get(ajaxurl, {
                action: 'ninja_mortgage_ajax_actions',
                route: 'get_tables',
                per_page: this.per_page,
                page_number: this.page_number
            })
                .then(response => {
                    this.tableData = response.data.tables;
                    this.total = response.data.total;
                })
                .fail(error => {
                     console.log(error);
                })
                .always(() => {
                    this.tableLoading = false
                })
        },

        changePage(pageNumber) {
            this.page_number = pageNumber;
            this.fetchTables();
        },
        
        deleteItem(tableId) {
            jQuery.post(ajaxurl, {
                action: 'ninja_mortgage_ajax_actions',
                route: 'delete_table',
                table_id: tableId
            }).then(
                response => {
                    this.$notify.success({
                        title: 'Deleted',
                        message: response.data.message
                    })
                    this.total = this.total - 1;
                    if(this.total == this.per_page) {
                        this.page_number = 1;
                    } 
                   else  if( (this.total % 2 != 0) && (this.total % this.per_page) == 0 ) {
                        var res = parseInt(this.total / 2);
                        if( this.total - ((res * 2) + 1) == 0 && this.total != this.per_page) {
                            this.page_number = this.page_number - 1;
                        }    
                    }
                    else if(this.total % 2 == 0 && (this.total % this.per_page) == 0) {
                        var res = parseInt(this.total / 2);
                        if( this.total - ((res * 2)) == 0 && this.total != this.per_page ) {
                            this.page_number = this.page_number - 1;
                        } 
                    }                 
                    this.fetchTables();
                }
            ).fail(
                error => {
                    this.$notify.error({
                        title: 'Error', 
                        message: error.responseJSON.data.message
                    })
                }
            )
            },
            clipboardRender(){
                var clipboard = new Clipboard('.copy');
                clipboard.on('success', (e) => {
                    this.$message({
                        message: 'Copied to Clipboard!',
                        type: 'success'
                    });
                });
            }

    },
    created() {
        this.fetchTables();
        this.clipboardRender();
    }
}
</script>


<style lang="scss">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #F1F1F1;
    }

    .ninja_mortgage_editor {
        .section_action {
            float: right;
            margin-top: -32px;
        }

        .select_calc_type {
            margin-top: 10px;
        }

        .editor {
            width: 100%;
            float: right;
        }

        hr {
            color: #DDDDDD;
        }

        .el-message--success {
            z-index: 999999!important;
            top: 5px;
        }
    }    
</style>
