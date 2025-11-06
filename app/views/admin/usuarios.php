<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill"></i> Gestionar Usuarios</h2>
    </div>
    <?php flash('user_message'); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol Actual</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['users'] as $user): ?>
            <tr>
                <td><?php echo $user->id_usuario; ?></td>
                <td><?php echo $user->nombre; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php echo ucfirst($user->rol); ?></td>
                <td>
                    <form class="d-inline-flex align-items-center" action="<?php echo URLROOT; ?>/admin/changeRole/<?php echo $user->id_usuario; ?>" method="post">
                        <select name="rol" class="form-select form-select-sm me-2" style="width: 120px;">
                            <option value="usuario" <?php echo ($user->rol == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                            <option value="admin" <?php echo ($user->rol == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        <button type="submit" class="btn btn-info btn-sm">Cambiar</button>
                    </form>
                    <form class="d-inline" action="<?php echo URLROOT; ?>/admin/deleteUser/<?php echo $user->id_usuario; ?>" method="post">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
