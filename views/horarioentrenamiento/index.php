<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ CAPACITACIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE ENTRENAMIENTOS</h4>
                </div>
                <div class="card-body">
                    <form id="FormEntrenamiento">
                        <input type="hidden" id="entrenamiento_id" name="entrenamiento_id">
                        <input type="hidden" id="entrenamiento_usuario_creo" name="entrenamiento_usuario_creo" value="1">
                        <input type="hidden" id="entrenamiento_situacion" name="entrenamiento_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="entrenamiento_capacitacion_id" class="form-label">Capacitación</label>
                                <select class="form-select" id="entrenamiento_capacitacion_id" name="entrenamiento_capacitacion_id" >
                                    <option value="">Seleccione una capacitación</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="entrenamiento_compania_id" class="form-label">Compañía</label>
                                <select class="form-select" id="entrenamiento_compania_id" name="entrenamiento_compania_id" >
                                    <option value="">Seleccione una compañía</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="entrenamiento_instructor_id" class="form-label">Instructor</label>
                                <select class="form-select" id="entrenamiento_instructor_id" name="entrenamiento_instructor_id" >
                                    <option value="">Seleccione un instructor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="entrenamiento_area_id" class="form-label">Área de Entrenamiento</label>
                                <select class="form-select" id="entrenamiento_area_id" name="entrenamiento_area_id" >
                                    <option value="">Seleccione un área</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="entrenamiento_fecha_inicio" class="form-label">Fecha de Inicio</label>
                                <input type="datetime-local" class="form-control" id="entrenamiento_fecha_inicio" name="entrenamiento_fecha_inicio" >
                            </div>
                            <div class="col-md-4">
                                <label for="entrenamiento_fecha_fin" class="form-label">Fecha de Fin</label>
                                <input type="datetime-local" class="form-control" id="entrenamiento_fecha_fin" name="entrenamiento_fecha_fin" >
                            </div>
                            <div class="col-md-4">
                                <label for="entrenamiento_estado" class="form-label">Estado</label>
                                <select class="form-select" id="entrenamiento_estado" name="entrenamiento_estado" >
                                    <option value="PROGRAMADO">Programado</option>
                                    <option value="EN_CURSO">En Curso</option>
                                    <option value="COMPLETADO">Completado</option>
                                    <option value="CANCELADO">Cancelado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="entrenamiento_observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="entrenamiento_observaciones" name="entrenamiento_observaciones" 
                                          rows="3" placeholder="Ingrese observaciones adicionales (opcional)"></textarea>
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
                    <h4 class="text-center mb-0">Entrenamientos registrados en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableEntrenamiento">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/horarioentrenamiento/index.js') ?>"></script>