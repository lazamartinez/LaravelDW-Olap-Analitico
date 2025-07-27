import { defineStore } from 'pinia'
import axios from 'axios'

export const useOlapStore = defineStore('olap', {
  state: () => ({
    sales: [],
    products: [],
    timeDimensions: [],
    stores: [],
    metrics: {
      total_sales: 0,
      avg_sale: 0,
      top_product: null,
      top_store: null,
      sales_by_category: {},
      sales_trend: []
    },
    filters: {
      date_range: null,
      categories: [],
      stores: []
    },
    loading: false,
    error: null
  }),

  getters: {
    formattedSales: (state) => {
      return state.sales.map(sale => ({
        ...sale,
        formatted_date: new Date(sale.time.date).toLocaleDateString(),
        formatted_amount: new Intl.NumberFormat('es-ES', {
          style: 'currency',
          currency: 'EUR'
        }).format(sale.net_amount)
      }))
    },
    categories: (state) => {
      return [...new Set(state.products.map(p => p.category))]
    },
    topProducts: (state) => {
      return [...state.products]
        .sort((a, b) => b.total_sales - a.total_sales)
        .slice(0, 5)
    }
  },

  actions: {
    async fetchSalesData(params = {}) {
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/api/olap/sales', { 
          params: {
            ...this.filters,
            ...params
          }
        })
        this.sales = response.data
        this.calculateMetrics()
      } catch (error) {
        this.error = this.handleApiError(error)
      } finally {
        this.loading = false
      }
    },

    async fetchProducts() {
      this.loading = true
      try {
        const response = await axios.get('/api/olap/products')
        this.products = response.data
      } catch (error) {
        this.error = this.handleApiError(error)
      } finally {
        this.loading = false
      }
    },

    async fetchTimeDimensions() {
      try {
        const response = await axios.get('/api/olap/time-dimensions')
        this.timeDimensions = response.data
      } catch (error) {
        this.error = this.handleApiError(error)
      }
    },

    async fetchStores() {
      try {
        const response = await axios.get('/api/olap/stores')
        this.stores = response.data
      } catch (error) {
        this.error = this.handleApiError(error)
      }
    },

    calculateMetrics() {
      // Ventas totales y promedio
      this.metrics.total_sales = this.sales.reduce((sum, sale) => sum + sale.net_amount, 0)
      this.metrics.avg_sale = this.sales.length > 0 
        ? this.metrics.total_sales / this.sales.length 
        : 0

      // Producto más vendido
      const productSales = {}
      this.sales.forEach(sale => {
        productSales[sale.product.name] = (productSales[sale.product.name] || 0) + sale.net_amount
      })
      this.metrics.top_product = Object.entries(productSales)
        .sort((a, b) => b[1] - a[1])[0]?.[0] || 'N/A'

      // Sucursal con más ventas
      const storeSales = {}
      this.sales.forEach(sale => {
        storeSales[sale.store.name] = (storeSales[sale.store.name] || 0) + sale.net_amount
      })
      this.metrics.top_store = Object.entries(storeSales)
        .sort((a, b) => b[1] - a[1])[0]?.[0] || 'N/A'

      // Ventas por categoría
      this.metrics.sales_by_category = {}
      this.sales.forEach(sale => {
        const category = sale.product.category
        this.metrics.sales_by_category[category] = 
          (this.metrics.sales_by_category[category] || 0) + sale.net_amount
      })

      // Tendencia de ventas (por mes)
      this.metrics.sales_trend = this.calculateSalesTrend()
    },

    calculateSalesTrend() {
      const monthlySales = {}
      this.sales.forEach(sale => {
        const date = new Date(sale.time.date)
        const monthYear = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`
        monthlySales[monthYear] = (monthlySales[monthYear] || 0) + sale.net_amount
      })

      return Object.entries(monthlySales)
        .map(([period, amount]) => ({ period, amount }))
        .sort((a, b) => a.period.localeCompare(b.period))
    },

    updateFilters(newFilters) {
      this.filters = { ...this.filters, ...newFilters }
    },

    resetFilters() {
      this.filters = {
        date_range: null,
        categories: [],
        stores: []
      }
    },

    handleApiError(error) {
      console.error('API Error:', error)
      if (error.response) {
        return {
          status: error.response.status,
          message: error.response.data.message || 'Error en la solicitud'
        }
      } else if (error.request) {
        return { message: 'No se recibió respuesta del servidor' }
      } else {
        return { message: 'Error al configurar la solicitud' }
      }
    },

    async initialize() {
      await Promise.all([
        this.fetchSalesData(),
        this.fetchProducts(),
        this.fetchTimeDimensions(),
        this.fetchStores()
      ])
    }
  },

  persist: {
    enabled: true,
    strategies: [
      {
        key: 'olap_store',
        storage: localStorage,
        paths: ['filters']
      }
    ]
  }
})