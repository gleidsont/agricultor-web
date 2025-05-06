document.addEventListener('DOMContentLoaded', function() {
    let valorChart, quantidadeChart;
    let currentFilters = {
        tipo: 'consumo',
        data_inicio: '',
        data_fim: ''
    };

    // Inicializar datas padrão (mês atual)
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    document.getElementById('data_inicio').valueAsDate = firstDay;
    document.getElementById('data_fim').valueAsDate = lastDay;

    currentFilters.data_inicio = formatDate(firstDay);
    currentFilters.data_fim = formatDate(lastDay);

    // Carregar dados iniciais
    loadData();

    // Formulário de filtro
    document.getElementById('filtroForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        currentFilters = {
            tipo: document.getElementById('tipo').value,
            data_inicio: document.getElementById('data_inicio').value,
            data_fim: document.getElementById('data_fim').value
        };

        loadData();
    });

    // Botão exportar Excel
    document.getElementById('exportExcel').addEventListener('click', function() {
        exportToExcel();
    });

    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    function loadData() {
        fetch(`/api/relatorios/gerar_relatorio.php?${new URLSearchParams(currentFilters)}`)
            .then(response => response.json())
            .then(data => {
                updateTable(data);
                updateCharts(data);
            })
            .catch(error => console.error('Erro:', error));
    }

    function updateTable(data) {
        const tableBody = document.querySelector('#relatorioTable tbody');
        tableBody.innerHTML = '';

        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.produto}</td>
                <td>${item.quantidade}</td>
                <td>R$ ${item.valor.toFixed(2)}</td>
                <td>${new Date(item.data).toLocaleDateString('pt-BR')}</td>
                <td>${item.observacoes || '-'}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    function updateCharts(data) {
        const labels = data.map(item => item.produto);
        const valores = data.map(item => item.valor);
        const quantidades = data.map(item => item.quantidade);

        // Destruir gráficos existentes se eles existirem
        if (valorChart) valorChart.destroy();
        if (quantidadeChart) quantidadeChart.destroy();

        // Gráfico de valores
        const valorCtx = document.getElementById('valorChart').getContext('2d');
        valorChart = new Chart(valorCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Valor (R$)',
                    data: valores,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico de quantidades
        const quantidadeCtx = document.getElementById('quantidadeChart').getContext('2d');
        quantidadeChart = new Chart(quantidadeCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Quantidade',
                    data: quantidades,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function exportToExcel() {
        const params = new URLSearchParams(currentFilters);
        window.location.href = `/api/relatorios/exportar_excel.php?${params}`;
    }
});