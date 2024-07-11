<script setup>
import {fetchData} from "../../Composables/fetchData";

const props = defineProps({
  url: String,
  label: String,
})

const {data, totalCount, error, loading} = fetchData(props.url)

</script>

<template>
  <v-select
      :loading="loading ? 'primary' : false"
      :label="label"
      item-title="name"
      item-text="name"
      item-value="value"
      :items="data"
      return-object>
  </v-select>
</template>




