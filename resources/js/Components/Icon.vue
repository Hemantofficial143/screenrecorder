<script setup>
defineProps({
    icon: {
        required: true,
        default: ''
    }
})
</script>
<template>
    <span class="material-symbols-outlined mr-1">
        {{ icon }}
    </span>
</template>
