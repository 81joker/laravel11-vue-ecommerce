import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './components/router/index.js' 
import {LoadingPlugin} from 'vue-loading-overlay';
import VueDOMPurifyHTML from 'vue-dompurify-html'
import VueImageZoomer from 'vue-image-zoomer'
import Toast from "vue-toastification";

import "vue-toastification/dist/index.css";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import 'vue-loading-overlay/dist/css/index.css';
import 'vue-image-zoomer/dist/style.css';
import './style.css'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const pinia = createPinia()
const app = createApp(App)

pinia.use(piniaPluginPersistedstate)
app.use(Toast)
app.use(VueImageZoomer);
app.use(VueDOMPurifyHTML)
app.use(LoadingPlugin);
app.use(router)
app.use(pinia)
app.mount('#app')
