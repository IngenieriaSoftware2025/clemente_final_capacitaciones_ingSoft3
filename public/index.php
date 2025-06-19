<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
use Controllers\UsuariosController;
use Controllers\AplicacionController;
use Controllers\PermisosController;
use Controllers\AsignacionPermisosController;
use Controllers\ComisionController;
use Controllers\ComisionPersonalController;
use Controllers\EstadisticasController;
use Controllers\HistorialActController;
use Controllers\MapasController;
<<<<<<< HEAD
=======
=======
use Controllers\RegistroController;
use Controllers\MarcasController;
use Controllers\ModelosController;
use Controllers\ClientesController;
use Controllers\EstadisticaController;
use Controllers\InventarioController;
use Controllers\MapaController;
use Controllers\ReparacionesController;
use Controllers\RolesController;
use Controllers\PermisosController;
use Controllers\RolesPermisosController;
use Controllers\RutasActividadesController;
use Controllers\VentasController;
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
// RUTA PRINCIPAL
$router->get('/login', [LoginController::class,'renderizarPagina']);
$router->get('/inicio', [AppController::class,'index']);
$router->post('/API/login', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);

// USUARIOS
$router->get('/usuarios', [UsuariosController::class, 'renderizarPagina']);
$router->post('/usuarios/guardarAPI', [UsuariosController::class, 'guardarAPI']);
$router->get('/usuarios/buscarAPI', [UsuariosController::class, 'buscarAPI']);
$router->post('/usuarios/modificarAPI', [UsuariosController::class, 'modificarAPI']);
$router->get('/usuarios/eliminar', [UsuariosController::class, 'EliminarAPI']);

// APLICACIONES
$router->get('/aplicacion', [AplicacionController::class, 'renderizarPagina']);
$router->post('/aplicacion/guardarAPI', [AplicacionController::class, 'guardarAPI']);
$router->get('/aplicacion/buscarAPI', [AplicacionController::class, 'buscarAPI']);
$router->post('/aplicacion/modificarAPI', [AplicacionController::class, 'modificarAPI']);
$router->get('/aplicacion/eliminar', [AplicacionController::class, 'EliminarAPI']);

// PERMISOS
$router->get('/permisos', [PermisosController::class, 'renderizarPagina']);
$router->post('/permisos/guardarAPI', [PermisosController::class, 'guardarAPI']);
$router->get('/permisos/buscarAPI', [PermisosController::class, 'buscarAPI']);
$router->post('/permisos/modificarAPI', [PermisosController::class, 'modificarAPI']);
$router->get('/permisos/eliminar', [PermisosController::class, 'EliminarAPI']);
$router->get('/permisos/buscarUsuariosAPI', [PermisosController::class, 'buscarUsuariosAPI']);
$router->get('/permisos/buscarAplicacionesAPI', [PermisosController::class, 'buscarAplicacionesAPI']);

// ASIGNACIÓN DE PERMISOS
$router->get('/asignacionpermisos', [AsignacionPermisosController::class, 'renderizarPagina']);
$router->post('/asignacionpermisos/guardarAPI', [AsignacionPermisosController::class, 'guardarAPI']);
$router->get('/asignacionpermisos/buscarAPI', [AsignacionPermisosController::class, 'buscarAPI']);
$router->post('/asignacionpermisos/modificarAPI', [AsignacionPermisosController::class, 'modificarAPI']);
$router->get('/asignacionpermisos/eliminar', [AsignacionPermisosController::class, 'EliminarAPI']);
$router->get('/asignacionpermisos/buscarUsuariosAPI', [AsignacionPermisosController::class, 'buscarUsuariosAPI']);
$router->get('/asignacionpermisos/buscarAplicacionesAPI', [AsignacionPermisosController::class, 'buscarAplicacionesAPI']);
$router->get('/asignacionpermisos/buscarPermisosAPI', [AsignacionPermisosController::class, 'buscarPermisosAPI']);

// COMISIONES
$router->get('/comisiones', [ComisionController::class, 'renderizarPagina']);
$router->post('/comisiones/guardarAPI', [ComisionController::class, 'guardarAPI']);
$router->get('/comisiones/buscarAPI', [ComisionController::class, 'buscarAPI']);
$router->post('/comisiones/modificarAPI', [ComisionController::class, 'modificarAPI']);
$router->get('/comisiones/eliminar', [ComisionController::class, 'EliminarAPI']);

