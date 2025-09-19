<?php
/**
 * Controlador de Ventas
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class VentasController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Datos demo para ventas
        $ventasRecientes = [
            [
                'id' => 1,
                'numero' => 'VEN-2025-001',
                'cliente' => 'Supermercado La Estrella',
                'fecha' => '2025-09-19',
                'productos' => ['Queso Fresco 5kg', 'Queso Manchego 2kg'],
                'total' => 1250.00,
                'estado' => 'pagada',
                'vendedor' => 'Carlos Méndez'
            ],
            [
                'id' => 2,
                'numero' => 'VEN-2025-002',
                'cliente' => 'Restaurante El Buen Sabor',
                'fecha' => '2025-09-19',
                'productos' => ['Queso Oaxaca 3kg', 'Queso Fresco 2kg'],
                'total' => 850.00,
                'estado' => 'pendiente',
                'vendedor' => 'Ana García'
            ],
            [
                'id' => 3,
                'numero' => 'VEN-2025-003',
                'cliente' => 'Tienda Don José',
                'fecha' => '2025-09-18',
                'productos' => ['Queso Manchego 1kg'],
                'total' => 320.00,
                'estado' => 'entregada',
                'vendedor' => 'Luis Torres'
            ]
        ];
        
        $clientesActivos = [
            ['nombre' => 'Supermercado La Estrella', 'tipo' => 'Mayorista', 'credito' => 25000.00, 'ultima_compra' => '2025-09-19'],
            ['nombre' => 'Restaurante El Buen Sabor', 'tipo' => 'HORECA', 'credito' => 15000.00, 'ultima_compra' => '2025-09-19'],
            ['nombre' => 'Tienda Don José', 'tipo' => 'Detallista', 'credito' => 5000.00, 'ultima_compra' => '2025-09-18']
        ];
        
        $estadisticas = [
            'ventas_dia' => 2420.00,
            'ordenes_pendientes' => 5,
            'clientes_activos' => 24,
            'meta_mensual' => 75.5
        ];
        
        $this->view->render('modules/ventas/index', [
            'title' => 'Ventas y Distribución',
            'ventasRecientes' => $ventasRecientes,
            'clientesActivos' => $clientesActivos,
            'estadisticas' => $estadisticas
        ]);
    }
    
    public function clientes() {
        $this->requireAuth();
        
        $this->view->render('modules/ventas/clientes', [
            'title' => 'Gestión de Clientes',
            'message' => 'Módulo de clientes en desarrollo.'
        ]);
    }
    
    public function ordenes() {
        $this->requireAuth();
        
        $this->view->render('modules/ventas/ordenes', [
            'title' => 'Órdenes de Venta',
            'message' => 'Gestión de órdenes en desarrollo.'
        ]);
    }
    
    public function facturacion() {
        $this->requireAuth();
        
        $this->view->render('modules/ventas/facturacion', [
            'title' => 'Facturación',
            'message' => 'Sistema de facturación en desarrollo.'
        ]);
    }
}