<?php
session_start();
include '../../includes/header.php';
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

$stmt = $conexao->prepare("SELECT nome FROM agricultores WHERE id = ?");
$stmt->bind_param("i", $id_agricultor);
$stmt->execute();
$result = $stmt->get_result();
$nome_agricultor = '';

if ($row = $result->fetch_assoc()) {
    $nome_agricultor = $row['nome'];
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

<main class="container my-5">
    <div class="mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Adicionar Registro</button>
    </div>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM caderneta WHERE usuario_id = ? ORDER BY data DESC");
    $stmt->bind_param('i', $id_agricultor);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <?php if (isset($_GET['atualizado'])): ?>
        <div class="alert alert-success">Registro atualizado com sucesso!</div>
    <?php elseif (isset($_GET['sucesso'])): ?>
        <div class="alert alert-success">Registro cadastrado com sucesso!</div>
    <?php elseif (isset($_GET['excluido'])): ?>
        <div class="alert alert-success">Registro excluído com sucesso!</div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-light">
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
        <?php 
        $totalGeralQuantidade = 0;
        $totalGeralValor = 0;
        $totaisPorTipo = [
                            'CONSUMO' => ['quantidade' => 0, 'valor' => 0],
                            'TROCA' => ['quantidade' => 0, 'valor' => 0],
                            'DOAÇÃO' => ['quantidade' => 0, 'valor' => 0],
                            'VENDA' => ['quantidade' => 0, 'valor' => 0],
                        ];
        while ($row = mysqli_fetch_assoc($result)) {
        $tipo = $row['tipo_cadastro'];
        $quantidade = (float)$row['quantidade'];
        $valor = (float)$row['valor']; 

        if (isset($totaisPorTipo[$tipo])) {
        $totaisPorTipo[$tipo]['quantidade'] += $quantidade;
        $totaisPorTipo[$tipo]['valor'] += $valor;
        }

        $totalGeralQuantidade += $quantidade;
        $totalGeralValor += $valor;

        ?>
                <tr>
                    <td><?= htmlspecialchars($row['tipo_cadastro']) ?></td>
                    <td><?= htmlspecialchars($row['produto']) ?></td>
                    <td><?= htmlspecialchars($row['quantidade']) ?></td>
                    <td><?= htmlspecialchars($row['valor']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="deletar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este registro?')">Excluir</a>
                    </td>
                </tr>
            <?php }; 
            mysqli_data_seek($result, 0);
            ?>
        </tbody>
        <tfoot>
            <!-- Totais por tipo de registro -->
            <?php foreach ($totaisPorTipo as $tipo => $totais): ?>
                <?php if ($totais['quantidade'] > 0 || $totais['valor'] > 0): ?>
                    <tr class="table-info">
                        <td colspan="2"><strong>Total <?= htmlspecialchars($tipo) ?></strong></td>
                        <td><strong><?= number_format($totais['quantidade'], 2, ',', '.') ?></strong>
                        <small> (<?= round(($totais['quantidade'] / $totalGeralQuantidade) * 100, 2) ?>%)</small>
                        </td>
                        <td><strong>R$ <?= number_format($totais['valor'], 2, ',', '.') ?></strong>
                            <small> (<?= round(($totais['valor'] / $totalGeralValor) * 100, 2) ?>%)</small>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            
            <!-- Total geral -->
            <tr class="table-active">
                <td colspan="2"><strong>TOTAL GERAL</strong></td>
                <td><strong><?= number_format($totalGeralQuantidade, 2, ',', '.') ?></strong></td>
                <td><strong>R$ <?= number_format($totalGeralValor, 2, ',', '.') ?></strong></td>
                
                <td colspan="2"></td>
            </tr>
        </tfoot>
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
</main>
<?php include '../../includes/footer.php'; ?>