<script setup>
import RecipeSubTitle from "./RecipeSubTitle.vue";

const props = defineProps({
  recipe: Object,
})

const textSummary = props.recipe.preparation.slice(0, 200) + '...'
</script>

<template>
  <v-card class="mb-8 cardOutline" border="thin" color="text" variant="outlined">
    <v-card-title class="text-primary ">{{recipe.name}} </v-card-title>
    <RecipeSubTitle :recipe="recipe"/>
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