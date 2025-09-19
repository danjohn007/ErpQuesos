<?php
/**
 * Controlador de Producción
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class ProduccionController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Datos demo para producción
        $lotesHoy = [
            ['id' => 1, 'numero' => 'LOT-2025-001', 'producto' => 'Queso Manchego', 'cantidad' => 25.5, 'estado' => 'en_proceso', 'progreso' => 65],
            ['id' => 2, 'numero' => 'LOT-2025-002', 'producto' => 'Queso Fresco', 'cantidad' => 18.0, 'estado' => 'terminado', 'progreso' => 100],
            ['id' => 3, 'numero' => 'LOT-2025-003', 'producto' => 'Queso Oaxaca', 'cantidad' => 12.8, 'estado' => 'programado', 'progreso' => 0]
        ];
        
        $recetasActivas = [
            ['id' => 1, 'nombre' => 'Queso Manchego Tradicional', 'tiempo_maduracion' => 45, 'rendimiento' => 85],
            ['id' => 2, 'nombre' => 'Queso Fresco Ranchero', 'tiempo_maduracion' => 0, 'rendimiento' => 92],
            ['id' => 3, 'nombre' => 'Queso Oaxaca Artesanal', 'tiempo_maduracion' => 7, 'rendimiento' => 88]
        ];
        
        $estadisticas = [
            'produccion_dia' => 56.3,
            'lotes_activos' => 12,
            'recetas_disponibles' => 8,
            'eficiencia_promedio' => 89.5
        ];
        
        $this->view->render('modules/produccion/index', [
            'title' => 'Gestión de Producción',
            'lotesHoy' => $lotesHoy,
            'recetasActivas' => $recetasActivas,
            'estadisticas' => $estadisticas
        ]);
    }
    
    public function recetas() {
        $this->requireAuth();
        
        // Datos demo de recetas
        $recetas = [
            [
                'id' => 1,
                'nombre' => 'Queso Manchego Tradicional',
                'categoria' => 'Semicurado',
                'tiempo_maduracion' => 45,
                'rendimiento' => 85,
                'ingredientes' => ['Leche de oveja', 'Cuajo natural', 'Sal marina'],
                'estado' => 'activa',
                'creado' => '2025-01-15'
            ],
            [
                'id' => 2,
                'nombre' => 'Queso Fresco Ranchero',
                'categoria' => 'Fresco',
                'tiempo_maduracion' => 0,
                'rendimiento' => 92,
                'ingredientes' => ['Leche de vaca', 'Cuajo', 'Sal', 'Ácido cítrico'],
                'estado' => 'activa',
                'creado' => '2025-01-10'
            ],
            [
                'id' => 3,
                'nombre' => 'Queso Oaxaca Artesanal',
                'categoria' => 'Fresco',
                'tiempo_maduracion' => 7,
                'rendimiento' => 88,
                'ingredientes' => ['Leche de vaca', 'Cuajo', 'Sal'],
                'estado' => 'activa',
                'creado' => '2025-01-08'
            ]
        ];
        
        $this->view->render('modules/produccion/recetas', [
            'title' => 'Recetas de Producción',
            'recetas' => $recetas
        ]);
    }
    
    public function lotes() {
        $this->requireAuth();
        
        $this->view->render('modules/produccion/lotes', [
            'title' => 'Lotes de Producción',
            'message' => 'Gestión de lotes en desarrollo.'
        ]);
    }
    
    public function crearLote() {
        $this->requireAuth();
        
        $this->view->render('modules/produccion/crear-lote', [
            'title' => 'Crear Lote de Producción',
            'message' => 'Funcionalidad en desarrollo.'
        ]);
    }
    
    public function verLote($id) {
        $this->requireAuth();
        
        $this->view->render('modules/produccion/ver-lote', [
            'title' => 'Ver Lote de Producción',
            'message' => 'Funcionalidad en desarrollo.',
            'lote_id' => $id
        ]);
    }
}