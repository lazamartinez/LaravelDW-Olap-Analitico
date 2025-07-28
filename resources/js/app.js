import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';

// Theme and CSS
import 'primevue/resources/themes/saga-blue/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import '../css/app.css';

const app = createApp(App);

// Plugins
app.use(router);
app.use(PrimeVue);
app.use(ToastService);

// Mount the app
app.mount('#app');