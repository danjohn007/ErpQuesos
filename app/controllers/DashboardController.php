<?php
/**
 * Controlador del Dashboard
 */

defined('ERP_QUESOS') or die('Acceso denegado');

class DashboardController extends Controller {
    
    public function index() {
        $this->requireAuth();
        
        // Obtener estadísticas básicas
        $db = Database::getInstance();
        
        // Estadísticas de producción
        $produccionHoy = $db->queryOne("
            SELECT COUNT(*) as total, SUM(cantidad_producida) as kg_producidos 
            FROM lotes_produccion 
            WHERE DATE(fecha_inicio) = CURDATE() AND estado = 'terminado'
        ");
        
        // Estadísticas de inventario
        $inventarioProductos = $db->queryOne("
            SELECT SUM(cantidad) as total_kg 
            FROM inventario 
            WHERE tipo = 'producto_terminado' AND estado = 'disponible'
        ");
        
        // Productos próximos a vencer (próximos 7 días)
        $proximosVencer = $db->query("
            SELECT p.nombre, i.cantidad, i.fecha_caducidad 
            FROM inventario i 
            JOIN productos p ON i.item_id = p.id 
            WHERE i.tipo = 'producto_terminado' 
            AND i.estado = 'disponible' 
            AND i.fecha_caducidad BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            ORDER BY i.fecha_caducidad ASC
            LIMIT 5
        ");
        
        // Lotes en proceso
        $lotesEnProceso = $db->query("
            SELECT lp.numero_lote, p.nombre as producto, lp.fecha_inicio, lp.estado
            FROM lotes_produccion lp
            JOIN recetas r ON lp.receta_id = r.id
            JOIN productos p ON r.producto_id = p.id
            WHERE lp.estado IN ('programado', 'en_proceso')
            ORDER BY lp.fecha_inicio ASC
            LIMIT 5
        ");
        
        // Ventas del mes
        $ventasMes = $db->queryOne("
            SELECT COUNT(*) as total_ordenes, SUM(total) as total_ventas
            FROM ventas 
            WHERE MONTH(fecha_venta) = MONTH(CURDATE()) 
            AND YEAR(fecha_venta) = YEAR(CURDATE())
        ") ?? ['total_ordenes' => 0, 'total_ventas' => 0];
        
        $this->view->render('dashboard/index', [
            'title' => 'Dashboard',
            'produccionHoy' => $produccionHoy,
            'inventarioProductos' => $inventarioProductos,
            'proximosVencer' => $proximosVencer,
            'lotesEnProceso' => $lotesEnProceso,
            'ventasMes' => $ventasMes
        ]);
    }
}