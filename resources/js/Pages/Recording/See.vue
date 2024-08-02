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
                autoplay: false,
                controls: true,
                sources: []
            }
        }
    },
    mounted(){
        this.videoOptions.sources.push({
            src : this.recording.link
        })
        setTimeout(() =>{
            this.showVideoPlayer = true
        },1000)

    }
}
</script>
