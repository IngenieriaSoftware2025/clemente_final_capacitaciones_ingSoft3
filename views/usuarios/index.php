<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ CAPACITACIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE USUARIOS</h4>
                </div>
                <div class="card-body">
                    <form id="FormUsuarios" enctype="multipart/form-data">
                        <input type="hidden" id="usuario_id" name="usuario_id">
                        <input type="hidden" id="usuario_token" name="usuario_token" value="">
                        <input type="hidden" id="usuario_fecha_creacion" name="usuario_fecha_creacion" value="">
                        <input type="hidden" id="usuario_fecha_contra" name="usuario_fecha_contra" value="">
                        <input type="hidden" id="usuario_situacion" name="usuario_situacion" value="1">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario_nom1" class="form-label">Primer Nombre</label>
                                <input type="text" class="form-control" id="usuario_nom1" name="usuario_nom1" 
                                       placeholder="Ingrese primer nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_nom2" class="form-label">Segundo Nombre</label>
                                <input type="text" class="form-control" id="usuario_nom2" name="usuario_nom2" 
                                       placeholder="Ingrese segundo nombre" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario_ape1" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="usuario_ape1" name="usuario_ape1" 
                                       placeholder="Ingrese primer apellido" required>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_ape2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="usuario_ape2" name="usuario_ape2" 
                                       placeholder="Ingrese segundo apellido" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario_tel" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="usuario_tel" name="usuario_tel" 
                                       placeholder="Ingrese número de teléfono" required>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_dpi" class="form-label">DPI</label>
                                <input type="text" class="form-control" id="usuario_dpi" name="usuario_dpi" 
                                       placeholder="Ingrese DPI" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario_direc" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="usuario_direc" name="usuario_direc" 
                                       placeholder="Ingrese dirección" required>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario_correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="usuario_correo" name="usuario_correo" 
                                       placeholder="ejemplo@ejemplo.com" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario_contra" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="usuario_contra" name="usuario_contra" 
                                       placeholder="Ingrese contraseña" required>
                            </div>
                            <div class="col-md-6">
                                <label for="confirmar_contra" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmar_contra" name="confirmar_contra" 
                                       placeholder="Confirme contraseña" required>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="usuario_fotografia" class="form-label">Fotografía</label>
                                <input type="file" class="form-control" id="usuario_fotografia" name="usuario_fotografia" accept=".jpg,.jpeg,.png">
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
                    <h4 class="text-center mb-0">Usuarios registrados en el sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableUsuarios">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/usuarios/index.js') ?>"></script>