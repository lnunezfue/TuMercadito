<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-shop-window"></i> Gestionar Mercados</h2>
        <a href="<?php echo URLROOT; ?>/admin/addMarket" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Añadir Mercado</a>
    </div>
    <?php flash('market_message'); ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Distrito</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['markets'] as $market): ?>
            <tr>
                <td><?php echo $market->id_mercado; ?></td>
                <td><?php echo $market->nombre; ?></td>
                <td><?php echo $market->distrito; ?></td>
                <td><?php echo $market->direccion; ?></td>
                <td>
                    <a href="<?php echo URLROOT; ?>/admin/editMarket/<?php echo $market->id_mercado; ?>" class="btn btn-secondary btn-sm">Editar</a>
                    <form class="d-inline" action="<?php echo URLROOT; ?>/admin/deleteMarket/<?php echo $market->id_mercado; ?>" method="post">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro? Se borrarán todos los precios y favoritos asociados a este mercado.')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
