<script setup>
import RecipeSubTitle from "./RecipeSubTitle.vue";
import {useRouter} from "vue-router";
import {computed, inject} from "vue";

const props = defineProps({
  recipe: Object,
})

const router = useRouter()
const textSummary = props.recipe.preparation.slice(0, 200) + '...'

const gotoRecipe = (id) => {
  router.push({name:'recipeView', params: {id:id}});
}

const currentUser = inject('currentUser');
const allowEdit = computed(() => {
  return (currentUser.value.id === props.recipe.user.id) || currentUser.value.roles.indexOf('ROLE_ADMIN') !== -1
})
</script>

<template>
  <v-card class="mb-8 cardOutline" border="thin" color="text" variant="outlined">
    <v-card-title class="text-primary text-h5 cursor-pointer" @click="gotoRecipe(recipe.id)"> {{recipe.name}} </v-card-title>
    <v-row>
      <v-col cols="3">
        <v-img v-if="recipe.images[0]?.path" :src="recipe.images[0].path" @click="gotoRecipe(recipe.id)" aspect-ratio="1" cover class="ml-4 mb-4 border-thin cursor-pointer">
          <template v-slot:placeholder>
            <div class="d-flex align-center justify-center fill-height">
              <v-progress-circular color="grey-lighten-4" indeterminate></v-progress-circular>
            </div>
          </template>
        </v-img>
        <v-card v-else variant="flat">
          <v-img  src="/images/placeholder.jpg" aspect-ratio="1" @click="gotoRecipe(recipe.id)" cover class="ml-4 mb-4 border-thin opacity-50 cursor-pointer">
            <div class="d-flex align-center justify-center fill-height">
              <v-icon icon="mdi-camera-off-outline" size="70" class="float-right"/>
            </div>
          </v-img>
        </v-card>
      </v-col>
      <v-col cols="9">
        <RecipeSubTitle :recipe="recipe"/>
        <v-card-text class="mt-n4">
          {{textSummary}}
        </v-card-text>
        <v-card-actions>
          <v-btn
              :to="{name:'recipeView', params: {id:recipe.id}}"
              color="primary"
              text="Bekijk recept"
              variant="text"
          ></v-btn>
          <v-btn
              v-if="allowEdit"
              :to="{name:'recipeEdit', params: {id:recipe.id}}"
              color="secundary"
              text="Bewerk recept"
              variant="text"
          ></v-btn>
        </v-card-actions>
      </v-col>
    </v-row>

  </v-card>
</template>

<style scoped>
  .cardOutline {
    border-bottom: solid 3px !important;
    border-bottom-color:#FFAB91 !important;
  }
</style>