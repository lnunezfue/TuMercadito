<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-petroleum mb-0"><i class="fas fa-store me-2"></i>Mercados</h2>
            <p class="text-muted small mt-1">Gestión de sucursales y puntos de venta.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="<?php echo URLROOT; ?>/admin/addMarket" class="btn btn-custom-green shadow-sm">
                <i class="fas fa-plus me-2"></i>Nuevo Mercado
            </a>
        </div>
    </div>

    <?php flash('market_message'); ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">ID</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Nombre</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Distrito</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Dirección</th>
                            <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['markets'] as $market): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-petroleum">#<?php echo $market->id_mercado; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-petroleum-soft text-petroleum rounded-circle me-3">
                                        <i class="fas fa-shop"></i>
                                    </div>
                                    <span class="fw-semibold text-dark"><?php echo $market->nombre; ?></span>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?php echo $market->distrito; ?></span></td>
                            <td class="text-muted small"><?php echo $market->direccion; ?></td>
                            <td class="pe-4 text-end">
                                <a href="<?php echo URLROOT; ?>/admin/editMarket/<?php echo $market->id_mercado; ?>" class="btn btn-icon btn-light text-petroleum me-1" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteMarket/<?php echo $market->id_mercado; ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-icon btn-light text-danger" onclick="return confirm('¿Eliminar este mercado?')" title="Eliminar">
                                        <i class="fas fa-trash"></i>
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
    :root { --color-green: #2ECC71; --color-petroleum: #34495E; }
    body { background-color: #F5F6F7; font-family: 'Poppins', sans-serif; }
    
    .text-petroleum { color: var(--color-petroleum); }
    .bg-petroleum-soft { background-color: rgba(52, 73, 94, 0.1); }
    
    .btn-custom-green {
        background-color: var(--color-green);
        color: white;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
        transition: all 0.2s;
    }
    .btn-custom-green:hover { background-color: #27ae60; transform: translateY(-2px); color: white;}

    .btn-icon { width: 35px; height: 35px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; }
    .btn-icon:hover { background-color: #e2e6ea; }
    
    .avatar-sm { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .table-hover tbody tr:hover { background-color: rgba(52, 73, 94, 0.02); }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>