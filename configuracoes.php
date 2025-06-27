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
        <div class="d-flex align-items-center flex-grow-1 p-1"> <!-- Container flexível -->
            <img src="images/configuracao_novo.png" class="img-fluid" alt="Caderneta" style="max-height: 70px;">
        <h5 class="mb-0 me-3">CONFIGURAÇÕES</h5>
        </div>        
    </div>
</header>

<main class="container my-5">
    <div class="row row-cols-3 row-cols-md-4 row-cols-lg-6 g-4">

        <div class="col">
            <div class="card h-100 d-flex flex-column">
                <div class="d-flex align-items-center justify-content-center flex-grow-1 p-3"> <!-- Container flexível -->
                    <img src="images/usuario.png" class="img-fluid" alt="Caderneta" style="max-height: 150px;">
                </div>
                <div class="card-body d-flex flex-column text-center">
                    <div class="mt-auto">
                        <h5 class="card-title">Gerenciamento de Usuários</h5>
                        <p class="card-text">Cadastre, edite ou apague os usuários do sistema</p>
                        <a href="cadastro.php" class="btn btn-success">Acessar</a>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</main>
<?php include 'includes/footer.php'; ?>