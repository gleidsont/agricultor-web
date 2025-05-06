document.addEventListener('DOMContentLoaded', function() {
    // Simulação de dados - em produção viria do backend
    let registros = [
        { id: 1, produto: "Milho", quantidade: 10, valor: 15.50, data: "2023-10-01" },
        { id: 2, produto: "Feijão", quantidade: 5, valor: 25.00, data: "2023-10-02" }
    ];

    const tableBody = document.getElementById('consumoTable');
    const consumoForm = document.getElementById('consumoForm');
    const saveBtn = document.getElementById('saveBtn');
    const addModal = new bootstrap.Modal(document.getElementById('addModal'));

    // Carrega os registros na tabela
    function loadRegistros() {
        tableBody.innerHTML = '';
        registros.forEach(registro => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${registro.produto}</td>
                <td>${registro.quantidade}</td>
                <td>R$ ${registro.valor.toFixed(2)}</td>
                <td>${new Date(registro.data).toLocaleDateString('pt-BR')}</td>
                <td>
                    <button class="btn btn-sm btn-warning edit-btn" data-id="${registro.id}">Editar</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${registro.id}">Excluir</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Adiciona eventos aos botões
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', editRegistro);
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', deleteRegistro);
        });
    }

    // Editar registro
    function editRegistro(e) {
        const id = parseInt(e.target.getAttribute('data-id'));
        const registro = registros.find(r => r.id === id);
        
        document.getElementById('registroId').value = registro.id;
        document.getElementById('produto').value = registro.produto;
        document.getElementById('quantidade').value = registro.quantidade;
        document.getElementById('valor').value = registro.valor;
        document.getElementById('data').value = registro.data;
        
        addModal.show();
    }

    // Excluir registro
    function deleteRegistro(e) {
        const id = parseInt(e.target.getAttribute('data-id'));
        if (confirm('Tem certeza que deseja excluir este registro?')) {
            registros = registros.filter(r => r.id !== id);
            loadRegistros();
        }
    }

    // Salvar registro (cria ou atualiza)
    saveBtn.addEventListener('click', function() {
        const id = parseInt(document.getElementById('registroId').value);
        const produto = document.getElementById('produto').value;
        const quantidade = parseFloat(document.getElementById('quantidade').value);
        const valor = parseFloat(document.getElementById('valor').value);
        const data = document.getElementById('data').value;

        if (id) {
            // Atualiza registro existente
            const index = registros.findIndex(r => r.id === id);
            registros[index] = { id, produto, quantidade, valor, data };
        } else {
            // Cria novo registro
            const newId = registros.length > 0 ? Math.max(...registros.map(r => r.id)) + 1 : 1;
            registros.push({ id: newId, produto, quantidade, valor, data });
        }

        consumoForm.reset();
        addModal.hide();
        loadRegistros();
    });

    // Carrega os registros inicialmente
    loadRegistros();
});