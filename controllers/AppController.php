<?php

namespace Controllers;

use MVC\Router;


class AppController {
    public static function index(Router $router){

        $router->render('pages/index', [], $layout = 'layouts/layoutlogin');
        //renderizar para la pagina principal, para que aparezaca
    }

    public static function testLogin() {
    getHeadersApi();
    echo json_encode([
        'codigo' => 1,
        'mensaje' => 'Test exitoso'
    ]);
}
}