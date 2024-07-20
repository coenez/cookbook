<script setup>

import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {ref} from "vue";
import {fetchData} from "../../Composables/fetchData";

const ingredients = defineModel('ingredients')
const selectableIngredients = ref([])

if (!ingredients.value.length) {
  ingredients.value = [
    {
      id: null,
      name: '',
      unit: ''
    }
  ]
}

fetchData(getConfig('urls.ingredient.list')).then((result) => {
  selectableIngredients.value = result.data
})
</script>

<template>
  <h5 class="text-primary text-h6">Ingredienten</h5>
  <v-row no-gutters>
    <template v-for="(ingredient, index) in ingredients">
      <v-col cols="8" >
        <v-select
            v-model="ingredient.id"
            clearable
            label="Ingredient"
            item-title="name"
            item-value="id"
            :items="selectableIngredients"
            return-object>

          <template v-slot:prepend>
            <v-icon icon="mdi-plus" color="primary"/>
          </template>

        </v-select>
      </v-col>
      <v-col cols="4">
        <v-number-input
            v-model="ingredient.amount"
            :min="0"
            :label="'Aantal ('+ ingredient.unit+')'"
        >
          <template v-slot:append v-if="ingredients.length > 1">
            <v-icon icon="mdi-minus" color="secondary"/>
          </template>
        </v-number-input>
      </v-col>
    </template>

  </v-row>
</template>

<style scoped>

</style>