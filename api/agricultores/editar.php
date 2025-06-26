<?php
include '../../includes/header.php';
require_once '../../includes/conexao.php';

if (!isset($_GET['id'])) {
    echo "ID não informado.";
    exit;
}

$id = $_GET['id'];
$stmt = mysqli_prepare($conexao, "SELECT * FROM agricultores WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$agricultor = mysqli_fetch_assoc($result)) {
    echo "Agricultor não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Agricultor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Agricultor</h2>
        <form action="atualizar.php" method="POST">
            <input type="hidden" name="id" value="<?= $agricultor['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($agricultor['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Organização</label>
                <input type="text" name="organizacao" class="form-control" value="<?= htmlspecialchars($agricultor['organizacao']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">UF</label>
                <input type="text" name="uf" class="form-control" maxlength="2" value="<?= htmlspecialchars($agricultor['uf']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Município</label>
                <input type="text" name="municipio" class="form-control" value="<?= htmlspecialchars($agricultor['municipio']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Comunidade</label>
                <input type="text" name="comunidade" class="form-control" value="<?= htmlspecialchars($agricultor['comunidade']) ?>">
            </div>
            <div class="d-flex justify-content-between">
                <a href="agricultores.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</body>

</html>