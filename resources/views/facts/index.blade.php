@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-database me-2"></i>Tablas de Hechos</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tablas de Hechos</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <button class="btn btn-outline-secondary me-2" data-mdb-toggle="tooltip" title="Actualizar">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="btn btn-primary" data-mdb-toggle="tooltip" title="Nueva tabla">
                    <i class="fas fa-plus me-1 d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Nueva</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Tablas de Hechos del Data Warehouse</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Tabla</th>
                                <th>Registros</th>
                                <th>Dimensiones Relacionadas</th>
                                <th>Métricas</th>
                                <th>Última actualización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-shopping-cart text-primary me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">Ventas</h6>
                                            <small class="text-muted">Transacciones de venta</small>
                                        </div>
                                    </div>
                                </td>
                                <td>fact_ventas</td>
                                <td>1,245,852</td>
                                <td>
                                    <span class="badge bg-light text-dark me-1">Tiempo</span>
                                    <span class="badge bg-light text-dark me-1">Producto</span>
                                    <span class="badge bg-light text-dark me-1">Sucursal</span>
                                    <span class="badge bg-light text-dark">Cliente</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark me-1">Cantidad</span>
                                    <span class="badge bg-light text-dark">Monto</span>
                                </td>
                                <td>Hoy 03:15 AM</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip" title="Ver estructura">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip" title="Analizar">
                                            <i class="fas fa-chart-bar"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver estructura de tabla de hechos -->
<div class="modal fade" id="factTableStructureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estructura de fact_ventas</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Columna</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Ejemplo</th>
                                <th>Dimensión</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>venta_id</code></td>
                                <td>integer</td>
                                <td>ID de venta</td>
                                <td>1</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td><code>tiempo_id</code></td>
                                <td>integer</td>
                                <td>Referencia a dim_tiempo</td>
                                <td>1825</td>
                                <td>Tiempo</td>
                            </tr>
                            <tr>
                                <td><code>producto_id</code></td>
                                <td>integer</td>
                                <td>Referencia a dim_producto</td>
                                <td>458</td>
                                <td>Producto</td>
                            </tr>
                            <tr>
                                <td><code>sucursal_id</code></td>
                                <td>integer</td>
                                <td>Referencia a dim_sucursal</td>
                                <td>12</td>
                                <td>Sucursal</td>
                            </tr>
                            <tr>
                                <td><code>cliente_id</code></td>
                                <td>integer</td>
                                <td>Referencia a dim_cliente</td>
                                <td>8452</td>
                                <td>Cliente</td>
                            </tr>
                            <tr>
                                <td><code>cantidad_vendida</code></td>
                                <td>integer</td>
                                <td>Cantidad de productos vendidos</td>
                                <td>2</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td><code>monto_total</code></td>
                                <td>decimal(12,2)</td>
                                <td>Monto total de la venta</td>
                                <td>1250.50</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-chart-bar me-1"></i>Analizar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Configurar modal de estructura
    const factStructureModal = new mdb.Modal(document.getElementById('factTableStructureModal'));
    
    // Manejar clic en botón "Ver estructura"
    document.querySelectorAll('[data-mdb-toggle="tooltip"][title="Ver estructura"]').forEach(btn => {
        btn.addEventListener('click', function() {
            factStructureModal.show();
        });
    });
});
</script>
@endsection
