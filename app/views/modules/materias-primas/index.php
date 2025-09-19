<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-seedling"></i> <?= $title ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= $this->url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas de Materias Primas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Materias Disponibles</h6>
                            <h3 class="mb-0"><?= $estadisticas['materias_disponibles'] ?></h3>
                        </div>
                        <div><i class="fas fa-boxes fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Proveedores Activos</h6>
                            <h3 class="mb-0"><?= $estadisticas['proveedores_activos'] ?></h3>
                        </div>
                        <div><i class="fas fa-truck fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Valor Inventario</h6>
                            <h3 class="mb-0"><?= $this->formatMoney($estadisticas['valor_inventario']) ?></h3>
                        </div>
                        <div><i class="fas fa-dollar-sign fa-2x"></i></div>
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
        <!-- Inventario de Materias Primas -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-warehouse"></i> Inventario de Materias Primas</h5>
                    <div>
                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#nuevaEntradaModal">
                            <i class="fas fa-plus"></i> Nueva Entrada
                        </button>
                        <a href="<?= $this->url('materias-primas/inventario') ?>" class="btn btn-primary btn-sm">
                            Ver Todo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Materia Prima</th>
                                    <th>Tipo</th>
                                    <th>Stock</th>
                                    <th>Proveedor</th>
                                    <th>Caducidad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($materiasStock as $materia): ?>
                                <tr>
                                    <td>
                                        <strong><?= $this->escape($materia['nombre']) ?></strong>
                                        <br><small class="text-muted">Lote: <?= $this->escape($materia['lote_proveedor']) ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($materia['tipo']) {
                                            case 'leche': $badgeClass = 'bg-primary'; break;
                                            case 'insumo': $badgeClass = 'bg-success'; break;
                                            case 'empaque': $badgeClass = 'bg-info'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($materia['tipo']) ?></span>
                                    </td>
                                    <td>
                                        <strong><?= number_format($materia['cantidad'], 1) ?></strong> <?= $materia['unidad'] ?>
                                        <br><small class="text-muted">Ingreso: <?= $this->formatDate($materia['fecha_ingreso']) ?></small>
                                    </td>
                                    <td><?= $this->escape($materia['proveedor']) ?></td>
                                    <td>
                                        <?php
                                        $fechaCaducidad = new DateTime($materia['fecha_caducidad']);
                                        $hoy = new DateTime();
                                        $dias = $hoy->diff($fechaCaducidad)->days;
                                        
                                        $alertClass = '';
                                        if ($dias <= 2) {
                                            $alertClass = 'text-danger fw-bold';
                                        } elseif ($dias <= 7) {
                                            $alertClass = 'text-warning fw-bold';
                                        }
                                        ?>
                                        <span class="<?= $alertClass ?>">
                                            <?= $this->formatDate($materia['fecha_caducidad']) ?>
                                            <br><small>(<?= $dias ?> días)</small>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> <?= ucfirst($materia['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger" title="Usar">
                                                <i class="fas fa-minus"></i>
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
        
        <!-- Proveedores Certificados -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-award"></i> Proveedores Certificados</h5>
                    <a href="<?= $this->url('materias-primas/proveedores') ?>" class="btn btn-outline-primary btn-sm">
                        Ver Todos
                    </a>
                </div>
                <div class="card-body">
                    <?php foreach ($proveedoresCertificados as $proveedor): ?>
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?= $this->escape($proveedor['nombre']) ?></h6>
                                <small class="text-muted"><?= $this->escape($proveedor['tipo']) ?></small>
                            </div>
                            <span class="badge bg-success"><i class="fas fa-shield-alt"></i></span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <small><strong>Certificación:</strong> <?= $this->escape($proveedor['certificacion']) ?></small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small><strong>Vence:</strong> <?= $this->formatDate($proveedor['vencimiento']) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Control de Calidad -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-microscope"></i> Control de Calidad</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-test-tube"></i> Análisis Pendientes
                        </button>
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-check-circle"></i> Certificados de Calidad
                        </button>
                        <button class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-exclamation-triangle"></i> Alertas de Caducidad
                        </button>
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
                            <a href="<?= $this->url('materias-primas/inventario') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-warehouse fa-2x mb-2"></i>
                                <span>Inventario Completo</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('materias-primas/proveedores') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-handshake fa-2x mb-2"></i>
                                <span>Gestión de Proveedores</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <span>Análisis de Consumo</span>
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <span>Órdenes de Compra</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Entrada -->
<div class="modal fade" id="nuevaEntradaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Nueva Entrada de Materia Prima</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Materia Prima</label>
                                <select class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="leche_vaca">Leche de Vaca</option>
                                    <option value="leche_cabra">Leche de Cabra</option>
                                    <option value="cuajo">Cuajo Natural</option>
                                    <option value="sal">Sal Marina</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Proveedor</label>
                                <select class="form-select">
                                    <option value="">Seleccionar proveedor...</option>
                                    <option value="granja_san_jose">Granja San José</option>
                                    <option value="insumos_lacteos">Insumos Lácteos SA</option>
                                    <option value="salinas_pacifico">Salinas del Pacífico</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" class="form-control" step="0.1" min="0" placeholder="100.0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Unidad</label>
                                <select class="form-select">
                                    <option value="kg">Kilogramos</option>
                                    <option value="litros">Litros</option>
                                    <option value="unidades">Unidades</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Caducidad</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Lote del Proveedor</label>
                                <input type="text" class="form-control" placeholder="LV-2025-089">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Temperatura de Almacenamiento (°C)</label>
                                <input type="number" class="form-control" step="0.1" placeholder="4.0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" rows="2" placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">
                    <i class="fas fa-save"></i> Registrar Entrada
                </button>
            </div>
        </div>
    </div>
</div>
