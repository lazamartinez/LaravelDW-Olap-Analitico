<template>
  <div>
    <Chart type="line" :data="chartData" :options="chartOptions" />
  </div>
</template>

<script>
import Chart from 'primevue/chart'

export default {
  components: {
    Chart
  },
  props: {
    data: {
      type: Array,
      required: true
    }
  },
  computed: {
    chartData() {
      return {
        labels: this.data.map(item => item.period),
        datasets: [
          {
            label: 'Ventas totales',
            data: this.data.map(item => item.total_sales),
            fill: false,
            borderColor: '#42A5F5',
            tension: 0.4
          }
        ]
      }
    },
    chartOptions() {
      return {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Ventas por período',
            font: {
              size: 16
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `Ventas: $${context.raw.toFixed(2)}`
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return `$${value}`
              }
            }
          }
        }
      }
    }
  }
}
</script>