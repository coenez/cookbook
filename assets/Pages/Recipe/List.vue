<script setup>

import RecipeSummary from "../../Components/Recipe/RecipeSummary.vue";
import {inject, ref, watch} from "vue";
import {useGlobalSearchTerm} from "../../Composables/useGlobalSearchTerm";
import {debounce} from "lodash/function";
import {fetchData} from "../../Composables/fetchData";

const localSearchTerm = useGlobalSearchTerm(inject('globalSearchTerm'));
const filters = inject('globalFilter');
const applicationError = inject('applicationError');
const data = ref([])
const loading = ref(true)

const loadData = (params) => {
  fetchData(getConfig('urls.recipe.list'), params, applicationError).then((result)=>{
    loading.value = false
    data.value = result.data
  });
}

loadData({
  params: {
    orderBy:  'created|DESC'
  }
})

//watch local searchterm change to trigger a reload
watch(localSearchTerm, debounce(async () => {
  loading.value = true
  data.value = [];
  let params = {
    params: {
      search: localSearchTerm.value
    }
  }
  loadData(params)
}, 500));

//watch filters to trigger a reload
watch(filters, () => {
  loading.value = true
  data.value = [];
  let params = {
    params: {
      filters: JSON.stringify(filters.value)
    }
  }

  loadData(params)
});

</script>

<template>
  <v-fab
      :to="{name:'recipeNew'}"
      icon="mdi-plus"
      color="primary"
      location="top"
      fixed
      app
  />
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