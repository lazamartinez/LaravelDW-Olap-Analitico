import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('auth_token') || null
  }),
  actions: {
    async login(credentials) {
      try {
        const response = await axios.post('/api/login', credentials)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('auth_token', this.token)
        return true
      } catch (error) {
        console.error('Login error:', error)
        return false
      }
    },
    logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('auth_token')
    }
  },
  getters: {
    isAuthenticated: (state) => !!state.token
  }
})