<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-4">
    
    <!-- Header Perfil -->
    <div class="d-flex align-items-center mb-5">
        <div class="bg-petroleum text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm me-4" style="width: 80px; height: 80px; font-size: 2rem;">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h2 class="fw-bold text-petroleum mb-0"><?php echo $data['user']->nombre; ?></h2>
            <p class="text-muted mb-0"><?php echo $data['user']->email; ?></p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Tarjeta de Información -->
        <div class="col-lg-5">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-petroleum mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Detalles de la Cuenta</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small fw-bold text-uppercase">Rol de Usuario</span>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <?php echo ucfirst($data['user']->rol); ?>
                            </span>
                        </li>
                        <li class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-bold text-uppercase">Miembro Desde</span>
                            <span class="fw-semibold text-petroleum">
                                <?php echo date("d/m/Y", strtotime($data['user']->fecha_registro)); ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tarjeta Cambio de Contraseña -->
        <div class="col-lg-7">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-petroleum mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i>Seguridad</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php flash('profile_message'); ?>

                    <form action="<?php echo URLROOT; ?>/users/profile" method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-bold small text-muted text-uppercase">Nueva Contraseña</label>
                                <input type="password" name="new_password" class="form-control bg-light border-0 py-2" required placeholder="••••••">
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label fw-bold small text-muted text-uppercase">Confirmar</label>
                                <input type="password" name="confirm_password" class="form-control bg-light border-0 py-2" required placeholder="••••••">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-petroleum px-4 rounded-pill shadow-sm fw-bold">
                                <i class="fas fa-save me-2"></i>Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .bg-petroleum { background-color: #34495E; }
    .btn-petroleum { background-color: #34495E; color: white; border: none; transition: 0.3s; }
    .btn-petroleum:hover { background-color: #2c3e50; transform: translateY(-2px); color: white; }
    .form-control:focus { box-shadow: none; background-color: #fff !important; border: 1px solid #34495E !important; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>