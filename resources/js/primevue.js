import { createApp } from 'vue'
import PrimeVue from 'primevue/config'
import Chart from 'primevue/chart'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Dropdown from 'primevue/dropdown'
import Calendar from 'primevue/calendar'
import ToastService from 'primevue/toastservice'
import Toast from 'primevue/toast'

export default (app) => {
  app.use(PrimeVue)
  app.use(ToastService)
  
  app.component('Chart', Chart)
  app.component('DataTable', DataTable)
  app.component('Column', Column)
  app.component('Button', Button)
  app.component('InputText', InputText)
  app.component('Dropdown', Dropdown)
  app.component('Calendar', Calendar)
  app.component('Toast', Toast)
}