<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Columna Izquierda: Formulario -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h4 class="fw-bold text-petroleum mb-1"><i class="fas fa-shopping-basket me-2"></i>Mi Lista</h4>
                    <p class="text-muted small">Arma tu canasta para comparar.</p>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo URLROOT; ?>/comparador" method="post">
                        <div id="product-list" class="mb-3">
                            <div class="product-item mb-2">
                                <div class="input-group">
                                    <select name="products[]" class="form-select bg-light border-0">
                                        <option selected disabled>Producto...</option>
                                        <?php foreach($data['products'] as $product): ?>
                                            <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" class="form-control bg-light border-0 text-center" style="max-width: 70px;" name="quantities[<?php echo str_replace('.', '_', $product->nombre); ?>]" value="1" min="1" placeholder="Cant.">
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-product" class="btn btn-light w-100 text-muted fw-bold mb-3 border-dashed">
                            <i class="fas fa-plus-circle me-2"></i>Agregar Otro
                        </button>
                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm rounded-3">
                            <i class="fas fa-search me-2"></i>Comparar Precios
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Resultados -->
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <h3 class="fw-bold text-petroleum mb-0"><i class="fas fa-chart-bar me-2"></i>Resultados</h3>
            </div>

            <?php if (!empty($data['results'])): ?>
                <!-- Tarjeta de Recomendación -->
                <div class="card border-0 shadow-sm rounded-4 bg-petroleum text-white mb-4 overflow-hidden position-relative">
                    <div class="card-body p-4 position-relative z-1">
                        <h6 class="text-uppercase text-success fw-bold mb-2">Mejor Opción de Compra</h6>
                        <h2 class="fw-bold mb-1"><?php echo $data['recommendation']['market']; ?></h2>
                        <h1 class="display-4 fw-bold text-success">S/ <?php echo number_format($data['recommendation']['total'], 2); ?></h1>
                        <p class="mb-0 text-white-50">Es el mercado más económico para tu lista actual.</p>
                    </div>
                    <i class="fas fa-trophy position-absolute text-white opacity-10" style="font-size: 150px; right: -20px; bottom: -20px;"></i>
                </div>

                <!-- Tabla Detallada -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary text-uppercase small">Producto</th>
                                    <?php foreach(array_keys($data['results']) as $marketName): ?>
                                        <th class="py-3 text-center text-secondary text-uppercase small"><?php echo $marketName; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $allProducts = [];
                                foreach ($data['results'] as $market => $products) $allProducts = array_merge($allProducts, array_keys($products));
                                $uniqueProducts = array_unique($allProducts);
                                sort($uniqueProducts);
                                ?>
                                <?php foreach($uniqueProducts as $productName): ?>
                                    <tr>
                                        <td class="ps-4 fw-semibold text-petroleum"><?php echo $productName; ?></td>
                                        <?php foreach($data['results'] as $marketName => $products): ?>
                                            <td class="text-center">
                                                <?php if (isset($products[$productName])): ?>
                                                    <span class="badge bg-light text-dark border">S/ <?php echo number_format($products[$productName], 2); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="bg-light border-top">
                                <tr>
                                    <th class="ps-4 py-3 fw-bold text-petroleum">TOTAL</th>
                                    <?php foreach($data['totals'] as $total): ?>
                                        <th class="text-center py-3 fw-bold text-success fs-5">S/ <?php echo number_format($total, 2); ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-basket-shopping fa-3x text-muted mb-3 opacity-50"></i>
                    <p class="text-muted">Añade productos a tu lista para ver la comparativa aquí.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Template oculto JS -->
<div id="product-template" style="display: none;">
    <div class="product-item input-group mb-2">
        <select name="products[]" class="form-select bg-light border-0">
            <option selected disabled>Producto...</option>
            <?php foreach($data['products'] as $product): ?>
                <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" class="form-control bg-light border-0 text-center" style="max-width: 70px;" name="quantities[<?php echo str_replace('.', '_', $product->nombre); ?>]" value="1" min="1" placeholder="Cant.">
        <button class="btn btn-outline-danger border-0 remove-product" type="button"><i class="fas fa-times"></i></button>
    </div>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .bg-petroleum { background-color: #34495E; }
    .border-dashed { border: 2px dashed #dee2e6; }
    .form-select:focus, .form-control:focus { box-shadow: none; border: 1px solid #2ECC71 !important; background: #fff !important; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>