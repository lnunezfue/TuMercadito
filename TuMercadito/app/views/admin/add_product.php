<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?php echo URLROOT; ?>/admin/productos" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 45px; height: 45px;">
                    <i class="fas fa-arrow-left text-muted mt-2"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-petroleum mb-0">Añadir Producto</h2>
                    <p class="text-muted small mb-0">Ingresa los detalles del nuevo producto.</p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <form action="<?php echo URLROOT; ?>/admin/addProduct" method="post">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['nombre']; ?>" placeholder="Ej: Arroz Costeño">
                            <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Unidad de Medida</label>
                                <select name="unidad_medida" class="form-control form-control-lg bg-light border-0">
                                    <option value="kg">Kilogramo (kg)</option>
                                    <option value="lt">Litro (lt)</option>
                                    <option value="unid">Unidad</option>
                                    <option value="paq">Paquete</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Categoría</label>
                                <input type="text" name="categoria" class="form-control form-control-lg bg-light border-0" 
                                       value="<?php echo $data['categoria']; ?>" placeholder="Ej: Abarrotes">
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-green btn-lg py-3 rounded-3 shadow-sm">
                                <i class="fas fa-check me-2"></i>Guardar Producto
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
    
    .form-control {
        border-radius: 12px !important;
        padding: 15px;
        transition: 0.3s;
    }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        border: 1px solid var(--color-green) !important;
    }

    .btn-green {
        background-color: var(--color-green);
        color: white;
        font-weight: 600;
        border: none;
        transition: 0.3s;
    }
    .btn-green:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
        color: white;
    }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>