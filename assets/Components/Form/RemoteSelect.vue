<script setup>
import {fetchData} from "../../Composables/fetchData";

const {data, totalCount, error, loading} = fetchData(getConfig('urls.ingredient.unitList'))

</script>

<template>
  <v-select
      :loading="loading ? 'primary' : false"
      label="Test ready"
      item-title="name"
      item-text="name"
      item-value="value"
      :items="data"
      return-object="return-object">
  </v-select>
</template>




