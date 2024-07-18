import { createMemoryHistory, createRouter } from 'vue-router'

import RecipeList from './Pages/Recipe/List.vue'
import CategoryList from './Pages/Category/List.vue'
import IngredientList from './Pages/Ingredient/List.vue'
import LabelList from './Pages/Label/List.vue'
import UnitList from './Pages/Unit/List.vue'
import RecipeView from './Pages/Recipe/View.vue'
import RecipeNew from './Pages/Recipe/New.vue'

const routes = [
    {
        name: 'recipeList',
        component: RecipeList,
        meta: {
            main: true, //used to determine main navigation
            label: 'Recepten',
            icon: 'mdi-silverware-fork-knife',
        }
    },
    {
        name: 'categoryList',
        component: CategoryList,
        meta: {
            main: true,
            label: 'Categorieen',
            icon: 'mdi-note-text-outline'
        }
    },
    {
        name: 'ingredientList',
        component: IngredientList,
        meta: {
            main: true,
            label: 'Ingredienten',
            icon: 'mdi-bowl-mix-outline'
        }
    },
    {
        name: 'labelList',
        component: LabelList,
        meta: {
            main: true,
            label: 'Labels',
            icon: 'mdi-label-multiple-outline'
        }
    },
    {
        name: 'unitList',
        component: UnitList,
        meta: {
            main: true,
            label: 'Eenheden',
            icon: 'mdi-ruler'
        }
    },
    {
        name: 'recipeView',
        path: '/recipe/:id',
        component: RecipeView,
        props: true,
        meta: {
            main: false,
        }
    },
    {
        name: 'recipeNew',
        component: RecipeNew,
        meta: {
            main: false,
        }
    },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router