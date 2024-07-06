<script setup>

const props = defineProps({
  record: Object,
  itemType: String,
  itemName: String,
  modelValue: Boolean,
})

const emit = defineEmits([
    'deleteConfirmed',
    'update:modelValue'
]);

function deleteConfirmed() {
  emit("deleteConfirmed", props.record)
}

function close() {
  emit('update:modelValue', false)

}
</script>

<template>
  <v-dialog :model-value="modelValue">
    <v-card>
      <v-card-title class="bg-primary" color="buttonText">{{ itemType }} verwijderen</v-card-title>
      <v-card-text>
        <v-row>
          Weet u zeker dat u dit item wilt verwijderen: {{ itemName }}?
        </v-row>
        <v-row justify="center">
          <v-col cols="4">
            <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="deleteConfirmed">Ok</v-btn>
            <v-btn variant="outlined" type="cancel" @click="close">Annuleren</v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
