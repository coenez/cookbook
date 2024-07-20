<script setup>

import RecipeEditor from "../../Components/Recipe/RecipeEditor.vue";
</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4">Nieuw recept</v-card-title>
    <v-card-text>
      <RecipeEditor form-text="Vul het formulier in om een nieuw recept aan te maken"/>
    </v-card-text>
  </v-card>
</template>