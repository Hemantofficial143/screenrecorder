<template>
    <AuthenticatedLayout>
        <div id="dplayer"></div>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DPlayer from 'dplayer';


export default {
    components: {
        AuthenticatedLayout,
    },
    props : ['recording'],
    data(){
    },
    mounted(){
        const dp = new DPlayer({
            container: document.getElementById('dplayer'),
            screenshot: true,
            video: {
                url: this.recording.link,
            },
        });
    }
}
</script>
