<script setup>
import RecipeSubTitle from "./RecipeSubTitle.vue";
import {useRouter} from "vue-router";

const props = defineProps({
  recipe: Object,
})

const router = useRouter()
const textSummary = props.recipe.preparation.slice(0, 200) + '...'

const gotoRecipe = (id) => {
  router.push({name:'recipeView', params: {id:id}});
}
</script>

<template>
  <v-card class="mb-8 cardOutline" border="thin" color="text" variant="outlined">
    <v-card-title class="text-primary cursor-pointer" @click="gotoRecipe(recipe.id)"> {{recipe.name}} </v-card-title>
    <RecipeSubTitle :recipe="recipe"/>
    <v-card-text class="mt-n4">
      {{textSummary}}
    </v-card-text>
    <v-card-actions>
      <v-btn
          :to="{name:'recipeView', params: {id:recipe.id}}"
          color="primary"
          text="Bekijk recept"
          variant="text"
      ></v-btn>
      <v-btn
          :to="{name:'recipeEdit', params: {id:recipe.id}}"
          color="secundary"
          text="Bewerk recept"
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