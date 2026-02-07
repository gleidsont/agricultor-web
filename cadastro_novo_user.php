<?php
session_start();
include 'includes/conexao.php';

// Ativa erros para debug (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$erro = '';
$sucesso = '';

// Processa o cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Criação de novo usuário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];

    // Validações básicas
    if (empty($nome) || empty($email) || empty($senha) || empty($cpf) || empty($data_nascimento) || empty($telefone)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um e-mail válido!";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } else {
        // Verifica se email já existe
        $check = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado!";
        } else {
            // Criptografa a senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, cpf, data_nascimento, telefone) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nome, $email, $senha_hash, $cpf, $data_nascimento, $telefone);
            
            if ($stmt->execute()) {
                $sucesso = "Cadastro realizado com sucesso!";
                // Limpa os campos do formulário
                $_POST = array();
            } else {
                $erro = "Erro ao realizar cadastro. Por favor, tente novamente mais tarde.";
            }
        }
    }
}

// Recupera mensagens da sessão (se houver redirecionamento)
if (isset($_SESSION['sucesso'])) {
    $sucesso = $_SESSION['sucesso'];
    unset($_SESSION['sucesso']);
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Crie sua conta</h4>
                </div>
                <div class="card-body">
                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= $erro ?></div>
                    <?php elseif ($sucesso): ?>
                        <div class="alert alert-success"><?= $sucesso ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required 
                                       value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control" required maxlength="14"
                                       value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" 
                                       placeholder="000.000.000-00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['data_nascimento'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" class="form-control" required
                                       value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>"
                                       placeholder="(00) 00000-0000">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" required minlength="6">
                                <small class="text-muted">Mínimo 6 caracteres</small>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Máscaras para CPF e Telefone (opcional)
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfField = document.querySelector('input[name="cpf"]');
    if (cpfField) {
        cpfField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.replace(/^(\d{3})(\d)/g, '$1.$2');
            if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})(\d)/g, '$1.$2.$3');
            if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})(\d)/g, '$1.$2.$3-$4');
            e.target.value = value.substring(0, 14);
        });
    }
    
    // Máscara para Telefone
    const telField = document.querySelector('input[name="telefone"]');
    if (telField) {
        telField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) value = value.replace(/^(\d)/, '($1');
            if (value.length > 3) value = value.replace(/^(\d{2})(\d)/g, '$1) $2');
            if (value.length > 10) value = value.replace(/(\d{5})(\d)/g, '$1-$2');
            e.target.value = value.substring(0, 15);
        });
    }
});
</script>

<?php include 'includes/footer.php'; ?>