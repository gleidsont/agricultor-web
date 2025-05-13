<?php
session_start();
include 'includes/conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $perfil = 'Agricultor';

    // Verifica se o e-mail já está cadastrado
    $check = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $erro = "Este e-mail já está em uso.";
    } else {
        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, cpf, data_nascimento, telefone, perfil) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdss", $nome, $email, $senha, $cpf, $data_nascimento, $telefone, $perfil);
        if ($stmt->execute()) {
            $sucesso = "Conta criada com sucesso! Você já pode fazer login.";
            header("refresh:3;url=login.php");
            exit;

        } else {
            $erro = "Erro ao criar conta.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center">Criar Conta</h3>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php elseif ($sucesso): ?>
        <div class="alert alert-success"><?php echo $sucesso; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group mb-3">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="form-control" required />
        </div>
        <div class="form-group mb-3">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" class="form-control" required />
        </div>
        <div class="form-group mb-3">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" class="form-control" required maxlength="14" />
        </div>
        <div class="form-group mb-3">
            <label for="data_nascimento">Telefone:</label>
            <input type="text" name="telefone" class="form-control" required />
        </div>
        <div class="form-group mb-3">
            <label for="email">E-mail:</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="form-group mb-3">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" class="form-control" required />
        </div>                      
        <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>
    <div class="mt-3 text-center">
        <a href="login.php">Já tem conta? Entrar</a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>