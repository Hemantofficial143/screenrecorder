<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head :title="recording.name" />
    <GuestLayout size="dd">
        <div style="width: 80%;height: 50%;">
            <video id="player" playsinline controls data-poster="/path/to/poster.jpg">
                <source :src="recording.link" type="video/mp4" />
            </video>
        </div>
    </GuestLayout>
</template>
<script>
export default {
    props :{
        recording : {
            default : null
        }
    },
    mounted(){
        const player = new Plyr('#player');
    }
}
</script>
