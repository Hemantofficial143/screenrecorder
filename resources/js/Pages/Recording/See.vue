<template>
    <GuestLayout>

        <Head :title="recording.name" />
        <Player playsinline ref="player" @vPlaybackReady="onPlaybackReady">
            <Video poster="https://media.vimejs.com/720p.mp4">
                <source data-src="https://media.vimejs.com/720p.mp4" type="video/mp4" />
            </Video>
            <DefaultUi>
                <TapSidesToSeek />
            </DefaultUi>
        </Player>
    </GuestLayout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { Player, Video, DefaultUi } from '@vime/vue-next';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

// Default theme.
import '@vime/core/themes/default.css';

// Optional light theme (extends default).
// import '@vime/core/themes/light.css';

// Custom UI Component.
import TapSidesToSeek from './TapSidesToSeek.vue';

export default defineComponent({
    name: 'App',
    components: {
        Player,
        Video,
        DefaultUi,
        TapSidesToSeek,
        GuestLayout,
        Head

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
            // ...
        },
    },
});
</script>
