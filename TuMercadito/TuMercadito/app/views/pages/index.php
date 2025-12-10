<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="hero-section d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <i class="fas fa-shopping-basket fa-4x text-success mb-3"></i>
                </div>
                <h1 class="display-4 fw-bold text-petroleum mb-3"><?php echo $data['title']; ?></h1>
                <p class="lead text-muted mb-5"><?php echo $data['description']; ?> Comienza a planificar tus compras de manera eficiente y ahorra en cada visita al mercado.</p>
                
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a class="btn btn-success btn-lg px-5 shadow-sm rounded-pill fw-bold" href="<?php echo URLROOT; ?>/users/register" role="button">
                        Regístrate Gratis
                    </a>
                    <a class="btn btn-outline-secondary btn-lg px-5 rounded-pill fw-bold" href="<?php echo URLROOT; ?>/users/login" role="button">
                        Inicia Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-section {
        min-height: 80vh;
        background: linear-gradient(180deg, #f5f6f756 0%, #ffffff27 100%);
    }
    .text-petroleum { color: #34495E; }
    .btn-success { background-color: #2ECC71; border-color: #2ECC71; }
    .btn-success:hover { background-color: #27ae60; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>