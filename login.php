<?php
include 'includes/conexao.php';
$logout_msg = "";
$erro = '';
if (isset($_GET['logout'])) {
    $logout_msg = "Você saiu com sucesso.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        //if ($usuario['ativo'] == 0) {
        //    $erro = "Este usuário está bloqueado.";
        //} else
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];
            header("Location: index.php");
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5" style="max-width: 500px;">
    <h3 class="text-center">Login</h3>
    <?php 
    
    if ($logout_msg): ?>
    <div class="alert alert-success"><?php echo $logout_msg; ?></div>
    <?php endif; ?>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group mb-3">
            <label for="email">E-mail:</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="form-group mb-3">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
    <div class="mt-3 text-center">
        <a href="registro.php">Criar conta</a> | 
        <a href="recuperar_senha.php">Esqueci minha senha</a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>