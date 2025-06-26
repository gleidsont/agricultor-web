<?php
include 'includes/conexao.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['agricultor_selecionado'] = $_POST['agricultor_id'];
    header("Location: index.php");
    exit;
}


// Buscar agricultores
$sql = "SELECT id, nome FROM agricultores";
$result = $conexao->query($sql);

?>

<?php
session_start();
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>

<div class="container mt-5" style="max-width: 500px;">
    <h2>Selecione o Agricultor</h2>   
    <form action="selecionar_agricultor.php" method="post">
        <div class="form-group mb-3">
            <select class="form-control" name="agricultor_id" required>
                <option value="">Selecione...</option>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Continuar</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>