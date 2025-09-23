<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-industry"></i> Módulo de Producción</h2>
    <div class="text-muted">
        <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i') ?>
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt"></i> Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <button class="btn btn-success w-100 btn-quick-action" data-action="nuevo-lote" data-module="produccion">
                            <i class="fas fa-plus-circle fa-2x d-block mb-2"></i>
                            <span>Nuevo Lote</span>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info w-100 btn-quick-action" data-action="consultar-lotes" data-module="produccion">
                            <i class="fas fa-search fa-2x d-block mb-2"></i>
                            <span>Consultar Lotes</span>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-warning w-100 btn-quick-action" data-action="crear-receta" data-module="produccion">
                            <i class="fas fa-book fa-2x d-block mb-2"></i>
                            <span>Nueva Receta</span>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-secondary w-100 btn-quick-action" data-action="programar-produccion" data-module="produccion">
                            <i class="fas fa-calendar-alt fa-2x d-block mb-2"></i>
                            <span>Programar Producción</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de Producción -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Lotes Hoy</h6>
                        <h3 class="mb-0"><?= $estadisticas['lotes_hoy'] ?? 0 ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">
                    Lotes iniciados hoy
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-header bg-success text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Producción</h6>
                        <h3 class="mb-0"><?= number_format($estadisticas['kg_producidos'] ?? 0, 1) ?> kg</h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-weight"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">
                    Kilogramos producidos hoy
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-header bg-warning text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">En Proceso</h6>
                        <h3 class="mb-0"><?= $estadisticas['lotes_proceso'] ?? 0 ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">
                    Lotes en proceso
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card card-stats">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Recetas</h6>
                        <h3 class="mb-0"><?= $estadisticas['total_recetas'] ?? 0 ?></h3>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">
                    Recetas registradas
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Lotes Recientes -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock"></i> Lotes Recientes
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($lotesRecientes)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Lote</th>
                                    <th>Producto</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lotesRecientes as $lote): ?>
                                <tr>
                                    <td><strong><?= $this->escape($lote['numero_lote']) ?></strong></td>
                                    <td><?= $this->escape($lote['producto']) ?></td>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch ($lote['estado']) {
                                            case 'programado':
                                                $badgeClass = 'bg-info';
                                                break;
                                            case 'en_proceso':
                                                $badgeClass = 'bg-warning';
                                                break;
                                            case 'terminado':
                                                $badgeClass = 'bg-success';
                                                break;
                                            default:
                                                $badgeClass = 'bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= ucfirst(str_replace('_', ' ', $lote['estado'])) ?></span>
                                    </td>
                                    <td><?= $this->formatDate($lote['fecha_inicio']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-ver-lote" data-lote-id="<?= $lote['id'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= $this->url('produccion/lotes') ?>" class="btn btn-outline-primary btn-sm">
                            Ver Todos los Lotes
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p>No hay lotes registrados</p>
                        <button class="btn btn-primary btn-sm btn-quick-action" data-action="nuevo-lote" data-module="produccion">
                            Crear Primer Lote
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recetas Activas -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book"></i> Recetas Activas
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recetasActivas)): ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recetasActivas as $receta): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= $this->escape($receta['nombre']) ?></h6>
                                <p class="mb-1 text-muted"><?= $this->escape($receta['descripcion']) ?></p>
                                <small class="text-muted">Tiempo: <?= $receta['tiempo_preparacion'] ?> min</small>
                            </div>
                            <button class="btn btn-sm btn-outline-success btn-usar-receta" data-receta-id="<?= $receta['id'] ?>">
                                <i class="fas fa-play"></i> Usar
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?= $this->url('produccion/recetas') ?>" class="btn btn-outline-primary btn-sm">
                            Ver Todas las Recetas
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-book-open fa-3x mb-3"></i>
                        <p>No hay recetas registradas</p>
                        <button class="btn btn-warning btn-sm btn-quick-action" data-action="crear-receta" data-module="produccion">
                            Crear Primera Receta
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript específico para Producción -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejador para botones de acciones rápidas
    document.querySelectorAll('.btn-quick-action').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const module = this.dataset.module;
            
            handleQuickAction(module, action, this);
        });
    });
    
    // Manejador para ver lote
    document.querySelectorAll('.btn-ver-lote').forEach(button => {
        button.addEventListener('click', function() {
            const loteId = this.dataset.loteId;
            window.location.href = '<?= $this->url('produccion/lotes/ver') ?>/' + loteId;
        });
    });
    
    // Manejador para usar receta
    document.querySelectorAll('.btn-usar-receta').forEach(button => {
        button.addEventListener('click', function() {
            const recetaId = this.dataset.recetaId;
            handleUsarReceta(recetaId, this);
        });
    });
});

function handleQuickAction(module, action, button) {
    // Mostrar loading
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
    
    // Realizar petición AJAX
    fetch('<?= $this->url('ajax') ?>/' + module + '/' + action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            csrf_token: '<?= $this->csrfToken() ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                // Mostrar mensaje de éxito
                showAlert('success', data.message || 'Acción completada exitosamente');
            }
        } else {
            showAlert('error', data.message || 'Error al procesar la acción');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error de comunicación con el servidor');
    })
    .finally(() => {
        // Restaurar botón
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function handleUsarReceta(recetaId, button) {
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    // Redirigir a crear lote con receta preseleccionada
    window.location.href = '<?= $this->url('produccion/lotes/crear') ?>?receta=' + recetaId;
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insertar al inicio del contenido
    const container = document.querySelector('.container-fluid');
    if (container) {
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-hide después de 5 segundos
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);
    }
}
</script>