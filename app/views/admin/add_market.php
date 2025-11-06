<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="col-md-8 mx-auto">
        <h2>Añadir Nuevo Mercado</h2>
        <div class="card card-body">
            <form action="<?php echo URLROOT; ?>/admin/addMarket" method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Mercado: <sup>*</sup></label>
                    <input type="text" name="nombre" class="form-control <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['nombre']; ?>">
                    <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                </div>
                <div class="mb-3">
                    <label for="distrito" class="form-label">Distrito:</label>
                    <input type="text" name="distrito" class="form-control" value="<?php echo $data['distrito']; ?>">
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" name="direccion" class="form-control" value="<?php echo $data['direccion']; ?>">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" name="telefono" class="form-control" value="<?php echo $data['telefono']; ?>">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Guardar Mercado</button>
                    <a href="<?php echo URLROOT; ?>/admin/mercados" class="btn btn-light">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
