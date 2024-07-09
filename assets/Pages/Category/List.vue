<script setup>
import CrudDataTable from "../../Components/Core/CrudDataTable.vue"

const sortBy = [{ key: 'name', order: 'asc' }]
const endPoints = {
  get: getConfig('urls.category.list'),
  put: ''
}

const headers = [
  {
    title: 'Naam',
    key: 'name',
  },
  {
    title: 'Slug',
    key: 'slug',
  },
];

const dataModel = {
  id: 0,
  name: '',
  slug: ''
}

const entityName = 'Categorie'

const formFields = [
    [
      {
        type: 'v-text-field',
        name: 'name',
        label: 'Naam'
      },
      {
        type: 'v-text-field',
        name: 'slug',
        label: 'Slug'
      }
  ],
]

</script>

<template>
  <v-card flat>
    <v-card-title class="text-secondary" >Categorieen</v-card-title>

    <!--Data grid -->
    <CrudDataTable
        :data-model="dataModel"
        :headers="headers"
        :end-points="endPoints"
        :page-size="5"
        :entity-name="entityName"
        :sort-by="sortBy"
        :form-fields="formFields"
        new-label="Nieuwe"
    >
    </CrudDataTable>

  </v-card>
</template>

