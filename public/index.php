<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\LoginController;
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

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

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


$router->comprobarRutas();