import { createMemoryHistory, createRouter } from 'vue-router'

import RecipeList from './Pages/Recipe/List.vue'
import CategoryList from './Pages/Category/List.vue'

const routes = [
    {
        name: 'recipeList',
        component: RecipeList,
        meta: {
            label: 'Recepten',
            icon: 'mdi-silverware-fork-knife',
        }
    },
    {
        name: 'categoryList',
        component: CategoryList,
        meta:{
            label: 'Categorieen',
            icon: 'mdi-note-text-outline'
        }
    },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router