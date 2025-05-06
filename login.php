<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Acesse sua conta</h4>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00" required>
                            </div>
                            <div class="mb-3">
                                <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="dataNascimento" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Entrar</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="cadastro.html">Não tem conta? Cadastre-se</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>