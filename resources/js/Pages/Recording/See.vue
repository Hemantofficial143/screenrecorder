<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Player, Video, DefaultUi } from '@vime/vue-next';
import '@vime/core/themes/default.css';
import { computed, onMounted, ref, watch } from 'vue';


const props = defineProps({
    recording: {
        type: Object,
        default: null
    }
});

const videoLink = ref('')

const setVideoLink = async () => {
    const response = await fetch(props.recording.link);
    const videoBlob = await response.blob();
    const blobUrl = URL.createObjectURL(videoBlob);
    videoLink.value = blobUrl
}

onMounted(() => {
    setVideoLink()
})

</script>
<template>

    <Head :title="recording.name" />
    <GuestLayout size="dd">
        <div style="width: 80%;height: 50%;">
            <Player playsinline ref="player" v-if="videoLink">
                <Video :poster="videoLink">
                    <source :data-src="videoLink" />
                </Video>
                <DefaultUi>
                    <TapSidesToSeek />
                </DefaultUi>
            </Player>
        </div>
    </GuestLayout>
</template>
