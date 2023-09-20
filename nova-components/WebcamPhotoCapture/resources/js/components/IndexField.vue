<template>
    <img
        :src="fieldValue"
        class="object-cover object-center rounded-lg block w-8 h-8 border-2 border-solid border-white dark:border-gray-800"
    />
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value
    },
  }
}
</script>
