@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-layer-group me-2"></i>Dimensiones del Data Warehouse</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dimensiones</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex">
                <button class="btn btn-outline-secondary me-2" data-mdb-toggle="tooltip" title="Actualizar">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="btn btn-primary" data-mdb-toggle="tooltip" title="Nueva dimensión">
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
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Listado de Dimensiones</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Tabla</th>
                                <th>Registros</th>
                                <th>Atributos</th>
                                <th>Última actualización</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">Tiempo</h6>
                                            <small class="text-muted">Dimensión de tiempo</small>
                                        </div>
                                    </div>
                                </td>
                                <td>dim_tiempo</td>
                                <td>1,825</td>
                                <td>12</td>
                                <td>Hoy 03:15 AM</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip" title="Ver estructura">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-box text-success me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">Producto</h6>
                                            <small class="text-muted">Dimensión de productos</small>
                                        </div>
                                    </div>
                                </td>
                                <td>dim_producto</td>
                                <td>2,458</td>
                                <td>8</td>
                                <td>Hoy 03:15 AM</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip" title="Ver estructura">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-store text-warning me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">Sucursal</h6>
                                            <small class="text-muted">Dimensión de sucursales</small>
                                        </div>
                                    </div>
                                </td>
                                <td>dim_sucursal</td>
                                <td>24</td>
                                <td>10</td>
                                <td>Ayer 03:15 AM</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip" title="Ver estructura">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-users text-info me-2"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">Cliente</h6>
                                            <small class="text-muted">Dimensión de clientes</small>
                                        </div>
                                    </div>
                                </td>
                                <td>dim_cliente</td>
                                <td>15,842</td>
                                <td>9</td>
                                <td>Hoy 03:15 AM</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip" title="Ver estructura">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit"></i>
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

<!-- Modal para ver estructura de dimensión -->
<div class="modal fade" id="dimensionStructureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estructura de Dimensión</h5>
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
                            </tr>
                        </thead>
                        <tbody id="dimensionStructureBody">
                            <!-- Datos dinámicos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Configurar modales y eventos
    const structureModal = new mdb.Modal(document.getElementById('dimensionStructureModal'));
    
    // Ejemplo de cómo cargar estructura de dimensión
    document.querySelectorAll('[data-mdb-toggle="tooltip"][title="Ver estructura"]').forEach(btn => {
        btn.addEventListener('click', function() {
            // Simular carga de datos
            const dimensionName = this.closest('tr').querySelector('h6').textContent;
            document.querySelector('.modal-title').textContent = `Estructura de ${dimensionName}`;
            
            // Datos de ejemplo (en producción, esto vendría de una API)
            let structureData = [];
            
            switch(dimensionName) {
                case 'Tiempo':
                    structureData = [
                        { column: 'tiempo_id', type: 'integer', description: 'ID de tiempo', example: '1' },
                        { column: 'fecha', type: 'date', description: 'Fecha completa', example: '2023-11-15' },
                        { column: 'dia', type: 'integer', description: 'Día del mes', example: '15' },
                        { column: 'mes', type: 'integer', description: 'Mes del año', example: '11' },
                        { column: 'anio', type: 'integer', description: 'Año', example: '2023' }
                    ];
                    break;
                case 'Producto':
                    structureData = [
                        { column: 'producto_id', type: 'integer', description: 'ID de producto', example: '1' },
                        { column: 'codigo', type: 'varchar(50)', description: 'Código de producto', example: 'PROD-001' },
                        { column: 'nombre', type: 'varchar(100)', description: 'Nombre del producto', example: 'Leche Entera 1L' },
                        { column: 'categoria', type: 'varchar(50)', description: 'Categoría del producto', example: 'Lácteos' }
                    ];
                    break;
            }
            
            // Renderizar datos
            const tbody = document.getElementById('dimensionStructureBody');
            tbody.innerHTML = structureData.map(item => `
                <tr>
                    <td><code>${item.column}</code></td>
                    <td>${item.type}</td>
                    <td>${item.description}</td>
                    <td>${item.example}</td>
                </tr>
            `).join('');
            
            structureModal.show();
        });
    });
});
</script>
@endsection