<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo URLROOT; ?>/admin/mercados" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left text-muted mt-2"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-petroleum mb-0">Añadir Mercado</h2>
                    <p class="text-muted small mb-0">Registra un nueva sucursal en el sistema.</p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <form action="<?php echo URLROOT; ?>/admin/addMarket" method="post">
                        <!-- Nombre -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nombre del Mercado</label>
                            <input type="text" name="nombre" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['nombre']; ?>" placeholder="Ej: Mercado Central">
                            <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                        </div>

                        <div class="row">
                            <!-- Distrito -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Distrito</label>
                                <input type="text" name="distrito" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['distrito']; ?>" placeholder="Ej: Miraflores">
                            </div>
                            <!-- Teléfono -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Teléfono</label>
                                <input type="text" name="telefono" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['telefono']; ?>" placeholder="+51 999 999 999">
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="mb-5">
                            <label class="form-label fw-bold text-muted small text-uppercase">Dirección Completa</label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                <input type="text" name="direccion" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['direccion']; ?>" placeholder="Av. Principal 123">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-petroleum btn-lg py-3 rounded-3 shadow-sm">
                                <i class="fas fa-save me-2"></i>Guardar Mercado
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
    
    .form-control, .input-group-text {
        border-radius: 12px !important;
        padding: 15px;
        transition: 0.3s;
    }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(52, 73, 94, 0.1);
        border: 1px solid var(--color-petroleum) !important;
    }

    .btn-petroleum {
        background-color: var(--color-petroleum);
        color: white;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }
    .btn-petroleum:hover {
        background-color: #2c3e50;
        transform: translateY(-2px);
        color: white;
    }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>