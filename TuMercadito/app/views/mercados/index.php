<?php require APPROOT . '/views/templates/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-petroleum mb-1"><i class="fas fa-store me-2"></i><?php echo $data['title']; ?></h2>
            <p class="text-muted mb-0">Encuentra y guarda tus mercados favoritos.</p>
        </div>
    </div>
    
    <?php flash('market_message'); ?>
    
    <div class="row g-4">
        <?php if (empty($data['markets'])): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No hay mercados registrados en este momento.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['markets'] as $market): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-card">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="icon-box bg-petroleum-soft text-petroleum rounded-circle">
                                    <i class="fas fa-shop"></i>
                                </div>
                                <?php if($market->is_favorite): ?>
                                    <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>Favorito</span>
                                <?php endif; ?>
                            </div>
                            
                            <h5 class="card-title fw-bold text-petroleum mb-1"><?php echo $market->nombre; ?></h5>
                            <h6 class="card-subtitle mb-3 text-muted small"><?php echo $market->distrito; ?></h6>
                            
                            <p class="card-text text-muted small mb-4 flex-grow-1">
                                <i class="fas fa-map-marker-alt me-2 text-danger opacity-75"></i> 
                                <?php echo $market->direccion ?? 'Dirección no disponible'; ?>
                            </p>
                            
                            <a href="<?php echo URLROOT; ?>/mercados/toggleFavorite/<?php echo $market->id_mercado; ?>" 
                               class="btn w-100 rounded-pill fw-bold <?php echo ($market->is_favorite) ? 'btn-outline-warning' : 'btn-outline-secondary'; ?>">
                                <i class="fas <?php echo ($market->is_favorite) ? 'fa-star-half-alt' : 'fa-star'; ?> me-2"></i>
                                <?php echo ($market->is_favorite) ? 'Quitar Favorito' : 'Añadir Favorito'; ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .text-petroleum { color: #34495E; }
    .bg-petroleum-soft { background-color: rgba(52, 73, 94, 0.1); }
    .icon-box { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
    .hover-card { transition: transform 0.3s; }
    .hover-card:hover { transform: translateY(-5px); }
</style>

<?php require APPROOT . '/views/templates/footer.php'; ?>