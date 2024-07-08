
<script setup>
/**
 *
 * DynaForm
 * a component that can render a form based on an array with field configurations.
 *
 * @param array formFields: field definition. Each inner array represents a row in the form
 * @example:
 * formFields = [
 *     [
 *       {
 *         type: 'v-text-field',
 *         name: 'name',
 *       },
 *       {
 *         type: 'v-text-field',
 *         name: 'slug',
 *       }
 *   ],
 * ]
 *
 * @param string name
 * the name determines the emitted events fired by the form to which a parent component can react
 * @example
 * name= 'test' will emit the following events:
 *  - DFtestSave
 *  - DFtestCancel
 */


const props = defineProps({
  formFields: {
    type: Object,
    required: true
  },
  name: {
    type: String,
    default: 'form'
  }
})

const activeRecord = defineModel('activeRecord')

const events = {
  save: 'DF'+props.name+'Save',
  cancel: 'DF'+props.name+'Cancel'
}

</script>

<template>
  <v-form @submit.prevent>
    <v-row v-for="(fieldRow) in formFields">
      <v-col v-for="(field) in fieldRow">
        <component :is="field.type" v-model="activeRecord[field.name]" :name="field.name" :label="field.label"/>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="4">
        <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="$emit(events.save)">Opslaan</v-btn>
        <v-btn variant="outlined" type="cancel" @click="$emit(events.cancel)">Annuleren</v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>

<style scoped>

</style>