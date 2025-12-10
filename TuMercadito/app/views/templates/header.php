<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>

    <!-- LIBRERÍAS MODERNAS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Compatibilidad -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">

    <style>
        /* --- PALETA DE COLORES PROFESIONAL --- */
        :root {
            --primary: #2ECC71;       /* Verde Principal */
            --primary-soft: rgba(46, 204, 113, 0.12);
            --petroleum: #34495E;     /* Azul Petróleo */
            --petroleum-dark: #2c3e50;
            --yellow: #F1C40F;        /* Alertas/Precios */
            --bg-body: #F5F6F7;       /* Fondo General */
            --white: #FFFFFF;
            --sidebar-width: 270px;   /* Un poco más ancho para elegancia */
            --shadow-soft: 0 4px 20px rgba(0,0,0,0.04);
            --shadow-hover: 0 10px 25px rgba(0,0,0,0.08);
        }

       body {
            background-color: var(--bg-body);
            
            /* IMAGEN DE FONDO CON FILTRO PROFESIONAL */
            background-image: 
                /* Capa 1: Filtro de color #f5f6f7ff con 93% de opacidad para que el texto se lea bien */
                linear-gradient(rgba(245, 246, 247, 0.58), rgba(245, 246, 247, 0.2)),
                /* Capa 2: Tu imagen */
                url('https://st3.depositphotos.com/1542745/14200/i/450/depositphotos_142004792-stock-photo-empty-wooden-table-with-blurred.jpg');
            
            /* Ajustes para que la imagen cubra todo y no se mueva al hacer scroll */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;

            font-family: 'Poppins', sans-serif;
            color: var(--petroleum);
            overflow-x: hidden;
        }
        /* --- SIDEBAR REFINADO --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--white);
            border-right: 1px solid rgba(0,0,0,0.03); /* Borde sutil en vez de sombra fuerte */
            box-shadow: 5px 0 25px rgba(0,0,0,0.02);
            z-index: 1050;
            padding: 30px 20px;
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--petroleum-dark);
            display: flex;
            align-items: center;
            margin-bottom: 50px;
            text-decoration: none;
            padding-left: 10px;
            letter-spacing: -0.5px;
        }
        
        .brand-logo i { color: var(--primary); font-size: 1.8rem; }

        .sidebar .nav-link {
            color: #7f8c8d;
            font-weight: 500;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 0.95rem;
            border: 1px solid transparent; /* Para evitar saltos al hover */
        }

        .sidebar .nav-link i { 
            width: 24px; 
            text-align: center; 
            margin-right: 14px; 
            font-size: 1.1rem;
            transition: 0.2s;
        }
        
        /* Efecto Hover */
        .sidebar .nav-link:hover {
            background-color: #fafbfc;
            color: var(--petroleum);
            transform: translateX(3px);
        }

        /* Link Activo (Estilo Material Design 3) */
        .sidebar .nav-link.active-nav {
            background-color: var(--primary-soft);
            color: var(--primary);
            font-weight: 600;
            border: 1px solid rgba(46, 204, 113, 0.1);
        }

        .sidebar .nav-link.active-nav i {
            color: var(--primary);
        }

        .menu-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #adb5bdff;
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 12px;
            padding-left: 18px;
        }

        /* --- CONTENIDO PRINCIPAL --- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px 40px;
            min-height: 100vh;
            transition: margin 0.3s ease;
        }

        /* --- TOPBAR FLOTANTE --- */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 15px 0;
            /* Efecto Glassmorphism opcional si haces scroll */
            background: transparent; 
        }

        /* --- TÍTULOS Y TEXTOS --- */
        h1, h2, h3, h4, h5 { font-weight: 700; letter-spacing: -0.5px; }
        .text-petroleum { color: var(--petroleum); }

        /* --- AVATAR --- */
        .user-avatar {
            width: 45px; 
            height: 45px; 
            border-radius: 50%;
            background: var(--white);
            color: var(--primary);
            font-size: 1.2rem;
            display: flex; 
            align-items: center; 
            justify-content: center;
            box-shadow: var(--shadow-soft);
            border: 2px solid var(--white);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); box-shadow: 5px 0 25px rgba(0,0,0,0.1); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .mobile-toggler { display: block !important; }
            .brand-logo { margin-bottom: 30px; }
        }
        .mobile-toggler { display: none; font-size: 1.6rem; cursor: pointer; color: var(--petroleum); transition: 0.2s;}
        .mobile-toggler:hover { color: var(--primary); }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1ff; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #bbb; }
    </style>
</head>
<body>

<?php 
    // Función helper simple para detectar URL activa
    function isActive($path) {
        $uri = $_SERVER['REQUEST_URI'];
        if ($path == '/' && ($uri == '/' || $uri == '/TuMercadito/' || $uri == '/TuMercadito/index')) return 'active-nav';
        if ($path != '/' && strpos($uri, $path) !== false) return 'active-nav';
        return '';
    }
?>

