<script setup>
import {fetchData} from "../../Composables/fetchData";
import {ref} from "vue";

const props = defineProps({
  url: String,
  label: String,
  itemValue: {
    type: String,
    default: ''
  }
})

const data = ref([])
const returnObject = props.itemValue === ''
const {loading} = fetchData(props.url, {}, data)

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




