<script setup>
import {calculateDuration} from "../../Composables/calculateDuration";

const props = defineProps({
  recipe: Object,
  editable: {
    type: Boolean,
    default: false
  }
})

const duration = calculateDuration(props.recipe.duration);

function redirect(label) {
  console.log('redirect to', label)
}
</script>

<template>
  <v-card-subtitle>
    {{recipe.category.name}}
    <v-icon icon="mdi-clock" class="ml-2"/> {{duration}}
    <v-icon icon="mdi-account-group" class="ml-2"/> {{recipe.portions}}
    <v-tooltip text="show user name here">
      <template v-slot:activator="{ props }">
        <v-icon icon="mdi-account" v-bind="props" class="ml-2 cursor-pointer"/>
      </template>
    </v-tooltip>
  </v-card-subtitle>
  <v-card-text>
    <v-chip
        v-for="label in recipe.labels"
        class="mr-2 mb-2"
        density="comfortable"
        size="small"
        variant="tonal"
        color="primary"
        @click="redirect(label)"
    >
      {{label.name}}
    </v-chip>
  </v-card-text>
</template>

<style scoped>

</style>