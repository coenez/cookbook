<script setup>

import MainLayout from "./Layouts/MainLayout.vue";
import {ref, provide} from "vue";
import ErrorDialog from "./Components/Core/ErrorDialog.vue";
import {HashParser} from "./Composables/hashParser";
import {useRouter} from "vue-router";
import axios from "axios";
import Login from "./Layouts/Login.vue";

const loading = ref(true)

//global search term that will be used in different contexts
const globalSearchTerm = ref('')
provide('globalSearchTerm', globalSearchTerm);

const applicationError = ref(null)
provide('applicationError', applicationError);

const globalFilter = ref(null)
provide('globalFilter', globalFilter);

//install hash redirection
const router = useRouter()
const hashParser = new HashParser(router)
hashParser.install()
provide('hashParser', hashParser);

//check for a validated user and determine the layout to be shown
const currentUser = ref(null)
provide('currentUser', currentUser)

axios.get(getConfig('urls.main.checkCurrentUser')).then(response => {
  currentUser.value = response.data
  loading.value = false;
}).catch(() => {
  currentUser.value = null
  loading.value = false;
})
</script>

<template>
  <ErrorDialog :error="applicationError" />
  <MainLayout v-if="!loading && currentUser"></MainLayout>

  <v-layout v-else-if="!loading" ref="login">
    <v-main class="justify-center px-5 mt-5">
      <Login/>
    </v-main>
  </v-layout>
</template>