<?php
session_start();
?>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .container-simple {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
    }

    .header-simple {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        margin-bottom: 3rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .titulo-principal {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .subtitulo {
        color: #f8f9fa;
        font-size: 1.2rem;
        font-weight: 300;
        margin-bottom: 1rem;
    }

    .usuario-info {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 1rem;
        margin: 1rem 0;
        color: #ffffff;
        font-weight: 500;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .menu-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        text-decoration: none;
        color: #ffffff;
    }

    .menu-card:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        color: #ffffff;
        text-decoration: none;
    }

    .menu-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }

    .menu-titulo {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .menu-descripcion {
        font-size: 0.9rem;
        opacity: 0.9;
        line-height: 1.4;
    }

    .footer-simple {
        text-align: center;
        margin-top: 3rem;
        padding: 2rem;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .titulo-principal {
            font-size: 2rem;
        }
        .menu-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-simple">

    <div class="header-simple">
        <h1 class="titulo-principal"> SISTEMA DE CAPACITACIONES</h1>
        <p class="subtitulo">Gestión Militar de Entrenamiento y Formación</p>
        
        <?php if(isset($_SESSION['user']) && isset($_SESSION['usuario_id'])): ?>
            <div class="usuario-info">
              Bienvenido:</strong> <?= $_SESSION['user'] ?><br>
                <small>ID: <?= $_SESSION['usuario_id'] ?></small>
            </div>
        <?php endif; ?>
    </div>


    <div class="menu-grid">
        
        <a href="/clemente_final_capacitaciones_ingSoft3/usuarios" class="menu-card">
            <i class="bi bi-people menu-icon"></i>
            <div class="menu-titulo">Usuarios</div>
            <div class="menu-descripcion">Gestión de personal militar</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/instructor" class="menu-card">
            <i class="bi bi-person-badge menu-icon"></i>
            <div class="menu-titulo">Instructores</div>
            <div class="menu-descripcion">Registro de instructores</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/capacitacion" class="menu-card">
            <i class="bi bi-book menu-icon"></i>
            <div class="menu-titulo">Capacitaciones</div>
            <div class="menu-descripcion">Programas de entrenamiento</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/horarioentrenamiento" class="menu-card">
            <i class="bi bi-calendar-check menu-icon"></i>
            <div class="menu-titulo">Horarios</div>
            <div class="menu-descripcion">Programación de entrenamientos</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/areaentrenamiento" class="menu-card">
            <i class="bi bi-geo-alt menu-icon"></i>
            <div class="menu-titulo">Áreas</div>
            <div class="menu-descripcion">Zonas de entrenamiento</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/estadisticasentrenamiento" class="menu-card">
            <i class="bi bi-bar-chart menu-icon"></i>
            <div class="menu-titulo">Estadísticas</div>
            <div class="menu-descripcion">Reportes y métricas</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/permisos" class="menu-card">
            <i class="bi bi-shield-check menu-icon"></i>
            <div class="menu-titulo">Permisos</div>
            <div class="menu-descripcion">Control de acceso</div>
        </a>

        <a href="/clemente_final_capacitaciones_ingSoft3/mapas" class="menu-card">
            <i class="bi bi-map menu-icon"></i>
            <div class="menu-titulo">Mapas</div>
            <div class="menu-descripcion">Ubicaciones de entrenamiento</div>
        </a>

    </div>

    <div class="footer-simple">
        <p>🇬🇹 Subteniente de Intendencia ADRIANA VICTORIA PEREZ CLEMENTE</strong></p>
        <p>Sistema de Gestión de Capacitaciones Militares</p>
    </div>
</div>