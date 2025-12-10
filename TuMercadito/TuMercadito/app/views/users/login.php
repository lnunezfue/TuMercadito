<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4">
        
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-success-soft rounded-circle mb-3" style="width: 60px; height: 60px;">
                <i class="fas fa-user-lock fa-2x text-success"></i>
            </div>
            <h2 class="fw-bold text-petroleum">Bienvenido de nuevo</h2>
            <p class="text-muted">Ingresa tus credenciales para acceder a tu cuenta.</p>
        </div>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4 p-sm-5">
                <?php flash('register_success'); ?>
                
                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold small text-muted text-uppercase">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 ps-3"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0 py-3 <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['email']; ?>" placeholder="ejemplo@correo.com">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold small text-muted text-uppercase">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 ps-3"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0 py-3 <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                                   value="<?php echo $data['password']; ?>" placeholder="••••••••">
                            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                        </div>
                    </div>

                    <div class="d-grid gap-3 mt-5">
                        <input type="submit" value="Iniciar Sesión" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                        
                        <div class="text-center mt-2">
                            <span class="text-muted small">¿Aún no tienes cuenta?</span>
                            <a href="<?php echo URLROOT; ?>/users/register" class="text-success fw-bold text-decoration-none ms-1">Regístrate gratis</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?php echo URLROOT; ?>" class="text-muted small text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Volver al inicio
            </a>
        </div>
    </div>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); }
    .btn-success { background-color: #2ECC71; border-color: #2ECC71; }
    .btn-success:hover { background-color: #27ae60; border-color: #27ae60; }
    .form-control:focus { box-shadow: none; background-color: #fff !important; border: 1px solid #2ECC71 !important; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>