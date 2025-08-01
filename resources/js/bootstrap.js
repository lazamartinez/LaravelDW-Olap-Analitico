import axios from 'axios'
import { createPinia } from 'pinia'

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.withCredentials = true
window.axios.defaults.baseURL = '/api'

const pinia = createPinia()

export { axios, pinia }