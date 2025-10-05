import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import './style.css'
import App from './App.vue'
import router from './components/router/index.js' 
import {LoadingPlugin} from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import VueDOMPurifyHTML from 'vue-dompurify-html'

const pinia = createPinia()
const app = createApp(App)


app.use(VueDOMPurifyHTML)
app.use(LoadingPlugin);
app.use(router)
app.use(pinia)
app.mount('#app')
