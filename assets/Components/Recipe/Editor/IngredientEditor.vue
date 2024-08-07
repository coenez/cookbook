<script setup>

import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {ref} from "vue";
import {fetchData} from "../../../Composables/fetchData";
import {useModel} from "../../../Composables/useModel";
import {rules} from "../../../Composables/rules";
import DynaForm from "../../Core/DynaForm.vue";

const recipeIngredients = defineModel('ingredients')
const availableIngredients = ref([])
const availableUnits = ref([])

fetchData(getConfig('urls.ingredient.list')).then((result) => {
  availableIngredients.value = result.data
})
fetchData(getConfig('urls.unit.list')).then((result) => {
  availableUnits.value = result.data
})

const addRecipeIngredientRow = (index) => {
  recipeIngredients.value.splice(index+1, 0, useModel('recipeIngredient'));
}

const removeRecipeIngredientRow = (index) => {
  recipeIngredients.value.splice(index, 1);
}

//new ingredient dialog
const showIngredientForm = ref(false)
const ingredientSaveUrl = getConfig('urls.ingredient.save')
const newIngredient = ref(useModel('ingredient'))
const ingredientformFields = [
  [
    {
      type: 'v-text-field',
      name: 'name',
      label: 'Naam',
      rules: rules.required
    },
  ],
]

const addIngredientToAvailable = (newData) => {
  showIngredientForm.value = false
  availableIngredients.value.push(newData)
  newIngredient.value = useModel('ingredient')

  let lastIndex = recipeIngredients.value.length -1;

  recipeIngredients.value[lastIndex].ingredient.id = newData.id;
  recipeIngredients.value[lastIndex].ingredient.name = newData.name;
}

const passSearchedIngredient = (event) => {
  newIngredient.value.name = event.target.value;
}

//new unit dialog
const showUnitForm = ref(false)
const unitSaveUrl = getConfig('urls.unit.save')
const newUnit = ref(useModel('unit'))
const unitFormFields = [
  [
    {
      type: 'v-text-field',
      name: 'name',
      label: 'Naam',
      rules: rules.required
    },
    {
      type: 'v-text-field',
      name: 'value',
      label: 'Waarde',
      rules: rules.required
    },
  ],
]

const addUnitToAvailable = (newData) => {
  showUnitForm.value = false
  availableUnits.value.push(newData)
  newUnit.value = useModel('unit')

  //auto select the new unit
  let lastIndex = recipeIngredients.value.length -1;

  recipeIngredients.value[lastIndex].unit.id = newData.id;
  recipeIngredients.value[lastIndex].unit.name = newData.name;
}

const passSearchedUnit = (event) => {
  newUnit.value.name = event.target.value;
}
</script>

<template>
  <h5 class="text-primary text-h6">Ingredienten</h5>
  <v-row no-gutters>
    <template v-for="(recipeIngredient, index) in recipeIngredients">
      <v-col cols="6">
        <v-autocomplete
            v-model="recipeIngredient.ingredient.id"
            clearable
            label="Ingredient"
            item-title="name"
            item-value="id"
            :items="availableIngredients"
            :rules="rules.required"
            @input.native="passSearchedIngredient"
            >

          <template v-slot:prepend>
            <v-icon icon="mdi-plus" color="primary" @click="addRecipeIngredientRow(index)" />
          </template>

          <template v-slot:no-data>
            <v-list-item v-if="!showIngredientForm" prepend-icon="mdi-plus" class="text-primary cursor-pointer" @click="showIngredientForm = !showIngredientForm">Maak nieuw ingredient</v-list-item>
          </template>
        </v-autocomplete>
      </v-col>
      <v-col cols="3">
        <v-number-input
            v-model="recipeIngredient.amount"
            :min="0"
            :step="0.25"
            label="Aantal"
            :rules="rules.aboveZero"
        />
      </v-col>
      <v-col cols="3">
        <v-autocomplete
            v-model="recipeIngredient.unit.id"
            clearable
            label="Eenheid"
            item-title="name"
            item-value="id"
            :items="availableUnits"
            :rules="rules.required"
            @input.native="passSearchedUnit"
            >
          <template v-slot:append v-if="recipeIngredients.length > 1">
            <v-icon icon="mdi-minus" color="secondary" @click="removeRecipeIngredientRow(index)"/>
          </template>
          <template v-slot:no-data>
            <v-list-item v-if="!showUnitForm" prepend-icon="mdi-plus" class="text-primary cursor-pointer" @click="showUnitForm = !showUnitForm">Maak nieuwe eenheid</v-list-item>
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

  <v-dialog v-model="showUnitForm">
    <DynaForm
        :active-record="newUnit"
        :end-point="unitSaveUrl"
        :form-fields="unitFormFields"
        name="Eenheid"
        new-label="Nieuwe"
        @df-save="addUnitToAvailable"
        @df-cancel="showUnitForm = !showUnitForm"
    />
  </v-dialog>

</template>