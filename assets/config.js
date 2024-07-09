export const config = {
  urls: {
    category: {
      list: 'category/list'
    },
    recipe: {
      list: 'recipe/list'
    }
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