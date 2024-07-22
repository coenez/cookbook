<script setup>
  import {ref, inject, computed} from "vue";
  import router from "../../router";
  import Filter from "./Filter.vue";

  const showMainNavDrawer = ref(false)
  const globalSearchTerm = inject('globalSearchTerm')
  const showSearchBar = ref(false)
  const showSearchIcon = computed(() => {
    return router.currentRoute.value.name !== 'recipeView' &&
        router.currentRoute.value.name !== 'recipeNew' &&
        router.currentRoute.value.name !== 'recipeEdit'
  })

  const showFilterDrawer = ref(false)
  const showFilterIcon = computed(() => {
    return router.currentRoute.value.name === 'recipeList'
  })

</script>

<template>
  <v-app-bar flat color="primary" name="app-bar">
    <v-app-bar-nav-icon @click.stop="showMainNavDrawer = !showMainNavDrawer"></v-app-bar-nav-icon>
    <v-app-bar-title>CookBook</v-app-bar-title>
    <v-spacer></v-spacer>
    <v-text-field
        v-if="showSearchBar"
        v-model="globalSearchTerm"
        variant="outlined"
        class="mt-5"
        placeholder="Zoeken"
        clearable="clearable"
        autofocus="autofocus"
    />

    <v-btn v-if="showSearchIcon" @click.stop="showSearchBar = !showSearchBar" icon="mdi-magnify"/>
    <v-btn v-if="showFilterIcon" @click.stop="showFilterDrawer = !showFilterDrawer" icon="mdi-filter"/>
    <v-btn icon="mdi-account"/>
  </v-app-bar>

  <v-navigation-drawer v-model="showMainNavDrawer" location="left" temporary>
    <v-list nav>
      <div v-for="route in router.getRoutes()">
        <v-list-item
            v-if="route.meta.main"
            :to="{name:route.name}"
            :prepend-icon="route.meta.icon"
            :title="route.meta.label"
            :value="route.name">
        </v-list-item>
      </div>

    </v-list>
  </v-navigation-drawer>

  <Filter :show="showFilterDrawer" @submitFilter="showFilterDrawer = !showFilterDrawer"/>
</template>