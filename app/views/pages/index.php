<?php require APPROOT . '/views/templates/header.php'; ?>
    <div class="jumbotron text-center">
        <div class="container">
            <h1 class="display-3"><?php echo $data['title']; ?></h1>
            <p class="lead"><?php echo $data['description']; ?></p>
            <hr class="my-4">
            <p>Comienza ahora a planificar tus compras de manera eficiente.</p>
            <a class="btn btn-primary btn-lg" href="<?php echo URLROOT; ?>/users/register" role="button">Regístrate</a>
            <a class="btn btn-secondary btn-lg" href="<?php echo URLROOT; ?>/users/login" role="button">Inicia Sesión</a>
        </div>
    </div>
<?php require APPROOT . '/views/templates/footer.php'; ?>
