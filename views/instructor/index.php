<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ CAPACITACIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE INSTRUCTORES</h4>
                </div>
                <div class="card-body">
                    <form id="FormInstructor" enctype="multipart/form-data">
                        <input type="hidden" id="instructor_id" name="instructor_id">
                        <input type="hidden" id="instructor_fecha_registro" name="instructor_fecha_registro" value="">
                        <input type="hidden" id="instructor_situacion" name="instructor_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="instructor_usuario_id" class="form-label">Usuario</label>
                                <select class="form-control" id="instructor_usuario_id" name="instructor_usuario_id" required>
                                    <option value="">Seleccione un usuario</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="instructor_grado" class="form-label">Grado</label>
                                <input type="text" class="form-control" id="instructor_grado" name="instructor_grado" 
                                       placeholder="Ej: TENIENTE, CAPITÁN, MAYOR" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="instructor_arma" class="form-label">Arma</label>
                                <input type="text" class="form-control" id="instructor_arma" name="instructor_arma" 
                                       placeholder="Ej: INFANTERÍA, ARTILLERÍA, CABALLERÍA" required>
                            </div>
                            <div class="col-md-6">
                                <label for="instructor_anos_servicio" class="form-label">Años de Servicio</label>
                                <input type="number" class="form-control" id="instructor_anos_servicio" name="instructor_anos_servicio" 
                                       placeholder="Ingrese años de servicio" min="0" max="50" required>
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
                    <h4 class="text-center mb-0">Instructores registrados en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableInstructor">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/instructor/index.js') ?>"></script>