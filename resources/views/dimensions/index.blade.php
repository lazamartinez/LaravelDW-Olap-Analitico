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
                    <button class="btn btn-primary" id="newDimensionBtn" data-mdb-toggle="tooltip" title="Nueva dimensión">
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
                                            <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip"
                                                title="Ver estructura">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip"
                                                title="Editar">
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
                                            <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip"
                                                title="Ver estructura">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip"
                                                title="Editar">
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
                                            <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip"
                                                title="Ver estructura">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip"
                                                title="Editar">
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
                                            <button class="btn btn-sm btn-outline-primary me-2" data-mdb-toggle="tooltip"
                                                title="Ver estructura">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" data-mdb-toggle="tooltip"
                                                title="Editar">
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

    <!-- Modal para agregar nueva dimensión -->
    <div class="modal fade" id="newDimensionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Nueva Dimensión</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-4" id="dimensionTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sucursal-tab" data-mdb-toggle="tab"
                                data-mdb-target="#sucursal-tab-pane" type="button" role="tab">
                                <i class="fas fa-store me-2"></i>Sucursal
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tiempo-tab" data-mdb-toggle="tab"
                                data-mdb-target="#tiempo-tab-pane" type="button" role="tab">
                                <i class="fas fa-calendar-alt me-2"></i>Tiempo
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="producto-tab" data-mdb-toggle="tab"
                                data-mdb-target="#producto-tab-pane" type="button" role="tab">
                                <i class="fas fa-box me-2"></i>Producto
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cliente-tab" data-mdb-toggle="tab"
                                data-mdb-target="#cliente-tab-pane" type="button" role="tab">
                                <i class="fas fa-users me-2"></i>Cliente
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="custom-tab" data-mdb-toggle="tab"
                                data-mdb-target="#custom-tab-pane" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>Personalizada
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="dimensionTabsContent">
                        <!-- Pestaña Sucursal -->
                        <div class="tab-pane fade show active" id="sucursal-tab-pane" role="tabpanel">
                            <form id="branchForm">
                                <div class="row g-3">
                                    <!-- Información básica -->
                                    <div class="col-md-6">
                                        <div class="card mb-4 shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información
                                                    Básica</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre de la Sucursal*</label>
                                                    <input type="text" class="form-control" name="nombre" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Código*</label>
                                                    <input type="text" class="form-control" name="codigo" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Teléfono</label>
                                                    <input type="tel" class="form-control" name="telefono">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha de Apertura*</label>
                                                    <input type="date" class="form-control" name="fecha_apertura"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="activa"
                                                            name="activa" checked>
                                                        <label class="form-check-label" for="activa">Sucursal
                                                            Activa</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Horario</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <label class="form-label">Hora de Apertura*</label>
                                                        <input type="time" class="form-control" name="hora_apertura"
                                                            required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Hora de Cierre*</label>
                                                        <input type="time" class="form-control" name="hora_cierre"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="form-label">Días de Operación*</label>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="lunes" name="dias[]" value="Lunes" checked>
                                                            <label class="form-check-label" for="lunes">Lunes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="martes" name="dias[]" value="Martes" checked>
                                                            <label class="form-check-label" for="martes">Martes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="miercoles" name="dias[]" value="Miércoles" checked>
                                                            <label class="form-check-label"
                                                                for="miercoles">Miércoles</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="jueves" name="dias[]" value="Jueves" checked>
                                                            <label class="form-check-label" for="jueves">Jueves</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="viernes" name="dias[]" value="Viernes" checked>
                                                            <label class="form-check-label" for="viernes">Viernes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="sabado" name="dias[]" value="Sábado">
                                                            <label class="form-check-label" for="sabado">Sábado</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="domingo" name="dias[]" value="Domingo">
                                                            <label class="form-check-label" for="domingo">Domingo</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ubicación y Mapa -->
                                    <div class="col-md-6">
                                        <div class="card mb-4 shadow-sm">
                                            <div
                                                class="card-header bg-light d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Ubicación
                                                    Geográfica</h6>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    id="locateMeBtn">
                                                    <i class="fas fa-location-arrow me-1"></i>Mi ubicación
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Dirección Exacta*</label>
                                                    <input type="text" class="form-control" name="direccion_exacta"
                                                        id="direccionInput" required>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Provincia*</label>
                                                        <select class="form-select" name="provincia" id="provinciaSelect"
                                                            required>
                                                            <option value="">Seleccionar</option>
                                                            <option value="San José">San José</option>
                                                            <option value="Alajuela">Alajuela</option>
                                                            <option value="Cartago">Cartago</option>
                                                            <option value="Heredia">Heredia</option>
                                                            <option value="Guanacaste">Guanacaste</option>
                                                            <option value="Puntarenas">Puntarenas</option>
                                                            <option value="Limón">Limón</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Cantón*</label>
                                                        <select class="form-select" name="canton" id="cantonSelect"
                                                            required disabled>
                                                            <option value="">Seleccione provincia primero</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Distrito*</label>
                                                        <select class="form-select" name="distrito" id="distritoSelect"
                                                            required disabled>
                                                            <option value="">Seleccione cantón primero</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Mapa interactivo -->
                                                <div id="branchMapContainer"
                                                    style="height: 300px; border-radius: 0.5rem; overflow: hidden; position: relative;">
                                                    <div id="branchMap" style="height: 100%; width: 100%;"></div>
                                                    <div class="map-overlay">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="mapSearch"
                                                                placeholder="Buscar ubicación...">
                                                            <label for="mapSearch">Buscar ubicación...</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Coordenadas -->
                                                <div class="row g-2 mt-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Latitud*</label>
                                                        <input type="text" class="form-control" name="latitud"
                                                            id="latitudInput" required readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Longitud*</label>
                                                        <input type="text" class="form-control" name="longitud"
                                                            id="longitudInput" required readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Atributos OLAP adicionales -->
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-cubes me-2"></i>Atributos OLAP</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Región Comercial*</label>
                                                    <select class="form-select" name="region_comercial" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="Central">Central</option>
                                                        <option value="Norte">Norte</option>
                                                        <option value="Sur">Sur</option>
                                                        <option value="Caribe">Caribe</option>
                                                        <option value="Pacífico">Pacífico</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Sucursal*</label>
                                                    <select class="form-select" name="tipo_sucursal" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="Tienda">Tienda</option>
                                                        <option value="Supermercado">Supermercado</option>
                                                        <option value="Hipermercado">Hipermercado</option>
                                                        <option value="Express">Express</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tamaño (m²)</label>
                                                    <input type="number" class="form-control" name="tamano"
                                                        min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Pestaña Tiempo -->
                        <div class="tab-pane fade" id="tiempo-tab-pane" role="tabpanel">
                            <form id="timeForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-calendar me-2"></i>Configuración de
                                                    Tiempo</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Rango de Fechas*</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="fecha_inicio"
                                                            required>
                                                        <span class="input-group-text">a</span>
                                                        <input type="date" class="form-control" name="fecha_fin"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Granularidad*</label>
                                                    <select class="form-select" name="granularidad" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="diaria">Diaria</option>
                                                        <option value="semanal">Semanal</option>
                                                        <option value="mensual" selected>Mensual</option>
                                                        <option value="trimestral">Trimestral</option>
                                                        <option value="anual">Anual</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Incluir Feriados</label>
                                                    <select class="form-select" name="feriados">
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-cubes me-2"></i>Atributos Jerárquicos
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Niveles Jerárquicos*</label>
                                                    <select class="form-select" name="niveles_jerarquicos" multiple
                                                        required>
                                                        <option value="anio">Año</option>
                                                        <option value="semestre">Semestre</option>
                                                        <option value="trimestre">Trimestre</option>
                                                        <option value="mes">Mes</option>
                                                        <option value="semana">Semana</option>
                                                        <option value="dia">Día</option>
                                                        <option value="hora">Hora</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Atributos Adicionales</label>
                                                    <select class="form-select" name="atributos_adicionales" multiple>
                                                        <option value="dia_semana">Día de la semana</option>
                                                        <option value="fin_semana">Fin de semana</option>
                                                        <option value="mes_nombre">Nombre del mes</option>
                                                        <option value="trimestre_nombre">Nombre del trimestre</option>
                                                        <option value="semana_anio">Semana del año</option>
                                                        <option value="feriado">Es feriado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Pestaña Producto -->
                        <div class="tab-pane fade" id="producto-tab-pane" role="tabpanel">
                            <form id="productForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-box-open me-2"></i>Información Básica
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Código de Producto*</label>
                                                    <input type="text" class="form-control" name="codigo_producto"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre*</label>
                                                    <input type="text" class="form-control" name="nombre_producto"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea class="form-control" name="descripcion" rows="2"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Categoría*</label>
                                                    <select class="form-select" name="categoria" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="Alimentos">Alimentos</option>
                                                        <option value="Bebidas">Bebidas</option>
                                                        <option value="Limpieza">Limpieza</option>
                                                        <option value="Electrónica">Electrónica</option>
                                                        <option value="Otros">Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-cubes me-2"></i>Atributos OLAP</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Subcategoría</label>
                                                    <input type="text" class="form-control" name="subcategoria">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Marca*</label>
                                                    <input type="text" class="form-control" name="marca" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Proveedor</label>
                                                    <input type="text" class="form-control" name="proveedor">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Unidad de Medida*</label>
                                                    <select class="form-select" name="unidad_medida" required>
                                                        <option value="">Seleccionar</option>
                                                        <option value="Unidad">Unidad</option>
                                                        <option value="Kg">Kilogramo</option>
                                                        <option value="L">Litro</option>
                                                        <option value="Paquete">Paquete</option>
                                                        <option value="Caja">Caja</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Pestaña Cliente -->
                        <div class="tab-pane fade" id="cliente-tab-pane" role="tabpanel">
                            <form id="clientForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-user-circle me-2"></i>Información
                                                    Personal</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Identificación*</label>
                                                    <input type="text" class="form-control" name="identificacion"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre Completo*</label>
                                                    <input type="text" class="form-control" name="nombre_completo"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Género</label>
                                                    <select class="form-select" name="genero">
                                                        <option value="">Seleccionar</option>
                                                        <option value="Masculino">Masculino</option>
                                                        <option value="Femenino">Femenino</option>
                                                        <option value="Otro">Otro</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha de Nacimiento</label>
                                                    <input type="date" class="form-control" name="fecha_nacimiento">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Ubicación
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Provincia</label>
                                                    <select class="form-select" name="provincia">
                                                        <option value="">Seleccionar</option>
                                                        <option value="San José">San José</option>
                                                        <option value="Alajuela">Alajuela</option>
                                                        <option value="Cartago">Cartago</option>
                                                        <option value="Heredia">Heredia</option>
                                                        <option value="Guanacaste">Guanacaste</option>
                                                        <option value="Puntarenas">Puntarenas</option>
                                                        <option value="Limón">Limón</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Cantón</label>
                                                    <input type="text" class="form-control" name="canton">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Distrito</label>
                                                    <input type="text" class="form-control" name="distrito">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Dirección Exacta</label>
                                                    <input type="text" class="form-control" name="direccion">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-cubes me-2"></i>Atributos OLAP</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Segmento*</label>
                                                        <select class="form-select" name="segmento" required>
                                                            <option value="">Seleccionar</option>
                                                            <option value="Retail">Retail</option>
                                                            <option value="Corporativo">Corporativo</option>
                                                            <option value="Mayorista">Mayorista</option>
                                                            <option value="Institucional">Institucional</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Tipo de Cliente*</label>
                                                        <select class="form-select" name="tipo_cliente" required>
                                                            <option value="">Seleccionar</option>
                                                            <option value="Ocasional">Ocasional</option>
                                                            <option value="Frecuente">Frecuente</option>
                                                            <option value="Premium">Premium</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Rango de Edad</label>
                                                        <select class="form-select" name="rango_edad">
                                                            <option value="">Seleccionar</option>
                                                            <option value="18-25">18-25 años</option>
                                                            <option value="26-35">26-35 años</option>
                                                            <option value="36-45">36-45 años</option>
                                                            <option value="46-55">46-55 años</option>
                                                            <option value="56+">56+ años</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Pestaña Personalizada -->
                        <div class="tab-pane fade" id="custom-tab-pane" role="tabpanel">
                            <form id="customForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Configuración Básica
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre de la Dimensión*</label>
                                                    <input type="text" class="form-control" name="nombre_dimension"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre de la Tabla*</label>
                                                    <input type="text" class="form-control" name="nombre_tabla"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea class="form-control" name="descripcion" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0"><i class="fas fa-columns me-2"></i>Atributos</h6>
                                            </div>
                                            <div class="card-body">
                                                <div id="customAttributesContainer">
                                                    <div class="attribute-item mb-3">
                                                        <div class="row g-2">
                                                            <div class="col-md-5">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Nombre del atributo"
                                                                    name="atributos[0][nombre]" required>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select class="form-select" name="atributos[0][tipo]"
                                                                    required>
                                                                    <option value="">Tipo de dato</option>
                                                                    <option value="string">Texto</option>
                                                                    <option value="integer">Entero</option>
                                                                    <option value="decimal">Decimal</option>
                                                                    <option value="date">Fecha</option>
                                                                    <option value="boolean">Booleano</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger w-100 remove-attribute"
                                                                    disabled>
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    id="addAttributeBtn">
                                                    <i class="fas fa-plus me-1"></i>Agregar Atributo
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveDimensionBtn">
                        <i class="fas fa-save me-1"></i>Guardar Dimensión
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Leaflet CSS y JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Incluir plugin de geocodificación -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Incluir Select2 para selects mejorados -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Estilos para el mapa y componentes */
        .map-overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            z-index: 1000;
        }

        #branchMapContainer {
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        #branchMapContainer:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .leaflet-control-geocoder-form {
            width: 300px;
        }

        .leaflet-control-geocoder-form input {
            width: 100% !important;
        }

        /* Estilos para las pestañas */
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #4361ee;
            background-color: rgba(67, 97, 238, 0.05);
        }

        .nav-tabs .nav-link.active {
            color: #4361ee;
            background-color: transparent;
            border-bottom: 3px solid #4361ee;
        }

        /* Estilos para las cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .card-header {
            transition: background-color 0.3s ease;
        }

        /* Estilos para los formularios */
        .form-control,
        .form-select {
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        /* Estilos para los atributos personalizados */
        .attribute-item {
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .attribute-item:hover {
            background-color: #e9ecef;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-pane {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Estilos para los selects de múltiple opción */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            min-height: 38px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #4361ee;
            border: none;
            color: white;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inicializar mapa
            let map, marker, geocoder;
            const initialCoords = [9.9281, -84.0907]; // Coordenadas centrales de Costa Rica

            function initMap() {
                map = L.map('branchMap').setView(initialCoords, 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Inicializar geocoder
                geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    position: 'topright',
                    placeholder: 'Buscar ubicación...',
                    errorMessage: 'Ubicación no encontrada',
                    collapsed: false,
                    expand: 'click'
                }).addTo(map);

                geocoder.on('markgeocode', function(e) {
                    const {
                        center,
                        name
                    } = e.geocode;
                    updateLocation(center.lat, center.lng, name);
                });

                // Manejar clics en el mapa
                map.on('click', function(e) {
                    updateLocation(e.latlng.lat, e.latlng.lng);
                });

                // Agregar marcador inicial
                marker = L.marker(initialCoords, {
                    draggable: true,
                    icon: L.divIcon({
                        html: '<div class="store-marker"><i class="fas fa-map-pin"></i></div>',
                        className: '',
                        iconSize: [40, 40]
                    })
                }).addTo(map);

                // Manejar arrastre de marcador
                marker.on('dragend', function(e) {
                    const {
                        lat,
                        lng
                    } = e.target.getLatLng();
                    updateLocation(lat, lng);
                });

                // Actualizar campos de coordenadas
                document.getElementById('latitudInput').value = initialCoords[0];
                document.getElementById('longitudInput').value = initialCoords[1];
            }

            // Actualizar ubicación en el mapa y campos del formulario
            function updateLocation(lat, lng, address = null) {
                // Mover marcador
                marker.setLatLng([lat, lng]);

                // Actualizar campos
                document.getElementById('latitudInput').value = lat;
                document.getElementById('longitudInput').value = lng;

                if (address) {
                    document.getElementById('direccionInput').value = address;
                }

                // Centrar mapa
                map.setView([lat, lng], 15);
            }

            // Localizar al usuario
            document.getElementById('locateMeBtn').addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert('Geolocalización no soportada por tu navegador');
                    return;
                }

                const btn = this;
                btn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Localizando...';
                btn.disabled = true;

                navigator.geolocation.getCurrentPosition(
                    position => {
                        const {
                            latitude,
                            longitude
                        } = position.coords;
                        updateLocation(latitude, longitude);

                        // Obtener dirección aproximada
                        fetch(
                                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.display_name) {
                                    document.getElementById('direccionInput').value = data
                                        .display_name;
                                }
                            })
                            .catch(error => console.error('Error al obtener dirección:', error));

                        btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i> Mi ubicación';
                        btn.disabled = false;
                    },
                    error => {
                        console.error('Error al obtener ubicación:', error);
                        alert(
                            'No se pudo obtener tu ubicación. Asegúrate de haber concedido los permisos necesarios.');
                        btn.innerHTML = '<i class="fas fa-location-arrow me-1"></i> Mi ubicación';
                        btn.disabled = false;
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000
                    }
                );
            });

            // Cargar cantones y distritos dinámicamente
            document.getElementById('provinciaSelect').addEventListener('change', function() {
                const provincia = this.value;
                const cantonSelect = document.getElementById('cantonSelect');

                if (provincia) {
                    // Simular carga de cantones (en producción sería una llamada API)
                    setTimeout(() => {
                        const cantones = {
                            'San José': ['San José', 'Escazú', 'Desamparados', 'Puriscal',
                                'Tarrazú', 'Aserrí', 'Mora', 'Goicoechea', 'Santa Ana',
                                'Alajuelita', 'Vázquez de Coronado', 'Acosta', 'Tibás',
                                'Moravia', 'Montes de Oca', 'Turrubares', 'Dota',
                                'Curridabat', 'Pérez Zeledón', 'León Cortés Castro'
                            ],
                            'Alajuela': ['Alajuela', 'San Ramón', 'Grecia', 'San Mateo',
                                'Atenas', 'Naranjo', 'Palmares', 'Poás', 'Orotina',
                                'San Carlos', 'Zarcero', 'Valverde Vega', 'Upala',
                                'Los Chiles', 'Guatuso', 'Río Cuarto'
                            ]
                        };

                        cantonSelect.innerHTML = '<option value="">Seleccionar cantón</option>';
                        if (cantones[provincia]) {
                            cantones[provincia].forEach(canton => {
                                cantonSelect.innerHTML +=
                                    `<option value="${canton}">${canton}</option>`;
                            });
                        }
                        cantonSelect.disabled = false;
                    }, 300);
                } else {
                    cantonSelect.innerHTML = '<option value="">Seleccione provincia primero</option>';
                    cantonSelect.disabled = true;
                    document.getElementById('distritoSelect').innerHTML =
                        '<option value="">Seleccione cantón primero</option>';
                    document.getElementById('distritoSelect').disabled = true;
                }
            });

            document.getElementById('cantonSelect').addEventListener('change', function() {
                const canton = this.value;
                const distritoSelect = document.getElementById('distritoSelect');

                if (canton) {
                    // Simular carga de distritos (en producción sería una llamada API)
                    setTimeout(() => {
                        const distritos = {
                            'San José': ['Carmen', 'Merced', 'Hospital', 'Catedral', 'Zapote',
                                'San Francisco de Dos Ríos', 'Uruca', 'Mata Redonda',
                                'Pavas', 'Hatillo', 'San Sebastián'
                            ],
                            'Escazú': ['Escazú', 'San Antonio', 'San Rafael']
                        };

                        distritoSelect.innerHTML = '<option value="">Seleccionar distrito</option>';
                        if (distritos[canton]) {
                            distritos[canton].forEach(distrito => {
                                distritoSelect.innerHTML +=
                                    `<option value="${distrito}">${distrito}</option>`;
                            });
                        } else {
                            distritoSelect.innerHTML += '<option value="Central">Central</option>';
                        }
                        distritoSelect.disabled = false;
                    }, 300);
                } else {
                    distritoSelect.innerHTML = '<option value="">Seleccione cantón primero</option>';
                    distritoSelect.disabled = true;
                }
            });

            // Configurar selects múltiples
            $('select[multiple]').select2({
                width: '100%',
                placeholder: 'Seleccione opciones',
                allowClear: true
            });

            // Agregar atributos dinámicos en pestaña personalizada
            let attributeCounter = 1;
            document.getElementById('addAttributeBtn').addEventListener('click', function() {
                const container = document.getElementById('customAttributesContainer');
                const newAttribute = document.createElement('div');
                newAttribute.className = 'attribute-item mb-3';
                newAttribute.innerHTML = `
            <div class="row g-2">
                <div class="col-md-5">
                    <input type="text" class="form-control" placeholder="Nombre del atributo" name="atributos[${attributeCounter}][nombre]" required>
                </div>
                <div class="col-md-5">
                    <select class="form-select" name="atributos[${attributeCounter}][tipo]" required>
                        <option value="">Tipo de dato</option>
                        <option value="string">Texto</option>
                        <option value="integer">Entero</option>
                        <option value="decimal">Decimal</option>
                        <option value="date">Fecha</option>
                        <option value="boolean">Booleano</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger w-100 remove-attribute">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
                container.appendChild(newAttribute);
                attributeCounter++;

                // Habilitar botones de eliminar si hay más de un atributo
                if (attributeCounter > 1) {
                    document.querySelectorAll('.remove-attribute').forEach(btn => {
                        btn.disabled = false;
                    });
                }
            });

            // Eliminar atributos dinámicos
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-attribute')) {
                    const attributeItem = e.target.closest('.attribute-item');
                    attributeItem.remove();
                    attributeCounter--;

                    // Deshabilitar botones de eliminar si solo queda un atributo
                    if (attributeCounter <= 1) {
                        document.querySelectorAll('.remove-attribute').forEach(btn => {
                            btn.disabled = true;
                        });
                    }
                }
            });

            // Guardar dimensión
            document.getElementById('saveDimensionBtn').addEventListener('click', function() {
                const activeTab = document.querySelector('#dimensionTabs .nav-link.active');
                const btn = this;

                let formId, formData;

                switch (activeTab.id) {
                    case 'sucursal-tab':
                        formId = 'branchForm';
                        break;
                    case 'tiempo-tab':
                        formId = 'timeForm';
                        break;
                    case 'producto-tab':
                        formId = 'productForm';
                        break;
                    case 'cliente-tab':
                        formId = 'clientForm';
                        break;
                    case 'custom-tab':
                        formId = 'customForm';
                        break;
                }

                const form = document.getElementById(formId);

                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    if (key.includes('atributos')) {
                        // Manejar atributos personalizados
                        const matches = key.match(/atributos\[(\d+)\]\[(\w+)\]/);
                        if (matches) {
                            const index = matches[1];
                            const field = matches[2];
                            if (!data.atributos) data.atributos = [];
                            if (!data.atributos[index]) data.atributos[index] = {};
                            data.atributos[index][field] = value;
                        }
                    } else if (key.endsWith('[]')) {
                        // Manejar arrays (como días de operación)
                        const cleanKey = key.replace('[]', '');
                        if (!data[cleanKey]) data[cleanKey] = [];
                        data[cleanKey].push(value);
                    } else {
                        data[key] = value;
                    }
                });

                btn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Guardando...';
                btn.disabled = true;

                // Simular envío a API (en producción sería fetch/axios)
                setTimeout(() => {
                    console.log('Datos de dimensión a guardar:', data);

                    // Simular éxito
                    const modal = bootstrap.Modal.getInstance(document.getElementById(
                        'newDimensionModal'));
                    modal.hide();

                    // Mostrar notificación
                    toastr.success('Dimensión creada correctamente');

                    // Resetear formulario
                    form.reset();
                    form.classList.remove('was-validated');

                    // Resetear mapa si es la pestaña de sucursal
                    if (formId === 'branchForm' && marker) {
                        marker.setLatLng(initialCoords);
                        map.setView(initialCoords, 13);
                        document.getElementById('latitudInput').value = initialCoords[0];
                        document.getElementById('longitudInput').value = initialCoords[1];
                    }

                    btn.innerHTML = '<i class="fas fa-save me-1"></i> Guardar Dimensión';
                    btn.disabled = false;

                    // Aquí podrías recargar la tabla de dimensiones
                }, 1500);
            });

            // Inicializar mapa cuando se muestra el modal de nueva dimensión
            document.getElementById('newDimensionModal').addEventListener('shown.bs.modal', function() {
                if (!map) {
                    initMap();
                } else if (marker) {
                    // Resetear vista si ya está inicializado
                    map.setView(initialCoords, 13);
                    marker.setLatLng(initialCoords);
                    document.getElementById('latitudInput').value = initialCoords[0];
                    document.getElementById('longitudInput').value = initialCoords[1];
                }
            });

            // Mostrar modal al hacer clic en "Nueva dimensión"
            // Mostrar modal al hacer clic en "Nueva dimensión"
            document.getElementById('newDimensionBtn').addEventListener('click', function() {
                // Inicializa el modal si no está inicializado
                const modalElement = document.getElementById('newDimensionModal');
                const modal = new bootstrap.Modal(modalElement);
                modal.show();

                // Opcional: Resetear el formulario al abrir el modal
                const form = document.getElementById('branchForm');
                if (form) form.reset();
            });

            // Configurar modales y eventos para ver estructura de dimensión
            const structureModal = new bootstrap.Modal(document.getElementById('dimensionStructureModal'));

            document.querySelectorAll('[data-mdb-toggle="tooltip"][title="Ver estructura"]').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Simular carga de datos
                    const dimensionName = this.closest('tr').querySelector('h6').textContent;
                    document.querySelector('.modal-title').textContent =
                        `Estructura de ${dimensionName}`;

                    // Datos de ejemplo (en producción, esto vendría de una API)
                    let structureData = [];

                    switch (dimensionName) {
                        case 'Tiempo':
                            structureData = [{
                                    column: 'tiempo_id',
                                    type: 'integer',
                                    description: 'ID de tiempo',
                                    example: '1'
                                },
                                {
                                    column: 'fecha',
                                    type: 'date',
                                    description: 'Fecha completa',
                                    example: '2023-11-15'
                                },
                                {
                                    column: 'dia',
                                    type: 'integer',
                                    description: 'Día del mes',
                                    example: '15'
                                },
                                {
                                    column: 'mes',
                                    type: 'integer',
                                    description: 'Mes del año',
                                    example: '11'
                                },
                                {
                                    column: 'anio',
                                    type: 'integer',
                                    description: 'Año',
                                    example: '2023'
                                },
                                {
                                    column: 'trimestre',
                                    type: 'integer',
                                    description: 'Trimestre del año',
                                    example: '4'
                                },
                                {
                                    column: 'semana',
                                    type: 'integer',
                                    description: 'Semana del año',
                                    example: '46'
                                },
                                {
                                    column: 'dia_semana',
                                    type: 'varchar',
                                    description: 'Día de la semana',
                                    example: 'Miércoles'
                                },
                                {
                                    column: 'es_feriado',
                                    type: 'boolean',
                                    description: 'Indica si es feriado',
                                    example: 'false'
                                }
                            ];
                            break;
                        case 'Producto':
                            structureData = [{
                                    column: 'producto_id',
                                    type: 'integer',
                                    description: 'ID de producto',
                                    example: '1'
                                },
                                {
                                    column: 'codigo',
                                    type: 'varchar(50)',
                                    description: 'Código de producto',
                                    example: 'PROD-001'
                                },
                                {
                                    column: 'nombre',
                                    type: 'varchar(100)',
                                    description: 'Nombre del producto',
                                    example: 'Leche Entera 1L'
                                },
                                {
                                    column: 'categoria',
                                    type: 'varchar(50)',
                                    description: 'Categoría del producto',
                                    example: 'Lácteos'
                                },
                                {
                                    column: 'subcategoria',
                                    type: 'varchar(50)',
                                    description: 'Subcategoría del producto',
                                    example: 'Lácteos líquidos'
                                },
                                {
                                    column: 'marca',
                                    type: 'varchar(50)',
                                    description: 'Marca del producto',
                                    example: 'Dos Pinos'
                                }
                            ];
                            break;
                        case 'Sucursal':
                            structureData = [{
                                    column: 'sucursal_id',
                                    type: 'integer',
                                    description: 'ID de sucursal',
                                    example: '1'
                                },
                                {
                                    column: 'codigo',
                                    type: 'varchar(20)',
                                    description: 'Código de sucursal',
                                    example: 'SC-001'
                                },
                                {
                                    column: 'nombre',
                                    type: 'varchar(100)',
                                    description: 'Nombre de sucursal',
                                    example: 'Sucursal Central'
                                },
                                {
                                    column: 'region_comercial',
                                    type: 'varchar(50)',
                                    description: 'Región comercial',
                                    example: 'Central'
                                },
                                {
                                    column: 'tipo_sucursal',
                                    type: 'varchar(50)',
                                    description: 'Tipo de sucursal',
                                    example: 'Supermercado'
                                },
                                {
                                    column: 'latitud',
                                    type: 'decimal(10,6)',
                                    description: 'Coordenada latitud',
                                    example: '9.928100'
                                },
                                {
                                    column: 'longitud',
                                    type: 'decimal(10,6)',
                                    description: 'Coordenada longitud',
                                    example: '-84.090700'
                                }
                            ];
                            break;
                        case 'Cliente':
                            structureData = [{
                                    column: 'cliente_id',
                                    type: 'integer',
                                    description: 'ID de cliente',
                                    example: '1'
                                },
                                {
                                    column: 'identificacion',
                                    type: 'varchar(50)',
                                    description: 'Número de identificación',
                                    example: '1-2345-6789'
                                },
                                {
                                    column: 'nombre_completo',
                                    type: 'varchar(100)',
                                    description: 'Nombre completo',
                                    example: 'Juan Pérez'
                                },
                                {
                                    column: 'segmento',
                                    type: 'varchar(50)',
                                    description: 'Segmento de cliente',
                                    example: 'Retail'
                                },
                                {
                                    column: 'tipo_cliente',
                                    type: 'varchar(50)',
                                    description: 'Tipo de cliente',
                                    example: 'Frecuente'
                                },
                                {
                                    column: 'rango_edad',
                                    type: 'varchar(20)',
                                    description: 'Rango de edad',
                                    example: '26-35'
                                }
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 (depende de jQuery) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- jQuery (requerido por Select2) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap Bundle JS (incluye Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- MDB (si lo estás usando) -->
<script src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@6.0.1/js/mdb.min.js"></script>
@endsection
