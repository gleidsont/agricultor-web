<?php
include 'includes/auth_admin_pesquisador.php';
include 'includes/conexao.php';
include 'includes/header.php';

//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['agricultor_selecionado'] = $_POST['agricultor_id'];
    header("Location: index.php");
    exit;
    }

// Buscar agricultores
$sql = "SELECT id, nome FROM usuarios WHERE perfil = 'Agricultor'";
$result = $conexao->query($sql);
?>

<div class="container mt-5" style="max-width: 500px;">
    <h2>Selecione o Agricultor</h2>   
        <div class="form-group mb-3">
        <form action="selecionar_agricultor.php" method="post">       
        <select name="agricultor_id" required>
            <option value="">Selecione...</option>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
            <?php } ?>
        </select>
            </div>
        <button type="submit">Continuar</button>
    </form>
</div>    


<?php
include 'includes/footer.php';
?>