/**
 * centralized model definitions that are used in the frontend
 */

const models = {
    category: {
        id: null,
        name: '',
    },
    ingredient: {
        id: null,
        name: '',
    },
    label: {
        id: null,
        name: '',
    },
    unit: {
        id: null,
        name: '',
        value: '',
    },
    recipe: {
        id: null,
        name: '',
        category: null,
        duration: 30,
        portions: 2,
        labels: [],
        images: [],
        preparation: '',
        recipeIngredients: []
    },
    recipeIngredient: {
        id: null,
        ingredient: {
            id: null,
            name: ''
        },
        name: '',
        unit: {
            id: null,
            name: '',
            value: ''
        },
        amount: 1
    },
    image: {
        id: null,
        name: '',
        path: ''
    },
    user: {
        id: null,
        email: '',
        name: null,
        username: '',
        password: ''
    }
};

export function useModel(name) {
    return models[name] ? JSON.parse(JSON.stringify(models[name])) : null;
}