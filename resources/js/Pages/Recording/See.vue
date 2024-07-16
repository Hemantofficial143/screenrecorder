<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

let props = defineProps({
    recording : {
        default : {
            name : "Title",
            link : 'https://file-examples.com/storage/fe9f6f893066954d9aac3a2/2017/04/file_example_MP4_480_1_5MG.mp4'
        }
    }
})
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
    mounted(){
        const player = new Plyr('#player');
    }
}
</script>
