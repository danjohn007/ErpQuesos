<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-shopping-cart"></i> <?= $title ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= $this->url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas de Ventas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Ventas del Día</h6>
                            <h3 class="mb-0"><?= $this->formatMoney($estadisticas['ventas_dia']) ?></h3>
                        </div>
                        <div><i class="fas fa-cash-register fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Órdenes Pendientes</h6>
                            <h3 class="mb-0"><?= $estadisticas['ordenes_pendientes'] ?></h3>
                        </div>
                        <div><i class="fas fa-clock fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Clientes Activos</h6>
                            <h3 class="mb-0"><?= $estadisticas['clientes_activos'] ?></h3>
                        </div>
                        <div><i class="fas fa-users fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Meta Mensual</h6>
                            <h3 class="mb-0"><?= number_format($estadisticas['meta_mensual'], 1) ?>%</h3>
                        </div>
                        <div><i class="fas fa-target fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Ventas Recientes -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-receipt"></i> Ventas Recientes</h5>
                    <div>
                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#nuevaVentaModal">
                            <i class="fas fa-plus"></i> Nueva Venta
                        </button>
                        <a href="<?= $this->url('ventas/ordenes') ?>" class="btn btn-primary btn-sm">
                            Ver Todas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Productos</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Vendedor</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ventasRecientes as $venta): ?>
                                <tr>
                                    <td>
                                        <strong><?= $this->escape($venta['numero']) ?></strong>
                                        <br><small class="text-muted"><?= $this->formatDate($venta['fecha']) ?></small>
                                    </td>
                                    <td><?= $this->escape($venta['cliente']) ?></td>
                                    <td>
                                        <?php foreach (array_slice($venta['productos'], 0, 2) as $producto): ?>
                                            <span class="badge bg-light text-dark me-1"><?= $this->escape($producto) ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($venta['productos']) > 2): ?>
                                            <span class="badge bg-secondary">+<?= count($venta['productos']) - 2 ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= $this->formatMoney($venta['total']) ?></strong></td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($venta['estado']) {
                                            case 'pagada': $badgeClass = 'bg-success'; break;
                                            case 'pendiente': $badgeClass = 'bg-warning'; break;
                                            case 'entregada': $badgeClass = 'bg-info'; break;
                                            case 'cancelada': $badgeClass = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($venta['estado']) ?></span>
                                    </td>
                                    <td><?= $this->escape($venta['vendedor']) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-success" title="Facturar">
                                                <i class="fas fa-file-invoice"></i>
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
        
        <!-- Clientes Activos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-handshake"></i> Clientes Activos</h5>
                    <a href="<?= $this->url('ventas/clientes') ?>" class="btn btn-outline-primary btn-sm">
                        Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <?php foreach ($clientesActivos as $cliente): ?>
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?= $this->escape($cliente['nombre']) ?></h6>
                                <small class="text-muted"><?= $this->escape($cliente['tipo']) ?></small>
                            </div>
                            <span class="badge bg-primary"><i class="fas fa-star"></i></span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <small><strong>Crédito:</strong> <?= $this->formatMoney($cliente['credito']) ?></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small><strong>Última compra:</strong> <?= $this->formatDate($cliente['ultima_compra']) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <div class="text-center mt-3">
                        <a href="<?= $this->url('ventas/clientes') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nuevo Cliente
                        </a>
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
                            <a href="<?= $this->url('ventas/ordenes') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                                <span>Gestión de Órdenes</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('ventas/clientes') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>Gestión de Clientes</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('ventas/facturacion') ?>" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                                <span>Facturación Electrónica</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <span>Reportes de Ventas</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Venta -->
<div class="modal fade" id="nuevaVentaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Nueva Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cliente</label>
                                <select class="form-select">
                                    <option value="">Seleccionar cliente...</option>
                                    <option value="supermercado">Supermercado La Estrella</option>
                                    <option value="restaurante">Restaurante El Buen Sabor</option>
                                    <option value="tienda">Tienda Don José</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Venta</label>
                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Productos</label>
                        <div class="border rounded p-3">
                            <div class="row align-items-end mb-2">
                                <div class="col-md-5">
                                    <select class="form-select form-select-sm">
                                        <option value="">Seleccionar producto...</option>
                                        <option value="manchego">Queso Manchego - $250/kg</option>
                                        <option value="fresco">Queso Fresco - $180/kg</option>
                                        <option value="oaxaca">Queso Oaxaca - $220/kg</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control form-control-sm" placeholder="Cantidad" step="0.1" min="0">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="$0.00" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-success w-100">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Vendedor</label>
                                <select class="form-select">
                                    <option value="">Seleccionar vendedor...</option>
                                    <option value="carlos">Carlos Méndez</option>
                                    <option value="ana">Ana García</option>
                                    <option value="luis">Luis Torres</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Método de Pago</label>
                                <select class="form-select">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="credito">Crédito</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" rows="2" placeholder="Observaciones adicionales..."></textarea>
                    </div>
                    <div class="text-end">
                        <h5>Total: <span class="text-success">$0.00</span></h5>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">
                    <i class="fas fa-save"></i> Registrar Venta
                </button>
            </div>
        </div>
    </div>
</div>
