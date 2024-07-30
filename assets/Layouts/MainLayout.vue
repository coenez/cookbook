<script setup>
  import Menu from "../Components/Core/Menu.vue";
  import {ref, watch, provide} from "vue";

  const flash = ref({
    show: false,
    type: 'success',
    title: '',
    text: '',
  });

  provide('flash', flash)

  watch(flash, () => {
    flash.value.show = true
    window.setInterval(() => {
      flash.value.show = false;
    }, 3000)
  })

</script>

<template>
  <v-layout ref="app">
    <Menu/>
    <v-main class="justify-center px-5 mt-5" style="min-height: 300px;">
      <v-alert
          v-model="flash.show"
          :text="flash.text"
          :title="flash.title"
          :type="flash.type"
          variant="outlined"
      ></v-alert>
      <RouterView :key="$route.fullPath" />
    </v-main>

    <v-footer name="footer" app>
      <v-btn class="mx-auto" variant="text" > footer</v-btn>
    </v-footer>
  </v-layout>


</template>