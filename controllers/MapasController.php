<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class MapaController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('mapa/index', []);
    }

    public static function obtenerUbicacionAPI(){
        getHeadersApi();
        
        try {
            // Ubicación principal del sistema PEREZ COMISIONES
            $ubicacion = [
                'id' => 1,
                'nombre' => 'Sistema PEREZ COMISIONES',
                'direccion' => 'Ciudad de Guatemala, Guatemala',
                'telefono' => '2251-0000',
                'lat' => 14.6349,
                'lng' => -90.5069,
                'descripcion' => 'Sede principal del sistema de gestión de comisiones'
            ];

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Ubicación obtenida correctamente',
                'data' => $ubicacion
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener la ubicación',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}