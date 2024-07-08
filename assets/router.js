import { createMemoryHistory, createRouter } from 'vue-router'

import RecipeList from './Pages/Recipe/List.vue'
import CategoryList from './Pages/Category/List.vue'

const routes = [
    {
        name: 'home',
        component: RecipeList,
        label: 'Recepten'
    },
    {
        name: 'categoryList',
        component: CategoryList,
        label: 'Categorieen'
    },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router