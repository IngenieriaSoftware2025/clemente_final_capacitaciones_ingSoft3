<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ COMISIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE COMISIONES</h4>
                </div>
                <div class="card-body">
                    <form id="FormComisiones">
                        <input type="hidden" id="comision_id" name="comision_id">
                        <input type="hidden" id="comision_fecha_creacion" name="comision_fecha_creacion" value="">
                        <input type="hidden" id="comision_usuario_creo" name="comision_usuario_creo" value="">
                        <input type="hidden" id="comision_situacion" name="comision_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="comision_titulo" class="form-label">Título de la Comisión</label>
                                <input type="text" class="form-control" id="comision_titulo" name="comision_titulo" 
                                       placeholder="Ingrese título de la comisión" required>
                            </div>
                            <div class="col-md-6">
                                <label for="comision_tipo" class="form-label">Tipo de Comisión</label>
                                <select class="form-control" id="comision_tipo" name="comision_tipo" required>
                                    <option value="">Seleccione el tipo</option>
                                    <option value="TRANSMISIONES">TRANSMISIONES</option>
                                    <option value="INFORMATICA">INFORMÁTICA</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="comision_descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="comision_descripcion" name="comision_descripcion" rows="3" 
                                          placeholder="Ingrese descripción detallada de la comisión" required></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="comision_fecha_inicio" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control" id="comision_fecha_inicio" name="comision_fecha_inicio" required>
                            </div>
                            <div class="col-md-6">
                                <label for="comision_ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="comision_ubicacion" name="comision_ubicacion" 
                                       placeholder="Ingrese ubicación de la comisión" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="comision_duracion" class="form-label">Duración</label>
                                <input type="number" class="form-control" id="comision_duracion" name="comision_duracion" 
                                       placeholder="Ingrese duración" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="comision_duracion_tipo" class="form-label">Tipo de Duración</label>
                                <select class="form-control" id="comision_duracion_tipo" name="comision_duracion_tipo" required>
                                    <option value="">Seleccione el tipo</option>
                                    <option value="HORAS">HORAS</option>
                                    <option value="DIAS">DÍAS</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="comision_estado" class="form-label">Estado</label>
                                <select class="form-control" id="comision_estado" name="comision_estado">
                                    <option value="PROGRAMADA">PROGRAMADA</option>
                                    <option value="EN_CURSO">EN CURSO</option>
                                    <option value="COMPLETADA">COMPLETADA</option>
                                    <option value="CANCELADA">CANCELADA</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="comision_observaciones" class="form-label">Observaciones</label>
                                <input type="text" class="form-control" id="comision_observaciones" name="comision_observaciones" 
                                       placeholder="Observaciones adicionales">
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
                    <h4 class="text-center mb-0">Comisiones registradas en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableComisiones">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/comisiones/index.js') ?>"></script>