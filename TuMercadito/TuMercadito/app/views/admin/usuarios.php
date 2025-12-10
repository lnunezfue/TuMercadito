<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-12">
            <h2 class="fw-bold text-petroleum mb-0"><i class="fas fa-users me-2"></i>Usuarios</h2>
            <p class="text-muted small mt-1">Administración de accesos y roles.</p>
        </div>
    </div>

    <?php flash('user_message'); ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">ID</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Usuario</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Email</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Rol</th>
                            <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Gestión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['users'] as $user): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?php echo $user->id_usuario; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light text-secondary rounded-circle me-3 border">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="fw-semibold text-dark"><?php echo $user->nombre; ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?php echo $user->email; ?></td>
                            <td>
                                <?php if($user->rol == 'admin'): ?>
                                    <span class="badge bg-petroleum-soft text-petroleum border border-petroleum-soft px-3 py-2 rounded-pill">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Usuario</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <form action="<?php echo URLROOT; ?>/admin/changeRole/<?php echo $user->id_usuario; ?>" method="post" class="d-inline-flex align-items-center">
                                    <select name="rol" class="form-select form-select-sm me-2 border-0 bg-light" style="width: 100px; cursor: pointer;">
                                        <option value="usuario" <?php echo ($user->rol == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                                        <option value="admin" <?php echo ($user->rol == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-icon btn-light text-primary me-2" title="Guardar Rol">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="<?php echo URLROOT; ?>/admin/deleteUser/<?php echo $user->id_usuario; ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-icon btn-light text-danger" onclick="return confirm('¿Eliminar usuario?')" title="Eliminar">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    :root { --color-petroleum: #34495E; }
    body { background-color: #F5F6F7; font-family: 'Poppins', sans-serif; }
    
    .text-petroleum { color: var(--color-petroleum); }
    .bg-petroleum-soft { background-color: rgba(52, 73, 94, 0.1); }
    .border-petroleum-soft { border-color: rgba(52, 73, 94, 0.2) !important; }
    
    .btn-icon { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; }
    .avatar-sm { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>