<script setup>

import RemoteSelect from "../Form/RemoteSelect.vue";
import {inject, ref} from "vue";

const show = defineModel('show')

const labelsUrl = getConfig('urls.label.list')
const categoryUrl = getConfig('urls.category.list')
const ingredientUrl = getConfig('urls.ingredient.list')

const filters = inject('globalFilter')

const emit = defineEmits(['submitFilter'])

const selectedCategory = ref(null)
const selectedLabels = ref(null)
const selectedIngredients = ref(null)

function submitFilter() {
  //set filter values to the globalFilter
  filters.value = null;
  filters.value = {
    category: selectedCategory.value,
    labels: selectedLabels.value,
    ingredients: selectedIngredients.value,
  }

  emit('submitFilter')
}
</script>

<template>
  <v-navigation-drawer v-model="show" location="right" temporary>
    <v-list>
      <v-list-item title="Filters" class="text-secondary"></v-list-item>
    </v-list>
    <v-list nav>
      <RemoteSelect v-model="selectedCategory" :url="categoryUrl" label="Categorie" />
      <RemoteSelect v-model="selectedLabels" :url="labelsUrl" label="Labels" multiple chips />
      <RemoteSelect v-model="selectedIngredients" :url="ingredientUrl" label="Ingredienten" multiple chips />
      <v-btn variant="flat" base-color="primary" class="mr-4" @click="submitFilter">Zoek recepten</v-btn>
    </v-list>
  </v-navigation-drawer>
</template>
