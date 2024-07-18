<script setup>
import {fetchData} from "../../Composables/fetchData";
import {ref} from "vue";

const props = defineProps({
  url: String,
  label: String,
  itemValue: {
    type: String,
    default: ''
  },
  multiple: {
    type: Boolean,
    default: false
  }
})

const data = ref([])
const returnObject = props.itemValue === ''
const loading = ref(true)
fetchData(props.url, {}).then((result)=> {
  loading.value = false
  data.value = result.data
})

</script>

<template>
  <v-select
      clearable
      :multiple="multiple"
      :loading="loading ? 'primary' : false"
      :label="label"
      item-title="name"
      :item-value="itemValue"
      :items="data"
      :return-object="returnObject">
  </v-select>
</template>




