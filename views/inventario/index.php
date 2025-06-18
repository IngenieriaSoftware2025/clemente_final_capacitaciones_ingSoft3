<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión de Inventario!</h5>
                    <h4 class="mb-0">ADMINISTRACIÓN DE INVENTARIO DE CELULARES</h4>
                </div>
                <div class="card-body">
                    <form id="FormInventario">
                        <input type="hidden" id="id_inventario" name="id_inventario">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_marca" class="form-label">Marca </label>
                                <select class="form-select" id="id_marca" name="id_marca" >
                                    <option value="">Seleccione una marca</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_modelo" class="form-label">Modelo </label>
                                <select class="form-select" id="id_modelo" name="id_modelo" >
                                    <option value="">Seleccione un modelo</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="estado_celular" class="form-label">Estado del Celular </label>
                                <select class="form-select" id="estado_celular" name="estado_celular" >
                                    <option value="">Seleccione estado</option>
                                    <option value="nuevo">Nuevo</option>
                                    <option value="usado">Usado</option>
                                    <option value="dañado">Dañado</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="precio_compra" class="form-label">Precio de Compra </label>
                                <input type="number" class="form-control" id="precio_compra" name="precio_compra" 
                                       placeholder="0.00" step="0.01" min="0" >
                            </div>
                            <div class="col-md-4">
                                <label for="precio_venta" class="form-label">Precio de Venta </label>
                                <input type="number" class="form-control" id="precio_venta" name="precio_venta" 
                                       placeholder="0.00" step="0.01" min="0" >
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="estado_inventario" class="form-label">Estado del Inventario </label>
                                <select class="form-select" id="estado_inventario" name="estado_inventario" >
                                    <option value="">Seleccione estado</option>
                                    <option value="disponible">Disponible</option>
                                    <option value="vendido">Vendido</option>
                                    <option value="en_reparacion">En Reparación</option>
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
                    <h4 class="text-center mb-0">Inventario registrado en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableInventario">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/inventario/index.js') ?>"></script>