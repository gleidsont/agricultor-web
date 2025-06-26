document.addEventListener('DOMContentLoaded', function() {
    // Elementos do DOM com verificação
    const filtroForm = document.getElementById('filtroForm');
    if (!filtroForm) {
        console.error('Formulário não encontrado! Verifique o ID.');
        return;
    }

    // Gráficos
    const valorChartCtx = document.getElementById('valorChart').getContext('2d');
    const quantidadeChartCtx = document.getElementById('quantidadeChart').getContext('2d');
    
    // Inicializa gráficos
    const valorChart = new Chart(valorChartCtx, {
        type: 'bar',
        data: { labels: [], datasets: [] },
        options: getChartOptions('Valor (R$)')
    });
    
    const quantidadeChart = new Chart(quantidadeChartCtx, {
        type: 'bar',
        data: { labels: [], datasets: [] },
        options: getChartOptions('Quantidade')
    });

    // Função para carregar dados
    function loadData(params = '') {
        const apiUrl = '/agricultor-web/api/relatorios/relatorios.php';
        console.log('Carregando dados de:', apiUrl + '?' + params);
        
        fetch(apiUrl + '?' + params)
            .then(response => {
                if (!response.ok) throw new Error(`Erro ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.error);
                updateCharts(data);
                updateTable(data.detalhes);
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar dados: ' + error.message);
            });
    }

    // Atualiza gráficos
    function updateCharts(data) {
        valorChart.data.labels = data.labels;
        valorChart.data.datasets = [{
            label: 'Valor Total',
            data: data.valores,
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }];
        valorChart.update();
        
        quantidadeChart.data.labels = data.labels;
        quantidadeChart.data.datasets = [{
            label: 'Quantidade Total',
            data: data.quantidades,
            backgroundColor: 'rgba(75, 192, 192, 0.7)'
        }];
        quantidadeChart.update();
    }

    // Configuração dos gráficos
    function getChartOptions(title) {
        return {
            responsive: true,
            plugins: {
                title: { display: true, text: title }
            }
        };
    }

    // Event listener
    filtroForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(filtroForm);
        loadData(new URLSearchParams(formData).toString());
    });

    // Carrega dados iniciais
    loadData();
});