<?php
include 'includes/auth_admin_pesq_agricultor.php';
include 'includes/conexao.php';
include 'includes/header.php';
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
                    <img src="images/consumo.png" class="card-img-top" alt="Consumo">
                    <div class="card-body">
                        <h5 class="card-title">Consumo</h5>
                        <p class="card-text">Registre os produtos consumidos pela família</p>
                        <a href="api/consumo/ler.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100">
                    <img src="images/doacao.png" class="card-img-top" alt="Doação">
                    <div class="card-body">
                        <h5 class="card-title">Doação</h5>
                        <p class="card-text">Registre produtos doados para outras pessoas</p>
                        <a href="api/doacao/ler.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100">
                    <img src="images/troca.png" class="card-img-top" alt="Troca">
                    <div class="card-body">
                        <h5 class="card-title">Troca</h5>
                        <p class="card-text">Registre trocas de produtos com outros agricultores</p>
                        <a href="api/troca/ler.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card h-100">
                    <img src="images/venda.png" class="card-img-top" alt="Venda">
                    <div class="card-body">
                        <h5 class="card-title">Venda</h5>
                        <p class="card-text">Registre vendas de produtos</p>
                        <a href="api/venda/ler.php" class="btn btn-primary">Acessar</a>
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