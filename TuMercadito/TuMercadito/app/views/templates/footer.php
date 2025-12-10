</div> 
    <!-- Cierre del div principal:
         - .main-content (Si está logueado)
         - .container-fluid (Si es visitante)
    -->

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js (Para gráficos) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Scripts Propios -->
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>

    <!-- Script para cerrar sidebar en móvil al hacer click fuera (opcional) -->
    <script>
        document.addEventListener('click', function(event) {
            var sidebar = document.querySelector('.sidebar');
            var toggler = document.querySelector('.mobile-toggler');
            if (window.innerWidth < 992 && sidebar && !sidebar.contains(event.target) && !toggler.contains(event.target)) {
                sidebar.style.transform = 'translateX(-100%)';
            }
        });
    </script>
</body>
</html>