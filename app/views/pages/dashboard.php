<?php require APPROOT . '/views/templates/header.php'; ?>
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenido, <?php echo $_SESSION['user_name']; ?></h1>
            <p>Este es tu panel de control. Desde aquí podrás acceder a todas las funcionalidades de TuMercadito.</p>
        </div>
    </div>
    
    <div class="p-5 mb-4 bg-light rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Comparador de Precios</h1>
        <p class="col-md-8 fs-4">Crea tu lista de compras y descubre en qué mercado te conviene más comprar para maximizar tu ahorro.</p>
        <a class="btn btn-primary btn-lg" href="<?php echo URLROOT; ?>/comparador">Ir al Comparador</a>
      </div>
    </div>

<?php require APPROOT . '/views/templates/footer.php'; ?>
