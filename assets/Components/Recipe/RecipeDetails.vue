<script setup>

import {calculateDuration} from "../../Composables/calculateDuration";
import RecipeSubTitle from "./RecipeSubTitle.vue";

const props = defineProps({
  recipe: Object
})

const duration = calculateDuration(props.recipe.duration);
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">{{recipe.name}}</v-card-title>
    <RecipeSubTitle :recipe="recipe" />
    <v-card-text>
      <div>image here</div>
      Labels hier
    </v-card-text>
  </v-card>
  <v-card class="mb-4 " border="thin" variant="outlined">
    <v-card-title class="text-primary">Ingredienten</v-card-title>
    <v-card-text>
      ingredienten hier
    </v-card-text>
  </v-card>
  <v-card class="" border="thin" variant="outlined">
    <v-card-title class="text-primary">Bereiding</v-card-title>
    <v-card-text>
      {{recipe.preparation}}
    </v-card-text>
  </v-card>
</template>

