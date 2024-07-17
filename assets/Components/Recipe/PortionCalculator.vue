<script setup>
import {ref, watch} from "vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  portions: Number,
  ingredients: Array
})

const portionsToCalculate = ref(props.portions)

const calculatePortions = ()=> {
  for (const [key, ingredient] of Object.entries(props.ingredients)) {

    if (!ingredient.orgAmount) {
      ingredient.orgAmount = ingredient.amount
    }
    let result = parseFloat((ingredient.orgAmount/props.portions) * portionsToCalculate.value)

    ingredient.amount = result.toString().split('.').length > 1 ? result.toFixed(2) : result
  }
}

watch(portionsToCalculate, calculatePortions)
</script>

<template>
  <v-card-text v-if="show">
    <div class="text-caption">Wijzig aantal porties:</div>
    <v-slider v-model="portionsToCalculate" color="primary" :max="25" :min="1" :step="1" thumb-label show-ticks width="500">
      <template v-slot:append>
        <v-text-field v-model="portionsToCalculate" readOnly density="compact" style="width: 60px" type="number" variant="plain" hide-details></v-text-field>
      </template>
    </v-slider>
  </v-card-text>

</template>
