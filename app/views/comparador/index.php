<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-4">
            <h2><i class="bi bi-basket"></i> Mi Lista de Compras</h2>
            <p>Selecciona los productos y la cantidad que deseas comparar.</p>
            <form action="<?php echo URLROOT; ?>/comparador" method="post">
                <div id="product-list">
                    <div class="product-item input-group mb-3">
                        <select name="products[]" class="form-select">
                            <option selected disabled>Elige un producto...</option>
                            <?php foreach($data['products'] as $product): ?>
                                <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="number" class="form-control" name="quantities[<?php echo str_replace('.', '_', $product->nombre); ?>]" value="1" min="1" placeholder="Cant.">
                    </div>
                </div>

                <button type="button" id="add-product" class="btn btn-secondary mb-3"><i class="bi bi-plus-circle"></i> Añadir Producto</button>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Comparar Precios</button>
            </form>
        </div>

        <div class="col-lg-8">
            <h2><i class="bi bi-table"></i> Resultados de la Comparación</h2>
            <?php if (!empty($data['results'])): ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">¡Recomendación! <i class="bi bi-trophy-fill"></i></h4>
                    <p>El mercado más económico para tu lista es <strong><?php echo $data['recommendation']['market']; ?></strong> con un total de <strong>S/ <?php echo number_format($data['recommendation']['total'], 2); ?></strong>.</p>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Producto</th>
                            <?php foreach(array_keys($data['results']) as $marketName): ?>
                                <th><?php echo $marketName; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $allProducts = [];
                        foreach ($data['results'] as $market => $products) {
                            $allProducts = array_merge($allProducts, array_keys($products));
                        }
                        $uniqueProducts = array_unique($allProducts);
                        sort($uniqueProducts);
                        ?>
                        <?php foreach($uniqueProducts as $productName): ?>
                            <tr>
                                <td><?php echo $productName; ?></td>
                                <?php foreach($data['results'] as $marketName => $products): ?>
                                    <td>
                                        <?php 
                                        if (isset($products[$productName])) {
                                            echo 'S/ ' . number_format($products[$productName], 2);
                                        } else {
                                            echo '<span class="text-muted">No disponible</span>';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-group-divider">
                        <tr>
                            <th class="fs-5">TOTAL</th>
                            <?php foreach($data['totals'] as $total): ?>
                                <th class="fs-5 text-danger">S/ <?php echo number_format($total, 2); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                   Selecciona al menos un producto de la lista y haz clic en "Comparar Precios" para ver los resultados aquí.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div id="product-template" style="display: none;">
    <div class="product-item input-group mb-3">
        <select name="products[]" class="form-select">
            <option selected disabled>Elige un producto...</option>
            <?php foreach($data['products'] as $product): ?>
                <option value="<?php echo $product->id_producto; ?>"><?php echo $product->nombre; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" class="form-control" name="quantities[<?php echo str_replace('.', '_', $product->nombre); ?>]" value="1" min="1" placeholder="Cant.">
        <button class="btn btn-outline-danger remove-product" type="button"><i class="bi bi-trash"></i></button>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
