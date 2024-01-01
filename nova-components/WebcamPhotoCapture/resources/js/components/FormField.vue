<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>

            <video v-show="!this.value" ref="video" class="camera-stream" />
            <canvas style="display: none;" id="photoTaken" ref="canvas" :width="450" :height="337"></canvas>

            <img v-show="this.value" :src="this.value" />

            <button
                type="button" v-if="this.value" @click="this.value = null"
                class="shrink-0 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring-2 rounded border-2 border-gray-200 dark:border-gray-500 hover:border-primary-500 active:border-primary-400 dark:hover:border-gray-400 dark:active:border-gray-300 bg-white dark:bg-transparent text-primary-500 dark:text-gray-400 px-3 h-9 inline-flex items-center font-bold shrink-0"
            >Reset</button>

            <button
                type="button" v-if="!this.value" @click="captureImage"
                class="shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold"
            >Capture</button>

        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova';

/**
 * @link https://dagomez.medium.com/vue-3-basics-camera-and-screenshot-component-ac9af7d902f2
 */
export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    mounted() {
        navigator.mediaDevices.getUserMedia({video: true})
                 .then(mediaStream => {
                     this.$refs.video.srcObject = mediaStream;
                     this.$refs.video.play()
                     this.mediaStream = mediaStream
                 })
    },

    unmounted() {
        this.mediaStream.getTracks().forEach(track => track.stop())
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || '';
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.fieldAttribute, this.value || '');
        },

        captureImage() {
            const context = this.$refs.canvas.getContext('2d')
            const photoFromVideo = this.$refs.video

            context.drawImage(photoFromVideo, 0, 0, 450, 337)

            this.value = document.getElementById("photoTaken").toDataURL("image/jpeg")
        },
    },
};
</script>
