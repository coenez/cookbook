<script setup>

import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {ref} from "vue";
import {fetchData} from "../../Composables/fetchData";
import {useModel} from "../../Composables/useModel";
import DynaForm from "../Core/DynaForm.vue";

const ingredients = defineModel('ingredients')
const availableIngredients = ref([])
const availableUnits = ref([])
const ingredientSaveUrl = getConfig('urls.ingredient.save')

const newIngredient = ref(useModel('ingredient'))

fetchData(getConfig('urls.ingredient.list')).then((result) => {
  availableIngredients.value = result.data
})
fetchData(getConfig('urls.unit.list')).then((result) => {
  availableUnits.value = result.data
})

const addIngredientRow = (index) => {
  ingredients.value.splice(index+1, 0, useModel('recipeIngredient'));
}

const removeIngredientRow = (index) => {
  ingredients.value.splice(index, 1);
}

const showIngredientForm = ref(false)
const ingredientformFields = [
  [
    {
      type: 'v-text-field',
      name: 'name',
      label: 'Naam'
    },
  ],
]

const addIngredientToAvailable = (newData) => {
  showIngredientForm.value = false
  availableIngredients.value.push(newData)
  newIngredient.value = useModel('ingredient')
}

</script>

<template>
  <h5 class="text-primary text-h6">Ingredienten</h5>
  <v-row no-gutters>
    <template v-for="(ingredient, index) in ingredients">
      <v-col cols="6">
        <v-autocomplete
            v-model="ingredient.id"
            clearable
            label="Ingredient"
            item-title="name"
            item-value="id"
            :items="availableIngredients"
            >

          <template v-slot:prepend>
            <v-icon icon="mdi-plus" color="primary" @click="addIngredientRow(index)" />
          </template>

          <template v-slot:no-data>
            <v-list-item v-if="!showIngredientForm" prepend-icon="mdi-plus" class="text-primary cursor-pointer" @click="showIngredientForm = !showIngredientForm">Maak nieuw ingredient</v-list-item>
          </template>
        </v-autocomplete>
      </v-col>
      <v-col cols="3">
        <v-number-input
            v-model="ingredient.amount"
            :min="0"
            label="Aantal"
        />
      </v-col>
      <v-col cols="3">
        <v-autocomplete
            v-model="ingredient.unit.id"
            clearable
            label="Eenheid"
            item-title="name"
            item-value="id"
            :items="availableUnits"
            >
          <template v-slot:append v-if="ingredients.length > 1">
            <v-icon icon="mdi-minus" color="secondary" @click="removeIngredientRow(index)"/>
          </template>
        </v-autocomplete>
      </v-col>
    </template>

  </v-row>

  <v-dialog v-model="showIngredientForm">
    <DynaForm
        :active-record="newIngredient"
        :end-point="ingredientSaveUrl"
        :form-fields="ingredientformFields"
        name="Ingredient"
        new-label="Nieuw"
        @df-save="addIngredientToAvailable"
        @df-cancel="showIngredientForm = !showIngredientForm"
    />
  </v-dialog>

</template>

<style scoped>

</style>