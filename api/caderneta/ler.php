<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caderneta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-success text-white py-3">
        <div class="container">
            <h1>Caderneta Agroecológica - Registros</h1>
        </div>
    </header>

    <main class="container my-5">
        <div class="mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Adicionar Registro</button>
        </div>

        <?php
        require_once '../../includes/conexao.php';
        $stmt = $pdo->query("SELECT * FROM caderneta ORDER BY data DESC");
        ?>

        <?php if (isset($_GET['atualizado'])): ?>
            <div class="alert alert-success">Registro atualizado com sucesso!</div>
        <?php elseif (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Registro cadastrado com sucesso!</div>
        <?php elseif (isset($_GET['excluido'])): ?>
            <div class="alert alert-success">Registro excluído com sucesso!</div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tipo de Registro</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Valor (R$)</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($stmt)) {?>
                    <tr>
                        <td><?= htmlspecialchars($row['tipo_cadastro']) ?></td>
                        <td><?= htmlspecialchars($row['produto']) ?></td>
                        <td><?= htmlspecialchars($row['quantidade']) ?></td>
                        <td><?= htmlspecialchars($row['valor']) ?></td>
                        <td><?= htmlspecialchars($row['data']) ?></td>
                        <td>
                            <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="deletar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este registro?')">Excluir</a>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </main>

    <!-- Modal de cadastro -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="criar.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Registro</label>
                            <select name="tipo_cadastro" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="CONSUMO">Consumo</option>
                                <option value="TROCA">Troca</option>
                                <option value="DOAÇÃO">Doação</option>
                                <option value="VENDA">Venda</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Produto</label>
                            <input type="text" name="produto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valor (R$)</label>
                            <input type="number" name="valor" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data</label>
                            <input type="date" name="data" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p>Sistema de Controle Agrícola &copy; 2025</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>