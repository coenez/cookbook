<script setup>
import {calculateDuration} from "../../Composables/calculateDuration";
import {inject, ref} from "vue";
import ShareDialog from "../Core/ShareDialog.vue";
import {useRouter} from "vue-router";

const props = defineProps({
  recipe: Object,
  editable: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['editPortion'])
const duration = calculateDuration(props.recipe.duration);
const showShareDialog = ref(false)

const filters = inject('globalFilter');

const redirect = (type, object) => {
  if (type === 'label') {
    filters.value = {
      labels: [object],
    }
  } else {
    filters.value = {
      category: object,
    }
  }
}

const router = useRouter()

const editRecipe = (id) => {
  router.push({name:'recipeEdit', params: {id:id}});
}

const changePortion = () => {
  emit('editPortion')
}
</script>

<template>
  <v-card-subtitle>
    <span class="cursor-pointer" @click="redirect('category', recipe.category)">{{recipe.category.name}}</span>
    <v-icon icon="mdi-clock" class="ml-2"/> {{duration}}
    <v-icon icon="mdi-account-group" class="ml-2" @click="changePortion"/> {{recipe.portions}}
    <v-tooltip text="show user name here">
      <template v-slot:activator="{ props }">
        <v-icon icon="mdi-account" v-bind="props" class="ml-2 cursor-pointer"/>
      </template>
    </v-tooltip>
    <v-tooltip text="Deel dit recept">
      <template v-slot:activator="{ props }">
        <v-icon icon="mdi-share" v-bind="props" @click="showShareDialog = !showShareDialog" class="ml-2 cursor-pointer"/>
      </template>
    </v-tooltip>
    <v-tooltip text="Bewerk dit recept">
      <template v-slot:activator="{ props }">
        <v-icon icon="mdi-pencil" v-bind="props" @click="editRecipe(recipe.id)" class="ml-2 cursor-pointer"/>
      </template>
    </v-tooltip>
  </v-card-subtitle>
  <v-card-text>
    <v-chip
        v-for="label in recipe.labels"
        class="mr-2 mb-2"
        density="comfortable"
        size="small"
        variant="tonal"
        color="primary"
        @click="redirect('label', label)"
    >
      {{label.name}}
    </v-chip>
  </v-card-text>

  <ShareDialog v-model="showShareDialog" :recipe="recipe"/>
</template>



