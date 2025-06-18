<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ COMISIONES!</h5>
                    <h4 class="mb-0">ASIGNACIÓN DE PERSONAL A COMISIONES</h4>
                </div>
                <div class="card-body">
                    <form id="FormComisionPersonal">
                        <input type="hidden" id="comision_personal_id" name="comision_personal_id">
                        <input type="hidden" id="comision_personal_fecha_asignacion" name="comision_personal_fecha_asignacion" value="">
                        <input type="hidden" id="comision_personal_usuario_asigno" name="comision_personal_usuario_asigno" value="">
                        <input type="hidden" id="comision_personal_situacion" name="comision_personal_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="comision_id" class="form-label">Comisión</label>
                                <select class="form-control" id="comision_id" name="comision_id" required>
                                    <option value="">Seleccione una comisión</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_id" class="form-label">Personal</label>
                                <select class="form-control" id="usuario_id" name="usuario_id" required>
                                    <option value="">Seleccione personal</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="comision_personal_observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="comision_personal_observaciones" name="comision_personal_observaciones" rows="3" 
                                          placeholder="Ingrese observaciones sobre la asignación"></textarea>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Nota:</strong> Solo se puede asignar personal que no tenga comisiones activas (PROGRAMADA o EN CURSO).
                        </div>
                        
                        <div class="text-center">
                            <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                <i class="bi bi-floppy me-1"></i>Asignar
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
                            <button class="btn btn-primary" type="button" id="BtnPersonalDisponible">
                                <i class="bi bi-people me-1"></i>Ver Personal Disponible
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4" id="seccionPersonalDisponible" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white" style="background: linear-gradient(135deg,rgb(40, 167, 69) 0%,rgb(25, 135, 84) 100%);">
                    <h4 class="text-center mb-0">Personal Disponible para Asignación</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TablePersonalDisponible">
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
                    <h4 class="text-center mb-0">Asignaciones de personal registradas en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableComisionPersonal">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/comisionpersonal/index.js') ?>"></script>