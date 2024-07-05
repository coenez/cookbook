import { createApp } from 'vue'

// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import colors from 'vuetify/util/colors'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'

import router from './router'
import App from './App.vue'
import './config';

const vuetify= createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'light',
        themes: {
            light: {
                dark: false,
                colors: {
                    primary: colors.teal.darken2,
                    secondary: colors.deepOrange.darken2,
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

app.use(vuetify)
    .use(router)
    .mount('#app')