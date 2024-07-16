<template>
    <AuthenticatedLayout>
        <video
            controls
            crossorigin
            playsinline
            id="player"
          >
            <source
              :src="recording.link"
              type="video/mp4"
            />

            <a :href="recording.link" download>Download</a>
          </video>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import 'custom-event-polyfill';
import 'url-polyfill';

import * as Sentry from '@sentry/browser';
import Shr from 'shr-buttons';

export default {
    components: {
        AuthenticatedLayout
    },
    props : ['recording'],
    mounted(){
        const selector = '#player';
        alert('sdsdsd')
        Shr.setup('.js-shr', {
        count: {
            className: 'button__count',
        },
        wrapper: {
            className: 'button--with-count',
        },
        });

        const player = new Plyr(selector)
        console.log(player,'player')
    }
}
</script>
