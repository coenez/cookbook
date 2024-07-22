<script setup>
  import Menu from "../Components/Core/Menu.vue";

</script>

<template>
  <v-layout ref="app">
    <Menu/>
    <v-main class="justify-center px-5 mt-5" style="min-height: 300px;">
      <RouterView :key="$route.fullPath" />
    </v-main>

    <v-footer name="footer" app>
      <v-btn class="mx-auto" variant="text" > footer</v-btn>
    </v-footer>
  </v-layout>


</template>