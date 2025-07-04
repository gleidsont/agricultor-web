<?php
session_start();
include '../../includes/header.php';
require_once '../../includes/conexao.php';

$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    header('Location: ../../selecionar_agricultor.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = $_POST['produto'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $tipo = $_POST['tipo_cadastro'];

    $stmt = mysqli_prepare($conexao, "INSERT INTO caderneta (usuario_id, produto, quantidade, valor, data, tipo_cadastro) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isdsss", $id_agricultor, $produto, $quantidade, $valor, $data, $tipo);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ler.php?sucesso=1");
        exit;
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conn);
    }
}
?>