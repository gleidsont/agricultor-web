<?php
session_start();

require_once '../../includes/conexao.php';
if (empty($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}
$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    header('Location: ../../selecionar_agricultor.php');
    exit;
}
include '../../includes/header.php';

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
        <a href="../../selecionar_agricultor.php" class="btn btn-light btn-sm">
            <i class="fas fa-exchange-alt"></i> Trocar Agricultor
        </a>
    </div>
</header>

    <div class="container mt-5">
        <h2>Agricultores Cadastrados</h2>

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="criar.php" class="btn btn-success">Novo Agricultor</a>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>Organização</th>
                    <th>UF</th>
                    <th>Município</th>
                    <th>Comunidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($agricultor = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($agricultor['nome']) ?></td>
                        <td><?= htmlspecialchars($agricultor['organizacao']) ?></td>
                        <td><?= htmlspecialchars($agricultor['uf']) ?></td>
                        <td><?= htmlspecialchars($agricultor['municipio']) ?></td>
                        <td><?= htmlspecialchars($agricultor['comunidade']) ?></td>
                        <td>
                            
                            <!-- <a href="../caderneta/ler.php?id=<?= $agricultor['id'] ?>" class="btn btn-sm btn-success">Caderneta</a> -->
                            <a href="editar.php?id=<?= $agricultor['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="deletar.php?id=<?= $agricultor['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este agricultor?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include '../../includes/footer.php'; ?>