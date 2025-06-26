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
?>
<header class="bg-success text-white py-3">
    <div class="container">
        <h2>Controle de Produção Agrícola</h2>
        <h5>Agricultor selecionado: <?= htmlspecialchars($nome_agricultor) ?></h5>
    </div>
</header>

<div class="container my-5">
    <h2 class="mb-4">Relatórios e Gráficos</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtrar Dados</h5>
        </div>
        <div class="card-body">
            <form id="filtroForm">
                <div class="row">
                    <div class="col-md-3">
                        <label for="tipo" class="form-label">Tipo de Registro</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="consumo">Consumo</option>
                            <option value="doacao">Doação</option>
                            <option value="troca">Troca</option>
                            <option value="venda">Venda</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Dados Filtrados</h5>
            <button id="exportExcel" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Exportar Excel
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="relatorioTable">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor (R$)</th>
                            <th>Data</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados serão carregados via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
// Passa o ID do agricultor para o JavaScript
const agricultorId = <?= $id_agricultor ?>;
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/relatorios.js"></script>
