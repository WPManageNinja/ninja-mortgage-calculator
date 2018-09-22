<template> 
    <div class="ninja_mortgage_editor">
        <div class="editor_header">
            <div class="section_header">
                <h1>All Mortgage Calculators</h1>
            </div>
            <div class="section_action">
                <el-button size="mini" type="primary" @click="addTableModal = true">Add Calculator</el-button>
            </div>
        </div>
    
        <hr>

        <!-- All Table List -->
        <app-list-all-table
            :tableData="tableData"
            :tableLoading="tableLoading"
            @removeTable="deleteItem($event)"></app-list-all-table>

        <!-- Dialog for Adding Table -->
        <app-add-table
            :calc_types="calc_types"
            @close="addTableModal = false"
            :addTableModal="addTableModal"
            :addingTableAjax="addingTableAjax"
            @addNewTable="addNewTable($event)"></app-add-table>
        

        <!-- Pagination -->
        <div class="pull-right">
            <app-pagination
                :paginate="paginate"
                @paginateData="paginateFunc($event)"></app-pagination>
        </div>
    </div>
</template>

<script>
import ListAllTable from '../components/core/_ListAllTable.vue';
import AddTable from '../components/core/_AddTable.vue';
import Pagination from '../components/ui/Pagination/Pagination.vue';
import Clipboard from 'clipboard';

export default {
    name: 'all_mortgage_tables',
    components: {
        'app-add-table': AddTable,
        'app-pagination': Pagination,
        'app-list-all-table': ListAllTable
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
            paginate: {
                total: 0, 
                current_page: 1,
                last_page: 1,
                per_page: 10
            }, 
            search: ''
        }
    },
    methods: {

        addNewTable(val) {
            this.addingTableAjax = true;
            jQuery.post(ajaxurl, {
                action: 'ninja_mortgage_ajax_actions',
                route: 'add_table',
                post_title: val.tableName,
                calculator_type: val.selectedCalc
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
            let fetchTablesAjaxData = {
                action: 'ninja_mortgage_ajax_actions',
                route: 'get_tables',
                search: this.search,
                per_page: this.paginate.per_page,
                page_number: this.paginate.current_page
            }
            jQuery.get(ajaxurl, fetchTablesAjaxData)
                .then(response => {
                    this.tableData = response.data.tables;
                    this.paginate.total = response.data.total;
                })
                .fail(error => {
                    console.log(error);
                })
                .always(() => {
                    this.tableLoading = false
                })
        },
        
        deleteItem(tableId) {
            let deleteTableAjaxData = {
                action: 'ninja_mortgage_ajax_actions',
                route: 'delete_table',
                table_id: tableId
            }
            jQuery.post(ajaxurl, deleteTableAjaxData).then(
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
        },

        paginateFunc(val) {
            this.paginate = val;
            this.fetchTables();
        }

    },
    created() {
        this.fetchTables();
        this.clipboardRender();
    }, 
    watch: {
        search() {
            this.paginate.current_page = 1;
            this.fetchTables();
        }
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
        .editor_header {
            display: flex;
            justify-content: space-between;
            .section_action {
                position: relative;
                padding-top: 6px;
                .form_group {
                    padding-top: 0;
                    margin-bottom: 0;
                    input {
                        padding: 5px;
                        border-radius: 5px;
                        box-sizing: border-box;
                    }
                    .el-icon-search {
                        position: absolute;
                        top: 14px;
                        right: 100px;
                        font-size: 16px;
                    }
                }
            }
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

        .pull-right {
            float: right;
        }
    }    
</style>
