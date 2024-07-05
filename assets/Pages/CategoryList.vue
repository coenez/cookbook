<script setup>
import axios from 'axios';
import {onMounted, ref} from "vue";

const pageSize = 5;
const categories = ref([]);
const totalItems = ref(0);
const loading = ref(true);
const sortBy = ref([{ key: 'name', order: 'asc' }])
const headers = [
  {
    title: 'Naam',
    key: 'name',
  },
  {
    title: 'Slug',
    key: 'slug',
    width: 200
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
    width: 200
  },
];

function editItem (item) {
  console.log(item)
}
function deleteItem (item) {
  console.log(item)
}

function loadItems() {
  console.log(sortBy.value[0]);
  axios.get(getConfig('urls.category.list'),{
    params: {
      orderBy: sortBy.value[0]?.key + '|' + sortBy.value[0]?.order,
      limit: pageSize,
    }
  }).then(response => {
    categories.value = response.data;
    totalItems.value = response.data?.length;
    loading.value = false;
  })
}

onMounted(loadItems)

</script>

<template>
  <v-card title="CategoryList" flat>
    <v-data-table-server
        v-model:items-per-page="pageSize"
        v-model:sort-by="sortBy"
        :headers="headers"
        :items="categories"
        :items-length="totalItems"
        :loading="loading"
        item-value="id"
        @update:options="loadItems"
    >
      <template v-slot:item.actions="{ item }">
        <v-icon class="me-2" size="small" @click="editItem(item)" >mdi-pencil</v-icon>
        <v-icon size="small" @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table-server>

  </v-card>
</template>

