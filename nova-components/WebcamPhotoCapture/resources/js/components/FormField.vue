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

            <button type="button" v-if="this.value" @click="this.value = null">Reset</button>
            <button type="button" v-if="!this.value" @click="captureImage">Capture</button>

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
