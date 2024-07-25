<script setup>

import RemoteSelect from "../../Form/RemoteSelect.vue";
import {VNumberInput} from "vuetify/lib/labs/VNumberInput";
import {inject, onMounted, ref} from "vue";
import axios from "axios";
import {fetchData} from "../../../Composables/fetchData";
import IngredientEditor from "./IngredientEditor.vue";
import {useModel} from "../../../Composables/useModel"
import {rules} from "../../../Composables/rules"
import RecipeImages from "../RecipeImages.vue";

const props = defineProps({
  formText: String,
  recipeId: String,
})

const recipe = ref(useModel('recipe'))
const recipeIngredients = ref([])

//backup so we can reset to the original value that was loaded
const originalValues = {
  recipe: null,
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
      originalValues.recipe = JSON.parse(JSON.stringify(result.data))

      recipe.value = result.data
      recipeIngredients.value = result.data.recipeIngredients
    })
  } else {
    recipeIngredients.value.push(useModel('recipeIngredient'))
  }
})

const save = async () => {
  const {valid} = await form.value.validate()

  if (valid) {
    recipe.value.recipeIngredients = recipeIngredients.value;

    let formData = new FormData();

    for(let i=0; i < files.value.length; i++) {
      formData.append('files[' + i + ']', files.value[i])
    }

    formData.append('recipe', JSON.stringify(recipe.value))

    axios.post(getConfig('urls.recipe.save'),
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
    ).then(response => {
      recipe.value = response.data;
    }).catch(error => {
      applicationError.value = error.response.data
    })
  }
}

const cancel = () => {
  recipe.value = originalValues.recipe
  recipeIngredients.value = recipe.value.recipeIngredients
  form.value.resetValidation();
}

const files = ref([])
const handleFileUpload = (event) => {
  files.value = event.target.files;
}

const form = ref(null);
const editableImages = true;

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

    <IngredientEditor :ingredients="recipeIngredients" />

    <h5 class="text-primary mt-4 text-h6">Beschrijving van de bereiding</h5>
    <v-row>
      <v-col cols="12"><v-textarea v-model="recipe.preparation" rows="5" :rules="rules.required"></v-textarea></v-col>
    </v-row>

    <h5 class="text-primary mb-4 text-h6">Afbeeldingen</h5>
    <v-row>
      <v-file-input
          chips
          class="ml-2"
          v-model="recipe.images"
          label="Selecteer je afbeeldingen voor dit recept"
          prepend-icon="mdi-camera"
          counter
          multiple
          @change="handleFileUpload( $event )"
      ></v-file-input>
    </v-row>

    <RecipeImages :images="recipe.images" :editable="editableImages"/>

    <v-row justify="center" class="mt-10">
      <v-btn variant="flat" base-color="primary" class="mr-4" type="submit">Opslaan</v-btn>
      <v-btn variant="outlined" class="float-right" type="button" @click="cancel">Annuleren</v-btn>
    </v-row>
  </v-form>
</template>