<script setup>

import DeleteDialog from "./DeleteDialog.vue";
import {ref, inject} from "vue";
import axios from "axios";
import DynaForm from "./DynaForm.vue";
import {useGlobalSearchTerm} from "../../Composables/useGlobalSearchTerm";

const props = defineProps({
  dataModel: {
    type: Object,
    required: true,
  },
  headers: {
    type: Array,
    required: true
  },
  endPoints: {
    type: Object,
    required: true
  },
  entityName: {
    type: String,
    required: true
  },
  formFields: {
    type: Array,
    required: true
  },
  pageSize: {
    type: Number,
    default: 10
  },
  sortBy: {
    type: Array,
    default: [{key: 'id', order: 'desc'}]
  },
  newLabel: {
    type: String,
    default: 'Nieuw'
  }
});

const defaultHeaders = [{
  title: 'Actions',
  key: 'actions',
  sortable: false,
  width: 200
}]

const localSearchTerm = useGlobalSearchTerm(inject('globalSearchTerm'));
const applicationError = inject('applicationError');

const headers = props.headers.concat(defaultHeaders)
const showDialog = ref(false);
const showDeleteDialog = ref(false);
const error = ref({});

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

function save(newData) {
  activeRecord.value = newData

  if (activeIndex.value > -1) {
    //existing record
    Object.assign(data.value[activeIndex.value], activeRecord.value)
  } else {
    data.value.push(activeRecord.value)
  }
  close()
}

function close() {
  activeIndex.value = -1
  activeRecord.value = Object.assign({}, props.dataModel)
  showDialog.value = false
  showDeleteDialog.value = false
}

function loadItems(params) {
  axios.get(props.endPoints.get, {
    params: {
      orderBy: params.sortBy[0].key + '|' + params.sortBy[0].order,
      limit: params.itemsPerPage,
      offset: (params.page-1) * params.itemsPerPage,
      search: params.search
    }
  }).then(response => {
    data.value = response.data.result;
    totalItems.value = response.data?.totalCount;
    loading.value = false;
  }).catch(error => {
      applicationError.value = error.response.data
  })
}

function deleteConfirmed() {
  //sync to backend
  let currentIndex = activeIndex.value;
  axios.delete(props.endPoints.delete, {
    params: {
      id: activeRecord.value.id
    }
  }).then(response => {
    if (data.value[currentIndex]) {
      delete data.value[currentIndex];
    }
  }).catch(error => {
    applicationError.value = error.response.data
  })

  close();
}
</script>

<template>
  <v-btn variant="flat" base-color="primary" class="mr-4 float-right" @click="createItem" >{{newLabel}} {{entityName}}</v-btn>
  <v-data-table-server
      must-sort="must-sort"
      :items-per-page="pageSize"
      :sort-by="sortBy"
      :headers="headers"
      :items="data"
      :items-length="totalItems"
      :loading="loading"
      item-value="id"
      :search="localSearchTerm"
      @update:options="loadItems"
  >
    <template v-slot:item.actions="{ item }">
      <v-icon class="me-2" size="small" @click="editItem(item)" >mdi-pencil</v-icon>
      <v-icon size="small" @click="deleteItem(item)">mdi-delete</v-icon>
    </template>
  </v-data-table-server>

  <!--FORM-->
  <v-dialog v-model="showDialog">
    <DynaForm :name="entityName" :end-point="endPoints.put" :form-fields="formFields" :active-record="activeRecord" :new-label="newLabel" @df-save="save" @df-cancel="close"/>
  </v-dialog>

  <!-- Delete dialog -->
  <DeleteDialog
      v-model="showDeleteDialog"
      :record="activeRecord"
      :item-name="activeRecord.name"
      :entity-name="entityName"
      @deleteConfirmed="deleteConfirmed"
  />
</template>
