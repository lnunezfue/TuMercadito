<?php require APPROOT . '/views/templates/header.php'; ?>
<div class="container py-4">
    <h2><i class="bi bi-shop"></i> <?php echo $data['title']; ?></h2>
    <p>Explora los mercados disponibles y guarda tus preferidos para un acceso rápido.</p>
    <?php flash('market_message'); ?>
    <div class="row">
        <?php if (empty($data['markets'])): ?>
            <div class="col">
                <p class="text-center">No hay mercados registrados en este momento.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['markets'] as $market): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $market->nombre; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $market->distrito; ?></h6>
                            <p class="card-text flex-grow-1">
                                <i class="bi bi-geo-alt-fill"></i> <?php echo $market->direccion ?? 'Dirección no disponible'; ?>
                            </p>
                            <a href="<?php echo URLROOT; ?>/mercados/toggleFavorite/<?php echo $market->id_mercado; ?>" class="btn <?php echo ($market->is_favorite) ? 'btn-warning' : 'btn-outline-warning'; ?>">
                                <i class="bi <?php echo ($market->is_favorite) ? 'bi-star-fill' : 'bi-star'; ?>"></i>
                                <?php echo ($market->is_favorite) ? 'Quitar de Favoritos' : 'Añadir a Favoritos'; ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
