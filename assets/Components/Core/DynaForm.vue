
<script setup>/**
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
 */
import axios from "axios";
import {inject, ref} from "vue";

const props = defineProps({
  formFields: {
    type: Object,
    required: true
  },
  name: {
    type: String,
    default: 'form'
  },
  newLabel: {
    type: String,
    default: 'Nieuw'
  },
  endPoint: {
    type: String,
    required: true
  },
})

const emit = defineEmits(['DfSave', 'DfCancel'])
const activeRecord = defineModel('activeRecord')
const applicationError = inject('applicationError');

//compile form title
function getFormTitle() {
  return (activeRecord.value.id > 0 ? 'Bewerk' : props.newLabel) + ' ' + props.name;
}

const save = async () => {
  const {valid} = await form.value.validate()
  if (valid) {
    axios.put(props.endPoint, activeRecord.value).then(response => {
      activeRecord.value = response.data;
      emit('DfSave', activeRecord.value)
    }).catch(error => {
      if (error.response) {
        applicationError.value = error.response.data
      }
    })
  }
}

const form = ref(null)

</script>

<template>
  <v-card>
    <v-card-title class="bg-primary" color="buttonText">{{getFormTitle()}}</v-card-title>
    <v-card-text>
      <v-form ref="form" @submit.prevent="save">
        <v-row v-for="(fieldRow) in formFields">
          <v-col v-for="(field) in fieldRow">
            <component
                :is="field.type"
                variant="outlined"
                v-model="activeRecord[field.name]"
                :name="field.name"
                :label="field.label"
                :rules="field.rules ?? []"
                :url="field.url ?? ''"
                :itemValue="field.itemValue ?? ''"
            />
          </v-col>
        </v-row>
        <v-row justify="center">
          <v-col cols="4">
            <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" >Opslaan</v-btn>
            <v-btn variant="outlined" type="cancel" @click="emit('DfCancel')">Annuleren</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
  </v-card>
</template>