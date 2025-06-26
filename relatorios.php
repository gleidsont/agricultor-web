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


<?php
// Processa filtros se formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $data_inicio = $_POST['data_inicio'] ?? '';
    $data_fim = $_POST['data_fim'] ?? '';
    
    // Consulta com filtros
    $query = "SELECT produto, SUM(quantidade) as total_quantidade, 
              SUM(valor) as total_valor, DATE_FORMAT(data, '%m/%Y') as mes_formatado
              FROM caderneta WHERE usuario_id = ?";
    
    $params = [$id_agricultor];
    $types = "i";
    
    if ($tipo) {
        $query .= " AND tipo_cadastro = ?";
        $params[] = strtoupper($tipo);
        $types .= "s";
    }
    
    if ($data_inicio && $data_fim) {
        $query .= " AND data BETWEEN ? AND ?";
        $params[] = $data_inicio;
        $params[] = $data_fim;
        $types .= "ss";
    }
    
    $query .= " GROUP BY produto, mes_formatado ORDER BY mes_formatado";
    
    $stmt = $conexao->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $dados = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!-- Seu HTML mantido igual até o formulário -->
<form method="POST" id="filtroForm">
    <!-- Campos do formulário mantidos iguais -->
</form>

<!-- Gráficos e tabela -->
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Gráfico de Valores</h5>
            </div>
            <div class="card-body">
                <canvas id="valorChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Gráfico de Quantidades</h5>
            </div>
            <div class="card-body">
                <canvas id="quantidadeChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabela de dados -->
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor (R$)</th>
                        <th>Mês</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dados)): ?>
                        <?php foreach ($dados as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['produto']) ?></td>
                                <td><?= number_format($item['total_quantidade'], 2, ',', '.') ?></td>
                                <td>R$ <?= number_format($item['total_valor'], 2, ',', '.') ?></td>
                                <td><?= $item['mes_formatado'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum dado encontrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php if (!empty($dados)): ?>
        // Prepara dados para os gráficos
        const produtos = <?= json_encode(array_column($dados, 'produto')) ?>;
        const valores = <?= json_encode(array_column($dados, 'total_valor')) ?>;
        const quantidades = <?= json_encode(array_column($dados, 'total_quantidade')) ?>;
        
        // Gráfico de Valores
        new Chart(document.getElementById('valorChart'), {
            type: 'bar',
            data: {
                labels: produtos,
                datasets: [{
                    label: 'Valor (R$)',
                    data: valores,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)'
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
        
        // Gráfico de Quantidades
        new Chart(document.getElementById('quantidadeChart'), {
            type: 'bar',
            data: {
                labels: produtos,
                datasets: [{
                    label: 'Quantidade',
                    data: quantidades,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    <?php endif; ?>
});
</script>

<?php include 'includes/footer.php'; ?>