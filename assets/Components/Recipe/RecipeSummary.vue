<script setup>
import {calculateDuration} from "../../Composables/calculateDuration";

const props = defineProps({
  recipe: Object,
})

const textSummary = props.recipe.preparation.slice(0, 200) + '...'
const duration = calculateDuration(props.recipe.duration);
</script>

<template>
  <v-card class="mb-8 cardOutline" border="thin" color="text" variant="outlined">
    <v-card-title class="text-primary">{{recipe.name}} </v-card-title>

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
      {{textSummary}}
    </v-card-text>

    <v-card-actions>
      <v-btn
          :to="{name:'recipeView', params: {id:recipe.id}}"
          color="primary"
          text="Bekijk recept"
          variant="text"
      ></v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped>
  .cardOutline {
    border-bottom: solid 3px !important;
    border-bottom-color:#FFAB91 !important;
  }
</style>