<script setup>
import axios from 'axios';
import {ref} from "vue";
import DeleteDialog from "../Component/Core/DeleteDialog.vue"

const pageSize = 5;
const data = ref([]);
const dialog = ref(false);
const deleteDialog = ref(false);
const totalItems = ref(0);
const loading = ref(true);
const sortBy = ref([{ key: 'name', order: 'asc' }])
const headers = [
  {
    title: 'Naam',
    key: 'name',
  },
  {
    title: 'Slug',
    key: 'slug',
    width: 200
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false,
    width: 200
  },
];

const model = {
  id: 0,
  name: '',
  slug: ''
}

const activeRecord = ref(Object.assign({}, model));
const activeIndex = ref(-1);

function editItem (item) {
  dialog.value = true
  activeIndex.value = data.value.indexOf(item)
  activeRecord.value = Object.assign({}, item)
}

function createItem() {
  dialog.value = true
  activeRecord.value = Object.assign({}, model)
}

function deleteItem (item) {
  activeIndex.value = data.value.indexOf(item)
  activeRecord.value = Object.assign({}, item)
  deleteDialog.value = true
}

function save() {
  //push to server first then update the grid
  
  if (activeIndex.value > -1) {
    //existing record
    Object.assign(data.value[activeIndex.value], activeRecord.value)
  } else {
      data.value.push(activeRecord.value)
  }
  close();
}

function close() {
  activeIndex.value = -1
  activeRecord.value = Object.assign({}, model)
  dialog.value = false
  deleteDialog.value = false
}

function loadItems() {
  axios.get(getConfig('urls.category.list'), {
    params: {
      orderBy: sortBy.value[0]?.key + '|' + sortBy.value[0]?.order,
      limit: pageSize,
    }
  }).then(response => {
    data.value = response.data;
    totalItems.value = response.data?.length;
    loading.value = false;
  })
}

function deleteConfirmed() {
  if (data.value[activeIndex.value]) {
    delete data.value[activeIndex.value];
  }
  close();
}

</script>

<template>
  <v-card flat>
    <v-card-title class="text-primary" >Categorieen</v-card-title>
    <v-btn variant="flat" base-color="primary" class="mr-4 float-right" @click="createItem" >Nieuwe categorie</v-btn>

    <!--Data grid -->
    <v-data-table-server
        v-model:items-per-page="pageSize"
        v-model:sort-by="sortBy"
        :headers="headers"
        :items="data"
        :items-length="totalItems"
        :loading="loading"
        item-value="id"
        @update:options="loadItems"
    >
      <template v-slot:item.actions="{ item }">
        <v-icon class="me-2" size="small" @click="editItem(item)" >mdi-pencil</v-icon>
        <v-icon size="small" @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
    </v-data-table-server>

    <!--FORM-->
    <v-dialog v-model="dialog">
      <v-card>
        <v-card-title class="bg-primary" color="buttonText">formtest</v-card-title>
        <v-card-text>
          <v-form @submit.prevent>
            <v-row>
              <v-col>
                <v-text-field label="Name" v-model="activeRecord.name"></v-text-field>
                <v-text-field label="Slug" v-model="activeRecord.slug"></v-text-field>
              </v-col>
            </v-row>
            <v-row justify="center">
              <v-col cols="4">
                <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="save">Opslaan</v-btn>
                <v-btn variant="outlined" type="cancel" @click="close">Annuleren</v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- Delete dialog -->
    <DeleteDialog
        v-model="deleteDialog"
        :record="activeRecord"
        :item-name="activeRecord.name"
        item-type="Categorie"
        @deleteConfirmed="deleteConfirmed"
    />

  </v-card>
</template>

