<template>
    <div>
        <label>
            <strong>{{label}}</strong>
        </label>
        <el-switch
            v-model="model"
            active-value="yes"
            inactive-value="no"></el-switch>
    </div>
</template>

<script>
export default {
    name: 'InputSwitch',
    props: {
        value: {
            default: ''
        },
        label: {
            default: ''
        }
    },
    computed: {
        model: {
            get() {
                return this.value
            },
            set(newValue) {
                this.$emit('input', newValue)
            }
        }
    }
}
</script>
