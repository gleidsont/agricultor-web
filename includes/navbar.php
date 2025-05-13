<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a href="javascript:history.back()" class="btn btn-sm btn-outline-primary me-3">⬅ Voltar Página</a>
        <a class="navbar-brand" href="/agricultor-web/index.php">Caderno Agroecológico & Solidário</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="/agricultor-web/perfil.php">Painel</a></li>
                    <li class="nav-item"><a class="nav-link" href="/agricultor-web/logout.php">Sair</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/agricultor-web/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/agricultor-web/cadastro.php">Registrar</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>