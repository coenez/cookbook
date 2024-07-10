<script setup>
import CrudDataTable from "../../Components/Core/CrudDataTable.vue"

const sortBy = [{ key: 'name', order: 'asc' }]
const endPoints = {
  get: getConfig('urls.ingredient.list'),
  put: ''
}

const headers = [
  {
    title: 'Naam',
    key: 'name',
  },

];

const dataModel = {
  id: 0,
  name: '',
}

const entityName = 'Ingredient'

const formFields = [
  [
    {
      type: 'v-text-field',
      name: 'name',
      label: 'Naam'
    },
  ],
]

</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary" >Ingredienten</v-card-title>

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

