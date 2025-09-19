<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-warehouse"></i> <?= $title ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= $this->url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Alertas de Inventario -->
    <?php if (!empty($alertas)): ?>
    <div class="row mb-4">
        <div class="col-12">
            <?php foreach ($alertas as $alerta): ?>
            <div class="alert alert-<?= $alerta['tipo'] == 'próximo_vencer' ? 'warning' : 'danger' ?> alert-dismissible fade show">
                <i class="fas fa-<?= $alerta['tipo'] == 'próximo_vencer' ? 'clock' : 'exclamation-triangle' ?>"></i>
                <strong><?= $this->escape($alerta['producto']) ?></strong> en <?= $this->escape($alerta['ubicacion']) ?>:
                <?php if ($alerta['tipo'] == 'próximo_vencer'): ?>
                    Vence en <?= $alerta['dias'] ?> días
                <?php else: ?>
                    Stock bajo (<?= $alerta['cantidad'] ?> kg restantes)
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Estadísticas de Inventario -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Valor Total</h6>
                            <h3 class="mb-0"><?= $this->formatMoney($estadisticas['valor_total']) ?></h3>
                        </div>
                        <div><i class="fas fa-dollar-sign fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Productos Activos</h6>
                            <h3 class="mb-0"><?= $estadisticas['productos_activos'] ?></h3>
                        </div>
                        <div><i class="fas fa-box fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Ubicaciones</h6>
                            <h3 class="mb-0"><?= $estadisticas['ubicaciones'] ?></h3>
                        </div>
                        <div><i class="fas fa-map-marker-alt fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Próximos a Vencer</h6>
                            <h3 class="mb-0"><?= $estadisticas['proximos_vencer'] ?></h3>
                        </div>
                        <div><i class="fas fa-exclamation-triangle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Inventario de Productos -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-boxes"></i> Inventario de Productos</h5>
                    <div>
                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#movimientoModal">
                            <i class="fas fa-exchange-alt"></i> Movimiento
                        </button>
                        <a href="<?= $this->url('inventario/productos') ?>" class="btn btn-primary btn-sm">
                            Ver Todo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Ubicación</th>
                                    <th>Stock</th>
                                    <th>Caducidad</th>
                                    <th>Valor</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productosInventario as $producto): ?>
                                <tr>
                                    <td>
                                        <strong><?= $this->escape($producto['codigo']) ?></strong>
                                        <br><small class="text-muted"><?= $this->escape($producto['lote']) ?></small>
                                    </td>
                                    <td>
                                        <?= $this->escape($producto['nombre']) ?>
                                        <br><span class="badge bg-secondary"><?= $producto['categoria'] ?></span>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                        <?= $this->escape($producto['ubicacion']) ?>
                                    </td>
                                    <td>
                                        <strong><?= number_format($producto['cantidad'], 1) ?></strong> <?= $producto['unidad'] ?>
                                        <br><small class="text-muted">Prod: <?= $this->formatDate($producto['fecha_produccion']) ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        $fechaCaducidad = new DateTime($producto['fecha_caducidad']);
                                        $hoy = new DateTime();
                                        $dias = $hoy->diff($fechaCaducidad)->days;
                                        
                                        $alertClass = '';
                                        if ($dias <= 3) {
                                            $alertClass = 'text-danger fw-bold';
                                        } elseif ($dias <= 7) {
                                            $alertClass = 'text-warning fw-bold';
                                        }
                                        ?>
                                        <span class="<?= $alertClass ?>">
                                            <?= $this->formatDate($producto['fecha_caducidad']) ?>
                                            <br><small>(<?= $dias ?> días)</small>
                                        </span>
                                    </td>
                                    <td>
                                        <?= $this->formatMoney($producto['cantidad'] * $producto['precio_unitario']) ?>
                                        <br><small class="text-muted"><?= $this->formatMoney($producto['precio_unitario']) ?>/<?= $producto['unidad'] ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($producto['estado']) {
                                            case 'disponible': $badgeClass = 'bg-success'; break;
                                            case 'próximo_vencer': $badgeClass = 'bg-warning'; break;
                                            case 'reservado': $badgeClass = 'bg-info'; break;
                                            case 'vencido': $badgeClass = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $producto['estado'])) ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="Mover">
                                                <i class="fas fa-arrows-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Movimientos Recientes -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt"></i> Movimientos Recientes</h5>
                    <a href="<?= $this->url('inventario/movimientos') ?>" class="btn btn-outline-primary btn-sm">
                        Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <?php foreach ($movimientosRecientes as $movimiento): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                        <div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-<?= $movimiento['tipo'] == 'entrada' ? 'arrow-down text-success' : 'arrow-up text-danger' ?> me-2"></i>
                                <strong><?= $this->escape($movimiento['producto']) ?></strong>
                            </div>
                            <small class="text-muted"><?= $this->escape($movimiento['motivo']) ?> - <?= $this->formatDate($movimiento['fecha']) ?></small>
                        </div>
                        <span class="badge bg-<?= $movimiento['tipo'] == 'entrada' ? 'success' : 'danger' ?>">
                            <?= $movimiento['cantidad'] ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                    
                    <div class="text-center mt-3">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#movimientoModal">
                            <i class="fas fa-plus"></i> Registrar Movimiento
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Resumen por Categoría -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Stock por Categoría</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Frescos</span>
                        <span class="badge bg-success">43.2 kg</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Semicurados</span>
                        <span class="badge bg-warning">28.8 kg</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Curados</span>
                        <span class="badge bg-info">45.5 kg</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Navegación Rápida -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-rocket"></i> Acceso Rápido</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('inventario/productos') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-box fa-2x mb-2"></i>
                                <span>Productos</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('inventario/movimientos') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                                <span>Movimientos</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
                                <span>Ubicaciones</span>
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <span>Reportes</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Movimiento de Inventario -->
<div class="modal fade" id="movimientoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Registrar Movimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Movimiento</label>
                        <select class="form-select">
                            <option value="entrada">Entrada</option>
                            <option value="salida">Salida</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="ajuste">Ajuste de Inventario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <select class="form-select">
                            <option value="">Seleccionar producto...</option>
                            <option value="manchego">Queso Manchego Curado</option>
                            <option value="fresco">Queso Fresco Ranchero</option>
                            <option value="oaxaca">Queso Oaxaca</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" class="form-control" step="0.1" min="0" placeholder="0.0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unidad</label>
                                <select class="form-select">
                                    <option value="kg">Kilogramos</option>
                                    <option value="piezas">Piezas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <select class="form-select">
                            <option value="produccion">Producción</option>
                            <option value="venta">Venta</option>
                            <option value="merma">Merma</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="ajuste">Ajuste</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" rows="2" placeholder="Observaciones del movimiento..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar Movimiento
                </button>
            </div>
        </div>
    </div>
</div>
