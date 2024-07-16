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

import Plyr from '../../../../public/plyr/js/plyr';
console.log(Plyr)


export default {
    components: {
        AuthenticatedLayout
    },
    props : ['recording'],
    mounted(){
        const selector = '#player';

        Shr.setup('.js-shr', {
        count: {
            className: 'button__count',
        },
        wrapper: {
            className: 'button--with-count',
        },
        });

        const player = new Plyr(selector, {
            debug: true,
            title: 'View From A Blue Moon',
            iconUrl: 'dist/demo.svg',
            keyboard: {
                global: true,
            },
            tooltips: {
                controls: true,
            },
            captions: { active: true},
            previewThumbnails: {
                enabled: true,
                src: [],
            },
        })

        // Expose for tinkering in the console
        window.player = player;

        // Setup type toggle
        const buttons = document.querySelectorAll('[data-source]');
        const types = Object.keys(sources);
        const historySupport = Boolean(window.history && window.history.pushState);
        let currentType = window.location.hash.substring(1);
        const hasInitialType = currentType.length;

        function render(type) {
            // Remove active classes
            Array.from(buttons).forEach((button) => button.parentElement.classList.toggle('active', false));

            // Set active on parent
            document.querySelector(`[data-source="${type}"]`).classList.toggle('active', true);

            // Show cite
            Array.from(document.querySelectorAll('.plyr__cite')).forEach((cite) => {
                // eslint-disable-next-line no-param-reassign
                cite.hidden = true;
            });

            document.querySelector(`.plyr__cite--${type}`).hidden = false;
        }

        function setSource(type, init) {
            // Bail if new type isn't known, it's the current type, or current type is empty (video is default) and new type is video
            if (!types.includes(type) || (!init && type === currentType) || (!currentType.length && type === 'video')) {
                return;
            }

            // Set the new source
            player.source = sources[type];

            // Set the current type for next time
            currentType = type;

            render(type);
        }

        Array.from(buttons).forEach((button) => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-source');

                setSource(type);

                if (historySupport) {
                window.history.pushState({ type }, '', `#${type}`);
                }
            });
        });

        window.addEventListener('popstate', (event) => {
            if (event.state && Object.keys(event.state).includes('type')) {
                setSource(event.state.type);
            }
        });

        if (!hasInitialType) {
            currentType = 'video';
            }

            // Replace current history state
            if (historySupport && types.includes(currentType)) {
            window.history.replaceState({ type: currentType }, '', hasInitialType ? `#${currentType}` : '');
            }

            // If it's not video, load the source
            if (currentType !== 'video') {
            setSource(currentType, true);
            }

            render(currentType);







    }
}
</script>
