<script setup>

import RecipeSubTitle from "./RecipeSubTitle.vue";

const props = defineProps({
  recipe: Object
})
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">{{recipe.name}}</v-card-title>

    <v-card-text>
      <div>image here</div>
    </v-card-text>
    <RecipeSubTitle :recipe="recipe" />


  </v-card>
  <v-card flat class="mb-4 pb-2 mt-n4 border-b-thin">
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

