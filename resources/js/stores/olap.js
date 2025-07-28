import { defineStore } from 'pinia'
import axios from 'axios'

export const useOlapStore = defineStore('olap', {
  state: () => ({
    salesData: [],
    categoryData: [],
    pivotData: null
  }),
  actions: {
    async fetchSalesData(params = {}) {
      const response = await axios.get('/api/olap/sales', { params })
      this.salesData = response.data
    },
    async fetchDrillDown(groupBy = 'month') {
      const response = await axios.get('/api/olap/sales/drill-down', { 
        params: { group_by: groupBy } 
      })
      return response.data
    },
    async fetchRollUp(level = 'category') {
      const response = await axios.get('/api/olap/sales/roll-up', { 
        params: { level } 
      })
      return response.data
    },
    async fetchPivotTable(rows = 'category', cols = 'year') {
      const response = await axios.get('/api/olap/sales/pivot', { 
        params: { rows, cols } 
      })
      return response.data
    }
  }
})