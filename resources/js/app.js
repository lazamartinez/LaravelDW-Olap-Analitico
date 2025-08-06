import { createApp } from 'vue';
import OlapOperations from './components/OlapOperations.vue';

const app = createApp({});
app.component('olap-operations', OlapOperations);
app.mount('#app');
