<template>
    <el-popover placement="top" width="160" style="margin-left: 10px" v-model="isVisible">
        <p>Are you sure to delete this?</p>
        <div style="text-align: right; margin: 0">  
            <el-button size="mini" type="text" @click="isVisible=false">Cancel</el-button>
            <el-button size="mini" type="primary" @click="confirm()">Confirm</el-button> 
        </div>
        <el-button slot="reference" title="Delete" size="mini" type="danger" icon="el-icon-delete"></el-button>
    </el-popover>
</template>

<script>
export default {
    name: 'deleteTable',
    data() {
        return {
            isVisible: false
        }
    },
    methods: {
        confirm() {
            this.$emit('delete', true);
        }
    }
}
</script>

