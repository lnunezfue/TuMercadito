<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-cart4"></i> Gestionar Productos</h2>
        <a href="<?php echo URLROOT; ?>/admin/addProduct" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Añadir Producto</a>
    </div>
    <?php flash('product_message'); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Unidad</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['products'] as $product): ?>
            <tr>
                <td><?php echo $product->id_producto; ?></td>
                <td><?php echo $product->nombre; ?></td>
                <td><?php echo $product->unidad_medida; ?></td>
                <td><?php echo $product->categoria; ?></td>
                <td>
                    <a href="<?php echo URLROOT; ?>/admin/editProduct/<?php echo $product->id_producto; ?>" class="btn btn-secondary btn-sm">Editar</a>
                    <form class="d-inline" action="<?php echo URLROOT; ?>/admin/deleteProduct/<?php echo $product->id_producto; ?>" method="post">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto? Se borrarán todos sus precios asociados.')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
