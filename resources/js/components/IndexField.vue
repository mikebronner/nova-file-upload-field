<script>
export default {
    props: ['resourceName', 'field'],
}
</script>

<template>
    <p>
        <img
            v-if="field.thumbnailUrl"
            :src="field.thumbnailUrl"
            style="object-fit: cover;" class="rounded w-8 h-8"
        >
        <span v-else>&mdash;</span>
    </p>
</template>
