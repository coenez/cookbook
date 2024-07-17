export const config = {
  urls: {
    category: {
      list: 'category/list',
      save: 'category/save',
    },
    recipe: {
      list: 'recipe/list',
      get: 'recipe/get',
      save: 'recipe/save',
    },
    ingredient: {
      list: 'ingredient/list',
      save: 'ingredient/save',
      recipe: 'ingredient/recipe'
    },
    label: {
      list: 'label/list',
      save: 'label/save',
    },
    unit: {
      list: 'unit/list',
      save: 'unit/save',
    },
  }
}

//make config global
window.getConfig = function(path) {
  if (path) {
    let parts = path.split('.');
    return parts.reduce((xs, x) => xs?.[x] ?? null, config);
  } else {
    return config;
  }
}