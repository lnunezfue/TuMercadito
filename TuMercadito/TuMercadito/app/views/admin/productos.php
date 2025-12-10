<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container-fluid py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-petroleum mb-0"><i class="fas fa-box-open me-2"></i>Productos</h2>
            <p class="text-muted small mt-1">Catálogo general de items disponibles.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="<?php echo URLROOT; ?>/admin/addProduct" class="btn btn-custom-green shadow-sm">
                <i class="fas fa-plus me-2"></i>Nuevo Producto
            </a>
        </div>
    </div>

    <?php flash('product_message'); ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">ID</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Producto</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Unidad</th>
                            <th class="py-3 text-uppercase text-muted small fw-bold">Categoría</th>
                            <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['products'] as $product): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-petroleum">#<?php echo $product->id_producto; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success-soft text-success rounded-circle me-3">
                                        <i class="fas fa-carrot"></i>
                                    </div>
                                    <span class="fw-semibold text-dark"><?php echo $product->nombre; ?></span>
                                </div>
                            </td>
                            <td><span class="text-muted small bg-light px-2 py-1 rounded"><?php echo $product->unidad_medida; ?></span></td>
                            <td><span class="badge bg-petroleum text-white rounded-pill px-3"><?php echo $product->categoria; ?></span></td>
                            <td class="pe-4 text-end">
                                <a href="<?php echo URLROOT; ?>/admin/editProduct/<?php echo $product->id_producto; ?>" class="btn btn-icon btn-light text-petroleum me-1">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="<?php echo URLROOT; ?>/admin/deleteProduct/<?php echo $product->id_producto; ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-icon btn-light text-danger" onclick="return confirm('¿Eliminar producto?')">
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
    .bg-petroleum { background-color: var(--color-petroleum); }
    .bg-success-soft { background-color: rgba(46, 204, 113, 0.1); }
    .text-success { color: var(--color-green) !important; }

    .btn-custom-green {
        background-color: var(--color-green);
        color: white;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
        transition: 0.2s;
    }
    .btn-custom-green:hover { background-color: #27ae60; transform: translateY(-2px); color: white;}
    .btn-icon { width: 35px; height: 35px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; }
    .avatar-sm { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>