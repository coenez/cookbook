<script setup>

import {computed, inject} from "vue";

const props = defineProps({
  recipe: Object,
  modelValue: Boolean,
})

const emit = defineEmits([
  'update:modelValue'
]);

const hashParser = inject('hashParser')

const url = computed(() => {
  return window.location.href + '#' + hashParser.buildHash(props.recipe.id)
})


function close() {
  emit('update:modelValue', false)
}
</script>

<template>
  <v-dialog :model-value="modelValue">
    <v-card>
      <v-card-title class="bg-primary" color="buttonText">Recept delen: {{recipe.name}} </v-card-title>
      <v-card-text>
        <v-row>
          Stuur de volgende url door om het recept {{recipe.name}} te delen:
        </v-row>
        <v-row><b>{{url}}</b></v-row>
        <v-row justify="center">
          <v-col cols="2">
            <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="close">Sluiten</v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
