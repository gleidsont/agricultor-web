<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Busca estatísticas para o dashboard
$stmt = $conexao->prepare("SELECT COUNT(*) as total FROM agricultores");
$stmt->execute();
$total_agricultores = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conexao->prepare("SELECT COUNT(*) as total FROM caderneta WHERE MONTH(data) = MONTH(CURRENT_DATE())");
$stmt->execute();
$lancamentos_mes = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conexao->prepare("SELECT tipo_cadastro, COUNT(*) as total FROM caderneta GROUP BY tipo_cadastro");
$stmt->execute();
$tipos_lancamento = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid py-4">
    <!-- Banner Superior -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body p-5 text-center">
                    <img src="images/Tema.png" class="img-fluid rounded mt-3" alt="Agricultura Familiar" style="max-height: 150px;">
                    <h1 class="display-4">Sistema Agroecológico</h1>
                    <p class="lead">Gestão de cadernetas e produção agrícola familiar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Resumo -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-users fa-2x mb-3 text-success"></i></h5>
                    <h3><?= $total_agricultores ?></h3>
                    <p class="card-text">Agricultoras Cadastradas</p>
                    <a href="api/agricultores/agricultores.php" class="btn btn-outline-success">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-book fa-2x mb-3 text-success"></i></h5>
                    <h3><?= $lancamentos_mes ?></h3>
                    <p class="card-text">Lançamentos Este Mês</p>
                    <a href="api/caderneta/ler.php" class="btn btn-outline-success">Ver Cadernetas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="card-title"><i class="fas fa-chart-pie fa-2x mb-3 text-success"></i></h5>
                    <h3>Relatórios</h3>
                    <p class="card-text">Dados e Estatísticas</p>
                    <a href="relatorios.php" class="btn btn-outline-success">Visualizar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Seções -->
    <div class="row">
        <!-- Gráfico de Tipos de Lançamento -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Distribuição por Tipo de Lançamento</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoTipos" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Últimas Atividades -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Últimas Atividades</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php
                        $stmt = $conexao->prepare("SELECT c.data, c.produto, c.tipo_cadastro, a.nome 
                                                   FROM caderneta c 
                                                   JOIN agricultores a ON c.usuario_id = a.id 
                                                   ORDER BY c.data DESC LIMIT 5");
                        $stmt->execute();
                        $atividades = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                        foreach ($atividades as $atividade): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= htmlspecialchars($atividade['produto']) ?></h6>
                                    <small><?= date('d/m/Y', strtotime($atividade['data'])) ?></small>
                                </div>
                                <p class="mb-1"><?= htmlspecialchars($atividade['tipo_cadastro']) ?> por <?= htmlspecialchars($atividade['nome']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acesso Rápido -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Acesso Rápido</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="agricultoras.php" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-users fa-2x mb-2"></i><br>
                                Agricultoras
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="caderneta.php" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-book fa-2x mb-2"></i><br>
                                Cadernetas
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="relatorios.php" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                                Relatórios
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="questionarios.php" class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-clipboard-list fa-2x mb-2"></i><br>
                                Questionários
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para Gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Tipos
        const ctxTipos = document.getElementById('graficoTipos').getContext('2d');
        new Chart(ctxTipos, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_column($tipos_lancamento, 'tipo_cadastro')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($tipos_lancamento, 'total')) ?>,
                    backgroundColor: [
                        '#2e7043', // Verde escuro
                        '#44a840', // Verde claro
                        '#ffba2e', // Amarelo
                        '#583f28' // Marrom
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permite que o gráfico não mantenha proporções fixas
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>