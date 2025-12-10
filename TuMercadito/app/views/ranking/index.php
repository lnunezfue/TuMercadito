<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-petroleum mb-2"><i class="fas fa-trophy me-2 text-warning"></i>Ranking de Precios</h2>
        <p class="text-muted">Descubre dónde comprar cada producto al mejor precio.</p>
    </div>

    <!-- Buscador -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <form action="<?php echo URLROOT; ?>/ranking" method="post" class="row g-3 align-items-center">
                    <div class="col-md-9">
                        <select name="product_id" id="product_id" class="form-select form-select-lg bg-light border-0">
                            <option disabled selected>Buscar producto...</option>
                            <?php foreach($data['products'] as $product): ?>
                                <option value="<?php echo $product->id_producto; ?>">
                                    <?php echo $product->nombre; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-warning btn-lg w-100 rounded-3 shadow-sm text-white fw-bold">
                            <i class="fas fa-search me-2"></i>Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <?php if (!empty($data['ranking'])): ?>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h4 class="mb-4 fw-bold text-petroleum">Top Precios: <span class="text-success"><?php echo $data['selected_product']; ?></span></h4>
            
            <div class="list-group shadow-sm rounded-4 overflow-hidden border-0">
                <?php $rank = 1; foreach($data['ranking'] as $item): ?>
                    <div class="list-group-item list-group-item-action p-4 border-0 border-bottom d-flex align-items-center">
                        <div class="me-4 d-flex align-items-center justify-content-center rounded-circle 
                            <?php echo ($rank == 1) ? 'bg-warning text-white' : 'bg-light text-muted'; ?>" 
                            style="width: 40px; height: 40px; font-weight: bold;">
                            <?php echo $rank++; ?>
                        </div>
                        
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-bold text-dark"><?php echo $item->nombre_mercado; ?></h5>
                            <small class="text-muted">Precio por Unidad/Kg</small>
                        </div>
                        
                        <div class="text-end">
                            <span class="badge bg-success rounded-pill px-3 py-2 fs-6">S/ <?php echo number_format($item->precio, 2); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="alert alert-warning text-center rounded-4 border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>No se encontraron precios registrados para este producto.
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .form-select:focus { box-shadow: 0 0 0 4px rgba(241, 196, 15, 0.2); background-color: #fff !important; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>