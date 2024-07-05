import { createApp } from 'vue'

// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import colors from 'vuetify/util/colors'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'

import {config} from "./config";

import router from './router'

import App from './App.vue'

const vuetify= createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'light',
        themes: {
            light: {
                dark: false,
                colors: {
                    primary: colors.blue.darken2,
                    secondary: colors.green.darken2,
                    text: colors.blueGrey.darken3,
                    buttonText: colors.shades.white
                }
            },
        }
    },
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
})

const app = createApp(App);

app.config.globalProperties.$config = config;

app.use(vuetify)
    .use(router)
    .mount('#app')