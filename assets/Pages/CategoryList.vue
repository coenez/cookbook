<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: []
    }
  },
  mounted() {
    axios.get('/category/list')
        .then(response => {
          this.categories = response.data;
        })
  }
};
</script>

<template>
<h1>CategoryList</h1>
<div class="d-flex flex-wrap">
  <v-card class="mr-3 mb-3" variant="outlined" v-for="category in categories" :title="category.name">
    <v-card-actions>
      <v-btn prepend-icon="mdi-pencil">Bewerken</v-btn>
      <v-btn prepend-icon="mdi-trash-can-outline">Verwijderen</v-btn>
    </v-card-actions>
  </v-card>
</div>
</template>
