<template>
    <div class="mortgageCalcInputDropdown">
        <label>{{ label }}</label><br>
        <el-select v-model="model" :placeholder="pcHolder" class="model_select" style="width: 100%;" :clearable="clearable">
            <el-option 
                v-for="(type, i) in optionTypes"
                :key="i"
                :label="type.label"
                :value="type.value"></el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    name: 'InputDropdown',
    props: {
        value: {
            default: ''
        },
        pcHolder: {
            default: '',
        },
        optionTypes: {
            default: ''
        },
        label: {
            default: ''
        },
        clearable: {
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

<style lang="scss">
.mortgageCalcInputDropdown {
    width: 50%;
    .model_select {
        top: 5px;
    }
    input {
        background-color: #fff;
    }
}
</style>