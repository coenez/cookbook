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

const lastOffset = ref(0)
const pageSize = 5

const activeParams = ref(null)
const defaultParams = {
  limit: pageSize,
  offset: lastOffset.value,
  orderBy: 'created|DESC'
}

const loadData = () => {
  activeParams.value.offset = lastOffset.value

  fetchData(getConfig('urls.recipe.list'), {params: activeParams.value}, applicationError).then((result) => {
    loading.value = false
    data.value = result.data
  });
}

let infiniteScrollStateHandler;

const loadOnScroll = ({ done }) => {
  activeParams.value.offset = lastOffset.value

  fetchData(getConfig('urls.recipe.list'), {params: activeParams.value}, applicationError).then((result) => {
    loading.value = false
    if (result.data.length) {
      result.data.forEach((row) => {
        data.value.push(row)
      })
      lastOffset.value += pageSize
      done('ok')
    } else {
      done('empty')

      //store the infinite scroll state so we can manipulate it on a reset, its a fat hack but it is a bug in the component so what am i supposed to do?!
      infiniteScrollStateHandler = done;
    }
  });
}

if (!activeParams.value) {
  activeParams.value = defaultParams
}

//watch local searchterm change to trigger a reload
watch(localSearchTerm, debounce(async () => {
  loading.value = true
  data.value = [];
  lastOffset.value = 0
  activeParams.value.search = localSearchTerm.value

  //reset the infinite scroll state, its a fat hack but it is a bug in the component so what am i supposed to do?!
  infiniteScrollStateHandler('ok');
  loadData()

}, 500));

//watch filters to trigger a reload
watch(filters, () => {
  loading.value = true
  data.value = [];
  lastOffset.value = 0
  activeParams.value.filters = JSON.stringify(filters.value)

  //reset the infinite scroll state, its a fat hack but it is a bug in the component so what am i supposed to do?!
  infiniteScrollStateHandler('ok');
  loadData()
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
    <v-card-title class="text-secondary text-h5">Recepten</v-card-title>
    <v-card-text>
      <v-infinite-scroll :items="data" :onLoad="loadOnScroll">
        <RecipeSummary v-for="(recipe, index) in data" :key="recipe.id" :recipe="recipe" :class="index % 2 !== 0 ? 'bg-grey-lighten-4' : ''"></RecipeSummary>
        <div><br/><br/></div>
      </v-infinite-scroll>

    </v-card-text>
  </v-card>
</template>