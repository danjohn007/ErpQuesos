<?php
/**
 * Controlador de Materias Primas
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class MateriasPrimasController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Datos demo de materias primas
        $materiasStock = [
            [
                'id' => 1,
                'nombre' => 'Leche de Vaca Fresca',
                'tipo' => 'leche',
                'cantidad' => 1250.5,
                'unidad' => 'litros',
                'fecha_ingreso' => '2025-09-19',
                'fecha_caducidad' => '2025-09-21',
                'proveedor' => 'Granja San José',
                'lote_proveedor' => 'LV-2025-089',
                'estado' => 'disponible'
            ],
            [
                'id' => 2,
                'nombre' => 'Cuajo Natural',
                'tipo' => 'insumo',
                'cantidad' => 2.8,
                'unidad' => 'kg',
                'fecha_ingreso' => '2025-09-15',
                'fecha_caducidad' => '2026-03-15',
                'proveedor' => 'Insumos Lácteos SA',
                'lote_proveedor' => 'CJ-2025-012',
                'estado' => 'disponible'
            ],
            [
                'id' => 3,
                'nombre' => 'Sal Marina Fina',
                'tipo' => 'insumo',
                'cantidad' => 45.2,
                'unidad' => 'kg',
                'fecha_ingreso' => '2025-09-10',
                'fecha_caducidad' => '2027-09-10',
                'proveedor' => 'Salinas del Pacífico',
                'lote_proveedor' => 'SM-2025-156',
                'estado' => 'disponible'
            ]
        ];
        
        $proveedoresCertificados = [
            ['nombre' => 'Granja San José', 'tipo' => 'Leche', 'certificacion' => 'SAGARPA', 'vencimiento' => '2025-12-15'],
            ['nombre' => 'Insumos Lácteos SA', 'tipo' => 'Químicos', 'certificacion' => 'FDA', 'vencimiento' => '2026-01-30'],
            ['nombre' => 'Salinas del Pacífico', 'tipo' => 'Minerales', 'certificacion' => 'NOM-251', 'vencimiento' => '2025-11-20']
        ];
        
        $estadisticas = [
            'materias_disponibles' => count($materiasStock),
            'proveedores_activos' => 8,
            'valor_inventario' => 85430.50,
            'proximos_vencer' => 2
        ];
        
        $this->view->render('modules/materias-primas/index', [
            'title' => 'Materias Primas',
            'materiasStock' => $materiasStock,
            'proveedoresCertificados' => $proveedoresCertificados,
            'estadisticas' => $estadisticas
        ]);
    }
    
    public function proveedores() {
        $this->requireAuth();
        
        $this->view->render('modules/materias-primas/proveedores', [
            'title' => 'Proveedores',
            'message' => 'Gestión de proveedores en desarrollo.'
        ]);
    }
    
    public function inventario() {
        $this->requireAuth();
        
        $this->view->render('modules/materias-primas/inventario', [
            'title' => 'Inventario de Materias Primas',
            'message' => 'Control de inventario en desarrollo.'
        ]);
    }
}