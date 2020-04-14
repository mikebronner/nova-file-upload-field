<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data: function () {
        return {
            fileUri: "",
            imagePreviewData: "",
        };
    },

    computed: {
        fileName: function () {
            let fileName = this.fileUri.split('\\').pop().split('/').pop();
            const fileLength = fileName.length;
            let maxLength = 45;

            if (this.$refs[this.field.name + '-text']) {
                maxLength = this.$refs[this.field.name + '-text'].clientWidth
                    / parseFloat(getComputedStyle(document.querySelector('body'))['font-size'])
                    * 1.25;
            }

            if (fileLength > maxLength) {
                fileName = "&hellip;" + fileName.substring(fileLength - maxLength);
            }

            return fileName;
        },

        placeholderText: function () {
            return this.imagePreviewData.length > 0
                ? ""
                : "Drag & drop a file, or click to browse.";
        },
    },

    methods: {

        processUriList: function (event) {
            const data = event.dataTransfer.getData("text/uri-list");

            if ((data || false) === false) {
                return false;
            }

            this.handleChange(data);

            return true;
        },

        processText: function (event) {
            const data = event.dataTransfer.getData("text");

            if ((data || false) === false) {
                return false;
            }

            this.handleChange(data);

            return true;
        },

        processHtmlText: function (event) {
            const data = event.dataTransfer.getData("text/html");
            const sourceRegExp = /src=['"](.*?)['"]/;
            const match = sourceRegExp.exec(data);

            if (match && match.length > 0) {
                this.handleChange(match[1]);

                return true;
            }

            return false;
        },

        processFiles: function (event) {
            if (event.dataTransfer.files.length > 0) {
                this.$refs[this.field.name + '-file'].files = event.dataTransfer.files;
                this.$refs[this.field.name + '-file'].dispatchEvent(new Event('change', { 'bubbles': true }));

                return true;
            }

            return false;
        },

        captureFile: function (event) {
            let result = false;

            if (! result) {
                result = this.processUriList(event);
            }

            if (! result) {
                this.processText(event);
            }

            if (! result) {
                this.processHtmlText(event);
            }

            if (! result) {
                this.processFiles(event);
            }
        },

        clearImage: function () {
            this.imagePreviewData = "";
            this.fileUri = "";
            this.value = null;
        },

        fill: function (formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        handleChange: function (value) {
            this.fileUri = value;
            this.imagePreviewData = value;
            this.value = value;
        },

        previewImage: function (event) {
            var input = event.target;
            var self = this;

            this.fileUri = input.value;

            if (input.files
                && input.files[0]
            ) {
                var reader = new FileReader();

                this.image = Object.assign({}, this.image, {
                    file: input.files[0],
                });
                reader.onload = function (event) {
                    var imageData = event.target.result;
                    self.imagePreviewData = "";

                    if (imageData.indexOf("data:;base64,") === 0) {
                        self.imagePreviewData = "";
                        imageData = atob(imageData.replace("data:;base64,", ""));
                        imageData = imageData.substring(18, imageData.length - 35);
                        self.fileUri = imageData;
                        self.imagePreviewData = imageData;
                    }

                    if (imageData.indexOf("data:image") === 0) {
                        self.imagePreviewData = imageData;
                    }
                }

                reader.readAsDataURL(input.files[0]);
                this.value = input.files[0];
            }
        },

        setInitialValue: function () {
            const originalImage = this.field.previewUrl
                ? this.field.previewUrl
                : "";
            this.imagePreviewData = originalImage;
            this.fileUri = originalImage;
        },

        showFileUploadDialogue: function () {
            this.$refs[this.field.name + '-file'].click();
        },
    },
}
</script>

<template>
    <default-field
        :field="field"
        :errors="errors"
    >
        <template slot="field">
            <div class="relative nova-file-upload-field">
                <form ref="testform">
                <input
                    :ref="field.name + '-text'"
                    type="text"
                    class="target bg-40 bold text-center w-full form-control form-input form-input-bordered border-2 border-dashed h-64"
                    :class="errorClasses"
                    :placeholder="__(placeholderText)"
                    @dragover.stop.prevent=""
                    @drop.stop.prevent="captureFile"
                    @click="showFileUploadDialogue()"
                    @paste.prevent
                    :style="'background-image: url(' + imagePreviewData + ')'"
                >
                </form>
                <input
                    @change="previewImage"
                    :ref="field.name + '-file'"
                    type="file"
                    class="hidden"
                >
                <p
                    v-show="fileUri.length > 0"
                    class="w-full bg-90-half absolute pin-b rounded-lg rounded-t-none p-2 px-4 text-white"
                >
                    <span
                        class="float-left"
                        v-html="fileName"
                    ></span>
                    <svg
                        @click="clearImage"
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="trash-alt"
                        class="cursor-pointer float-right h-4 svg-inline--fa fa-trash-alt fa-w-14"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"
                    ><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
                </p>
            </div>
        </template>
    </default-field>
</template>

<style scoped lang="scss">
    .target {
        height: 16rem;
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
        outline: none;
        color: transparent;
        text-shadow: 0 0 0 rgb(124, 133, 142);
        cursor: pointer;

        &:focus {
            box-shadow: rgba(0, 0, 0, 0.0470588) 0px 2px 4px 0px;
        }
    }
</style>
