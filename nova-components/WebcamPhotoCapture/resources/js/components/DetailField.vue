<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <div>
                <img v-if="field.value" :src="field.value" />
                <span v-else>(No Photo Available)</span>
            </div>
        </template>
    </PanelItem>
</template>

<script>
export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
