<script setup>

import DeleteDialog from "./DeleteDialog.vue";
import {ref} from "vue";
import axios from "axios";

const props = defineProps({
  dataModel: Object,
  headers: Array,
  endPoints: Object,
  entityName: Object,
  formTitle: String,
  formFields: Array,
  pageSize: Number,
});

const defaultHeaders = [{
  title: 'Actions',
  key: 'actions',
  sortable: false,
  width: 200
}]

const headers = props.headers.concat(defaultHeaders)
const sortBy = defineModel('sortBy')
const showDialog = ref(false);
const showDeleteDialog = ref(false);

//CRUD
const data = ref([]);
const totalItems = ref(0);
const loading = ref(true);
const activeRecord = ref(Object.assign({}, props.dataModel));
const activeIndex = ref(-1);

function editItem (item) {
  showDialog.value = true
  activeIndex.value = data.value.indexOf(item)
  activeRecord.value = Object.assign({}, item)
}

function createItem() {
  showDialog.value = true
  activeRecord.value = Object.assign({}, props.dataModel)
}

function deleteItem (item) {
  activeIndex.value = data.value.indexOf(item)
  activeRecord.value = Object.assign({}, item)
  showDeleteDialog.value = true
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
  activeRecord.value = Object.assign({}, props.dataModel)
  showDialog.value = false
  showDeleteDialog.value = false
}

function loadItems() {
  axios.get(props.endPoints.get, {
    params: {
      orderBy: sortBy.value[0]?.key + '|' + sortBy.value[0]?.order,
      limit: props.pageSize,
    }
  }).then(response => {
    data.value = response.data;
    totalItems.value = response.data?.length;
    loading.value = false;
  })
}

function deleteConfirmed() {
  //sync to backend
  if (data.value[activeIndex.value]) {
    delete data.value[activeIndex.value];
  }
  close();
}
</script>

<template>
  <v-btn variant="flat" base-color="primary" class="mr-4 float-right" @click="createItem" >Nieuwe {{entityName.single}}</v-btn>

  <v-data-table-server
      :items-per-page="pageSize"
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
  <v-dialog v-model="showDialog">
    <v-card>
      <v-card-title class="bg-primary" color="buttonText">{{formTitle}}</v-card-title>
      <v-card-text>
        <v-form @submit.prevent>

          <v-row v-for="(fieldRow) in formFields">
            <v-col v-for="(field, key) in fieldRow">
              <component  :is="field.type" v-model="activeRecord[field.name]" :name="field.name" :label="field.label"/>
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
      v-model="showDeleteDialog"
      :record="activeRecord"
      :item-name="activeRecord.name"
      :item-type="entityName.single"
      @deleteConfirmed="deleteConfirmed"
  />
</template>
