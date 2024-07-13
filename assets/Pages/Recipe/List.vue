<script setup>

import RecipeSummary from "../../Components/Recipe/RecipeSummary.vue";
import {inject, ref, watch} from "vue";
import {useGlobalSearchTerm} from "../../Composables/useGlobalSearchTerm";
import {debounce} from "lodash/function";
import {fetchData} from "../../Composables/fetchData";

const localSearchTerm = useGlobalSearchTerm(inject('globalSearchTerm'));
const filters = ref({});

const applicationError = inject('applicationError');

const data = ref([])
const {loading} = fetchData(getConfig('urls.recipe.list'), {}, data, applicationError)

//watch local searchterm change to trigger a reload
watch(localSearchTerm, debounce(() => {
  loadItems()
}, 1000));

</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">Recepten</v-card-title>
    <v-card-text>
      <div class="text-center">
        <v-progress-circular class="mx-auto" v-if="loading" size="100" width="10" color="primary" indeterminate/>
      </div>

      <RecipeSummary v-for="recipe in data" :recipe="recipe"></RecipeSummary>
    </v-card-text>
  </v-card>
</template>