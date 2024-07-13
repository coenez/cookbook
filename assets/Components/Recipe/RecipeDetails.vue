<script setup>

const props = defineProps({
  recipe: Object
})

console.log(props.recipe)
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary">{{recipe.name}}</v-card-title>
    <v-card-subtitle>Categorie: {{recipe.category.name}}</v-card-subtitle>
    <v-card-text>
      {{recipe.preparation}}
    </v-card-text>
  </v-card>
</template>

