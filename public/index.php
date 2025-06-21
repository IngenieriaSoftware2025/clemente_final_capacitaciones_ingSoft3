<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
use Controllers\UsuariosController;
use Controllers\AplicacionController;
use Controllers\AreaEntrenamientoController;
use Controllers\AsignacionPermisosController;
use Controllers\PermisosController;
use Controllers\CapacitacionController;
use Controllers\CompaniaController;
use Controllers\EstadisticasEntrenamientoController;
use Controllers\HistorialActividadesController;
use Controllers\HorarioEntrenamientoController;
use Controllers\InstructorController;
use Controllers\MapaController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);



// RUTA PRINCIPAL
$router->get('/login', [LoginController::class,'renderizarPagina']);
$router->post('/API/login', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);

// USUARIOS
$router->get('/usuarios', [UsuariosController::class, 'renderizarPagina']);
$router->post('/API/usuarios/guardar', [UsuariosController::class, 'guardarAPI']);
$router->get('/API/usuarios/buscar', [UsuariosController::class, 'buscarAPI']);
$router->post('/API/usuarios/modificar', [UsuariosController::class, 'modificarAPI']);
$router->get('/API/usuarios/eliminar', [UsuariosController::class, 'eliminarAPI']);

// COMPAÑÍAS
$router->get('/compania', [CompaniaController::class, 'renderizarPagina']);
$router->post('/API/compania/guardar', [CompaniaController::class, 'guardarAPI']);
$router->get('/API/compania/buscar', [CompaniaController::class, 'buscarAPI']);
$router->post('/API/compania/modificar', [CompaniaController::class, 'modificarAPI']);
$router->get('/API/compania/eliminar', [CompaniaController::class, 'eliminarAPI']);

// INSTRUCTORES
$router->get('/instructor', [InstructorController::class, 'renderizarPagina']);
$router->post('/API/instructor/guardar', [InstructorController::class, 'guardarAPI']);
$router->get('/API/instructor/buscar', [InstructorController::class, 'buscarAPI']);
$router->post('/API/instructor/modificar', [InstructorController::class, 'modificarAPI']);
$router->get('/API/instructor/eliminar', [InstructorController::class, 'eliminarAPI']);
$router->get('/API/instructor/obtenerUsuarios', [InstructorController::class, 'obtenerUsuariosAPI']);

// ÁREAS DE ENTRENAMIENTO
$router->get('/areaentrenamiento', [AreaEntrenamientoController::class, 'renderizarPagina']);
$router->post('/API/areaentrenamiento/guardar', [AreaEntrenamientoController::class, 'guardarAPI']);
$router->get('/API/areaentrenamiento/buscar', [AreaEntrenamientoController::class, 'buscarAPI']);
$router->post('/API/areaentrenamiento/modificar', [AreaEntrenamientoController::class, 'modificarAPI']);
$router->get('/API/areaentrenamiento/eliminar', [AreaEntrenamientoController::class, 'eliminarAPI']);

// ENTRENAMIENTOS y horario
$router->get('/horarioentrenamiento', [HorarioEntrenamientoController::class, 'renderizarPagina']);
$router->post('/API/horarioentrenamiento/guardar', [HorarioEntrenamientoController::class, 'guardarAPI']);
$router->get('/API/horarioentrenamiento/buscar', [HorarioEntrenamientoController::class, 'buscarAPI']);
$router->post('/API/horarioentrenamiento/modificar', [HorarioEntrenamientoController::class, 'modificarAPI']);
$router->get('/API/horarioentrenamiento/eliminar', [HorarioEntrenamientoController::class, 'eliminarAPI']);
$router->get('/API/horarioentrenamiento/obtenerCapacitaciones', [HorarioEntrenamientoController::class, 'obtenerCapacitacionesAPI']);
$router->get('/API/horarioentrenamiento/obtenerCompanias', [HorarioEntrenamientoController::class, 'obtenerCompaniasAPI']);
$router->get('/API/horarioentrenamiento/obtenerInstructores', [HorarioEntrenamientoController::class, 'obtenerInstructoresAPI']);
$router->get('/API/horarioentrenamiento/obtenerAreas', [HorarioEntrenamientoController::class, 'obtenerAreasAPI']);

