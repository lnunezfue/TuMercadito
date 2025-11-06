<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <h2><i class="bi bi-person-circle"></i> Mi Perfil</h2>
            <div class="card">
                <div class="card-body">
                    <p><strong>Nombre:</strong> <?php echo $data['user']->nombre; ?></p>
                    <p><strong>Email:</strong> <?php echo $data['user']->email; ?></p>
                    <p><strong>Rol:</strong> <?php echo ucfirst($data['user']->rol); ?></p>
                    <p><strong>Miembro desde:</strong> <?php echo date("d/m/Y", strtotime($data['user']->fecha_registro)); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h2><i class="bi bi-key-fill"></i> Cambiar Contraseña</h2>
            <div class="card">
                <div class="card-body">
                    <?php flash('profile_message'); ?>
                    <form action="<?php echo URLROOT; ?>/users/profile" method="post">
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña:</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña:</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
