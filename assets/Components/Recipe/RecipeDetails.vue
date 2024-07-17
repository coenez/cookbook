<script setup>

import RecipeSubTitle from "./RecipeSubTitle.vue";
import {inject, onMounted, ref} from "vue";
import {fetchData} from "../../Composables/fetchData";

const props = defineProps({
  recipe: Object
})

const ingredients = ref([])
const applicationError = inject('applicationError')

onMounted(() => {
  fetchData(getConfig('urls.ingredient.recipe'), {params: {recipeId: props.recipe.id}}, ingredients, applicationError)
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
      <div class="text-center">
        <v-progress-circular v-if="!ingredients.length" class="mx-auto" size="100" width="10" color="primary" indeterminate/>
      </div>

      <v-list density="compact" v-if="ingredients.length > 0">
        <v-list-item v-for="(ingredient) in ingredients">
          <template v-slot:prepend>
            <v-list-item-action start>
              <v-checkbox-btn></v-checkbox-btn>
            </v-list-item-action>
          </template>
            {{ingredient.name}}: {{ingredient.amount}} {{ingredient.unit}}
        </v-list-item>
      </v-list>
    </v-card-text>
  </v-card>
  <v-card flat>
    <v-card-title class="text-primary">Bereiding</v-card-title>
    <v-card-text>
      {{recipe.preparation}}
    </v-card-text>
  </v-card>
</template>

