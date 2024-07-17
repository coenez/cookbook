<script setup>

import RemoteSelect from "../Form/RemoteSelect.vue";
import {inject, ref} from "vue";

const labelsUrl = getConfig('urls.label.list')
const categoryUrl = getConfig('urls.category.list')
const ingredientUrl = getConfig('urls.ingredient.list')

const filter = inject('globalFilter')

function submitFilter() {

  filter.value = null;
  filter.value = {some:'filter'}
  //set filter values to the globalFilter
}
</script>

<template>
    <v-list>
      <v-list-item title="Filters" class="text-secondary"></v-list-item>
    </v-list>
    <v-list nav>
      <RemoteSelect :url="categoryUrl" label="Categorie" />
      <RemoteSelect :url="labelsUrl" label="Labels" multiple chips />
      <RemoteSelect :url="ingredientUrl" label="Ingredienten" multiple chips />
      <v-btn variant="flat" base-color="primary" class="mr-4" @click="submitFilter">Zoek recepten</v-btn>
    </v-list>
</template>
