<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Icon from '../../Components/Icon.vue';


defineProps({
    recordings: {
        type: Array,
        default: []
    }
});


</script>

<template>

    <Head title="Recordings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Recordings {{ text }}</h2>
        </template>

        <div class="py-12">
            <section class="text-gray-600 body-font">

                <div class="container px-5 mx-auto">
                    <div class="grid px-5 grid-cols-1">
                        <div v-if="message.message != ''"
                            :class="{ 'bg-green-700 text-green-100': message.state == 'success', 'bg-red-700 text-red-100': message.state == 'error' }"
                            class="p-2 items-center flex lg:inline-flex" role="alert">
                            <span
                                :class="{ 'bg-green-600': message.state == 'success', 'bg-red-600': message.state == 'error' }"
                                class="flex uppercase px-2 py-1 text-xs font-bold mr-3">{{ message.state ==
                                    'success' ? 'SUCCESSS' : 'ERROR'
                                }}</span>
                            <span class="font-semibold mr-2 text-left flex-auto">{{ message.message }}</span>
                            <svg class="fill-current opacity-700 cursor-pointer h-4 w-4" @click="clearMessage"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <div class="p-6 rounded-lg">
                                <button type="button" v-if="videoUploadInProgress"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                                    <Icon icon="cloud_upload"></Icon>
                                    Uploading Your Video
                                </button>

                                <button type="button" @click="clickRecord" v-else
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center">
                                    <Icon :icon="recordIcon"></Icon>
                                    {{ recordButton.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container px-5 py-0 mx-auto">
                    <div class="grid grid-cols-4 gap-4">
                        <div v-for="recording in list">
                            <div class="bg-gray-100 p-6 rounded-lg"
                                :class="{ 'border border-red-500': recording.latest != undefined }">
                                <span style="position: absolute;" v-if="recording.latest != undefined"
                                    class="bg-red-500 text-white text-uppercase text-xs px-2.5 py-0.5">LATEST</span>
                                <video :poster="recording.thumb_path" :src="recording.link" controls
                                    class="h-40 rounded w-full object-cover object-center mb-6"></video>
                                <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">
                                    {{ recording.days_passed }}</h3>
                                <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ recording.name
                                    }}</h2>
                                <p class="leading-relaxed text-base">Fingerstache flexitarian street art 8-bit
                                    waistcoat. Distillery hexagon disrupt edison bulbche.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import mixin from '../../Components/mixin.js'
let mediaRecorder;
let stream;

export default {
    mixins: [mixin],
    data() {
        return {
            message: {
                state: '',
                message: ''
            },
            videoUploadProgress: 0,
            videoUploadInProgress: false,
            recordButton: {
                disabled: false,
                inProgress: false,
                text: 'Start recording',
                error: '',
                success: '',
                mimeType: 'video/webm;codecs=vp9,opus'
            },
            options: {
                mimeTypes: [
                    'video/webm;codecs=vp9,opus',
                ],
                audioInputs: [],
                audioOutputs: [],
            },
            recordedBlobs: [],
            list: [],
        }
    },
    computed: {
        recordIcon() {
            if (this.recordButton.inProgress) {
                return 'stop_circle'
            } else {
                return 'radio_button_checked'
            }

        }
    },
    methods: {
        clearMessage() {
            this.message = {
                state: '',
                message: ''
            }
        },
        setMessage(state, message, $autoClear = false) {
            this.message = {
                state: state,
                message: message
            }

            if ($autoClear) {
                setTimeout(() => {
                    this.clearMessage()
                }, 5000)
            }
        },
        handleDataAvailable(event) {
            if (event.data && event.data.size > 0) {
                this.recordedBlobs.push(event.data);
            }
        },
        handleOnStop() {
            this.videoUploadInProgress = true;
            this.recordButton.inProgress = false;
            this.recordButton.text = 'Start Recording';
            stream.getTracks().forEach(track => track.stop());

            setTimeout(() => {
                const superBuffer = new Blob(this.recordedBlobs, { type: this.recordButton.mimeType });
                this.uploadRecording(superBuffer, URL.createObjectURL(superBuffer))
            }, 1000)
        },
        async startRecording() {
            try {
                let mimeType = this.recordButton.mimeType
                const options = { mimeType: mimeType };

                stream = await navigator.mediaDevices.getDisplayMedia({
                    audio: {

                    },
                    video: {
                        width: 1280, height: 720
                    }
                })
                window.stream = stream;


                if (mimeType.split(';', 1)[0] === 'video/mp4') {
                    // Adjust sampling rate to 48khz.
                    const track = window.stream.getAudioTracks()[0];
                    const { sampleRate } = track.getSettings();
                    if (sampleRate != 48000) {
                        track.stop();
                        window.stream.removeTrack(track);
                        const newStream = await navigator.mediaDevices.getUserMedia({ audio: { sampleRate: 48000 } });
                        window.stream.addTrack(newStream.getTracks()[0]);
                    }
                }

                mediaRecorder = new MediaRecorder(window.stream, options);
                mediaRecorder.ondataavailable = (e) => this.handleDataAvailable(e);
                mediaRecorder.onstop = (e) => this.handleOnStop(e)
                mediaRecorder.start();
                this.recordButton.inProgress = true;
                this.recordButton.text = 'Stop Recording';
            } catch (error) {
                console.log(error)
                if (error.name === 'NotAllowedError') {
                    this.setMessage('error', 'You need to allow access to screen sharing to proceed.', true)
                } else if (error.name === 'NotFoundError') {
                    this.setMessage('error', 'No media tracks of the specified type were found.', true)
                } else {
                    this.setMessage('error', 'An error occurred while trying to get the display media.', true)
                }
                setTimeout(() => {
                    this.recordButton.error = '';
                }, 3000)
            }

        },
        async uploadRecording(recording, blob) {
            const formData = new FormData();
            formData.append('recording', recording);
            formData.append('blob_url', blob);
            const response = await axios.post('/recordings/upload', formData, {
                onUploadProgress: progressEvent => {
                    this.videoUploadProgress = (progressEvent.loaded / progressEvent.total) * 100;
                }
            });
            if (response.status == 200) {
                if (response.data.success) {
                    let recordingData = response.data.recording
                    recordingData['latest'] = true;
                    this.list.unshift(recordingData);
                    this.setMessage('success', 'Your video was successfully saved. You can download from below grid.');
                }
            } else {
                this.setMessage('error', 'Somehow your video was failed to save although you can download from below grid first one is your recording');
            }
            this.videoUploadInProgress = false;
        },
        stopRecording() {
            mediaRecorder.stop();
        },
        clickRecord() {
            if (this.recordButton.inProgress) {
                this.stopRecording();
            } else {
                this.recordedBlobs = [];
                this.startRecording();
            }
        },
        handleBeforeUnload(event) {
            event.preventDefault();
            event.returnValue = '';
            return 'Are you sure you want to leave?';
        },
        getDevices(deviceInfos) {
            for (let i = 0; i !== deviceInfos.length; ++i) {
                const deviceInfo = deviceInfos[i];
                if (deviceInfo.kind === 'audioinput') {
                    this.options.audioInputs.push({ id: deviceInfo.deviceId, label: deviceInfo.label })
                } else if (deviceInfo.kind === 'audiooutput') {
                    this.options.audioOutputs.push({ id: deviceInfo.deviceId, label: deviceInfo.label })
                }
            }
            console.log(this.options, 'this.options')
        }
    },
    mounted() {
        this.list = this.recordings;
    }
}

</script>
