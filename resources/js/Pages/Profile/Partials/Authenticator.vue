<script setup>
defineProps({
    authenticator: {
        type: Object,
    },
});
</script>
<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Google Authenticator</h2>

        </header>

        <form  class="mt-6 space-y-6">
            <h4>{{authenticator.secret_key}}</h4>
            <div v-html="authenticator.qr_code">

            </div>
        </form>
    </section>
</template>
