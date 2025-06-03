<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caderneta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <header class="bg-success text-white py-3">
        <div class="container">
            <h1>Caderneta Agroecológica - Registros</h1>
        </div>
    </header>

    <main class="container my-5">
        <div class="mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                Adicionar Registro
            </button>
        </div>

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
            <tbody id="consumoTable">
                <!-- Dados serão inseridos via JavaScript -->
            </tbody>
        </table>
    </main>

    <!-- Modal para adicionar/editar -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Consumo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="consumoForm">
                        <input type="hidden" id="registroId">
                        <div class="mb-3">
                            <label for="produto" class="form-label">Produto</label>
                            <input type="text" class="form-control" id="produto" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" id="quantidade" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor (R$)</label>
                            <input type="number" class="form-control" id="valor" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" class="form-control" id="data" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            <p>Sistema de Controle Agrícola &copy; 2023</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/consumo.js"></script>
</body>
</html>