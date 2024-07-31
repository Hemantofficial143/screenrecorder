<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

let props = defineProps({
    show: {
        type: Boolean,
        default:false
    },
    title : {
        type : String,
        default : ''
    }
});

const modalOpen = computed(() => {
    return props.show
})

</script>
<template>
    <el-dialog
        v-bind="props"
    >
        <slot>

        </slot>
        <template #footer>
            <slot name="footer"></slot>
        </template>
    </el-dialog>

</template>
