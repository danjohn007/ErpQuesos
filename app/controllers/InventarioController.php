<?php
/**
 * Controlador de Inventario
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class InventarioController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Datos demo para inventario
        $productosInventario = [
            [
                'id' => 1,
                'codigo' => 'QM-001',
                'nombre' => 'Queso Manchego Curado',
                'categoria' => 'Curado',
                'ubicacion' => 'Cámara A-1',
                'lote' => 'LOT-2025-001',
                'cantidad' => 45.5,
                'unidad' => 'kg',
                'fecha_produccion' => '2024-12-15',
                'fecha_caducidad' => '2025-10-15',
                'precio_unitario' => 350.00,
                'estado' => 'disponible'
            ],
            [
                'id' => 2,
                'codigo' => 'QF-002',
                'nombre' => 'Queso Fresco Ranchero',
                'categoria' => 'Fresco',
                'ubicacion' => 'Refrigerador B-2',
                'lote' => 'LOT-2025-002',
                'cantidad' => 28.0,
                'unidad' => 'kg',
                'fecha_produccion' => '2025-09-17',
                'fecha_caducidad' => '2025-09-22',
                'precio_unitario' => 180.00,
                'estado' => 'disponible'
            ],
            [
                'id' => 3,
                'codigo' => 'QO-003',
                'nombre' => 'Queso Oaxaca',
                'categoria' => 'Fresco',
                'ubicacion' => 'Refrigerador B-1',
                'lote' => 'LOT-2025-003',
                'cantidad' => 15.2,
                'unidad' => 'kg',
                'fecha_produccion' => '2025-09-16',
                'fecha_caducidad' => '2025-09-23',
                'precio_unitario' => 220.00,
                'estado' => 'próximo_vencer'
            ]
        ];
        
        $movimientosRecientes = [
            ['tipo' => 'entrada', 'producto' => 'Queso Fresco', 'cantidad' => '+12.5 kg', 'fecha' => '2025-09-19', 'motivo' => 'Producción'],
            ['tipo' => 'salida', 'producto' => 'Queso Manchego', 'cantidad' => '-8.0 kg', 'fecha' => '2025-09-19', 'motivo' => 'Venta'],
            ['tipo' => 'entrada', 'producto' => 'Queso Oaxaca', 'cantidad' => '+6.5 kg', 'fecha' => '2025-09-18', 'motivo' => 'Producción']
        ];
        
        $alertas = [
            ['producto' => 'Queso Fresco Ranchero', 'ubicacion' => 'Refrigerador B-2', 'tipo' => 'próximo_vencer', 'dias' => 3],
            ['producto' => 'Queso Oaxaca', 'ubicacion' => 'Refrigerador B-1', 'tipo' => 'stock_bajo', 'cantidad' => 15.2]
        ];
        
        $estadisticas = [
            'valor_total' => 25875.00,
            'productos_activos' => 12,
            'ubicaciones' => 8,
            'proximos_vencer' => 2
        ];
        
        $this->view->render('modules/inventario/index', [
            'title' => 'Gestión de Inventarios',
            'productosInventario' => $productosInventario,
            'movimientosRecientes' => $movimientosRecientes,
            'alertas' => $alertas,
            'estadisticas' => $estadisticas
        ]);
    }
    
    public function productos() {
        $this->requireAuth();
        
        $this->view->render('modules/inventario/productos', [
            'title' => 'Productos en Inventario',
            'message' => 'Gestión de productos en desarrollo.'
        ]);
    }
    
    public function movimientos() {
        $this->requireAuth();
        
        $this->view->render('modules/inventario/movimientos', [
            'title' => 'Movimientos de Inventario',
            'message' => 'Control de movimientos en desarrollo.'
        ]);
    }
}