<template>

    <Head :title="recording.name" />
    <GuestLayout size="dd">
        <div style="width: 80%;height: 50%;">
            <Player playsinline ref="player" @vPlaybackReady="onPlaybackReady">
                <Video :poster="recording.link">
                    <source :data-src="recording.link" type="video/mp4" />
                </Video>
                <DefaultUi>
                    <TapSidesToSeek />
                </DefaultUi>
            </Player>
        </div>
    </GuestLayout>
</template>

<script lang="ts">
import { defineComponent, defineProps, ref } from 'vue';
import { Player, Video, DefaultUi } from '@vime/vue-next';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import '@vime/core/themes/default.css';
import TapSidesToSeek from './TapSidesToSeek.vue';

export default defineComponent({
    name: 'App',
    components: {
        GuestLayout,
        Head,
        Player,
        Video,
        DefaultUi,
        TapSidesToSeek,
    },
    props: {
        recording: {
            type: Object,
            default: null
        }
    },
    setup() {
        // Obtain a ref if you need to call any methods.
        const player = ref<HTMLVmPlayerElement | null>(null);
        return { player };
    },
    methods: {
        onPlaybackReady() {

        },
    },
});
</script>
