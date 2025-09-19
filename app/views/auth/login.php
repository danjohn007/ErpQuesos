<h2><?= $title ?></h2>

<form method="POST" id="loginForm">
    <div class="mb-3">
        <label for="username" class="form-label">
            <i class="fas fa-user"></i> Usuario o Email
        </label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="fas fa-lock"></i> Contraseña
        </label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">
            Recordar mis datos
        </label>
    </div>
    
    <div class="d-grid">
        <button type="submit" class="btn btn-primary" onclick="showLoading(this)">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </button>
    </div>
</form>

<hr class="my-4">

<div class="text-center">
    <h6 class="text-muted">Usuarios de Prueba:</h6>
    <div class="row text-start">
        <div class="col-12">
            <small class="text-muted">
                <strong>Administrador:</strong><br>
                Usuario: <code>admin</code><br>
                Contraseña: <code>admin123</code>
            </small>
        </div>
        <div class="col-12 mt-2">
            <small class="text-muted">
                <strong>Supervisor:</strong><br>
                Usuario: <code>supervisor1</code><br>
                Contraseña: <code>supervisor123</code>
            </small>
        </div>
        <div class="col-12 mt-2">
            <small class="text-muted">
                <strong>Operador:</strong><br>
                Usuario: <code>operador1</code><br>
                Contraseña: <code>operador123</code>
            </small>
        </div>
    </div>
</div>

<script>
function showLoading(button) {
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Iniciando sesión...';
}

// Auto-fill para testing
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const user = params.get('user');
    
    if (user === 'admin') {
        document.getElementById('username').value = 'admin';
        document.getElementById('password').value = 'admin123';
    } else if (user === 'supervisor') {
        document.getElementById('username').value = 'supervisor1';
        document.getElementById('password').value = 'supervisor123';
    } else if (user === 'operador') {
        document.getElementById('username').value = 'operador1';
        document.getElementById('password').value = 'operador123';
    }
});
</script>