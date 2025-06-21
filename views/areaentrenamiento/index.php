<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ CAPACITACIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE ÁREAS DE ENTRENAMIENTO</h4>
                </div>
                <div class="card-body">
                    <form id="FormAreaEntrenamiento">
                        <input type="hidden" id="area_id" name="area_id">
                        <input type="hidden" id="area_situacion" name="area_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="area_nombre" class="form-label">Nombre del Área</label>
                                <input type="text" class="form-control" id="area_nombre" name="area_nombre" 
                                       placeholder="Ingrese nombre del área" required>
                            </div>
                            <div class="col-md-6">
                                <label for="area_direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="area_direccion" name="area_direccion" 
                                       placeholder="Ingrese dirección del área" required>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="area_descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="area_descripcion" name="area_descripcion" 
                                          rows="4" placeholder="Ingrese descripción del área de entrenamiento" required></textarea>
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
                    <h4 class="text-center mb-0">Áreas de entrenamiento registradas en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableAreaEntrenamiento">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/areaentrenamiento/index.js') ?>"></script>