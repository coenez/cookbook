<script setup>
import CrudDataTable from "../../Components/Core/CrudDataTable.vue"
import {useModel} from "../../Composables/useModel";
import {rules} from "../../Composables/rules";

const sortBy = [{ key: 'name', order: 'asc' }]
const endPoints = {
  get: getConfig('urls.label.list'),
  put: getConfig('urls.label.save'),
  delete: getConfig('urls.label.delete')
}

const headers = [
  {
    title: 'Naam',
    key: 'name',
  },
];

const dataModel = useModel('label')

const entityName = 'Label'

const formFields = [
  [
    {
      type: 'v-text-field',
      name: 'name',
      label: 'Naam',
      rules: rules.required
    },
  ],
]

</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary text-h4" >Labels</v-card-title>

    <!--Data grid -->
    <CrudDataTable
        :data-model="dataModel"
        :headers="headers"
        :end-points="endPoints"
        :entity-name="entityName"
        :sort-by="sortBy"
        :form-fields="formFields"
        new-label="Nieuw"
    >
    </CrudDataTable>

  </v-card>
</template>

