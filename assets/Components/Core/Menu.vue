<script setup>
  import {ref, inject, computed} from "vue";
  import router from "../../router";

  const navDrawer = ref(false)
  const globalSearchTerm = inject('globalSearchTerm')
  const showSearch = ref(false)

  const showFilter = computed(() => {
    return router.currentRoute.value.name === 'recipeList'
  })

</script>

<template>
  <v-app-bar flat color="primary" name="app-bar">
    <v-app-bar-nav-icon  @click.stop="navDrawer = !navDrawer"></v-app-bar-nav-icon>
    <v-app-bar-title>CookBook</v-app-bar-title>
    <v-spacer></v-spacer>
    <v-text-field
        v-if="showSearch"
        v-model="globalSearchTerm"
        variant="outlined"
        class="mt-5"
        placeholder="Zoeken"
    />

    <v-btn @click.stop="showSearch = !showSearch" icon="mdi-magnify"/>
    <v-btn v-if="showFilter"  icon="mdi-filter"/>
    <v-btn icon="mdi-account"/>

  </v-app-bar>
  <v-navigation-drawer v-model="navDrawer" location="left" temporary>
    <v-list nav>
      <v-list-item v-for="route in router.getRoutes()"
         :to="{name:route.name}"
         :prepend-icon="route.meta.icon"
         :title="route.meta.label"
         :value="route.name">
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>