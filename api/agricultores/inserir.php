<?php
require_once '../../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $organizacao = $_POST['organizacao'];
    $uf = $_POST['uf'];
    $municipio = $_POST['municipio'];
    $comunidade = $_POST['comunidade'];

    $stmt = mysqli_prepare($conexao, "INSERT INTO agricultores (nome, organizacao, uf, municipio, comunidade) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $organizacao, $uf, $municipio, $comunidade);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: agricultores.php?msg=Cadastro realizado com sucesso");
        exit;
    } else {
        echo "Erro ao inserir: " . mysqli_error($conexao);
    }
}
?>
