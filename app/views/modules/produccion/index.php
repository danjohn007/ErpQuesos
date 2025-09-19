<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-industry"></i> <?= $title ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= $this->url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Estadísticas de Producción -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Producción Hoy</h6>
                            <h3 class="mb-0"><?= number_format($estadisticas['produccion_dia'], 1) ?> kg</h3>
                        </div>
                        <div><i class="fas fa-weight fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Lotes Activos</h6>
                            <h3 class="mb-0"><?= $estadisticas['lotes_activos'] ?></h3>
                        </div>
                        <div><i class="fas fa-boxes fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Recetas</h6>
                            <h3 class="mb-0"><?= $estadisticas['recetas_disponibles'] ?></h3>
                        </div>
                        <div><i class="fas fa-book fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Eficiencia</h6>
                            <h3 class="mb-0"><?= number_format($estadisticas['eficiencia_promedio'], 1) ?>%</h3>
                        </div>
                        <div><i class="fas fa-chart-line fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Lotes de Hoy -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-calendar-day"></i> Lotes de Hoy</h5>
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Lote
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Número de Lote</th>
                                    <th>Producto</th>
                                    <th>Cantidad (kg)</th>
                                    <th>Estado</th>
                                    <th>Progreso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lotesHoy as $lote): ?>
                                <tr>
                                    <td><strong><?= $this->escape($lote['numero']) ?></strong></td>
                                    <td><?= $this->escape($lote['producto']) ?></td>
                                    <td><?= number_format($lote['cantidad'], 1) ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($lote['estado']) {
                                            case 'programado': $badgeClass = 'bg-secondary'; break;
                                            case 'en_proceso': $badgeClass = 'bg-warning'; break;
                                            case 'terminado': $badgeClass = 'bg-success'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst($lote['estado']) ?></span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: <?= $lote['progreso'] ?>%" 
                                                 aria-valuenow="<?= $lote['progreso'] ?>" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                <?= $lote['progreso'] ?>%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" title="Ver">
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
        
        <!-- Recetas Activas -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book"></i> Recetas Activas</h5>
                    <a href="<?= $this->url('produccion/recetas') ?>" class="btn btn-outline-primary btn-sm">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    <?php foreach ($recetasActivas as $receta): ?>
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                        <div>
                            <h6 class="mb-1"><?= $this->escape($receta['nombre']) ?></h6>
                            <small class="text-muted">
                                Maduración: <?= $receta['tiempo_maduracion'] ?> días • 
                                Rendimiento: <?= $receta['rendimiento'] ?>%
                            </small>
                        </div>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-play"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                    
                    <div class="text-center mt-3">
                        <a href="<?= $this->url('produccion/recetas') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Nueva Receta
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
                            <a href="<?= $this->url('produccion/lotes') ?>" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <span>Gestión de Lotes</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= $this->url('produccion/recetas') ?>" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-book fa-2x mb-2"></i>
                                <span>Recetas</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <span>Control de Maduración</span>
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <span>Reportes de Producción</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>