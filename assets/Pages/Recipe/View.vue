<script setup>

import {ref, inject, onMounted} from "vue";
import {fetchData} from "../../Composables/fetchData";
import RecipeDetails from "../../Components/Recipe/RecipeDetails.vue";

const recipe = ref(null)
const ingredients = ref([])
const applicationError = inject('applicationError')

const props = defineProps({
  id: String
})

onMounted(() => {
  fetchData(getConfig('urls.recipe.get'), {params: {id: props.id}}, applicationError).then((result) => {
    recipe.value = result.data
  })
})
</script>

<template>
  <div class="text-center">
    <v-progress-circular v-if="!recipe" class="mx-auto" size="100" width="10" color="primary" indeterminate/>
  </div>
  <RecipeDetails v-if="recipe" :recipe="recipe" />
</template>