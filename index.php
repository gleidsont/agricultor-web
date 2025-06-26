<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';
$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    header('Location: selecionar_agricultor.php');
    exit;
}


$stmt = $conexao->prepare("SELECT nome FROM agricultores WHERE id = ?");
$stmt->bind_param("i", $id_agricultor);
$stmt->execute();
$result = $stmt->get_result();
$nome_agricultor = '';

if ($row = $result->fetch_assoc()) {
    $nome_agricultor = $row['nome'];
}

$sql = "SELECT * FROM agricultores ORDER BY nome";
$resultado = mysqli_query($conexao, $sql);

?>
<header class="bg-success text-white py-3">
    <div class="container d-flex center-content-between align-items-center">
        <h5 class="mb-0 me-3">Agricultor selecionado: <?= htmlspecialchars($nome_agricultor) ?></h5>
        <a href="selecionar_agricultor.php" class="btn btn-light btn-sm">
            <i class="fas fa-exchange-alt"></i> Trocar Agricultor
        </a>
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
                <img src="images/estatistica.png" class="card-img-top" alt="Relatórios">
                <div class="card-body">
                    <h5 class="card-title">Relatórios</h5>
                    <p class="card-text">Gere relatórios e exporte planilhas</p>
                    <a href="relatorios.php" class="btn btn-primary">Acessar</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</main>
<?php include 'includes/footer.php'; ?>