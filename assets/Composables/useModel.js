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
        preparation: '',
    },
    recipeIngredient: {
        id: null,
        name: '',
        unit: {
            id: null,
            name: '',
            value: ''
        },
        amount: 1
    },
};

export function useModel(name) {
    return models[name] ? Object.assign({}, models[name]) : null;
}