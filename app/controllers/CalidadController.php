<?php
/**
 * Controlador de Control de Calidad
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class CalidadController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Datos demo para control de calidad
        $analisisRecientes = [
            [
                'id' => 1,
                'lote' => 'LOT-2025-001',
                'producto' => 'Queso Manchego',
                'fecha' => '2025-09-19',
                'ph' => 5.2,
                'humedad' => 42.5,
                'grasa' => 28.0,
                'estado' => 'aprobado',
                'responsable' => 'Ana García'
            ],
            [
                'id' => 2,
                'lote' => 'LOT-2025-002',
                'producto' => 'Queso Fresco',
                'fecha' => '2025-09-19',
                'ph' => 6.1,
                'humedad' => 55.2,
                'grasa' => 25.5,
                'estado' => 'pendiente',
                'responsable' => 'Carlos López'
            ],
            [
                'id' => 3,
                'lote' => 'LOT-2025-003',
                'producto' => 'Queso Oaxaca',
                'fecha' => '2025-09-18',
                'ph' => 5.8,
                'humedad' => 48.1,
                'grasa' => 22.8,
                'estado' => 'observaciones',
                'responsable' => 'María Rodríguez'
            ]
        ];
        
        $alertasCalidad = [
            ['mensaje' => 'Lote LOT-2025-004 requiere análisis urgente', 'tipo' => 'urgente'],
            ['mensaje' => '3 productos próximos a caducar requieren inspección', 'tipo' => 'advertencia'],
            ['mensaje' => 'Certificación HACCP vence en 15 días', 'tipo' => 'info']
        ];
        
        $estadisticas = [
            'analisis_mes' => 45,
            'aprobados' => 42,
            'pendientes' => 3,
            'porcentaje_aprobacion' => 93.3
        ];
        
        $this->view->render('modules/calidad/index', [
            'title' => 'Control de Calidad',
            'analisisRecientes' => $analisisRecientes,
            'alertasCalidad' => $alertasCalidad,
            'estadisticas' => $estadisticas
        ]);
    }
    
    public function analisis() {
        $this->requireAuth();
        
        $this->view->render('modules/calidad/analisis', [
            'title' => 'Análisis de Calidad',
            'message' => 'Módulo de análisis en desarrollo.'
        ]);
    }
    
    public function trazabilidad() {
        $this->requireAuth();
        
        $this->view->render('modules/calidad/trazabilidad', [
            'title' => 'Trazabilidad',
            'message' => 'Sistema de trazabilidad en desarrollo.'
        ]);
    }
}