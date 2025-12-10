<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo URLROOT; ?>/admin/productos" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left text-muted mt-2"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-petroleum mb-0">Editar Producto</h2>
                    <p class="text-muted small mb-0">Modificando: <strong><?php echo $data['nombre']; ?></strong></p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <form action="<?php echo URLROOT; ?>/admin/editProduct/<?php echo $data['id_producto']; ?>" method="post">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['nombre']; ?>">
                            <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Unidad de Medida</label>
                                <input type="text" name="unidad_medida" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['unidad_medida']; ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Categoría</label>
                                <input type="text" name="categoria" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['categoria']; ?>">
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-green btn-lg py-3 rounded-3 shadow-sm">
                                <i class="fas fa-sync-alt me-2"></i>Actualizar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-petroleum: #34495E; --color-green: #2ECC71; }
    body { background-color: #F5F6F7; font-family: 'Poppins', sans-serif; }
    .text-petroleum { color: var(--color-petroleum); }
    .form-control { border-radius: 12px !important; padding: 15px; }
    .form-control:focus { box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1); background-color: #fff !important; }
    .btn-green { background-color: var(--color-green); color: white; border: none; font-weight: 600; }
    .btn-green:hover { background-color: #27ae60; color: white; transform: translateY(-2px); }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>