// COMISIÓN PERSONAL
$router->get('/comisionpersonal', [ComisionPersonalController::class, 'renderizarPagina']);
$router->post('/comisionpersonal/guardarAPI', [ComisionPersonalController::class, 'guardarAPI']);
$router->get('/comisionpersonal/buscarAPI', [ComisionPersonalController::class, 'buscarAPI']);
$router->post('/comisionpersonal/modificarAPI', [ComisionPersonalController::class, 'modificarAPI']);
$router->get('/comisionpersonal/eliminar', [ComisionPersonalController::class, 'EliminarAPI']);
$router->get('/comisionpersonal/buscarComisionesAPI', [ComisionPersonalController::class, 'buscarComisionesAPI']);
$router->get('/comisionpersonal/buscarUsuariosAPI', [ComisionPersonalController::class, 'buscarUsuariosAPI']);
$router->get('/comisionpersonal/validarAsignacionAPI', [ComisionPersonalController::class, 'validarAsignacionAPI']);

// ESTADÍSTICAS
$router->get('/estadisticas', [EstadisticasController::class, 'renderizarPagina']);
$router->get('/estadisticas/buscarComisionesPorTipoAPI', [EstadisticasController::class, 'buscarComisionesPorTipoAPI']);
$router->get('/estadisticas/buscarComisionesPorEstadoAPI', [EstadisticasController::class, 'buscarComisionesPorEstadoAPI']);
$router->get('/estadisticas/buscarPersonalMasActivoAPI', [EstadisticasController::class, 'buscarPersonalMasActivoAPI']);
$router->get('/estadisticas/buscarComisionesPorDuracionAPI', [EstadisticasController::class, 'buscarComisionesPorDuracionAPI']);
$router->get('/estadisticas/buscarComisionesMensualesAPI', [EstadisticasController::class, 'buscarComisionesMensualesAPI']);
$router->get('/estadisticas/buscarUsuariosPorPermisosAPI', [EstadisticasController::class, 'buscarUsuariosPorPermisosAPI']);

// MAPA
$router->get('/mapa', [MapasController::class, 'renderizarPagina']);

// HISTORIAL DE ACTIVIDADES
$router->get('/historial', [HistorialActController::class, 'renderizarPagina']);
$router->get('/historial/buscarAPI', [HistorialActController::class, 'buscarAPI']);
$router->get('/historial/buscarUsuariosAPI', [HistorialActController::class, 'buscarUsuariosAPI']);
$router->get('/historial/exportarReporteAPI', [HistorialActController::class, 'exportarReporteAPI']);
$router->get('/historial/buscarActividadPorTipoAPI', [HistorialActController::class, 'buscarActividadPorTipoAPI']);
$router->get('/historial/buscarActividadPorUsuarioAPI', [HistorialActController::class, 'buscarActividadPorUsuarioAPI']);
$router->get('/historial/buscarActividadPorDiaAPI', [HistorialActController::class, 'buscarActividadPorDiaAPI']);
$router->get('/historial/buscarActividadPorModuloAPI', [HistorialActController::class, 'buscarActividadPorModuloAPI']);
<<<<<<< HEAD
=======
=======
//  LOGIN RUTA PRINCIPAL AL ABRIR DESDE DOCKER
$router->get('/', [LoginController::class, 'renderizarPagina']);

// Rutas del sistema de login
$router->get('/login', [LoginController::class, 'renderizarPagina']); //MOSTRAR FORMULARIO DE LOGIN
$router->post('/login', [LoginController::class, 'login']); //PROCESAR DATOS LOGIN 
$router->get('/inicio', [LoginController::class, 'renderInicio']); //PAGINA PRINCIPAL PROTEGIDA ?
$router->post('/logout', [LoginController::class, 'logout']); //CERRAR SESION ?

// Ruta de prueba
$router->post('/test', [AppController::class, 'testLogin']);

// REGISTRO/USUARIOS
$router->get('/registro', [RegistroController::class, 'renderizarPagina']);
$router->post('/registro/guardarAPI', [RegistroController::class, 'guardarAPI']);
$router->get('/registro/buscarAPI', [RegistroController::class, 'buscarAPI']);
$router->post('/registro/modificarAPI', [RegistroController::class, 'modificarAPI']);
$router->get('/registro/eliminarAPI', [RegistroController::class, 'eliminarAPI']);
$router->get('/registro/obtenerRolesAPI', [RegistroController::class, 'obtenerRolesAPI']);


// ROLES
$router->get('/roles', [RolesController::class, 'renderizarPagina']);
$router->post('/roles/guardarAPI', [RolesController::class, 'guardarAPI']);
$router->get('/roles/buscarAPI', [RolesController::class, 'buscarAPI']);
$router->post('/roles/modificarAPI', [RolesController::class, 'modificarAPI']);
$router->get('/roles/eliminarAPI', [RolesController::class, 'eliminarAPI']);
$router->get('/roles/estadisticasAPI', [RolesController::class, 'estadisticasAPI']);
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675


$router->comprobarRutas();