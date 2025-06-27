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
    <div>
    <div class="row mb-4 justify-content-center" >
        <div class="col-md-3 mb-4">
            <div class="card border-success h-100">
                <a href="api/agricultores/agricultores.php" class="stretched-link"></a>
                <div class="card-body text-center">
                    <h4 class="card-title"><img src="images/agricultor.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;"></h4>
                    <p class="card-text">
                    <h4>Agricultores</h4>
                    </p>
                    <p class="card-text">Veja quais agricultores estão cadastrados</p>
                    <div class="btn btn-outline-success" style="z-index: 2;">Gerenciar</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-success h-100">
                <a href="api/caderneta/ler.php" class="stretched-link"></a>
                <div class="card-body text-center">
                    <h4 class="card-title"><img src="images/caderneta_digital.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;"></h4>
                    <p class="card-text">
                    <h4>Caderneta Digital</h4>
                    </p>
                    <p class="card-text">Registre aqui tudo o que foi consumido, trocado, doado ou vendido</p>
                    <div class="btn btn-outline-success" style="z-index: 2;">Gerenciar</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-success h-100">
                <a href="fotos.php" class="stretched-link"></a>
                <div class="card-body text-center">
                    <h4 class="card-title"><img src="images/caderneta.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;"></h4>
                    <p class="card-text">
                    <h4>Fotos da Caderneta</h4>
                    </p>
                    <p class="card-text">Tire as fotos da caderneta e deixe registrado o que foi escrito</p>
                    <div class="btn btn-outline-success" style="z-index: 2;">Gerenciar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 justify-content-center" >
        <div class="col-md-3 mb-4">
            <div class="card border-success h-100">
                <a href="api/estatistica/estatisticas.php" class="stretched-link"></a>
                <div class="card-body text-center">
                    <h4 class="card-title"><img src="images/estatistica.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;"></h4>
                    <p class="card-text">
                    <h4>Estatística</h4>
                    </p>
                    <p class="card-text">Veja aqui as estatísticas deste agricultor</p>
                    <div class="btn btn-outline-success" style="z-index: 2;">Gerenciar</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-success h-100">
                <a href="relatorios.php" class="stretched-link"></a>
                <div class="card-body text-center">
                    <h4 class="card-title"><img src="images/estatistica.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;"></h4>
                    <p class="card-text">
                    <h4>Relatórios</h4>
                    </p>
                    <p class="card-text">Gere relatórios e exporte planilhas</p>
                    <div class="btn btn-outline-success" style="z-index: 2;">Gerenciar</div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-success h-100">
                <a href="configuracoes.php" class="stretched-link"></a>
                <div class="card-body text-center">
                    <h4 class="card-title"><img src="images/configuracao_novo.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;"></h4>
                    <p class="card-text">
                    <h4>Configurações</h4>
                    </p>
                    <p class="card-text">Crie usuários, insira novos valores em tabelas, entre outras configurações</p>
                    <div class="btn btn-outline-success" style="z-index: 2;">Gerenciar</div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</main>
<?php include 'includes/footer.php'; ?>