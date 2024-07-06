<script setup>



</script>

<template>
  <v-layout ref="app">
    <v-app-bar flat color="primary" name="app-bar">

      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-app-bar-title>CookBook</v-app-bar-title>

      <router-link :to="{name:'home'}" >
        <v-btn prepend-icon="mdi-home" color="buttonText">Home</v-btn>
      </router-link>
      <router-link :to="{name:'categoryList'}" activeClass="border-indigo-500">
        <v-btn prepend-icon="mdi-note-text-outline" color="buttonText">Category</v-btn>
      </router-link>

      <v-spacer></v-spacer>
      <v-spacer></v-spacer>
    </v-app-bar>

    <v-main class="justify-center px-5 mt-5" style="min-height: 300px;">
      <RouterView />
    </v-main>

    <v-footer name="footer" app>
      <v-btn class="mx-auto" variant="text" > footer</v-btn>
    </v-footer>
  </v-layout>


</template>