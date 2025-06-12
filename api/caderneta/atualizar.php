<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $tipo = $_POST['tipo_cadastro'];

    $stmt = mysqli_prepare($conexao, "UPDATE caderneta SET produto = ?, quantidade = ?, valor = ?, data = ?, tipo_cadastro = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sdsssi", $produto, $quantidade, $valor, $data, $tipo, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ler.php?atualizado=1");
        exit;
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
}
?>