
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                    <h5 class="mb-1">¡Sistema de Gestión PEREZ COMISIONES!</h5>
                    <h4 class="mb-0">GESTIÓN DE PERMISOS</h4>
                </div>
                <div class="card-body">
                    <form id="FormPermisos">
                        <input type="hidden" id="permiso_id" name="permiso_id">
                        <input type="hidden" id="permiso_fecha" name="permiso_fecha" value="">
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
                                       placeholder="Ingrese nombre del permiso" required>
                            </div>
                            <div class="col-md-6">
                                <label for="permiso_clave" class="form-label">Clave del Permiso</label>
                                <input type="text" class="form-control" id="permiso_clave" name="permiso_clave" 
                                       placeholder="Ingrese clave del permiso" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="permiso_desc" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="permiso_desc" name="permiso_desc" 
                                       placeholder="Ingrese descripción del permiso" required>
                            </div>
                            <div class="col-md-6">
                                <label for="permiso_tipo" class="form-label">Tipo de Permiso</label>
                                <select class="form-control" id="permiso_tipo" name="permiso_tipo" required>
                                    <option value="FUNCIONAL">FUNCIONAL</option>
                                    <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                                    <option value="LECTURA">LECTURA</option>
                                    <option value="ESCRITURA">ESCRITURA</option>
                                    <option value="ELIMINACION">ELIMINACION</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="permiso_usuario_asigno" class="form-label">Usuario que Asigna</label>
                                <select class="form-control" id="permiso_usuario_asigno" name="permiso_usuario_asigno" required>
                                    <option value="">Seleccione quién asigna</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="permiso_motivo" class="form-label">Motivo</label>
                                <input type="text" class="form-control" id="permiso_motivo" name="permiso_motivo" 
                                       placeholder="Ingrese motivo de la asignación">
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Nota:</strong> La clave del permiso debe ser única en el sistema y se utilizará para validaciones internas.
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
                        <table class="table table-bordered table-hover" id="TablePermisos">
                        </table>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Permisos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
   
</head>

<body>
    <div class="container mt-4">
        
  
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                        <h3 class="mb-0">
                            <i class="bi bi-key me-2"></i>
                            Gestión de Permisos
                        </h3>
                    </div>
                    <div class="card-body">
                        <form id="FormPermisos">
                            <input type="hidden" id="id_permiso" name="id_permiso">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombre_permiso" class="form-label">Nombre del Permiso </label>
                                    <input type="text" id="nombre_permiso" name="nombre_permiso" 
                                           class="form-control" 
                                           placeholder="Ej: Administrar Usuarios" >
                                </div>
                                <div class="col-md-6">
                                    <label for="descripcion" class="form-label">Descripción </label>
                                    <input type="text" id="descripcion" name="descripcion" 
                                           class="form-control" 
                                           placeholder="Ej: Puede crear, editar y eliminar usuarios" >
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-success me-2" type="submit" id="BtnGuardar">
                                    <i class="bi bi-floppy me-1"></i>Guardar
                                </button>
                                <button class="btn btn-warning me-2 d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pencil-square me-1"></i>Modificar
                                </button>
                                <button class="btn btn-info me-2" type="button" id="BtnBuscar">
                                    <i class="bi bi-search me-1"></i>Ver Permisos
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

      
        <div class="row" id="seccionTabla" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white text-center" style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                        <h4 class="mb-0">
                            <i class="bi bi-list-ul me-2"></i>
                            Permisos del Sistema
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="TablePermisos">
                                <thead  style="background: linear-gradient(135deg,rgb(114, 70, 196) 0%,rgb(49, 22, 98) 100%);">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nombre del Permiso</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyPermisos">
                           
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('build/js/permisos/index.js') ?>"></script>
</div>
<script src="<?= asset('build/js/permisos/index.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset('build/js/permisos/index.js') ?>"></script>
</body>

</html>

