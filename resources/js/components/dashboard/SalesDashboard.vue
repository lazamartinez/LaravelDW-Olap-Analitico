<template>
    <div class="sales-dashboard">
      <div class="row mb-4">
        <div class="col-md-8">
          <h2>Análisis de Ventas</h2>
        </div>
        <div class="col-md-4">
          <OLAPControls @query="executeOLAPQuery" />
        </div>
      </div>
  
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              Ventas por Producto
            </div>
            <div class="card-body">
              <canvas ref="productChart"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              Ventas Mensuales
            </div>
            <div class="card-body">
              <canvas ref="monthlyChart"></canvas>
            </div>
          </div>
        </div>
      </div>
  
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              Datos Detallados
            </div>
            <div class="card-body">
              <div v-if="loadingData" class="text-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Cargando...</span>
                </div>
              </div>
              <div v-else>
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th v-for="header in resultHeaders" :key="header">
                          {{ header }}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row, index) in resultData" :key="index">
                        <td v-for="(value, key) in row" :key="key">
                          {{ formatValue(value) }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Chart, registerables } from 'chart.js'
  import axios from 'axios'
  
  Chart.register(...registerables)
  
  export default {
    data() {
      return {
        productChart: null,
        monthlyChart: null,
        resultData: [],
        resultHeaders: [],
        loadingData: false
      }
    },
    mounted() {
      this.initCharts()
      this.loadDefaultData()
    },
    methods: {
      initCharts() {
        this.productChart = new Chart(this.$refs.productChart, {
          type: 'bar',
          data: { labels: [], datasets: [] },
          options: {
            responsive: true,
            plugins: {
              legend: { position: 'top' }
            }
          }
        })
  
        this.monthlyChart = new Chart(this.$refs.monthlyChart, {
          type: 'line',
          data: { labels: [], datasets: [] },
          options: {
            responsive: true,
            plugins: {
              legend: { position: 'top' }
            }
          }
        })
      },
      async loadDefaultData() {
        try {
          this.loadingData = true
          
          // Ventas por producto
          const productsResponse = await axios.get('/api/olap/sales-by-product')
          this.updateChart(this.productChart, 
            productsResponse.data.map(item => item.nombre_producto),
            [{
              label: 'Ventas Totales',
              data: productsResponse.data.map(item => item.ventas_totales),
              backgroundColor: 'rgba(54, 162, 235, 0.5)'
            }]
          )
  
          // Ventas mensuales
          const monthlyResponse = await axios.get('/api/olap/sales-by-month')
          this.updateChart(this.monthlyChart,
            monthlyResponse.data.map(item => `${item.nombre_mes} ${item.anio}`),
            [{
              label: 'Ventas Mensuales',
              data: monthlyResponse.data.map(item => item.ventas_totales),
              borderColor: 'rgba(75, 192, 192, 1)',
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              fill: true
            }]
          )
  
          // Datos detallados
          this.resultHeaders = ['Producto', 'Mes', 'Ventas Totales']
          this.resultData = await axios.get('/api/olap/sales-details')
            .then(res => res.data)
  
        } catch (error) {
          console.error('Error loading dashboard data:', error)
        } finally {
          this.loadingData = false
        }
      },
      updateChart(chart, labels, datasets) {
        chart.data.labels = labels
        chart.data.datasets = datasets
        chart.update()
      },
      formatValue(value) {
        if (typeof value === 'number') {
          return value.toLocaleString('es-ES', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          })
        }
        return value
      },
      async executeOLAPQuery(queryParams) {
        try {
          this.loadingData = true
          const response = await axios.post('/api/olap/query', queryParams)
          
          this.resultHeaders = response.data.headers
          this.resultData = response.data.rows
          
          // Actualizar gráficos si corresponde
          if (queryParams.dimension === 'producto') {
            this.updateChart(this.productChart, 
              response.data.rows.map(row => row.nombre_producto),
              [{
                label: queryParams.metric,
                data: response.data.rows.map(row => row[queryParams.metric]),
                backgroundColor: 'rgba(54, 162, 235, 0.5)'
              }]
            )
          }
          
        } catch (error) {
          console.error('Error executing OLAP query:', error)
        } finally {
          this.loadingData = false
        }
      }
    }
  }
  </script>
  
  <style lang="scss" scoped>
  @use '../../../scss/variables' as *;
  
  .some-class {
  background: map-get($colors, white);
}
  </style>
  