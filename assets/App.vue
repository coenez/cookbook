<script setup>

import MainLayout from "./Layouts/MainLayout.vue";
import Test from "./Components/Test.vue";
import {ref, provide} from "vue";

//global search term that will be used in different contexts
const globalSearchTerm = ref('')
provide('globalSearchTerm', globalSearchTerm);
</script>

<template>
  <!--<Test></Test>-->
  <MainLayout></MainLayout>
</template>