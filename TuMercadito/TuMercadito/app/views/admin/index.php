<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="dashboard-container container-fluid py-5">
    <!-- Encabezado de Bienvenida -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="welcome-banner p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-6 fw-bold text-white mb-2">Panel de Control</h1>
                    <p class="text-white-50 mb-0">Bienvenido, gestiona todo tu mercado desde un solo lugar.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="fas fa-chart-pie fa-3x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Tarjetas -->
    <div class="row g-4">
        <!-- Tarjeta Precios -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-soft text-warning rounded-4 p-3">
                            <i class="fas fa-tags fa-lg"></i>
                        </div>
                        <div class="ms-auto">
                            <i class="fas fa-arrow-up text-success small"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-petroleum">Gestionar Precios</h5>
                    <p class="text-muted small mb-4">Actualiza costos y monitorea variaciones en tiempo real.</p>
                    <a href="<?php echo URLROOT; ?>/admin/precios" class="btn btn-link text-warning fw-bold p-0 text-decoration-none">
                        Acceder <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Productos -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success-soft text-success rounded-4 p-3">
                            <i class="fas fa-box-open fa-lg"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-petroleum">Gestionar Productos</h5>
                    <p class="text-muted small mb-4">Inventario, categorías y detalles de productos.</p>
                    <a href="<?php echo URLROOT; ?>/admin/productos" class="btn btn-link text-success fw-bold p-0 text-decoration-none">
                        Acceder <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Mercados -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-petroleum-soft text-petroleum rounded-4 p-3">
                            <i class="fas fa-store fa-lg"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-petroleum">Gestionar Mercados</h5>
                    <p class="text-muted small mb-4">Administración de sucursales y ubicaciones.</p>
                    <a href="<?php echo URLROOT; ?>/admin/mercados" class="btn btn-link text-petroleum fw-bold p-0 text-decoration-none">
                        Acceder <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Usuarios -->
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-info-soft text-info rounded-4 p-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-petroleum">Gestionar Usuarios</h5>
                    <p class="text-muted small mb-4">Control de acceso, roles y permisos del sistema.</p>
                    <a href="<?php echo URLROOT; ?>/admin/usuarios" class="btn btn-link text-info fw-bold p-0 text-decoration-none">
                        Acceder <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Paleta de Colores Personalizada */
    :root {
        --color-petroleum: #34495E;
        --color-green: #2ECC71;
        --color-yellow: #F1C40F;
        --bg-light: #F5F6F7;
    }
    
    body { background-color: var(--bg-light); font-family: 'Poppins', sans-serif; }
    
    .welcome-banner {
        background: linear-gradient(135deg, var(--color-petroleum) 0%, #2c3e50 100%);
        border-radius: 20px;
        box-shadow: 0 10px 20px -5px rgba(52, 73, 94, 0.4);
    }

    .text-petroleum { color: var(--color-petroleum); }
    .bg-petroleum-soft { background-color: rgba(52, 73, 94, 0.1); }
    
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); }
    .bg-warning-soft { background-color: rgba(241, 196, 15, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }

    .card { border-radius: 16px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>