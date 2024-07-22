<script setup>
import CrudDataTable from "../../Components/Core/CrudDataTable.vue"
import {useModel} from "../../Composables/useModel";
import {rules} from "../../Composables/rules";

const sortBy = [{ key: 'name', order: 'asc' }]
const endPoints = {
  get: getConfig('urls.category.list'),
  put: getConfig('urls.category.save')
}

const headers = [
  {
    title: 'Naam',
    key: 'name',
  },
];

const dataModel = useModel('category')

const entityName = 'Categorie'

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
    <v-card-title class="text-secondary text-h4" >Categorieen</v-card-title>

    <!--Data grid -->
    <CrudDataTable
        :data-model="dataModel"
        :headers="headers"
        :end-points="endPoints"
        :entity-name="entityName"
        :sort-by="sortBy"
        :form-fields="formFields"
        new-label="Nieuwe"
    >
    </CrudDataTable>

  </v-card>
</template>

