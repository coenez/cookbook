<script setup>

import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {ref} from "vue";
import {fetchData} from "../../Composables/fetchData";

const ingredients = defineModel('ingredients')
const availableIngredients = ref([])
const availableUnits = ref([])

fetchData(getConfig('urls.ingredient.list')).then((result) => {
  availableIngredients.value = result.data
})
fetchData(getConfig('urls.unit.list')).then((result) => {
  availableUnits.value = result.data
})

//todo: make ingredient selector option to add a new non existing ingredient, make logic for removal and adding

</script>

<template>
  <h5 class="text-primary text-h6">Ingredienten</h5>
  <v-row no-gutters>
    <template v-for="(ingredient) in ingredients">
      <v-col cols="6">
        <v-select
            v-model="ingredient.id"
            clearable
            label="Ingredient"
            item-title="name"
            item-value="id"
            :items="availableIngredients"
            return-object>

          <template v-slot:prepend>
            <v-icon icon="mdi-plus" color="primary"/>
          </template>
        </v-select>
      </v-col>
      <v-col cols="3">
        <v-number-input
            v-model="ingredient.amount"
            :min="0"
            label="Aantal"
        />
      </v-col>
      <v-col cols="3">
        <v-select
            v-model="ingredient.unit.id"
            clearable
            label="Eenheid"
            item-title="name"
            item-value="id"
            :items="availableUnits"
            return-object>
          <template v-slot:append v-if="ingredients.length > 1">
            <v-icon icon="mdi-minus" color="secondary"/>
          </template>
        </v-select>
      </v-col>
    </template>

  </v-row>
</template>

<style scoped>

</style>