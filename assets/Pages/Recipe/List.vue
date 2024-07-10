<script setup>

import RecipeSummary from "../../Components/Recipe/RecipeSummary.vue";
import {inject, onMounted, ref, watch} from "vue";
import axios from "axios";
import {useGlobalSearchTerm} from "../../Composables/useGlobalSearchTerm";
import {debounce} from "lodash/function";

const pageSize = 5;
const data = ref([]);
const totalItems = ref(0);
const loading = ref(true);
const sortBy = defineModel('sortBy')
const localSearchTerm = useGlobalSearchTerm(inject('globalSearchTerm'));
const filters = ref({});

function loadItems() {
  axios.get(getConfig('urls.recipe.list'), {
    params: {
      // orderBy: sortBy.value[0]?.key + '|' + sortBy.value[0]?.order,
      limit: pageSize,
      search: localSearchTerm.value,
      filters: filters
    }
  }).then(response => {
    data.value = response.data.result;
    totalItems.value = response.data.totalCount
    loading.value = false;
  })
}

onMounted(loadItems)

//watch local searchterm change to trigger a reload
watch(localSearchTerm, debounce(() => {
  loadItems()
}, 1000));

</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary">Recepten</v-card-title>
    <v-card-text>
      <RecipeSummary v-for="recipe in data" :recipe="recipe"></RecipeSummary>
    </v-card-text>
  </v-card>
</template>