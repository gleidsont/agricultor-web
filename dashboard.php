<?php
require_once 'config/auth_check.php';
require_once 'includes/header.php';
?>

<div class="container my-5">
    <h2 class="mb-4">Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h2>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Consumo</h5>
                    <p class="card-text">Total este mês: <span id="totalConsumo">R$ 0,00</span></p>
                    <a href="pages/consumo.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Doação</h5>
                    <p class="card-text">Total este mês: <span id="totalDoacao">R$ 0,00</span></p>
                    <a href="pages/doacao.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Troca</h5>
                    <p class="card-text">Total este mês: <span id="totalTroca">R$ 0,00</span></p>
                    <a href="pages/troca.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Venda</h5>
                    <p class="card-text">Total este mês: <span id="totalVenda">R$ 0,00</span></p>
                    <a href="pages/venda.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Resumo Mensal</h5>
        </div>
        <div class="card-body">
            <canvas id="resumoMensalChart" height="300"></canvas>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Últimos Registros</h5>
            <a href="relatorios.php" class="btn btn-sm btn-success">Ver Relatórios</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="ultimosRegistros">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dados serão carregados via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/dashboard.js"></script>

<?php require_once 'includes/footer.php'; ?>