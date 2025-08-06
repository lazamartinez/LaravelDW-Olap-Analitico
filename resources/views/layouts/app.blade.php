<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OLAP Dashboard - {{ config('app.name') }}</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- MDB 5 -->
    <link href="https://cdn.jsdelivr.net/npm/mdb-ui-kit@6.0.1/css/mdb.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
</head>

<body class="bg-light">

    <div id="preloader"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: white; z-index: 9999; display: flex; align-items: center; justify-content: center;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Sidebar Toggle para móviles -->
    <div class="d-lg-none">
        <button class="btn btn-primary position-fixed bottom-0 end-0 m-3 rounded-circle shadow-lg" id="mobileMenuToggle"
            style="width: 56px; height: 56px; z-index: 999;">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Layout Wrapper -->
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white d-flex align-items-center">
                <i class="fas fa-cubes me-2"></i>
                <strong>OLAP BD 2025</strong>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}"
                    class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a href="{{ route('etl') }}"
                    class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('etl') ? 'active' : '' }}">
                    <i class="fas fa-sync-alt me-2"></i>Procesos ETL
                </a>
                <a href="{{ route('olap.analysis') }}"
                    class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('olap.analysis') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie me-2"></i>Análisis OLAP
                </a>
                <a href="{{ route('dimensions') }}"
                    class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('dimensions') ? 'active' : '' }}">
                    <i class="fas fa-layer-group me-2"></i>Dimensiones
                </a>
                <a href="{{ route('facts') }}"
                    class="list-group-item list-group-item-action bg-dark text-white {{ request()->routeIs('facts') ? 'active' : '' }}">
                    <i class="fas fa-database me-2"></i>Tablas de Hechos
                </a>
            </div>

            <!-- Footer del Sidebar -->
            <div class="position-absolute bottom-0 start-0 end-0 p-3 text-center text-muted"
                style="font-size: 0.75rem;">
                v1.0.0 &copy; {{ date('Y') }}
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link text-white d-lg-none" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="d-flex align-items-center ms-auto">
                        <div class="me-3 d-none d-lg-block">
                            <span class="text-white">{{ now()->format('l, d F Y') }}</span>
                        </div>

                        <div class="dropdown">
                            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                                id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown"
                                aria-expanded="false">
                                <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg"
                                    class="rounded-circle" height="36" alt="User" loading="lazy" />
                                <span class="ms-2 text-white d-none d-lg-inline">Admin</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-user-circle me-2"></i> Mi perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-cog me-2"></i> Configuración
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid px-4 py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- MDB 5 JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/mdb-ui-kit@6.0.1/js/mdb.min.js"></script>

    <!-- Custom scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mostrar preloader al inicio
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.display = 'flex';

                // Ocultar cuando todo esté cargado
                window.addEventListener('load', function() {
                    setTimeout(function() {
                        preloader.classList.add('fade-out');
                        setTimeout(() => {
                            preloader.style.display = 'none';
                        }, 300);
                    }, 500);
                });
            }

            // Toggle sidebar
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    document.getElementById('wrapper').classList.toggle('toggled');
                });
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    document.getElementById('wrapper').classList.toggle('toggled');
                });
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-mdb-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new mdb.Tooltip(tooltipTriggerEl);
            });

            // Initialize charts
            if (typeof initCharts === 'function') {
                initCharts();
            }

            // Ajustar altura del contenido cuando se abre/cierra el sidebar
            const sidebar = document.getElementById('sidebar-wrapper');
            if (sidebar) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'style') {
                            window.dispatchEvent(new Event('resize'));
                        }
                    });
                });

                observer.observe(sidebar, {
                    attributes: true,
                    attributeFilter: ['style']
                });
            }
        });

        // Manejar redimensionamiento de ventana
        window.addEventListener('resize', function() {
            const wrapper = document.getElementById('wrapper');
            if (wrapper) {
                if (window.innerWidth < 992) {
                    wrapper.classList.add('toggled');
                } else {
                    wrapper.classList.remove('toggled');
                }
            }
        });

        // Inicializar al cargar
        window.addEventListener('load', function() {
            const wrapper = document.getElementById('wrapper');
            if (wrapper && window.innerWidth < 992) {
                wrapper.classList.add('toggled');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
