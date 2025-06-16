<?php
require_once '../../config.php';
include INCLUDE_PATH . '/header.php';
require_once '../../includes/conexao.php';

$sql = "SELECT tipo_cadastro, COUNT(*) AS registros, SUM(quantidade) AS total_quantidade, SUM(valor) AS total_valor FROM caderneta GROUP BY tipo_cadastro";
$result = $pdo->query($sql);
$estatisticas = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $estatisticas[] = $row;
    }
}
?>

<div class="container my-5">
    <h2 class="mb-4">Estatísticas da Caderneta</h2>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Tipo de Registro</th>
                <th>Número de Registros</th>
                <th>Total Quantidade</th>
                <th>Total Valor (R$)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estatisticas as $estat): ?>
                <tr>
                    <td><?= htmlspecialchars($estat['tipo_cadastro']) ?></td>
                    <td><?= htmlspecialchars($estat['registros']) ?></td>
                    <td><?= number_format($estat['total_quantidade'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($estat['total_valor'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($estatisticas)): ?>
                <tr><td colspan="4" class="text-center">Nenhum dado encontrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include INCLUDE_PATH . '/footer.php'; ?>