<?php if (isset($_SESSION['user_id'])): ?>
    <!-- ============================================================== -->
    <!-- DISEÑO DASHBOARD (Logueado)                                   -->
    <!-- ============================================================== -->

    <div class="sidebar" id="sidebar">
        <a href="<?php echo URLROOT; ?>" class="brand-logo">
            <i class="fas fa-shopping-basket me-3"></i> TuMercadito
        </a>
        
        <nav class="nav flex-column">
            
            <div class="menu-label">Principal</div>
            <a class="nav-link <?php echo isActive('/index'); ?>" href="<?php echo URLROOT; ?>">
                <i class="fas fa-home"></i> Inicio
            </a>

            <div class="menu-label">Herramientas</div>
            <a class="nav-link <?php echo isActive('comparador'); ?>" href="<?php echo URLROOT; ?>/comparador">
                <i class="fas fa-balance-scale"></i> Comparador
            </a>
            <a class="nav-link <?php echo isActive('ranking'); ?>" href="<?php echo URLROOT; ?>/ranking">
                <i class="fas fa-trophy"></i> Ranking
            </a>
            <a class="nav-link <?php echo isActive('graficos'); ?>" href="<?php echo URLROOT; ?>/graficos">
                <i class="fas fa-chart-line"></i> Gráficos
            </a>
            <a class="nav-link <?php echo isActive('mercados'); ?>" href="<?php echo URLROOT; ?>/mercados">
                <i class="fas fa-store"></i> Mercados
            </a>

            <?php if(isset($_SESSION['user_rol']) && $_SESSION['user_rol'] == 'admin'): ?>
                <div class="menu-label text-warning" style="opacity: 1;">Admin</div>
                <a class="nav-link <?php echo isActive('admin'); ?>" href="<?php echo URLROOT; ?>/admin" style="color: #d35400;">
                    <i class="fas fa-cogs"></i> Panel Admin
                </a>
            <?php endif; ?>

            <div class="menu-label">Mi Cuenta</div>
            <a class="nav-link <?php echo isActive('profile'); ?>" href="<?php echo URLROOT; ?>/users/profile">
                <i class="fas fa-user-circle"></i> Mi Perfil
            </a>
            <a class="nav-link text-danger mt-2" href="<?php echo URLROOT; ?>/users/logout">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </nav>
    </div>

    <div class="main-content" id="main-content">
        <!-- TOPBAR -->
        <div class="top-bar">
            <div class="d-flex align-items-center">
                <!-- Botón Móvil -->
                <i class="fas fa-bars mobile-toggler me-3" onclick="document.getElementById('sidebar').classList.toggle('active')"></i>
                
                <!-- Título Dinámico -->
                <div>
                    <h4 class="fw-bold text-petroleum mb-0">
                        <?php 
                            $uri = $_SERVER['REQUEST_URI'];
                            if(strpos($uri, 'comparador')) echo 'Comparador Inteligente';
                            elseif(strpos($uri, 'ranking')) echo 'Ranking de Precios';
                            elseif(strpos($uri, 'graficos')) echo 'Tendencias y Gráficos';
                            elseif(strpos($uri, 'mercados')) echo 'Gestión de Mercados';
                            elseif(strpos($uri, 'profile')) echo 'Perfil de Usuario';
                            elseif(strpos($uri, 'admin')) echo 'Panel de Administración';
                            else echo 'Panel de Control';
                        ?>
                    </h4>
                    <small class="text-muted d-none d-md-block">Gestiona tus compras de forma inteligente.</small>
                </div>
            </div>

            <!-- Perfil / Info -->
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem; font-weight: 700;">Bienvenido</small>
                    <span class="fw-bold text-petroleum"><?php echo $_SESSION['user_name']; ?></span>
                </div>
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

<?php else: ?>
    <!-- ============================================================== -->
    <!-- DISEÑO VISITANTE (Landing/Login) - NAVBAR FLOTANTE GLASS      -->
    <!-- ============================================================== -->
    
    <!-- 
         NOTA: En 'background-color', el último número (0.75) es la opacidad.
         - 1.0 = Totalmente blanco (sólido).
         - 0.5 = 50% transparente.
         - 0.0 = Invisible.
         0.75 con blur de 12px es el estándar de diseño moderno (estilo Apple).
    -->
    <nav class="navbar navbar-expand-lg fixed-top py-3" 
         style="background-color: rgba(255, 255, 255, 0.26); 
                backdrop-filter: blur(12px); 
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);">
                
        <div class="container">
            <a class="navbar-brand fw-bold text-petroleum fs-4" href="<?php echo URLROOT; ?>">
                <i class="fas fa-shopping-basket text-success me-2"></i> <?php echo SITENAME; ?>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="fas fa-bars text-petroleum fs-3"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link fw-medium text-muted px-3" href="<?php echo URLROOT; ?>/users/login">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success px-4 py-2 rounded-pill fw-bold shadow-sm" href="<?php echo URLROOT; ?>/users/register" style="background-color: var(--primary); border:none;">
                            Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Espaciador para el navbar fijo -->
    <div class="container-fluid p-0" style="margin-top: 85px;">

<?php endif; ?>