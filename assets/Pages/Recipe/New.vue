<script setup>

import RemoteSelect from "../../Components/Form/RemoteSelect.vue";
import { VNumberInput } from 'vuetify/labs/VNumberInput'
import {ref, watch} from "vue";
import axios from "axios";

const record = ref({
  id: 0,
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

const save = () => {
  console.log('save btn clicked', record.value)

  axios.put(getConfig('urls.recipe.save'), {
    recipe: record.value,
    ingredients: ingredients.value
  }).then(response => {
    record.value = response.data.recipe;
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
  <v-card flat>
    <v-card-title class="text-secondary text-h4">Nieuw recept</v-card-title>
    <v-card-text>
      Vul het formulier in om een nieuw recept aan te maken.
      <br/><br/>
      <v-form @submit.prevent>
        <v-text-field v-model="record.name" label="Naam" />
        <RemoteSelect v-model="record.category" :url="categoryUrl" label="Categorie" />
        <v-row>
          <v-col cols="6"><v-number-input v-model="record.duration" label="Bereidingstijd (minuten)" control-variant="split" :min="1" /></v-col>
          <v-col cols="6"><v-number-input v-model="record.portions" label="Porties" control-variant="split" :min="1" /></v-col>
        </v-row>
        <RemoteSelect v-model="record.labels" :url="labelsUrl" label="Labels" multiple chips />
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
          <v-col cols="12"><v-textarea v-model="record.preparation" rows="5"></v-textarea></v-col>
        </v-row>

        <v-row justify="center">
          <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="save">Opslaan</v-btn>
          <v-btn variant="outlined" class="float-right" type="cancel" @click="cancel">Annuleren</v-btn>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>