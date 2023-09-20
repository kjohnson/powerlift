<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <div>
                <img :src="field.value" />
            </div>
        </template>
    </PanelItem>
</template>

<script>
export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
