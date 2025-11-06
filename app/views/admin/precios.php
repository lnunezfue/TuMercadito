<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <h2><i class="bi bi-tags-fill"></i> Gestión de Precios</h2>
    <p>Selecciona un producto y un mercado para actualizar su precio.</p>
    <?php flash('price_update_success'); ?>
    <?php flash('price_update_fail'); ?>
    <div class="card card-body">
        <form action="<?php echo URLROOT; ?>/admin/precios" method="post">
            <div class="row g-3">
                <div class="col-md-5">
                    <label for="product_id" class="form-label">Producto</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="" disabled selected>-- Elige un producto --</option>
                        <?php foreach($data['products'] as $product): ?>
                            <option value="<?php echo $product->id_producto; ?>">
                                <?php echo $product->nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="market_id" class="form-label">Mercado</label>
                    <select name="market_id" id="market_id" class="form-select" required>
                        <option value="" disabled selected>-- Elige un mercado --</option>
                        <?php foreach($data['markets'] as $market): ?>
                            <option value="<?php echo $market->id_mercado; ?>">
                                <?php echo $market->nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="new_price" class="form-label">Nuevo Precio (S/)</label>
                    <input type="text" name="new_price" class="form-control" placeholder="Ej: 9.50" required>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat"></i> Actualizar Precio
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
