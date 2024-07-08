<script setup>
  import {ref} from "vue";
  import router from "../../router";

  const drawer = ref(false)
  console.log(router.getRoutes())
</script>

<template>
  <v-app-bar flat color="primary" name="app-bar">
    <v-app-bar-nav-icon  @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    <v-app-bar-title>CookBook</v-app-bar-title>
  </v-app-bar>
  <v-navigation-drawer v-model="drawer" location="left" temporary>
    <v-list nav>
      <v-list-item :to="{name:'home'}" prepend-icon="mdi-home" title="Home" value="home"></v-list-item>
      <v-list-item :to="{name:'categoryList'}" prepend-icon="mdi-note-text-outline" title="Categorieen" value="category"></v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>