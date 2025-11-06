<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php flash('register_success'); ?>
            <h2>Iniciar Sesión</h2>
            <p>Ingresa tus credenciales para acceder.</p>
            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                <div class="form-group mb-3">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Contraseña: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <input type="submit" value="Iniciar Sesión" class="btn btn-success w-100">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light w-100">¿No tienes cuenta? Regístrate</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
