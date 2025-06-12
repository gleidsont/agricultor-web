<?php
require_once '../../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $organizacao = $_POST['organizacao'];
    $uf = $_POST['uf'];
    $municipio = $_POST['municipio'];
    $comunidade = $_POST['comunidade'];

    $stmt = mysqli_prepare($conexao, "UPDATE agricultores SET nome = ?, organizacao = ?, uf = ?, municipio = ?, comunidade = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssssi", $nome, $organizacao, $uf, $municipio, $comunidade, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: agricultores.php?msg=Registro atualizado com sucesso");
        exit;
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
}
?>