// ESTADÍSTICAS DE ENTRENAMIENTOS
$router->get('/estadisticasentrenamiento', [EstadisticasEntrenamientoController::class, 'renderizarPagina']);
$router->get('/API/estadisticasentrenamiento/buscar', [EstadisticasEntrenamientoController::class, 'buscarAPI']);
$router->get('/API/estadisticasentrenamiento/buscarPorFechas', [EstadisticasEntrenamientoController::class, 'buscarPorFechasAPI']);


// APLICACIONES
$router->get('/aplicacion', [AplicacionController::class, 'renderizarPagina']);
$router->post('/API/aplicacion/guardar', [AplicacionController::class, 'guardarAPI']);
$router->get('/API/aplicacion/buscar', [AplicacionController::class, 'buscarAPI']);
$router->post('/API/aplicacion/modificar', [AplicacionController::class, 'modificarAPI']);
$router->get('/API/aplicacion/eliminar', [AplicacionController::class, 'eliminarAPI']);


// PERMISOS
$router->get('/permisos', [PermisosController::class, 'renderizarPagina']);
$router->post('/API/permisos/guardar', [PermisosController::class, 'guardarAPI']);
$router->get('/API/permisos/buscar', [PermisosController::class, 'buscarAPI']);
$router->post('/API/permisos/modificar', [PermisosController::class, 'modificarAPI']);
$router->get('/API/permisos/eliminar', [PermisosController::class, 'eliminarAPI']);
$router->get('/API/permisos/buscarUsuarios', [PermisosController::class, 'buscarUsuariosAPI']);
$router->get('/API/permisos/buscarAplicaciones', [PermisosController::class, 'buscarAplicacionesAPI']);


// CAPACITACIONES
$router->get('/capacitacion', [CapacitacionController::class, 'renderizarPagina']);
$router->post('/API/capacitacion/guardar', [CapacitacionController::class, 'guardarAPI']);
$router->get('/API/capacitacion/buscar', [CapacitacionController::class, 'buscarAPI']);
$router->post('/API/capacitacion/modificar', [CapacitacionController::class, 'modificarAPI']);
$router->get('/API/capacitacion/eliminar', [CapacitacionController::class, 'eliminarAPI']);
$router->get('/API/capacitacion/obtenerUsuarios', [CapacitacionController::class, 'obtenerUsuariosAPI']);


// PERMISOS
$router->get('/permisos', [PermisosController::class, 'renderizarPagina']);
$router->post('/API/permisos/guardar', [PermisosController::class, 'guardarAPI']);
$router->get('/API/permisos/buscar', [PermisosController::class, 'buscarAPI']);
$router->post('/API/permisos/modificar', [PermisosController::class, 'modificarAPI']);
$router->get('/API/permisos/eliminar', [PermisosController::class, 'eliminarAPI']);
$router->get('/API/permisos/obtenerUsuarios', [PermisosController::class, 'obtenerUsuariosAPI']);
$router->get('/API/permisos/obtenerAplicaciones', [PermisosController::class, 'obtenerAplicacionesAPI']);


// ASIGNACIÓN DE PERMISOS
$router->get('/asignacionpermisos', [AsignacionPermisosController::class, 'renderizarPagina']);
$router->post('/API/asignacionpermisos/guardar', [AsignacionPermisosController::class, 'guardarAPI']);
$router->get('/API/asignacionpermisos/buscar', [AsignacionPermisosController::class, 'buscarAPI']);
$router->post('/API/asignacionpermisos/modificar', [AsignacionPermisosController::class, 'modificarAPI']);
$router->get('/API/asignacionpermisos/eliminar', [AsignacionPermisosController::class, 'eliminarAPI']);
$router->get('/API/asignacionpermisos/obtenerUsuarios', [AsignacionPermisosController::class, 'obtenerUsuariosAPI']);
$router->get('/API/asignacionpermisos/obtenerAplicaciones', [AsignacionPermisosController::class, 'obtenerAplicacionesAPI']);
$router->get('/API/asignacionpermisos/obtenerPermisos', [AsignacionPermisosController::class, 'obtenerPermisosAPI']);


// MAPAS
$router->get('/mapas', [MapaController::class, 'renderizarPagina']);
$router->get('/mapas/buscarAPI', [MapaController::class, 'buscarAPI']);

//historial_actividades
$router->get('/historial_actividades', [HistorialActividadesController::class, 'renderizarPagina']);
$router->get('/historial_actividades/buscarAPI', [HistorialActividadesController::class, 'buscarAPI']);
$router->get('/historial_actividades/buscarUsuariosAPI', [HistorialActividadesController::class, 'buscarUsuariosAPI']);







$router->comprobarRutas();