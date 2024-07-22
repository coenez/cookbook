<script setup>

import RemoteSelect from "../../Form/RemoteSelect.vue";
import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {inject, onMounted, ref} from "vue";
import axios from "axios";
import {fetchData} from "../../../Composables/fetchData";
import IngredientEditor from "./IngredientEditor.vue";
import {useModel} from "../../../Composables/useModel"
import {rules} from "../../../Composables/rules"

const props = defineProps({
  formText: String,
  recipeId: String,
})

const recipe = ref(useModel('recipe'))
const ingredients = ref([])

//backup so we can reset to the original value that was loaded
const originalValues = {
  recipe: null,
  ingredients: null
}

const labelsUrl = getConfig('urls.label.list')
const categoryUrl = getConfig('urls.category.list')
const applicationError = inject('applicationError');

// fetch existing record if provided an id
onMounted(() => {
  if (props.recipeId) {
    fetchData(getConfig('urls.recipe.get'), {
      params: {
        id: props.recipeId
      }
    }).then((result) => {
      recipe.value = result.data.recipe
      ingredients.value = result.data.ingredients

      //save the original values so we can reset back to them
      originalValues.recipe = Object.assign({}, result.data.recipe)
      originalValues.ingredients = Object.assign({}, result.data.ingredients)
    })
  } else {
    ingredients.value = [
      useModel('recipeIngredient')
    ]
  }
})

const save = async () => {
  const {valid} = await form.value.validate()

  if (valid) {
    axios.put(getConfig('urls.recipe.save'), {
      recipe: recipe.value,
      ingredients: ingredients.value
    }).then(response => {
      recipe.value = response.data.recipe;
      ingredients.value = response.data.ingredients;
    }).catch(error => {
      applicationError.value = error.response.data
    })
  }
}

const cancel = () => {
  recipe.value = originalValues.recipe
  ingredients.value = originalValues.ingredients
  form.value.resetValidation();
}

const form = ref(null);

</script>

<template>
  {{formText}}
  <br/><br/>
  <v-form ref="form" validate-on="input" @submit.prevent="save">
    <h5 class="text-primary text-h6">Algemeen</h5>
    <v-text-field v-model="recipe.name" label="Naam" :rules="rules.required" />
    <RemoteSelect v-model="recipe.category" :url="categoryUrl" label="Categorie" :rules="rules.required" />
    <v-row>
      <v-col cols="6"><v-number-input v-model="recipe.duration" label="Bereidingstijd (minuten)" :min="1" :rules="rules.aboveZero" /></v-col>
      <v-col cols="6"><v-number-input v-model="recipe.portions" label="Porties" :min="1" :rules="rules.aboveZero" /></v-col>
    </v-row>
    <RemoteSelect v-model="recipe.labels" :url="labelsUrl" label="Labels" multiple chips />

    <IngredientEditor :ingredients="ingredients" />

    <h5 class="text-primary text-h6">Afbeeldingen</h5>
    <v-row>
      <v-col cols="4">afbeeldingen</v-col>
      <v-col cols="4">afbeeldingen</v-col>
      <v-col cols="4">afbeeldingen</v-col>
    </v-row>
    <br/><br/><br/>

    <h5 class="text-primary text-h6">Beschrijving van de bereiding</h5>
    <v-row>
      <v-col cols="12"><v-textarea v-model="recipe.preparation" rows="5" :rules="rules.required"></v-textarea></v-col>
    </v-row>

    <v-row justify="center">
      <v-btn variant="flat" base-color="primary" class="mr-4" type="submit">Opslaan</v-btn>
      <v-btn variant="outlined" class="float-right" type="button" @click="cancel">Annuleren</v-btn>
    </v-row>
  </v-form>
</template>

<style scoped>

</style>