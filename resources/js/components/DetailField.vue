<script>
import ImageLoader from '../../../vendor/laravel/nova/resources/js/components/ImageLoader';

export default {
    components: {
        ImageLoader,
    },

    props: ['resource', 'resourceName', 'resourceId', 'field'],

    data: function () {
        return {
            cardClasses: "",
            loading: false,
            missing: false,
            deleted: false,
            previewUrl: this.field.previewUrl,
        };
    },

    computed: {
        hasValue() {
            return (
                Boolean(this.field.value || this.previewUrl) &&
                !Boolean(this.deleted) &&
                !Boolean(this.missing)
            )
        },

        shouldShowLoader() {
            return !Boolean(this.deleted) && Boolean(this.field.value)
        },

        shouldShowToolbar() {
            return Boolean(this.field.downloadable || this.field.deletable) && this.hasValue
        },
    },

    methods: {
        download() {
            const { resourceName, resourceId } = this
            const attribute = this.field.attribute
            let link = document.createElement('a')
            link.href = `/nova-api/${resourceName}/${resourceId}/download/${attribute}`
            link.download = 'download'
            link.click()
        },
    }
}
</script>

<template>
    <panel-item :field="field">
        <div slot="value">
            <template v-if="shouldShowLoader">
                <image-loader
                    :src="previewUrl"
                    class="z-10 max-w-xs nova-file-upload-field"
                    @missing="(value) => missing = value"
                ></image-loader>
            </template>

            <template v-if="field.value && ! previewUrl">
                {{ field.value }}
            </template>

            <span v-if="!field.value && ! previewUrl">&mdash;</span>
            <span v-if="deleted">&mdash;</span>

            <p
                v-if="shouldShowToolbar"
                class="flex items-center text-sm mt-3"
            >
                <a
                    v-if="field.downloadable"
                    :dusk="field.attribute + '-download-link'"
                    @keydown.enter.prevent="download"
                    @click.prevent="download"
                    tabindex="0"
                    class="cursor-pointer dim btn btn-link text-primary inline-flex items-center"
                >
                    <icon class="mr-2" type="download" view-box="0 0 24 24" width="16" height="16" />
                    <span class="class mt-1">
                        {{ __('Download') }}
                    </span>
                </a>
            </p>
        </div>
    </panel-item>
</template>

<style lang="scss">
    //
</style>
