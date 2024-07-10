<script setup>

import {ref, watch} from "vue";

const showError = ref(false)
const showTrace = ref(false)
const error = defineModel('error')

watch(error, ()=> {
  showError.value = true;
})
</script>

<template>
  <v-dialog v-model="showError">
    <v-card
        class="mx-auto"
        width="600"
        :title="error.title +' ('+ error.status + ')'"
    >
      <template v-slot:prepend>
        <v-icon color="error" size="x-large" icon="mdi-close-circle"></v-icon>
      </template>

      <v-card-text>{{error.detail}}</v-card-text>
      <v-card-actions>
        <v-btn variant="flat" color="primary" text="Ok" @click="showError = !showError"/>
        <v-btn :icon="showTrace ? 'mdi-chevron-up' : 'mdi-chevron-down'" @click="showTrace = !showTrace"></v-btn>
      </v-card-actions>

      <v-expand-transition>
        <div v-show="showTrace">
          <v-divider></v-divider>
          <v-card-title class="text-secondary">Trace</v-card-title>
          <v-card-text>
            <div v-for="row in error.trace">{{row.file}} ({{row.line}})</div>
          </v-card-text>
        </div>
      </v-expand-transition>
    </v-card>
  </v-dialog>
</template>

