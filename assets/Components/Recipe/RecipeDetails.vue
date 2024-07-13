<script setup>

import {calculateDuration} from "../../Composables/calculateDuration";
import RecipeSubTitle from "./RecipeSubTitle.vue";

const props = defineProps({
  recipe: Object
})

const duration = calculateDuration(props.recipe.duration);

function redirect(label) {
  console.log('redirect to', label)
}
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">{{recipe.name}}</v-card-title>

    <v-card-text>
      <div>image here</div>
    </v-card-text>
    <RecipeSubTitle :recipe="recipe" />
    <v-card-text>
      <v-chip
          v-for="label in recipe.labels"
          class="mr-2 mt-2"
          density="comfortable"
          size="small"
          variant="tonal"
          color="primary"
          @click="redirect(label)"
      >
        {{label.name}}
      </v-chip>
    </v-card-text>

  </v-card>
  <v-card flat class="mb-4 border-b-thin">
    <v-card-title class="text-primary">Ingredienten</v-card-title>
    <v-card-text>
      ingredienten hier
    </v-card-text>
  </v-card>
  <v-card flat>
    <v-card-title class="text-primary">Bereiding</v-card-title>
    <v-card-text>
      {{recipe.preparation}}
    </v-card-text>
  </v-card>
</template>

