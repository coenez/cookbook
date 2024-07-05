<script>
import axios from 'axios';

export default {
  data: () => ({
    selected: [],
    pageSize: 5,
    totalItems: 0,
    sortBy: [{ key: 'name', order: 'asc' }],
    loading: true,
    headers: [
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
    ],
    categories: [],
  }),
  methods: {
    loadItems () {
      axios.get(this.$config.urls.category.list, {
        params: {
          orderBy: this.sortBy[0].key,
          limit: this.pageSize,
        }
      }).then(response => {
        this.categories = response.data;
        this.totalItems = response.data?.length;
        this.loading = false;
      })
    },
    editItem (item) {
      console.log(item)
    },
    delete (item) {
      console.log(item)
    }
  },
};


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

