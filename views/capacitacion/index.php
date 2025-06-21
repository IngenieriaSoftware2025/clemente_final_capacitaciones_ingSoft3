<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ CAPACITACIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE CAPACITACIONES</h4>
                </div>
                <div class="card-body">
                    <form id="FormCapacitacion" enctype="multipart/form-data">
                        <input type="hidden" id="capacitacion_id" name="capacitacion_id">
                        <input type="hidden" id="capacitacion_fecha_creacion" name="capacitacion_fecha_creacion" value="">
                        <input type="hidden" id="capacitacion_situacion" name="capacitacion_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="capacitacion_nombre" class="form-label">Nombre de la Capacitación</label>
                                <input type="text" class="form-control" id="capacitacion_nombre" name="capacitacion_nombre" 
                                       placeholder="Ingrese nombre de la capacitación" required>
                            </div>
                            <div class="col-md-6">
                                <label for="capacitacion_duracion_horas" class="form-label">Duración (Horas)</label>
                                <input type="number" class="form-control" id="capacitacion_duracion_horas" name="capacitacion_duracion_horas" 
                                       placeholder="Ingrese duración en horas" min="1" max="1000" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="capacitacion_descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="capacitacion_descripcion" name="capacitacion_descripcion" 
                                          rows="3" placeholder="Ingrese descripción de la capacitación" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="capacitacion_objetivos" class="form-label">Objetivos</label>
                                <textarea class="form-control" id="capacitacion_objetivos" name="capacitacion_objetivos" 
                                          rows="4" placeholder="Ingrese los objetivos de la capacitación" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="capacitacion_usuario_creo" class="form-label">Usuario Creador</label>
                                <select class="form-control" id="capacitacion_usuario_creo" name="capacitacion_usuario_creo" required>
                                    <option value="">Seleccione un usuario</option>
                                </select>
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
                    <h4 class="text-center mb-0">Capacitaciones registradas en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableCapacitacion">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/capacitacion/index.js') ?>"></script>