<script setup>

import RecipeEditor from "../../Components/Recipe/Editor/RecipeEditor.vue";

const props = defineProps({
  id: String
})

</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">Bewerk recept</v-card-title>
    <v-card-text>
      <RecipeEditor :recipe-id="id" form-text="Vul het formulier in het recept aan te passen."/>
    </v-card-text>
  </v-card>
</template>