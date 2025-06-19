<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estadísticas - PEREZ COMISIONES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">

    <div class="container-fluid py-4">

        <div class="card text-center shadow">
            <div class="card-header text-white" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                <h1 class="mb-3">PANEL DE ESTADÍSTICAS</h1>
                <p class="mb-0">Análisis completo del sistema PEREZ COMISIONES</p>
            </div>
        </div>

        <div class="mb-5 mt-4">
            <h3 class="text-primary fw-bold text-center mb-4 position-relative">
                ANÁLISIS DE COMISIONES
                <div class="bg-primary mx-auto mt-2" style="width: 80px; height: 3px; border-radius: 2px;"></div>
            </h3>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                        <div class="card-header bg-light text-center border-0">
                            <h5 class="text-primary fw-bold mb-0">Comisiones por Tipo</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                <canvas id="grafico1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                        <div class="card-header bg-light text-center border-0">
                            <h5 class="text-primary fw-bold mb-0">Estados de Comisiones</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                <canvas id="grafico2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                        <div class="card-header bg-light text-center border-0">
                            <h5 class="text-primary fw-bold mb-0">Comisiones por Mes</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                <canvas id="grafico7"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                        <div class="card-header bg-light text-center border-0">
                            <h5 class="text-primary fw-bold mb-0">Duración Promedio</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                <canvas id="grafico5"></canvas>

                                <div class="row justify-content-center p-3">
                                    <div class="col-lg-12">
                                        <div class="card custom-card shadow-lg" style="border-radius: 15px; border: 2px solid #3b82f6; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                                            <div class="card-body p-4">
                                                <div class="row mb-4">
                                                    <h1 class="text-center mb-2" style="color: #1e3a8a; font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Sistema de Gestión</h1>
                                                    <h1 class="text-center mb-2" style="color: #2563eb; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">REPARACIÓN DE CELULARES</h1>
                                                </div>

                                                <div class="row mb-4">
                                                    <h5 class="text-center mb-2" style="color: #1d4ed8;">Dashboard</h5>
                                                    <h4 class="text-center mb-2" style="color: #3b82f6; font-weight: 600;">Estadísticas de Reparaciones por Cliente</h4>
                                                </div>

                                                <div class="row p-3 justify-content-center">
                                                    <div class="col-lg-5 rounded shadow-lg m-2" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; padding: 20px;">
                                                        <canvas id="grafico1" width="400" height="200"></canvas>
                                                    </div>

                                                    <div class="col-lg-5 rounded shadow-lg m-2" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; padding: 20px;">
                                                        <canvas id="grafico2" width="400" height="200"></canvas>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-5">
                                    <h3 class="text-primary fw-bold text-center mb-4 position-relative">
                                        ANÁLISIS DE PERSONAL
                                        <div class="bg-primary mx-auto mt-2" style="width: 80px; height: 3px; border-radius: 2px;"></div>
                                    </h3>
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                                                <div class="card-header bg-light text-center border-0">
                                                    <h5 class="text-primary fw-bold mb-0">Personal más Asignado</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                                        <canvas id="grafico3"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                                                <div class="card-header bg-light text-center border-0">
                                                    <h5 class="text-primary fw-bold mb-0">Usuarios que más Crean Comisiones</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                                        <canvas id="grafico4"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                                                <div class="card-header bg-light text-center border-0">
                                                    <h5 class="text-primary fw-bold mb-0">Disponibilidad de Personal</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                                        <canvas id="grafico9"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                                                <div class="card-header bg-light text-center border-0">
                                                    <h5 class="text-primary fw-bold mb-0">Comisiones Activas vs Personal</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                                        <canvas id="grafico8"></canvas>
                                                        <div class="row justify-content-center p-3">
                                                            <div class="col-lg-12">
                                                                <div class="card custom-card shadow-lg" style="border-radius: 15px; border: 2px solid #10b981; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);">
                                                                    <div class="card-body p-4">
                                                                        <div class="row mb-4">
                                                                            <h1 class="text-center mb-2" style="color: #064e3b; font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Sistema de Gestión</h1>
                                                                            <h1 class="text-center mb-2" style="color: #059669; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">INVENTARIO DE CELULARES</h1>
                                                                        </div>

                                                                        <div class="row mb-4">
                                                                            <h5 class="text-center mb-2" style="color: #047857;">Inventario</h5>
                                                                            <h4 class="text-center mb-2" style="color: #10b981; font-weight: 600;">Distribución por Marcas</h4>
                                                                        </div>

                                                                        <div class="row p-3 justify-content-center">
                                                                            <div class="col-lg-8 rounded shadow-lg" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e5e7eb; padding: 20px;">
                                                                                <canvas id="grafico3" width="400" height="200"></canvas>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="mb-5">
                                                            <h3 class="text-primary fw-bold text-center mb-4 position-relative">
                                                                ANÁLISIS DE UBICACIONES
                                                                <div class="bg-primary mx-auto mt-2" style="width: 80px; height: 3px; border-radius: 2px;"></div>
                                                            </h3>
                                                            <div class="row">
                                                                <div class="col-lg-6 mb-3">
                                                                    <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                                                                        <div class="card-header bg-light text-center border-0">
                                                                            <h5 class="text-primary fw-bold mb-0">Ubicaciones más Frecuentes</h5>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                                                                <canvas id="grafico6"></canvas>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 mb-3">
                                                                    <div class="card shadow border-0 rounded-4 h-100" style="min-height: 450px;">
                                                                        <div class="card-header bg-light text-center border-0">
                                                                            <h5 class="text-primary fw-bold mb-0">Resumen General del Sistema</h5>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-center justify-content-center" style="height: 320px;">
                                                                                <canvas id="grafico10"></canvas>
                                                                                <div class="row justify-content-center p-3">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="card custom-card shadow-lg" style="border-radius: 15px; border: 2px solid #f59e0b; background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
                                                                                            <div class="card-body p-4">
                                                                                                <div class="row mb-4">
                                                                                                    <h1 class="text-center mb-2" style="color: #92400e; font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Sistema de Gestión</h1>
                                                                                                    <h1 class="text-center mb-2" style="color: #d97706; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">REPARACIONES MENSUALES</h1>
                                                                                                </div>

                                                                                                <div class="row mb-4">
                                                                                                    <h5 class="text-center mb-2" style="color: #b45309;">Progreso</h5>
                                                                                                    <h4 class="text-center mb-2" style="color: #f59e0b; font-weight: 600;">Reparaciones por Mes</h4>
                                                                                                </div>

                                                                                                <div class="row p-3 justify-content-center">
                                                                                                    <div class="col-lg-8 rounded shadow-lg" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e5e7eb; padding: 20px;">
                                                                                                        <canvas id="grafico4" width="400" height="200"></canvas>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                            </div>

                                                                            <script src="<?= asset('build/js/estadisticas/index.js') ?>"></script>

</body>

<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 15px; border: 2px solid #8b5cf6; background: linear-gradient(135deg, #f3e8ff 0%, #ede9fe 100%);">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <h1 class="text-center mb-2" style="color: #581c87; font-weight: 600; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">Sistema de Gestión</h1>
                    <h1 class="text-center mb-2" style="color: #7c3aed; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">USUARIOS DEL SISTEMA</h1>
                </div>

                <div class="row mb-4">
                    <h5 class="text-center mb-2" style="color: #6b21a8;">Personal</h5>
                    <h4 class="text-center mb-2" style="color: #8b5cf6; font-weight: 600;">Distribución de Usuarios por Rol</h4>
                </div>

                <div class="row p-3 justify-content-center">
                    <div class="col-lg-6 rounded shadow-lg" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e5e7eb; padding: 20px;">
                        <canvas id="grafico5" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/estadisticas/index.js') ?>"></script>