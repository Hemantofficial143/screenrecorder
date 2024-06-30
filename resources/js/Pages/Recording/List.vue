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
                            <div class="p-6">
                                <select v-model="recordButton.micId"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected>Mute</option>
                                    <option v-if="options.audioInputs.length > 0" v-for="mic in options.audioInputs"
                                        :value="mic.id">{{ mic.label }}</option>

                                </select>
                            </div>
                        </div>
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

                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                <div class="lg:w-1/4 md:w-1/2 p-4 w-full" v-for="recording in list">
                                    <a :href="route('view-recording', { 'recording_id': recording.recording_id })">
                                        <div class="bg-gray-100 p-6 rounded-lg block bg-white border border-gray-200">
                                            <a class="block relative h-48 rounded overflow-hidden">
                                                <span style="position: absolute;" v-if="recording.latest != undefined"
                                                    class=" bg-red-500 text-white text-uppercase text-xs px-2.5
                                                py-0.5">LATEST</span>
                                                <span
                                                    style="position: absolute;bottom:5px;right:5px;background-color: black;"
                                                    class="rounded-full bg-red-500 text-white text-uppercase text-xs px-2.5 py-0.5">4
                                                    mins</span>
                                                <img alt="ecommerce"
                                                    class="object-cover object-center w-full h-full block"
                                                    :src="recording.thumb_path">
                                            </a>
                                            <div class="mt-4">
                                                <h3
                                                    class="tracking-widest text-indigo-500 text-xs font-medium title-font">
                                                    {{ recording.days_passed }}</h3>
                                                <h2 class="text-gray-900 title-font text-lg font-medium">File Name </h2>
                                                <!-- <p class="mt-1">$16.00</p> -->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import mixin from '../../Components/mixin.js'
let mediaRecorder;
let audioStream = null;
let screenStream = null;

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
                micId: '',
                disabled: false,
                inProgress: false,
                text: 'Start recording',
                error: '',
                success: '',
                mimeType: 'video/mp4'
            },
            options: {
                mimeTypes: [
                    'video/mp4',
                ],
                audioInputs: [],
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
        async startRecording() {
            let composedStream = new MediaStream();


            if (this.recordButton.micId == '') {
                composedStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true })
            } else {
                screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true })
            }

            if (this.recordButton.micId != '') {
                audioStream = await navigator.mediaDevices.getUserMedia({ audio: { deviceId: { exact: this.recordButton.micId } } })
                composedStream = new MediaStream();
                screenStream.getVideoTracks().forEach(function (videoTrack) {
                    composedStream.addTrack(videoTrack);
                });
                var context = new AudioContext();

                var audioDestinationNode = context.createMediaStreamDestination();

                if (screenStream && screenStream.getAudioTracks().length > 0) {
                    const systemSource = context.createMediaStreamSource(screenStream);
                    const systemGain = context.createGain();
                    systemGain.gain.value = 1.0;
                    systemSource.connect(systemGain).connect(audioDestinationNode);
                }

                if (audioStream && audioStream.getAudioTracks().length > 0) {
                    const micSource = context.createMediaStreamSource(audioStream);
                    const micGain = context.createGain();
                    micGain.gain.value = 1.0;
                    micSource.connect(micGain).connect(audioDestinationNode);
                }

                audioDestinationNode.stream.getAudioTracks().forEach(function (audioTrack) {
                    composedStream.addTrack(audioTrack);
                });
            }

            console.log(composedStream, 'composedStream')
            if (composedStream != null) {
                let mimeType = this.recordButton.mimeType
                const options = { mimeType: mimeType };
                mediaRecorder = new MediaRecorder(composedStream, options);
                mediaRecorder.onstop = e => this.handleOnStop(e);
                mediaRecorder.ondataavailable = e => this.handleDataAvailable(e)
                mediaRecorder.start();
                this.recordButton.inProgress = true;
                this.recordButton.text = 'Stop Recording';
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

            if (audioStream != null) {
                this.clearTracks(audioStream);
                audioStream = null;
            }
            if (screenStream != null) {
                this.clearTracks(screenStream);
                screenStream = null;
            }


            setTimeout(() => {
                const superBuffer = new Blob(this.recordedBlobs, { type: this.recordButton.mimeType });
                this.uploadRecording(superBuffer, URL.createObjectURL(superBuffer))
            }, 1000)
        },
        clickRecord() {
            if (this.recordButton.inProgress) {
                this.stopRecording();
            } else {
                screenStream = null
                audioStream = null
                this.recordedBlobs = [];
                this.startRecording();
            }
        },
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
        clearTracks(stream) {
            stream.getTracks().forEach(track => {
                track.stop();
            });
        },
        async getMicrophones() {
            audioStream = await navigator.mediaDevices.getUserMedia({ audio: true })
            let deviceInfos = await navigator.mediaDevices.enumerateDevices();
            if (deviceInfos.length > 0) {
                deviceInfos.forEach(device => {
                    if (device.kind == 'audioinput') {
                        if (device.deviceId == 'default') {
                            this.recordButton.micId = device.deviceId
                        }
                        this.options.audioInputs.push({ id: device.deviceId, label: device.label });
                    }
                })
            }
            this.clearTracks(audioStream);
            audioStream = null;
        }
    },
    mounted() {
        this.getMicrophones()
        this.list = this.recordings;
    }
}

</script>
