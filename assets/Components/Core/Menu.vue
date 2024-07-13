<script setup>
  import {ref, inject, computed} from "vue";
  import router from "../../router";

  const showMainNavDrawer = ref(false)
  const globalSearchTerm = inject('globalSearchTerm')
  const showSearchBar = ref(false)

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

    <v-btn @click.stop="showSearchBar = !showSearchBar" icon="mdi-magnify"/>
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

  <!--extract to component later -->
  <v-navigation-drawer v-model="showFilterDrawer" location="right" temporary>
    <v-list>
      <v-list-item title="Filters" class="text-secondary"></v-list-item>
    </v-list>
    <v-list nav>
      <v-text-field variant="outlined" label="Testing filter tray"/>
    </v-list>
  </v-navigation-drawer>
</template>