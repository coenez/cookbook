# Summary
This is a practice project to learn symfony, vue and vuetify. 
The application contains a recipe book where users can submit their recipes 
and like recipes from other users. Functionalities will expand over time.

A recipe consists of: 
- ingredients and their amount
- portion amount
- preparation description
- duration in minutes
- labels
- variations
- suggestions
- likes

A recipe can have child recipes. These are the variations

A recipe can have suggestions.

A suggestion can be global for parent and child display

# Functional requirements
- search recipes by ingredients
- search recipes by name
- search recipes by category
- search recipes by labels
- user can create an account
- user needs to verify the account to access crud
- verified user can crud recipes 
- any user can change portions to recalculate ingredients
- verified user can like a recipe, but not its own
- verified user can add a suggestion to his own recipes
- 

## Stack
- Symfony
- Vite
- Axios
- Vue3 
- Vuetify

# Data structure
- id
- parent_id (a child recipe is a variation)
- name
- category (int many to one)
- ingredients (many to one? + counter in column?)
- preparation
- duration
- portions
- labels (many to many)


## Datamodels

### recipe
- id (PK AI)
- parent
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

### suggestion
- id
- recipe
- global
- text

### recipe_ingredient (connection to ingredient + amount)
- recipe_id
- ingredient_id
- amount

### recipe_label connection to labels (many to many)
- recipe_id
- label_id