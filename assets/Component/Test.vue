
<script setup>
//test component to try stuff
import { ref } from 'vue'

const message = ref('Hello World!')
const count = ref(0);
const increase = () => { count.value ++;}

</script>

<template>
  <div>{{message}}</div>
  <button @click="increase()">Click {{ count }}</button>
</template>