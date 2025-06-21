<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>PEREZ CAPACITACIONES</title>
    <style>

.nav-link {
    transition: all 0.3s ease !important;
    border-radius: 8px !important;
    margin: 0 2px !important;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3) !important;
}


.nav-link.active {
    background-color: rgba(255, 255, 255, 0.3) !important;
    color: #ffffff !important;
    font-weight: bold !important;
}


.dropdown-toggle:hover {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
        
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/clemente_final_capacitaciones_ingSoft3/inicio">
                <img src="<?= asset('./images/cit.png') ?>" width="35px'" alt="cit" >
                PEREZ CAPACITACIONES
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/clemente_final_capacitaciones_ingSoft3/inicio"><i class="bi bi-house-fill me-2"></i>Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/usuarios">
                            <i class="bi bi-people-fill me-2"></i>Usuarios
                        </a>
                    </li>

                      <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/compania">
                            <i class="bi bi-building"></i></i>Compañia
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/capacitacion">
                            <i class="bi bi-book"></i></i>Capacitaciones
                        </a>
                    </li>

                     <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/instructor">
                            <i class="bi bi-people-fill me-2"></i>Instructores
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/areaentrenamiento ">
                            <i class="bi bi-geo-alt"></i></i>Areas de Entrenamiento
                        </a>
                    </li>


                     <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/horarioentrenamiento ">
                            <i class="bi bi-calendar-check"></i></i>Horario de Entrenamiento
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" style="border: none; background: none;" href="/clemente_final_capacitaciones_ingSoft3/estadisticasentrenamiento">
                            <i class="bi bi-bar-chart"></i>Estadísticas  de Entrenamiento
                        </a>
                    </li>




                    

                    <li class="nav-item">
                        <a class="nav-link px-3" style="background: none;" href="/clemente_final_capacitaciones_ingSoft3/aplicacion">
                            <i class="bi bi-grid-fill me-2"></i>Aplicaciones
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" style="background: none; border: none;" href="/clemente_final_capacitaciones_ingSoft3/permisos">
                            <i class="bi bi-shield-lock-fill me-2"></i>Permisos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link px-3" style="background: none; border: none;" href="/clemente_final_capacitaciones_ingSoft3/asignacionpermisos">
                            <i class="bi bi-shield-check-fill me-2"><i class="bi bi-person-check"></i></i>Asignación de Permisos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" style="background: none; border: none;" href="/clemente_final_capacitaciones_ingSoft3/mapas">
                            <i class="bi bi-shield-check-fill me-2"><i class="bi bi-geo-alt"></i></i>Mapa
                        </a>
                    </li>
                   

                    <li class="nav-item">
                        <a class="nav-link px-3" style="background: none; border: none;" href="/clemente_final_capacitaciones_ingSoft3/historial">
                            <i class="bi bi-shield-check-fill me-2"><i class="bi bi-geo-alt"></i></i>Historial
                        </a>
                    </li>

                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Reportes
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/clemente_final_capacitaciones_ingSoft3/estadisticas"><i class="ms-lg-0 ms-2 bi bi-bar-chart-fill me-2"></i>Estadísticas</a>
                            </li>
                        </ul>
                    </div> 

                </ul> 
                
                <?php 
                session_start();
                if(isset($_SESSION['user'])): 
                ?>
                    <div class="d-flex align-items-center me-3">
                        <span class="text-white me-3">
                            <i class="bi bi-person-circle me-1"></i>
                            <?= $_SESSION['user'] ?> 
                            <?php if(isset($_SESSION['rol'])): ?>
                                (<?= $_SESSION['rol'] ?>)
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="col-lg-2 d-grid mb-lg-0 mb-2">
                        <div class="d-flex gap-2">
                            <a href="/clemente_final_capacitaciones_ingSoft3/logout" class="btn btn-danger">
                                <i class="bi bi-box-arrow-right"></i>Salir
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-1 d-grid mb-lg-0 mb-2">
                        <a href="/clemente_final_capacitaciones_ingSoft3/login" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i>Login
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        
    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                        Sistema de Capacitaciones - Ingeniería de Software 3, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>
</html>