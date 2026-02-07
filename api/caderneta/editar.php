<?php
session_start();

require_once '../../includes/conexao.php';
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

if (!isset($_GET['id'])) {
    echo "ID não informado.";
    exit;
}

$id = $_GET['id'];

$stmt = mysqli_prepare($conexao, "SELECT * FROM caderneta WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$registro = mysqli_fetch_assoc($result)) {
    echo "Registro não encontrado.";
    exit;
}

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
        <h2>Editar Registro da Caderneta</h2>

        <form action="atualizar.php" method="POST">
            <input type="hidden" name="id" value="<?= $registro['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Tipo de Registro</label>
                <select name="tipo_cadastro" class="form-control" required>
                    <option value="CONSUMO" <?= $registro['tipo_cadastro'] == 'CONSUMO' ? 'selected' : '' ?>>Consumo</option>
                    <option value="TROCA" <?= $registro['tipo_cadastro'] == 'TROCA' ? 'selected' : '' ?>>Troca</option>
                    <option value="DOAÇÃO" <?= $registro['tipo_cadastro'] == 'DOAÇÃO' ? 'selected' : '' ?>>Doação</option>
                    <option value="VENDA" <?= $registro['tipo_cadastro'] == 'VENDA' ? 'selected' : '' ?>>Venda</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Produto</label>
                <input type="text" name="produto" class="form-control" value="<?= htmlspecialchars($registro['produto']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantidade</label>
                <input type="number" name="quantidade" class="form-control" step="0.01" value="<?= $registro['quantidade'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Valor (R$)</label>
                <input type="number" name="valor" class="form-control" step="0.01" value="<?= $registro['valor'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Data</label>
                <input type="date" name="data" class="form-control" value="<?= $registro['data'] ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="ler.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>
</html>