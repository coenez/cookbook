<script setup>
import CrudDataTable from "../../Components/Core/CrudDataTable.vue"
import {useModel} from "../../Composables/useModel";

const sortBy = [{ key: 'name', order: 'asc' }]
const endPoints = {
  get: getConfig('urls.ingredient.list'),
  put: getConfig('urls.ingredient.save')
}

const headers = [
  {
    title: 'Naam',
    key: 'name',
  },{
    title: 'Eenheid',
    key: 'unit.name',
  },

];

const dataModel = useModel('ingredient')

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
    <v-card-title class="text-secondary text-h4" >Ingredienten</v-card-title>

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

