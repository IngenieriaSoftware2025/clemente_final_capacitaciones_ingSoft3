<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ COMISIONES!</h5>
                    <h4 class="mb-0">HISTORIAL DE ACTIVIDADES</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="filtro_usuario" class="form-label">Usuario</label>
                            <select class="form-select" id="filtro_usuario">
                                <option value="">Todos los usuarios</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtro_ruta" class="form-label">Ruta</label>
                            <select class="form-select" id="filtro_ruta">
                                <option value="">Todas las rutas</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio">
                        </div>
                        <div class="col-md-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-info me-2" id="BtnBuscar">
                            <i class="bi bi-search me-1"></i>Buscar Actividades
                        </button>
                        <button type="button" class="btn btn-secondary" id="BtnLimpiarFiltros">
                            <i class="bi bi-arrow-clockwise me-1"></i>Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h4 class="text-center mb-0">Historial de actividades del sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableHistorialActividades">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/historial/index.js') ?>"></script>