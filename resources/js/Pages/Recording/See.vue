<template>
    <AuthenticatedLayout>
        <VideoPlayer  v-if="showVideoPlayer" :options="videoOptions"></VideoPlayer>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VideoPlayer from '@/Components/VideoPlayer.vue';
import 'video.js/dist/video-js.css';

export default {
    components: {
        AuthenticatedLayout,
        VideoPlayer
    },
    props : ['recording'],
    data(){
        return {
            showVideoPlayer: false,
            videoOptions: {
                autoplay: true,
                controls: true,
                sources: [

                ]
            }
        }
    },
    mounted(){
        this.videoOptions.sources.push({
            src : this.recording.link
        })
        this.showVideoPlayer = true
    }
}
</script>
