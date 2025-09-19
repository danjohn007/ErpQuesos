<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-microscope"></i> <?= $title ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= $this->url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Alertas de Calidad -->
    <?php if (!empty($alertasCalidad)): ?>
    <div class="row mb-4">
        <div class="col-12">
            <?php foreach ($alertasCalidad as $alerta): ?>
            <div class="alert alert-<?= $alerta['tipo'] == 'urgente' ? 'danger' : ($alerta['tipo'] == 'advertencia' ? 'warning' : 'info') ?> alert-dismissible fade show">
                <i class="fas fa-<?= $alerta['tipo'] == 'urgente' ? 'exclamation-triangle' : ($alerta['tipo'] == 'advertencia' ? 'exclamation-circle' : 'info-circle') ?>"></i>
                <?= $this->escape($alerta['mensaje']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Estadísticas de Calidad -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Análisis del Mes</h6>
                            <h3 class="mb-0"><?= $estadisticas['analisis_mes'] ?></h3>
                        </div>
                        <div><i class="fas fa-flask fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Aprobados</h6>
                            <h3 class="mb-0"><?= $estadisticas['aprobados'] ?></h3>
                        </div>
                        <div><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Pendientes</h6>
                            <h3 class="mb-0"><?= $estadisticas['pendientes'] ?></h3>
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
                            <h6 class="card-title">% Aprobación</h6>
                            <h3 class="mb-0"><?= number_format($estadisticas['porcentaje_aprobacion'], 1) ?>%</h3>
                        </div>
                        <div><i class="fas fa-chart-pie fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Análisis Recientes -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-test-tube"></i> Análisis Recientes</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevoAnalisisModal">
                        <i class="fas fa-plus"></i> Nuevo Análisis
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Lote</th>
                                    <th>Producto</th>
                                    <th>Fecha</th>
                                    <th>pH</th>
                                    <th>Humedad %</th>
                                    <th>Grasa %</th>
                                    <th>Estado</th>
                                    <th>Responsable</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($analisisRecientes as $analisis): ?>
                                <tr>
                                    <td><strong><?= $this->escape($analisis['lote']) ?></strong></td>
                                    <td><?= $this->escape($analisis['producto']) ?></td>
                                    <td><?= $this->formatDate($analisis['fecha']) ?></td>
                                    <td>
                                        <span class="<?= $analisis['ph'] >= 5.0 && $analisis['ph'] <= 6.5 ? 'text-success' : 'text-warning' ?>">
                                            <?= number_format($analisis['ph'], 1) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="<?= $analisis['humedad'] <= 50 ? 'text-success' : 'text-warning' ?>">
                                            <?= number_format($analisis['humedad'], 1) ?>%
                                        </span>
                                    </td>
                                    <td><?= number_format($analisis['grasa'], 1) ?>%</td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($analisis['estado']) {
                                            case 'aprobado': $badgeClass = 'bg-success'; break;
                                            case 'pendiente': $badgeClass = 'bg-warning'; break;
                                            case 'observaciones': $badgeClass = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($analisis['estado']) ?></span>
                                    </td>
                                    <td><?= $this->escape($analisis['responsable']) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" title="Editar">
                                                <i class="fas fa-edit"></i>
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
        
        <!-- Panel de Control de Calidad -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-cogs"></i> Panel de Control</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Buscar Análisis
                        </button>
                        <a href="<?= $this->url('calidad/trazabilidad') ?>" class="btn btn-outline-success">
                            <i class="fas fa-route"></i> Trazabilidad
                        </a>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-certificate"></i> Certificaciones
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="fas fa-chart-bar"></i> Reportes
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Próximos Vencimientos -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-calendar-exclamation"></i> Próximos Vencimientos</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>Queso Fresco</strong>
                                <br><small class="text-muted">LOT-2025-002</small>
                            </div>
                            <span class="badge bg-warning">2 días</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <strong>Queso Manchego</strong>
                                <br><small class="text-muted">LOT-2025-001</small>
                            </div>
                            <span class="badge bg-info">5 días</span>
                        </div>
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
                            <a href="<?= $this->url('calidad/analisis') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-microscope fa-2x mb-2"></i>
                                <span>Análisis de Laboratorio</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('calidad/trazabilidad') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-route fa-2x mb-2"></i>
                                <span>Trazabilidad</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                                <span>HACCP</span>
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-award fa-2x mb-2"></i>
                                <span>Certificaciones</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Análisis -->
<div class="modal fade" id="nuevoAnalisisModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Nuevo Análisis de Calidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Número de Lote</label>
                                <select class="form-select">
                                    <option value="">Seleccionar lote...</option>
                                    <option value="LOT-2025-004">LOT-2025-004 - Queso Manchego</option>
                                    <option value="LOT-2025-005">LOT-2025-005 - Queso Fresco</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fecha de Análisis</label>
                                <input type="date" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">pH</label>
                                <input type="number" class="form-control" step="0.1" min="0" max="14" placeholder="5.5">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Humedad (%)</label>
                                <input type="number" class="form-control" step="0.1" min="0" max="100" placeholder="45.0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Grasa (%)</label>
                                <input type="number" class="form-control" step="0.1" min="0" max="100" placeholder="28.0">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Responsable del Análisis</label>
                        <select class="form-select">
                            <option value="">Seleccionar responsable...</option>
                            <option value="ana">Ana García - Jefe de Calidad</option>
                            <option value="carlos">Carlos López - Analista</option>
                            <option value="maria">María Rodríguez - Técnico</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" rows="3" placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Análisis
                </button>
            </div>
        </div>
    </div>
</div>
