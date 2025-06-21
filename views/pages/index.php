<?php

?>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .container-landing {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
        text-align: center;
    }

    .hero-section {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 4rem 2rem;
        margin-bottom: 3rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .escudo {
        font-size: 4rem;
        margin-bottom: 1rem;
        display: block;
    }

    .titulo-principal {
        color: #ffffff;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .subtitulo {
        color: #f8f9fa;
        font-size: 1.3rem;
        font-weight: 300;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .descripcion {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin-bottom: 3rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .botones-accion {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn-principal {
        background: rgba(255, 255, 255, 0.25);
        border: 2px solid rgba(255, 255, 255, 0.8);
        color: #ffffff;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        min-width: 180px;
    }

    .btn-principal:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        color: #ffffff;
        text-decoration: none;
    }

    .btn-secundario {
        background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.6);
        color: rgba(255, 255, 255, 0.9);
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        min-width: 180px;
    }

    .btn-secundario:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.8);
        color: #ffffff;
        text-decoration: none;
    }

    .caracteristicas {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 4rem;
    }

    .caracteristica-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2.5rem 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .caracteristica-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-5px);
    }

    .caracteristica-icon {
        font-size: 3rem;
        color: #ffffff;
        margin-bottom: 1.5rem;
    }

    .caracteristica-titulo {
        color: #ffffff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .caracteristica-descripcion {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        line-height: 1.5;
    }

    .footer-info {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        margin-top: 4rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .nombre-oficial {
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .cargo-oficial {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .titulo-principal {
            font-size: 2.2rem;
        }
        .subtitulo {
            font-size: 1.1rem;
        }
        .botones-accion {
            flex-direction: column;
            align-items: center;
        }
        .caracteristicas {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-landing">

    <div class="hero-section">
        <div class="escudo"></div>
        <h1 class="titulo-principal">SISTEMA DE CAPACITACIONES MILITARES</h1>
        <p class="subtitulo">Gestión Profesional de Entrenamiento y Formación Militar</p>
        
        <p class="descripcion">
            Plataforma integral para la administración de capacitaciones, instructores, 
            horarios y recursos de entrenamiento militar. Diseñado para optimizar 
            la formación del personal militar guatemalteco.
        </p>

        <div class="botones-accion">
            <a href="/clemente_final_capacitaciones_ingSoft3/login" class="btn-principal">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </a>
        </div>
    </div>


    <div class="caracteristicas">
        
        <div class="caracteristica-card">
            <div class="caracteristica-icon">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="caracteristica-titulo">Gestión de Personal</h3>
            <p class="caracteristica-descripcion">
                Administra instructores, usuarios y personal militar con información 
                completa y control de acceso granular.
            </p>
        </div>

        <div class="caracteristica-card">
            <div class="caracteristica-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <h3 class="caracteristica-titulo">Programación de Entrenamientos</h3>
            <p class="caracteristica-descripcion">
                Organiza horarios, asigna instructores y gestiona áreas de 
                entrenamiento de manera eficiente.
            </p>
        </div>

        <div class="caracteristica-card">
            <div class="caracteristica-icon">
                <i class="bi bi-bar-chart"></i>
            </div>
            <h3 class="caracteristica-titulo">Reportes y Estadísticas</h3>
            <p class="caracteristica-descripcion">
                Visualiza métricas de rendimiento, estadísticas de capacitaciones 
                y genera reportes detallados.
            </p>
        </div>

        <div class="caracteristica-card">
            <div class="caracteristica-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <h3 class="caracteristica-titulo">Seguridad y Permisos</h3>
            <p class="caracteristica-descripcion">
                Sistema robusto de permisos y control de acceso para garantizar 
                la seguridad de la información.
            </p>
        </div>

    </div>


    <div class="footer-info">
        <div class="nombre-oficial">Subteniente de Intendencia ADRIANA VICTORIA PEREZ CLEMENTE</div>
        <div class="cargo-oficial">Sistema de Gestión de Capacitaciones - Ejército de Guatemala</div>
    </div>
</div>