import { createMemoryHistory, createRouter } from 'vue-router'

import HomeView from './Pages/Home.vue'
import Page1View from './Pages/Page1.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/page1',
        name: 'page1',
        component: Page1View
    },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router