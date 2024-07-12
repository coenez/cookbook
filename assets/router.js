import { createMemoryHistory, createRouter } from 'vue-router'

import RecipeList from './Pages/Recipe/List.vue'
import CategoryList from './Pages/Category/List.vue'
import IngredientList from './Pages/Ingredient/List.vue'
import LabelList from './Pages/Label/List.vue'
import UnitList from './Pages/Unit/List.vue'

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
    {
        name: 'ingredientList',
        component: IngredientList,
        meta:{
            label: 'Ingredienten',
            icon: 'mdi-bowl-mix-outline'
        }
    },
    {
        name: 'labelList',
        component: LabelList,
        meta:{
            label: 'Labels',
            icon: 'mdi-label-multiple-outline'
        }
    },
    {
        name: 'unitList',
        component: UnitList,
        meta:{
            label: 'Eenheden',
            icon: 'mdi-ruler'
        }
    },
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})

export default router