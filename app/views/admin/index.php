<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <h2><i class="bi bi-shield-lock-fill"></i> <?php echo $data['title']; ?></h2>
    <p>Bienvenido al panel de control. Desde aquí puedes gestionar el contenido del sitio.</p>

    <div class="list-group">
      <a href="<?php echo URLROOT; ?>/admin/precios" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Gestionar Precios</h5>
          <small><i class="bi bi-arrow-right"></i></small>
        </div>
        <p class="mb-1">Actualiza los precios de los productos en los diferentes mercados.</p>
      </a>
      <a href="<?php echo URLROOT; ?>/admin/productos" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Gestionar Productos</h5>
           <small><i class="bi bi-arrow-right"></i></small>
        </div>
        <p class="mb-1">Añadir, editar o eliminar productos del sistema.</p>
      </a>
      <a href="<?php echo URLROOT; ?>/admin/mercados" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Gestionar Mercados</h5>
           <small><i class="bi bi-arrow-right"></i></small>
        </div>
        <p class="mb-1">Añadir, editar o eliminar mercados.</p>
      </a>
       <a href="<?php echo URLROOT; ?>/admin/usuarios" class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">Gestionar Usuarios</h5>
           <small><i class="bi bi-arrow-right"></i></small>
        </div>
        <p class="mb-1">Ver usuarios, cambiar roles y eliminar cuentas.</p>
      </a>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
