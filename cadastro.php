<?php
session_start();
include 'includes/conexao.php';

// Ativa erros para debug (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$erro = '';
$sucesso = '';
$acao = $_GET['acao'] ?? '';
$id = $_GET['id'] ?? '';

// Processa ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($acao === 'editar' && $id) {
        // Edição de usuário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $data_nascimento = $_POST['data_nascimento'];
        $telefone = $_POST['telefone'];

        // Verifica se a senha foi alterada
        $senha_sql = '';
        if (!empty($_POST['senha'])) {
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $senha_sql = ", senha = ?";
        }

        $sql = "UPDATE usuarios SET nome = ?, email = ?, cpf = ?, data_nascimento = ?, telefone = ? $senha_sql WHERE id = ?";
        $stmt = $conexao->prepare($sql);

        if (!empty($_POST['senha'])) {
            $stmt->bind_param("ssssssi", $nome, $email, $cpf, $data_nascimento, $telefone, $senha, $id);
        } else {
            $stmt->bind_param("sssssi", $nome, $email, $cpf, $data_nascimento, $telefone, $id);
        }

        if ($stmt->execute()) {
            $_SESSION['sucesso'] = "Usuário atualizado com sucesso!";
            header("Location: cadastro.php");
            exit;
        } else {
            $erro = "Erro ao atualizar usuário: " . $stmt->error;
        }
    } elseif ($acao === 'criar') {
        // Criação de novo usuário - VERSÃO CORRIGIDA
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $cpf = $_POST['cpf'];
        $data_nascimento = $_POST['data_nascimento'];
        $telefone = $_POST['telefone'];

        // Verifica se email já existe
        $check = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado!";
        } else {
            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, cpf, data_nascimento, telefone) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nome, $email, $senha, $cpf, $data_nascimento, $telefone);
            
            if ($stmt->execute()) {
                $_SESSION['sucesso'] = "Usuário criado com sucesso!";
                header("Location: cadastro.php");
                exit;
            } else {
                $erro = "Erro ao criar usuário: " . $stmt->error;
            }
        }
    }
} elseif ($acao === 'excluir' && $id) {
    // Exclusão de usuário
    $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['sucesso'] = "Usuário excluído com sucesso!";
        header("Location: cadastro.php");
        exit;
    } else {
        $erro = "Erro ao excluir usuário: " . $stmt->error;
    }
}

// Recupera mensagens da sessão
if (isset($_SESSION['sucesso'])) {
    $sucesso = $_SESSION['sucesso'];
    unset($_SESSION['sucesso']);
}

// Busca usuário para edição
$usuario_edicao = [];
if ($acao === 'editar' && $id) {
    $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario_edicao = $result->fetch_assoc();
}

// Lista todos os usuários
$stmt = $conexao->prepare("SELECT id, nome, email, cpf FROM usuarios ORDER BY nome");
$stmt->execute();
$usuarios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Gerenciamento de Usuários</h3>
        <button class="btn btn-primary" onclick="mostrarFormulario('criar')">
            <i class="fas fa-plus"></i> Novo Usuário
        </button>
    </div>

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= $erro ?></div>
    <?php elseif ($sucesso): ?>
        <div class="alert alert-success"><?= $sucesso ?></div>
    <?php endif; ?>

    <!-- Formulário de Edição/Criação -->
    <div class="card mb-4" id="formulario-usuario" style="display: <?= ($acao === 'editar' || $acao === 'criar') ? 'block' : 'none' ?>;">
        <div class="card-header">
            <h5><?= ($acao === 'editar') ? 'Editar Usuário' : 'Novo Usuário' ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" action="cadastro.php?<?= http_build_query(['acao' => $acao, 'id' => $id ?? '']) ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required 
                               value="<?= htmlspecialchars($usuario_edicao['nome'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" class="form-control" required
                               value="<?= htmlspecialchars($usuario_edicao['email'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" class="form-control" required maxlength="14"
                               value="<?= htmlspecialchars($usuario_edicao['cpf'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control" required
                               value="<?= htmlspecialchars($usuario_edicao['data_nascimento'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" class="form-control" required
                               value="<?= htmlspecialchars($usuario_edicao['telefone'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" <?= ($acao === 'criar') ? 'required' : '' ?>>
                        <?php if ($acao === 'editar'): ?>
                            <small class="text-muted">Deixe em branco para manter a senha atual</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" onclick="esconderFormulario()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Usuários -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>CPF</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td><?= htmlspecialchars($usuario['cpf']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="?acao=editar&id=<?= $usuario['id'] ?>" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?acao=excluir&id=<?= $usuario['id'] ?>" class="btn btn-danger" 
                                           onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarFormulario(acao) {
        // Redireciona para garantir que o parâmetro acao seja incluído na URL
        window.location.href = 'cadastro.php?acao=' + acao;
    }

    function esconderFormulario() {
        window.location.href = 'cadastro.php';
    }
</script>

<?php include 'includes/footer.php'; ?>