import { createMemoryHistory, createRouter } from 'vue-router'

import Home from './Pages/Home.vue'
import CategoryList from './Pages/CategoryList.vue'

const routes = [
    {
        name: 'home',
        component: Home,
    },
    {
        name: 'categoryList',
        component: CategoryList,
    },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router