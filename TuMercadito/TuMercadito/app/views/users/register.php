<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="d-flex align-items-center justify-content-center py-5">
    <div class="col-md-6 col-lg-5">
        
        <div class="text-center mb-4">
            <h2 class="fw-bold text-petroleum">Crear Cuenta</h2>
            <p class="text-muted">Únete a nosotros y empieza a ahorrar en tus compras.</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-sm-5">
                <form action="<?php echo URLROOT; ?>/users/register" method="post">
                    
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold small text-muted text-uppercase">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['nombre_err'])) ? 'is-invalid' : ''; ?>" 
                               value="<?php echo $data['nombre']; ?>" placeholder="Tu nombre">
                        <span class="invalid-feedback"><?php echo $data['nombre_err']; ?></span>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-muted text-uppercase">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                               value="<?php echo $data['email']; ?>" placeholder="tucorreo@ejemplo.com">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-bold small text-muted text-uppercase">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['password']; ?>" placeholder="••••••">
                            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                        </div>
                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label fw-bold small text-muted text-uppercase">Confirmar</label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg bg-light border-0 <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['confirm_password']; ?>" placeholder="••••••">
                            <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                        </div>
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        <input type="submit" value="Registrarse" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                        
                        <div class="text-center mt-2">
                            <span class="text-muted small">¿Ya tienes una cuenta?</span>
                            <a href="<?php echo URLROOT; ?>/users/login" class="text-success fw-bold text-decoration-none ms-1">Inicia Sesión</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .btn-success { background-color: #2ECC71; border-color: #2ECC71; }
    .btn-success:hover { background-color: #27ae60; border-color: #27ae60; }
    .form-control:focus { box-shadow: none; background-color: #fff !important; border: 1px solid #2ECC71 !important; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>