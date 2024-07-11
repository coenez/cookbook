<script setup>
import {fetchData} from "../../Composables/fetchData";

const props = defineProps({
  url: String,
  label: String,
  itemValue: {
    type: String,
    default: ''
  }
})

const returnObject = props.itemValue === ''
const {data, totalCount, error, loading} = fetchData(props.url)

</script>

<template>
  <v-select
      :loading="loading ? 'primary' : false"
      :label="label"
      item-title="name"
      :item-value="itemValue"
      :items="data"
      :return-object="returnObject">
  </v-select>
</template>




