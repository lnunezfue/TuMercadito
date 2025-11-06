<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="col-md-8 mx-auto">
        <h2>Añadir Nuevo Producto</h2>
        <div class="card card-body">
            <form action="<?php echo URLROOT; ?>/admin/addProduct" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto: <sup>*</sup></label>
                    <input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>">
                    <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="unidad_medida" class="form-label">Unidad de Medida:</label>
                    <input type="text" name="unidad_medida" class="form-control" value="<?php echo $data['unidad_medida']; ?>">
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <input type="text" name="categoria" class="form-control" value="<?php echo $data['categoria']; ?>">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                    <a href="<?php echo URLROOT; ?>/admin/productos" class="btn btn-light">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
