<script setup>

import RecipeSubTitle from "./RecipeSubTitle.vue";
import {ref} from "vue";
import PortionCalculator from "./PortionCalculator.vue";
import RecipeImages from "./RecipeImages.vue";

const props = defineProps({
  recipe: Object,
})

const showPortionSlider = ref(false)
const editableImages = false;
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">{{recipe.name}}</v-card-title>
    <RecipeSubTitle :recipe="recipe" @edit-portion="showPortionSlider = !showPortionSlider" />
    <PortionCalculator :show="showPortionSlider" :ingredients="recipe.recipeIngredients" :portions="recipe.portions" />
  </v-card>

  <v-card flat class="mb-4 pb-2 mt-n4 border-b-thin">
    <v-card-title class="text-primary">Ingredienten</v-card-title>
    <v-card-text>
      <div class="text-center">
        <v-progress-circular v-if="!recipe.recipeIngredients.length" class="mx-auto" size="100" width="10" color="primary" indeterminate/>
      </div>

      <v-row>
        <v-col cols="6" v-for="colCount in [1,2]">
          <v-list density="compact" v-if="recipe.recipeIngredients.length > 0">
            <template v-for="(recipeIngredient, index) in recipe.recipeIngredients">
              <v-list-item v-if="(colCount===1 ? index%2===0 : index%2!==0)">
                <template v-slot:prepend>
                  <v-list-item-action start>
                    <v-checkbox-btn></v-checkbox-btn>
                  </v-list-item-action>
                </template>
                {{recipeIngredient.ingredient.name}}: {{recipeIngredient.amount}} {{recipeIngredient.unit.name}}
              </v-list-item>
            </template>
          </v-list>
        </v-col>
      </v-row>

    </v-card-text>
  </v-card>
  <v-card flat>
    <v-card-title class="text-primary">Bereiding</v-card-title>
    <v-card-text>
      {{recipe.preparation}}
    </v-card-text>
  </v-card>

  <v-card flat>
    <v-card-title class="text-primary">Afbeeldingen</v-card-title>
    <v-card-text>
      <RecipeImages :images="recipe.images" :editable="editableImages"/>
    </v-card-text>
  </v-card>

</template>

