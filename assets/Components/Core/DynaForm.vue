<script setup>
const props = defineProps({
  formFields: Object
})

const activeRecord = defineModel('activeRecord')

const emit = defineEmits(['dynaformSave', 'dynaformClose']);

function dynaformSave() {
  emit('dynaformSave');
}

function dynaformClose() {
  emit('dynaformClose');
}
</script>

<template>
  <v-form @submit.prevent>
    <v-row v-for="(fieldRow) in formFields">
      <v-col v-for="(field) in fieldRow">
        <component  :is="field.type" v-model="activeRecord[field.name]" :name="field.name" :label="field.label"/>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="4">
        <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="dynaformSave">Opslaan</v-btn>
        <v-btn variant="outlined" type="cancel" @click="dynaformClose">Annuleren</v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>

<style scoped>

</style>