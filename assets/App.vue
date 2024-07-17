<script setup>

import MainLayout from "./Layouts/MainLayout.vue";
import {ref, provide} from "vue";
import ErrorDialog from "./Components/Core/ErrorDialog.vue";

//global search term that will be used in different contexts
const globalSearchTerm = ref('')
provide('globalSearchTerm', globalSearchTerm);

const applicationError = ref(null)
provide('applicationError', applicationError);

const globalFilter = ref(null)
provide('globalFilter', globalFilter);
</script>

<template>
  <ErrorDialog :error="applicationError" />
  <MainLayout></MainLayout>
</template>