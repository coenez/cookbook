<script setup>
import {calculateDuration} from "../../Composables/calculateDuration";
import {computed, inject, ref} from "vue";
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
const currentUser = inject('currentUser');

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

const allowEdit = computed(() => {
  return (currentUser.value.id === props.recipe.user.id) || currentUser.value.roles.indexOf('ROLE_ADMIN') !== -1
})
</script>

<template>
  <v-card-subtitle>
    <span class="cursor-pointer" @click="redirect('category', recipe.category)">{{recipe.category.name}}</span>
    <v-icon icon="mdi-clock" class="ml-2"/> {{duration}}
    <v-icon icon="mdi-account-group" class="ml-2" @click="changePortion"/> {{recipe.portions}}
    <v-tooltip :text="'Dit recept is van: '+recipe.user.name">
      <template v-slot:activator="{ props }">
        <v-icon icon="mdi-account" v-bind="props" class="ml-2 cursor-pointer"/>
      </template>
    </v-tooltip>
    <v-tooltip text="Deel dit recept">
      <template v-slot:activator="{ props }">
        <v-icon icon="mdi-share" v-bind="props" @click="showShareDialog = !showShareDialog" class="ml-2 cursor-pointer"/>
      </template>
    </v-tooltip>
    <v-tooltip v-if="allowEdit" text="Bewerk dit recept">
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



