<?php
include 'includes/auth_admin_pesq_agricultor.php';
include 'includes/conexao.php';
include __DIR__ . '/includes/header.php';
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';

$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
$sql = "SELECT nome FROM usuarios WHERE id = $id_agricultor";
$nome_agricultor = '';

if ($id_agricultor) {
    $stmt = $conexao->prepare("SELECT nome FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id_agricultor);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $nome_agricultor = $row['nome'];
    }
}

?>
<body>
    <header class="bg-success text-white py-3">
        <div class="container">
            <h2>Controle de Produção Agrícola</h2>
            <h4>Agricultor selecionado: <?= htmlspecialchars($nome_agricultor) ?></h4>
        </div>
    </header>

    <main class="container my-5">
        
    
        <div class="row row-cols-3 row-cols-md-4 row-cols-lg-6 g-4">
        <div class="col">
                <div class="card h-100">
                    <img src="images/caderneta.png" class="card-img-top" alt="Caderneta">
                    <div class="card-body">
                        <h5 class="card-title">Agricultores</h5>
                        <p class="card-text">Veja quais agricultores estão cadastrados</p>
                        <a href="api/agricultores/agricultores.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="images/caderneta.png" class="card-img-top" alt="Caderneta">
                    <div class="card-body">
                        <h5 class="card-title">Caderneta</h5>
                        <p class="card-text">Registre aqui tudo o que foi consumido, trocado, doado ou vendido</p>
                        <a href="api/caderneta/ler.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100">
                    <img src="images/estatistica.png" class="card-img-top" alt="Estatística">
                    <div class="card-body">
                        <h5 class="card-title">Estatística</h5>
                        <p class="card-text">Veja aqui as estatísticas deste agricultor</p>
                        <a href="api/estatistica/estatisticas.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
        

            <div class="col">
                <div class="card h-100">
                    <img src="images/configuracao.png" class="card-img-top" alt="Venda">
                    <div class="card-body">
                        <h5 class="card-title">Cadastro</h5>
                        <p class="card-text">Ajustes</p>
                        <a href="cadastro.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="images/login.png" class="card-img-top" alt="Venda">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <p class="card-text">Realize o Login para acessar</p>
                        <a href="login.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p>Caderneta Agroecológica &copy; 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>