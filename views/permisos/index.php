<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ CAPACITACIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE PERMISOS</h4>
                </div>
                <div class="card-body">
                    <form id="FormPermiso" enctype="multipart/form-data">
                        <input type="hidden" id="permiso_id" name="permiso_id">
                        <input type="hidden" id="permiso_situacion" name="permiso_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario_id" class="form-label">Usuario</label>
                                <select class="form-control" id="usuario_id" name="usuario_id" required>
                                    <option value="">Seleccione un usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="app_id" class="form-label">Aplicación</label>
                                <select class="form-control" id="app_id" name="app_id" required>
                                    <option value="">Seleccione una aplicación</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="permiso_nombre" class="form-label">Nombre del Permiso</label>
                                <input type="text" class="form-control" id="permiso_nombre" name="permiso_nombre" 
                                       placeholder="Ej: Crear Usuario" required>
                            </div>
                            <div class="col-md-6">
                                <label for="permiso_clave" class="form-label">Clave del Permiso</label>
                                <input type="text" class="form-control" id="permiso_clave" name="permiso_clave" 
                                       placeholder="Ej: USER_CREATE" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="permiso_tipo" class="form-label">Tipo de Permiso</label>
                                <select class="form-control" id="permiso_tipo" name="permiso_tipo" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                                    <option value="USUARIO">USUARIO</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="permiso_desc" class="form-label">Descripción</label>
                                <textarea class="form-control" id="permiso_desc" name="permiso_desc" 
                                          placeholder="Describe las funciones que permite este permiso" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="permiso_motivo" class="form-label">Motivo</label>
                                <textarea class="form-control" id="permiso_motivo" name="permiso_motivo" 
                                          placeholder="Explica por qué se otorga este permiso" rows="3" required></textarea>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                <i class="bi bi-floppy me-1"></i>Guardar
                            </button>
                            <button class="btn btn-warning me-2 d-none" type="button" id="BtnModificar">
                                <i class="bi bi-pencil-square me-1"></i>Modificar
                            </button>
                            <button class="btn btn-info me-2" type="button" id="BtnBuscar">
                                <i class="bi bi-search me-1"></i>Buscar
                            </button>
                            <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i>Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h4 class="text-center mb-0">Permisos registrados en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TablePermiso">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/permisos/index.js') ?>"></script>