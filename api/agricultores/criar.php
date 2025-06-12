<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Agricultor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Cadastrar Novo Agricultor</h2>
        <form action="inserir.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Organização</label>
                <input type="text" name="organizacao" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">UF</label>
                <input type="text" name="uf" class="form-control" maxlength="2">
            </div>
            <div class="mb-3">
                <label class="form-label">Município</label>
                <input type="text" name="municipio" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Comunidade</label>
                <input type="text" name="comunidade" class="form-control">
            </div>
            <div class="d-flex justify-content-between">
                <a href="agricultores.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>