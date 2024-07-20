<script setup>

import RemoteSelect from "../Form/RemoteSelect.vue";
import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {onMounted, ref} from "vue";
import axios from "axios";
import {fetchData} from "../../Composables/fetchData";

const props = defineProps({
  formText: String,
  recipeId: String,
})

const recipe = ref({
  id: props.recipeId,
  name: '',
  category: null,
  duration: 30,
  portions: 2,
  labels: [],
  preparation: '',
})

const ingredients = ref([])

const labelsUrl = getConfig('urls.label.list')
const categoryUrl = getConfig('urls.category.list')
const ingredientUrl = getConfig('urls.ingredient.list')

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
    })
  }
})


const save = () => {
  console.log('save btn clicked', recipe.value, ingredients.value)

  axios.put(getConfig('urls.recipe.save'), {
    recipe: recipe.value,
    ingredients: ingredients.value
  }).then(response => {
    recipe.value = response.data.recipe;
    ingredients.value = response.data.ingredients;


  }).catch(error => {
    console.error(error)
  })
}

const cancel = () => {
  console.log('cancel btn clicked')
}
</script>

<template>
  {{formText}}
  <br/><br/>
  <v-form @submit.prevent>
    <v-text-field v-model="recipe.name" label="Naam" />
    <RemoteSelect v-model="recipe.category" :url="categoryUrl" label="Categorie" />
    <v-row>
      <v-col cols="6"><v-number-input v-model="recipe.duration" label="Bereidingstijd (minuten)" control-variant="split" :min="1" /></v-col>
      <v-col cols="6"><v-number-input v-model="recipe.portions" label="Porties" control-variant="split" :min="1" /></v-col>
    </v-row>
    <RemoteSelect v-model="recipe.labels" :url="labelsUrl" label="Labels" multiple chips />
    <v-row>
      <v-col cols="12"><RemoteSelect v-model="ingredients" :url="ingredientUrl" label="Ingredienten" multiple chips /></v-col>
    </v-row>
    <v-row>
      <v-col cols="12">
        Build ingredient input here based on selected ingredients
        <br/><br/><br/>
      </v-col>
    </v-row>

    <h5 class="text-primary text-h6">Afbeeldingen</h5>
    <v-row>
      <v-col cols="4">afbeeldingen</v-col>
      <v-col cols="4">afbeeldingen</v-col>
      <v-col cols="4">afbeeldingen</v-col>
    </v-row>
    <br/><br/><br/>

    <h5 class="text-primary text-h6">Beschrijving van de bereiding</h5>
    <v-row>
      <v-col cols="12"><v-textarea v-model="recipe.preparation" rows="5"></v-textarea></v-col>
    </v-row>

    <v-row justify="center">
      <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="save">Opslaan</v-btn>
      <v-btn variant="outlined" class="float-right" type="cancel" @click="cancel">Annuleren</v-btn>
    </v-row>
  </v-form>
</template>

<style scoped>

</style>