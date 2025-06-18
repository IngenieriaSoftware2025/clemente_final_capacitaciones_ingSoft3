<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ COMISIONES!</h5>
                    <h4 class="mb-0">ASIGNACIÓN DE PERMISOS</h4>
                </div>
                <div class="card-body">
                    <form id="FormAsignacionPermisos">
                        <input type="hidden" id="asignacion_id" name="asignacion_id">
                        <input type="hidden" id="asignacion_fecha" name="asignacion_fecha" value="">
                        <input type="hidden" id="asignacion_situacion" name="asignacion_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asignacion_usuario_id" class="form-label">Usuario</label>
                                <select class="form-control" id="asignacion_usuario_id" name="asignacion_usuario_id" required>
                                    <option value="">Seleccione un usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="asignacion_app_id" class="form-label">Aplicación</label>
                                <select class="form-control" id="asignacion_app_id" name="asignacion_app_id" required>
                                    <option value="">Seleccione una aplicación</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="asignacion_permiso_id" class="form-label">Permiso</label>
                                <select class="form-control" id="asignacion_permiso_id" name="asignacion_permiso_id" required>
                                    <option value="">Seleccione primero una aplicación</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="asignacion_usuario_asigno" class="form-label">Usuario que Asigna</label>
                                <select class="form-control" id="asignacion_usuario_asigno" name="asignacion_usuario_asigno" required>
                                    <option value="">Seleccione quién asigna</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="asignacion_motivo" class="form-label">Motivo de la Asignación</label>
                                <textarea class="form-control" id="asignacion_motivo" name="asignacion_motivo" rows="3" 
                                          placeholder="Ingrese el motivo de la asignación del permiso" required></textarea>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Importante:</strong> No se puede asignar el mismo permiso dos veces al mismo usuario. Verifique que no exista una asignación previa.
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                <i class="bi bi-floppy me-1"></i>Asignar Permiso
                            </button>
                            <button class="btn btn-warning me-2 d-none" type="button" id="BtnModificar">
                                <i class="bi bi-pencil-square me-1"></i>Modificar
                            </button>
                            <button class="btn btn-info me-2" type="button" id="BtnBuscar">
                                <i class="bi bi-search me-1"></i>Buscar
                            </button>
                            <button class="btn btn-secondary me-2" type="reset" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i>Limpiar
                            </button>
                            <button class="btn btn-primary" type="button" id="BtnVerPermisos">
                                <i class="bi bi-person-check me-1"></i>Ver Permisos por Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4" id="seccionPermisosUsuario" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white" style="background: linear-gradient(135deg,rgb(40, 167, 69) 0%,rgb(25, 135, 84) 100%);">
                    <h4 class="text-center mb-0">Permisos por Usuario</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="filtroUsuario" class="form-label">Seleccionar Usuario</label>
                            <select class="form-control" id="filtroUsuario">
                                <option value="">Seleccione un usuario para ver sus permisos</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TablePermisosUsuario">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h4 class="text-center mb-0">Asignaciones de permisos registradas en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableAsignacionPermisos">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/asignacionpermisos/index.js') ?>"></script>