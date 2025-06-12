<?php
require_once '../../includes/conexao.php';

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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
                <a href="../caderneta.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</body>
</html>