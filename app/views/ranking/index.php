<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bar-chart-line-fill"></i> Ranking de Precios por Producto</h2>
    </div>
    <div class="card card-body">
        <form action="<?php echo URLROOT; ?>/ranking" method="post" class="row g-3 align-items-end">
            <div class="col-md-8">
                <label for="product_id" class="form-label">Selecciona un producto para ver su ranking:</label>
                <select name="product_id" id="product_id" class="form-select form-select-lg">
                    <option disabled selected>Elige un producto...</option>
                    <?php foreach($data['products'] as $product): ?>
                        <option value="<?php echo $product->id_producto; ?>">
                            <?php echo $product->nombre; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-lg w-100">Ver Ranking</button>
            </div>
        </form>
    </div>
    <?php if (!empty($data['ranking'])): ?>
    <div class="mt-5">
        <h3>Ranking para: <span class="text-primary"><?php echo $data['selected_product']; ?></span></h3>
        <ul class="list-group list-group-numbered">
            <?php foreach($data['ranking'] as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold fs-5"><?php echo $item->nombre_mercado; ?></div>
                        <small>Precio por unidad/Kg</small>
                    </div>
                    <span class="badge bg-success rounded-pill fs-4">S/ <?php echo number_format($item->precio, 2); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <div class="alert alert-warning mt-5" role="alert">
        No se encontraron precios para el producto seleccionado.
    </div>
    <?php endif; ?>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
