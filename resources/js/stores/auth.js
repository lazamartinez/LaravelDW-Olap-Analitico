import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null
  }),
  
  actions: {
    async login(credentials) {
      const response = await axios.post('/login', credentials)
      this.token = response.data.token
      localStorage.setItem('token', this.token)
      await this.fetchUser()
    },
    
    async fetchUser() {
      const response = await axios.get('/api/user')
      this.user = response.data
    },
    
    logout() {
      axios.post('/logout')
      this.user = null
      this.token = null
      localStorage.removeItem('token')
    }
  },
  
  getters: {
    isAuthenticated: (state) => !!state.token
  }
})