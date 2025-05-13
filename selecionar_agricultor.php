<?php
include 'includes/conexao.php';

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_perfil'], ['Administrador', 'Pesquisador Popular'])) {
    header("Location: login.php");
    exit;
}

// Buscar agricultores
$sql = "SELECT id, nome FROM usuarios WHERE perfil = 'Agricultor'";
$result = $conexao->query($sql);
?>

<h2>Selecione o Agricultor</h2>
<form action="definir_agricultor.php" method="post">
    <select name="agricultor_id" required>
        <option value="">Selecione...</option>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
        <?php } ?>
    </select>
    <button type="submit">Continuar</button>
</form>