<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-yellow-soft rounded-circle mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-tags fa-2x text-warning"></i>
                </div>
                <h2 class="fw-bold text-petroleum">Actualizar Precio</h2>
                <p class="text-muted">Selecciona el producto y mercado para establecer un nuevo precio.</p>
            </div>

            <?php flash('price_update_success'); ?>
            <?php flash('price_update_fail'); ?>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <form action="<?php echo URLROOT; ?>/admin/precios" method="post">
                        
                        <!-- Selectores -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-petroleum">Producto</label>
                            <select name="product_id" class="form-select form-select-lg bg-light border-0 py-3" required>
                                <option value="" disabled selected>Seleccionar producto...</option>
                                <?php foreach($data['products'] as $product): ?>
                                    <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-petroleum">Mercado</label>
                            <select name="market_id" class="form-select form-select-lg bg-light border-0 py-3" required>
                                <option value="" disabled selected>Seleccionar mercado...</option>
                                <?php foreach($data['markets'] as $market): ?>
                                    <option value="<?php echo $market->id_mercado; ?>"><?php echo $market->nombre; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Input Precio Destacado -->
                        <div class="mb-5 position-relative">
                            <label class="form-label fw-bold text-petroleum">Nuevo Precio (S/)</label>
                            <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-warning text-white border-0 fw-bold px-4">S/</span>
                                <input type="text" name="new_price" class="form-control border-0 text-end fw-bold fs-4 text-petroleum" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg py-3 rounded-3 shadow text-white fw-bold">
                                <i class="fas fa-save me-2"></i>Actualizar Precio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-petroleum: #34495E; --color-yellow: #F1C40F; }
    body { background-color: #F5F6F7; font-family: 'Poppins', sans-serif; }

    .text-petroleum { color: var(--color-petroleum); }
    .text-warning { color: var(--color-yellow) !important; }
    .bg-warning { background-color: var(--color-yellow) !important; }
    .bg-yellow-soft { background-color: rgba(241, 196, 15, 0.15); }
    
    .form-select, .form-control {
        border-radius: 12px;
        transition: 0.3s;
    }
    .form-select:focus, .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(241, 196, 15, 0.2);
    }
    
    .btn-warning { transition: 0.3s; border: none; }
    .btn-warning:hover { background-color: #d4ac0d; transform: translateY(-2px); }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>