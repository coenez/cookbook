<script setup>

import {rules} from "../Composables/rules";
import {inject, ref} from "vue";
import {useModel} from "../Composables/useModel";
import axios from "axios";

const userData = ref(useModel('user'))
const currentUser = inject('currentUser')
const form = ref(null)

const flash = ref({
  show: false,
  type: 'error',
  title: '',
  text: '',
});

const login = async () => {
  const {valid} = await form.value.validate()
  if (valid) {
    axios.post(getConfig('urls.main.login'), userData.value).then(response => {
      currentUser.value = response.data;
    }).catch(error => {
      if (error.response) {
        flash.value = {
          show: true,
          type: 'error',
          title: 'Login ongeldig',
          text: error.response.data.error,
        }
      }
    })
  }
}

</script>

<template>
  <v-alert class="mb-4"
      v-model="flash.show"
      :text="flash.text"
      :title="flash.title"
      :type="flash.type"
      closable="closable"
      variant="outlined"
  ></v-alert>
    <v-form ref="form" @submit.prevent="login">
      <v-row justify="center">
        <v-col cols="6">
          <v-card border="thin" variant="outlined">
            <v-card-title class="text-secondary text-h4">CookBook login</v-card-title>
            <v-text-field variant="outlined" color="primary" :rules="rules.required" class="ma-2" v-model="userData.username" label="E-mail" />
            <v-text-field variant="outlined" type="password" color="primary" :rules="rules.required" class="ma-2" v-model="userData.password" label="Wachtwoord" />
            <v-card-actions>
              <v-btn variant="flat" base-color="primary" type="submit" >Inloggen</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-form>
</template>

