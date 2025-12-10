<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <!-- Bienvenida -->
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="fw-bold text-petroleum">Hola, <?php echo $_SESSION['user_name']; ?> 👋</h1>
            <p class="text-muted">Bienvenido a tu panel personal de ahorro.</p>
        </div>
    </div>
    
    <!-- Bloque Destacado Comparador -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
        <div class="row g-0">
            <div class="col-md-8 p-5">
                <span class="badge bg-success-soft text-success mb-2 px-3 py-2 rounded-pill">Herramienta Principal</span>
                <h2 class="fw-bold text-petroleum mb-3">Comparador de Precios Inteligente</h2>
                <p class="text-muted fs-5 mb-4">Crea tu lista de compras y descubre al instante en qué mercado gastarás menos dinero hoy.</p>
                <a class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow-sm" href="<?php echo URLROOT; ?>/comparador">
                    <i class="fas fa-search me-2"></i>Ir al Comparador
                </a>
            </div>
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-5">
                <i class="fas fa-balance-scale fa-8x text-success opacity-25"></i>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 hover-card">
                <div class="icon-box bg-primary-soft text-primary rounded-circle mb-3">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
                <h5 class="fw-bold">Ver Gráficos</h5>
                <p class="text-muted small">Analiza la tendencia de precios históricos.</p>
                <a href="<?php echo URLROOT; ?>/graficos" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 hover-card">
                <div class="icon-box bg-warning-soft text-warning rounded-circle mb-3">
                    <i class="fas fa-trophy fa-lg"></i>
                </div>
                <h5 class="fw-bold">Ranking de Precios</h5>
                <p class="text-muted small">Descubre dónde venden más barato cada producto.</p>
                <a href="<?php echo URLROOT; ?>/ranking" class="stretched-link"></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 rounded-4 hover-card">
                <div class="icon-box bg-petroleum-soft text-petroleum rounded-circle mb-3">
                    <i class="fas fa-store fa-lg"></i>
                </div>
                <h5 class="fw-bold">Mercados Favoritos</h5>
                <p class="text-muted small">Gestiona tus lugares de compra preferidos.</p>
                <a href="<?php echo URLROOT; ?>/mercados" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>

<style>
    .text-petroleum { color: #0b253eff; }
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-petroleum-soft { background-color: rgba(52, 73, 94, 0.1); }
    .text-petroleum { color: #111d29ff; }
    
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; }
    .hover-card { transition: transform 0.3s; }
    .hover-card:hover { transform: translateY(-5px); }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>