<template>
    <AuthenticatedLayout>
        <VideoPlayer :options="videoOptions"></VideoPlayer>

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
            videoOptions: {
                autoplay: true,
                controls: true,
                sources: [
                    {
                        src:'https://sample-videos.com/video321/mp4/720/big_buck_bunny_720p_1mb.mp4'
                    }
                ]
            }
        }
    }
}
</script>
