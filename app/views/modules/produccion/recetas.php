<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0"><i class="fas fa-book"></i> <?= $title ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= $this->url('dashboard') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?= $this->url('produccion') ?>">Producción</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Catálogo de Recetas</h5>
                    <div>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevaRecetaModal">
                            <i class="fas fa-plus"></i> Nueva Receta
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Maduración</th>
                                    <th>Rendimiento</th>
                                    <th>Ingredientes</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recetas as $receta): ?>
                                <tr>
                                    <td>
                                        <strong><?= $this->escape($receta['nombre']) ?></strong>
                                        <br><small class="text-muted">Creado: <?= $this->formatDate($receta['creado']) ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($receta['categoria']) {
                                            case 'Fresco': $badgeClass = 'bg-success'; break;
                                            case 'Semicurado': $badgeClass = 'bg-warning'; break;
                                            case 'Curado': $badgeClass = 'bg-danger'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $receta['categoria'] ?></span>
                                    </td>
                                    <td>
                                        <?= $receta['tiempo_maduracion'] ?> días
                                        <?php if ($receta['tiempo_maduracion'] == 0): ?>
                                            <br><small class="text-success"><i class="fas fa-clock"></i> Inmediato</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary"><?= $receta['rendimiento'] ?>%</span>
                                        <br><small class="text-muted">Rendimiento</small>
                                    </td>
                                    <td>
                                        <?php foreach (array_slice($receta['ingredientes'], 0, 2) as $ingrediente): ?>
                                            <span class="badge bg-light text-dark me-1"><?= $this->escape($ingrediente) ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($receta['ingredientes']) > 2): ?>
                                            <span class="badge bg-secondary">+<?= count($receta['ingredientes']) - 2 ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> <?= ucfirst($receta['estado']) ?>
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
                                            <button class="btn btn-outline-success" title="Usar en Producción">
                                                <i class="fas fa-play"></i>
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
    </div>
    
    <!-- Estadísticas de Recetas -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-book fa-3x text-primary mb-3"></i>
                    <h5><?= count($recetas) ?></h5>
                    <p class="text-muted mb-0">Recetas Activas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-cheese fa-3x text-success mb-3"></i>
                    <h5>3</h5>
                    <p class="text-muted mb-0">Categorías</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-percentage fa-3x text-warning mb-3"></i>
                    <h5>88.3%</h5>
                    <p class="text-muted mb-0">Rendimiento Promedio</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-3x text-info mb-3"></i>
                    <h5>17</h5>
                    <p class="text-muted mb-0">Días Promedio Maduración</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Receta -->
<div class="modal fade" id="nuevaRecetaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Nueva Receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Receta</label>
                                <input type="text" class="form-control" placeholder="Ej: Queso Manchego Premium">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Categoría</label>
                                <select class="form-select">
                                    <option value="">Seleccionar...</option>
                                    <option value="fresco">Fresco</option>
                                    <option value="semicurado">Semicurado</option>
                                    <option value="curado">Curado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tiempo de Maduración (días)</label>
                                <input type="number" class="form-control" placeholder="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rendimiento Esperado (%)</label>
                                <input type="number" class="form-control" placeholder="85" min="1" max="100">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ingredientes</label>
                        <textarea class="form-control" rows="3" placeholder="Lista los ingredientes principales..."></textarea>
                        <div class="form-text">Separa cada ingrediente con una coma</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Instrucciones</label>
                        <textarea class="form-control" rows="4" placeholder="Describe el proceso de elaboración..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Receta
                </button>
            </div>
        </div>
    </div>
</div>