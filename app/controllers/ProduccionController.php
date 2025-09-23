<?php
/**
 * Controlador de Producción
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class ProduccionController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Inicializar datos para el dashboard
        $estadisticas = [
            'lotes_hoy' => 0,
            'kg_producidos' => 0,
            'lotes_proceso' => 0,
            'total_recetas' => 0
        ];
        $lotesRecientes = [];
        $recetasActivas = [];
        
        try {
            // Obtener estadísticas de producción
            $db = Database::getInstance();
            
            // Lotes iniciados hoy
            $estadisticas['lotes_hoy'] = $db->queryOne("
                SELECT COUNT(*) as total 
                FROM lotes_produccion 
                WHERE DATE(fecha_inicio) = CURDATE()
            ")['total'] ?? 0;
            
            // Kilogramos producidos hoy
            $estadisticas['kg_producidos'] = $db->queryOne("
                SELECT SUM(cantidad_producida) as total 
                FROM lotes_produccion 
                WHERE DATE(fecha_inicio) = CURDATE() AND estado = 'terminado'
            ")['total'] ?? 0;
            
            // Lotes en proceso
            $estadisticas['lotes_proceso'] = $db->queryOne("
                SELECT COUNT(*) as total 
                FROM lotes_produccion 
                WHERE estado IN ('programado', 'en_proceso')
            ")['total'] ?? 0;
            
            // Total de recetas
            $estadisticas['total_recetas'] = $db->queryOne("
                SELECT COUNT(*) as total 
                FROM recetas 
                WHERE activo = 1
            ")['total'] ?? 0;
            
            // Lotes recientes
            $lotesRecientes = $db->query("
                SELECT lp.id, lp.numero_lote, p.nombre as producto, lp.fecha_inicio, lp.estado
                FROM lotes_produccion lp
                LEFT JOIN recetas r ON lp.receta_id = r.id
                LEFT JOIN productos p ON r.producto_id = p.id
                ORDER BY lp.fecha_inicio DESC
                LIMIT 5
            ") ?? [];
            
            // Recetas activas
            $recetasActivas = $db->query("
                SELECT r.id, r.nombre, r.descripcion, r.tiempo_preparacion
                FROM recetas r
                WHERE r.activo = 1
                ORDER BY r.nombre ASC
                LIMIT 5
            ") ?? [];
            
        } catch (Exception $e) {
            // En caso de error de base de datos, usar datos demo
            if (DEBUG_MODE) {
                $this->setFlash('warning', 'Base de datos no conectada, mostrando datos demo');
            }
            
            $estadisticas = [
                'lotes_hoy' => 2,
                'kg_producidos' => 85.5,
                'lotes_proceso' => 3,
                'total_recetas' => 8
            ];
            
            $lotesRecientes = [
                [
                    'id' => 1,
                    'numero_lote' => 'LOT-' . date('Ymd') . '-001',
                    'producto' => 'Queso Manchego',
                    'fecha_inicio' => date('Y-m-d H:i:s'),
                    'estado' => 'en_proceso'
                ],
                [
                    'id' => 2,
                    'numero_lote' => 'LOT-' . date('Ymd') . '-002',
                    'producto' => 'Queso Fresco',
                    'fecha_inicio' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                    'estado' => 'programado'
                ],
                [
                    'id' => 3,
                    'numero_lote' => 'LOT-' . date('Ymd', strtotime('-1 day')) . '-003',
                    'producto' => 'Queso Oaxaca',
                    'fecha_inicio' => date('Y-m-d H:i:s', strtotime('-1 day')),
                    'estado' => 'terminado'
                ]
            ];
            
            $recetasActivas = [
                [
                    'id' => 1,
                    'nombre' => 'Queso Fresco Ranchero',
                    'descripcion' => 'Receta tradicional para queso fresco',
                    'tiempo_preparacion' => 120
                ],
                [
                    'id' => 2,
                    'nombre' => 'Queso Manchego Curado',
                    'descripcion' => 'Receta para queso manchego con 3 meses de curado',
                    'tiempo_preparacion' => 240
                ],
                [
                    'id' => 3,
                    'nombre' => 'Queso Oaxaca',
                    'descripcion' => 'Queso de hebra estilo Oaxaca',
                    'tiempo_preparacion' => 180
                ]
            ];
        }
        
        $this->view->render('modules/produccion/index', [
            'title' => 'Módulo de Producción',
            'estadisticas' => $estadisticas,
            'lotesRecientes' => $lotesRecientes,
            'recetasActivas' => $recetasActivas
        ]);
    }
    
    public function recetas() {
        $this->requireAuth();
        
        $this->view->render('modules/produccion/recetas', [
            'title' => 'Recetas de Producción',
            'message' => 'Gestión de recetas en desarrollo.'
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