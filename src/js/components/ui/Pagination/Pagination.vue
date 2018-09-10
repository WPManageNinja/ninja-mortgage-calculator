<template>
    <el-pagination
        @size-change="handleSizeChange"
        @current-change="goToPage"
        :current-page.sync="paginate.current_page"
        :page-sizes="[10, 20, 50, 100]"
        :page-size="paginate.per_page"
        layout="total, sizes, prev, pager, next, jumper"
        :total="paginate.total">
    </el-pagination>
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        paginate: {
            default: {
                total: 0, 
                current_page: 1,
                last_page: 1,
                per_page: 10
            }
        }
    },
    methods: {
        handleSizeChange(val) {
            this.paginate.per_page = val;
            this.$emit('paginateData', this.paginate)
        },
        goToPage(value) {
            this.paginate.current_page = value;
            this.$emit('paginateData', this.paginate)
        }
    }
}
</script>

<style>
</style>