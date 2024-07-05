<script setup>
import axios from 'axios';
import {ref} from "vue";

const pageSize = 5;
const data = ref([]);
const dialog = ref(false);
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

const activeRecord = ref(null);
const activeIndex = ref(0);

function editItem (item) {
  dialog.value = true
  activeIndex.value = data.value.indexOf(item)
  activeRecord.value = Object.assign({}, item)
}

function deleteItem (item) {
  console.log(item)
}

function save() {
  if (activeIndex.value > -1) {
    //existing record
    Object.assign(data.value[activeIndex.value], activeRecord.value)
  } else {
      data.value.push(activeRecord)
  }
  close();
}

function close() {
  activeIndex.value = -1;
  dialog.value = false;
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

</script>

<template>
  <v-card flat>
    <v-card-title class="text-primary" >Categorieen</v-card-title>
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
                <v-btn variant="flat" base-color="primary" class="mr-4" type="submit" @click="save" >Submit</v-btn>
                <v-btn variant="outlined" type="cancel" @click="close">cancel</v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-card>
</template>

