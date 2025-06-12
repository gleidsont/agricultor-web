<?php
include '../../includes/header.php';
require_once '../../includes/conexao.php';

// Buscar agricultores
$sql = "SELECT * FROM agricultores ORDER BY nome";
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agricultores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Agricultores</h2>

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
                            <a href="../caderneta/ler.php?id=<?= $agricultor['id'] ?>" class="btn btn-sm btn-warning">caderneta</a>
                            <a href="editar.php?id=<?= $agricultor['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="deletar.php?id=<?= $agricultor['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este agricultor?')">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>