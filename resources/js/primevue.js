import { defineAsyncComponent } from 'vue'

export default {
    install(app) {
        const components = {
            'Button': 'primevue/button',
            'DataTable': 'primevue/datatable',
            'Column': 'primevue/column',
            // Agrega más componentes según necesites
        }

        Object.entries(components).forEach(([name, path]) => {
            app.component(name, defineAsyncComponent(() => import(`${path}`)))
        })
    }
}