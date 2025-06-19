<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
use Controllers\UsuariosController;
use Controllers\AplicacionController;
use Controllers\PermisosController;
use Controllers\AsignacionPermisosController;
use Controllers\ComisionController;
use Controllers\ComisionPersonalController;
use Controllers\EstadisticasController;
use Controllers\HistorialActController;
use Controllers\MapasController;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

// RUTA PRINCIPAL
$router->get('/login', [LoginController::class,'renderizarPagina']);
$router->get('/inicio', [AppController::class,'index']);
$router->post('/API/login', [LoginController::class,'login']);
$router->get('/logout', [LoginController::class,'logout']);

// USUARIOS
$router->get('/usuarios', [UsuariosController::class, 'renderizarPagina']);
$router->post('/API/usuarios/guardar', [UsuariosController::class, 'guardarAPI']);
$router->get('/API/usuarios/buscar', [UsuariosController::class, 'buscarAPI']);
$router->post('/API/usuarios/modificar', [UsuariosController::class, 'modificarAPI']);
$router->get('/API/usuarios/eliminar', [UsuariosController::class, 'EliminarAPI']);

// APLICACIONES
$router->get('/aplicacion', [AplicacionController::class, 'renderizarPagina']);
$router->post('/API/aplicacion/guardar', [AplicacionController::class, 'guardarAPI']);
$router->get('/API/aplicacion/buscar', [AplicacionController::class, 'buscarAPI']);
$router->post('/API/aplicacion/modificar', [AplicacionController::class, 'modificarAPI']);
$router->get('/API/aplicacion/eliminar', [AplicacionController::class, 'EliminarAPI']);

// PERMISOS
$router->get('/permisos', [PermisosController::class, 'renderizarPagina']);
$router->post('/API/permisos/guardar', [PermisosController::class, 'guardarAPI']);
$router->get('/API/permisos/buscar', [PermisosController::class, 'buscarAPI']);
$router->post('/API/permisos/modificar', [PermisosController::class, 'modificarAPI']);
$router->get('/API/permisos/eliminar', [PermisosController::class, 'EliminarAPI']);
$router->get('/API/permisos/buscarUsuarios', [PermisosController::class, 'buscarUsuariosAPI']);
$router->get('/API/permisos/buscarAplicaciones', [PermisosController::class, 'buscarAplicacionesAPI']);

// ASIGNACIÓN DE PERMISOS
$router->get('/asignacionpermisos', [AsignacionPermisosController::class, 'renderizarPagina']);
$router->post('/API/asignacionpermisos/guardar', [AsignacionPermisosController::class, 'guardarAPI']);
$router->get('/API/asignacionpermisos/buscar', [AsignacionPermisosController::class, 'buscarAPI']);
$router->post('/API/asignacionpermisos/modificar', [AsignacionPermisosController::class, 'modificarAPI']);
$router->get('/API/asignacionpermisos/eliminar', [AsignacionPermisosController::class, 'EliminarAPI']);
$router->get('/API/asignacionpermisos/buscarUsuarios', [AsignacionPermisosController::class, 'buscarUsuariosAPI']);
$router->get('/API/asignacionpermisos/buscarAplicaciones', [AsignacionPermisosController::class, 'buscarAplicacionesAPI']);
$router->get('/API/asignacionpermisos/buscarPermisos', [AsignacionPermisosController::class, 'buscarPermisosAPI']);

// COMISIONES
$router->get('/comisiones', [ComisionController::class, 'renderizarPagina']);
$router->post('/API/comisiones/guarda', [ComisionController::class, 'guardarAPI']);
$router->get('/API/comisiones/buscar', [ComisionController::class, 'buscarAPI']);
$router->post('/API/comisiones/modificar', [ComisionController::class, 'modificarAPI']);
$router->get('/API/comisiones/eliminar', [ComisionController::class, 'EliminarAPI']);

// COMISIÓN PERSONAL
$router->get('/comisionpersonal', [ComisionPersonalController::class, 'renderizarPagina']);
$router->post('/API/comisionpersonal/guardar', [ComisionPersonalController::class, 'guardarAPI']);
$router->get('/API/comisionpersonal/buscar', [ComisionPersonalController::class, 'buscarAPI']);
$router->post('/API/comisionpersonal/modificar', [ComisionPersonalController::class, 'modificarAPI']);
$router->get('/API/comisionpersonal/eliminar', [ComisionPersonalController::class, 'EliminarAPI']);
$router->get('/API/comisionpersonal/buscarComisiones', [ComisionPersonalController::class, 'buscarComisionesAPI']);
$router->get('/API/comisionpersonal/buscarUsuarios', [ComisionPersonalController::class, 'buscarUsuariosAPI']);
$router->get('/API/comisionpersonal/validarAsignacion', [ComisionPersonalController::class, 'validarAsignacionAPI']);

// ESTADÍSTICAS
$router->get('/estadisticas', [EstadisticasController::class, 'renderizarPagina']);
$router->get('/API/estadisticas/buscarComisionesPorTipo', [EstadisticasController::class, 'buscarComisionesPorTipoAPI']);
$router->get('/API/estadisticas/buscarComisionesPorEstado', [EstadisticasController::class, 'buscarComisionesPorEstadoAPI']);
$router->get('/API/estadisticas/buscarPersonalMasActivo', [EstadisticasController::class, 'buscarPersonalMasActivoAPI']);
$router->get('/API/estadisticas/buscarComisionesPorDuracion', [EstadisticasController::class, 'buscarComisionesPorDuracionAPI']);
$router->get('/API/estadisticas/buscarComisionesMensuales', [EstadisticasController::class, 'buscarComisionesMensualesAPI']);
$router->get('/API/estadisticas/buscarUsuariosPorPermisos', [EstadisticasController::class, 'buscarUsuariosPorPermisosAPI']);

// MAPA
$router->get('/mapa', [MapasController::class, 'renderizarPagina']);

// HISTORIAL DE ACTIVIDADES
$router->get('/historial', [HistorialActController::class, 'renderizarPagina']);
$router->get('/API/historial/buscar', [HistorialActController::class, 'buscarAPI']);
$router->get('/API/historial/buscarUsuarios', [HistorialActController::class, 'buscarUsuariosAPI']);
$router->get('/API/historial/exportarReporte', [HistorialActController::class, 'exportarReporteAPI']);
$router->get('/API/historial/buscarActividadPorTipo', [HistorialActController::class, 'buscarActividadPorTipoAPI']);
$router->get('/API/historial/buscarActividadPorUsuario', [HistorialActController::class, 'buscarActividadPorUsuarioAPI']);
$router->get('/API/historial/buscarActividadPorDia', [HistorialActController::class, 'buscarActividadPorDiaAPI']);
$router->get('/API/historial/buscarActividadPorModulo', [HistorialActController::class, 'buscarActividadPorModuloAPI']);


$router->comprobarRutas();