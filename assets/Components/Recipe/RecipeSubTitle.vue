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
</template>

<style scoped>

</style>