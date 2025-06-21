<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class MapaController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('mapas/index', []);
    }

    public static function buscarAPI(){
        try {
            // Datos simples para dos puntos en el mapa
            $data = [
                [
                    'nombre' => 'Base Militar La Aurora',
                    'lat' => 14.5833,
                    'lng' => -90.5167,
                    'descripcion' => 'Centro de Entrenamiento Principal'
                ],
                [
                    'nombre' => 'Campo de Entrenamiento Petén',
                    'lat' => 16.9167,
                    'lng' => -89.8833,
                    'descripcion' => 'Área de Capacitación Avanzada'
                ]
            ];

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Ubicaciones obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las ubicaciones',
                'detalle' => $e->getMessage()
            ]);
        }
    }

}