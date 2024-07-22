export const config = {
  urls: {
    category: {
      list: 'category/list',
      save: 'category/save',
      delete: 'category/delete',
    },
    recipe: {
      list: 'recipe/list',
      get: 'recipe/get',
      save: 'recipe/save',
      delete: 'recipe/delete',
    },
    ingredient: {
      list: 'ingredient/list',
      save: 'ingredient/save',
      delete: 'ingredient/delete',
    },
    label: {
      list: 'label/list',
      save: 'label/save',
      delete: 'label/delete',
    },
    unit: {
      list: 'unit/list',
      save: 'unit/save',
      delete: 'unit/delete',
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