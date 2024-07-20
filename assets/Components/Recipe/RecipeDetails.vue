<script setup>

import RecipeSubTitle from "./RecipeSubTitle.vue";
import {ref} from "vue";
import PortionCalculator from "./PortionCalculator.vue";

const props = defineProps({
  recipe: Object,
  ingredients: Array
})

const showPortionSlider = ref(false)
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">{{recipe.name}}</v-card-title>
    <v-card-text>
      <div>image here</div>
    </v-card-text>
    <RecipeSubTitle :recipe="recipe" @edit-portion="showPortionSlider = !showPortionSlider" />
    <PortionCalculator :show="showPortionSlider" :ingredients="ingredients" :portions="recipe.portions" />
  </v-card>

  <v-card flat class="mb-4 pb-2 mt-n4 border-b-thin">
    <v-card-title class="text-primary">Ingredienten</v-card-title>
    <v-card-text>
      <div class="text-center">
        <v-progress-circular v-if="!ingredients.length" class="mx-auto" size="100" width="10" color="primary" indeterminate/>
      </div>

      <v-row>
        <v-col cols="6" v-for="colCount in [1,2]">
          <v-list density="compact" v-if="ingredients.length > 0">
            <template v-for="(ingredient, index) in ingredients">
              <v-list-item v-if="(colCount===1 ? index%2===0 : index%2!==0)">
                <template v-slot:prepend>
                  <v-list-item-action start>
                    <v-checkbox-btn></v-checkbox-btn>
                  </v-list-item-action>
                </template>
                {{ingredient.name}}: {{ingredient.amount}} {{ingredient.unit}}
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
</template>

