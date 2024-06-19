# Summary
This is a practice project to learn symfony, vue and vuetify. 
The application contains a recipe book where users can submit their recipes 
and like recipes from other users. Functionalities will expand over time.

## Stack
- Symfony
- Vite
- Axios
- Vue3 
- Vuetify

## Data structure
- id
- name
- category (int one to many)
- ingredients (many to one? + counter in column?)
- preparation
- duration
- portions
- labels (many to many)


## Datamodels

### recipe
- id (PK AI)
- name 
- slug 
- category
- preperation
- duration  
- portions 

### ingredient
- id 
- name
- slug
- unit

### labels
- id
- name
- slug

### category
- id
- name
- slug

### recipe_ingredient (connection to ingredient + amount)
- recipe_id
- ingredient_id
- amount

### recipe_label connection to labels (many to many)
- recipe_id
- label_id