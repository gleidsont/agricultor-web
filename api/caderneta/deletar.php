<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../includes/conexao.php';
//include '../../includes/auth_admin_pesq_agricultor.php';

$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    header('Location: ../../selecionar_agricultor.php');
    exit;
} 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conexao, "DELETE FROM caderneta WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ler.php?excluido=1");
        exit;
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    echo "ID não informado.";
}
?>