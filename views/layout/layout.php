<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>PEREZ COMISIONES</title>
    <style>
        .nav-select {
            background: rgba(37, 50, 83, 0.9);
            color: white;
            border: 1px solid rgba(52, 42, 42, 0.3);
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            margin: 0 0.3rem;
            font-size: 0.9rem;
        }

        .nav-select:hover {
            background: rgb(87, 85, 164);
            border-color: #4a90e2;
        }

        .nav-select:focus {
            background: rgba(30, 50, 100, 1);
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.3);
        }

        .nav-select option {
            background: #1a2a56;
            color: white;
            padding: 0.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/clemente_final_capacitaciones_ingSoft3/inicio">
                <img src="<?= asset('./images/cit.png') ?>" width="35px'" alt="cit">
                PEREZ COMISIONES
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">

          
                    <li class="nav-item">
                        <select class="nav-select" onchange="if(this.value) window.location.href=this.value">
                            <option value=""> Usuarios</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/usuarios">Gestión de Usuarios</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/aplicacion">Aplicaciones</option>
                        </select>
                    </li>

               
                    <li class="nav-item">
                        <select class="nav-select" onchange="if(this.value) window.location.href=this.value">
                            <option value="">Comisiones</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/comisiones">Gestión de Comisiones</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/comisionpersonal">Asignación de Personal</option>
                        </select>
                    </li>

                 
                    <li class="nav-item">
                        <select class="nav-select" onchange="if(this.value) window.location.href=this.value">
                            <option value=""> Seguridad</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/permisos">Gestión de Permisos</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/asignacionpermisos">Asignación de Permisos</option>
                        </select>
                    </li>

            
                    <li class="nav-item">
                        <select class="nav-select" onchange="if(this.value) window.location.href=this.value">
                            <option value=""> Reportes</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/estadisticas">Estadísticas</option>
                            <option value="/clemente_final_capacitaciones_ingSoft3/mapa">Ubicación</option>
                        </select>
                    </li>

                </ul>

                <?php
                session_start();
                if (isset($_SESSION['user'])):
                ?>
                    <div class="d-flex align-items-center me-3">
                        <span class="text-white me-3">
                            <i class="bi bi-person-circle me-1"></i>
                            <?= $_SESSION['user'] ?>
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

    <div class="container-fluid ">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                    Sistema PEREZ COMISIONES, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>

</body>

</html>