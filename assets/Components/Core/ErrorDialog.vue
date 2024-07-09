<script setup>

//handles AxiosError
import {ref, watch} from "vue";

const showError = ref(false)
const error = defineModel('error')

watch(error, ()=> {
  showError.value=true;
})
</script>

<template>
  <v-dialog v-model="showError">
    <v-card
        class="mx-auto"
        width="500"
        title="Error occurred"
        :subtitle="error.code +' ('+ error.status + ')' "
    >
      <template v-slot:prepend>
        <v-icon color="error" size="x-large" icon="mdi-close-circle"></v-icon>
      </template>

      <v-card-text>{{error.message}}</v-card-text>
      <v-card-actions>
        <v-btn variant="flat" color="primary" text="Ok" @click="showError = !showError"/>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

