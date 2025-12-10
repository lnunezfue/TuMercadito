<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo URLROOT; ?>/admin/mercados" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left text-muted mt-2"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-petroleum mb-0">Editar Mercado</h2>
                    <p class="text-muted small mb-0">Modificando información de: <strong><?php echo $data['nombre']; ?></strong></p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <form action="<?php echo URLROOT; ?>/admin/editMarket/<?php echo $data['id_mercado']; ?>" method="post">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nombre del Mercado</label>
                            <input type="text" name="nombre" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['nombre']; ?>">
                            <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Distrito</label>
                                <input type="text" name="distrito" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['distrito']; ?>">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Teléfono</label>
                                <input type="text" name="telefono" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['telefono']; ?>">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-muted small text-uppercase">Dirección</label>
                            <input type="text" name="direccion" class="form-control form-control-lg bg-light border-0" 
                                   value="<?php echo $data['direccion']; ?>">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-petroleum btn-lg py-3 rounded-3 shadow-sm">
                                <i class="fas fa-sync-alt me-2"></i>Actualizar Datos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-petroleum: #34495E; }
    body { background-color: #F5F6F7; font-family: 'Poppins', sans-serif; }
    .text-petroleum { color: var(--color-petroleum); }
    .form-control { border-radius: 12px !important; padding: 15px; }
    .form-control:focus { box-shadow: 0 0 0 4px rgba(52, 73, 94, 0.1); background-color: #fff !important; }
    .btn-petroleum { background-color: var(--color-petroleum); color: white; border: none; font-weight: 600; }
    .btn-petroleum:hover { background-color: #2c3e50; color: white; transform: translateY(-2px); }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>