<?php
require_once '../../includes/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conexao, "DELETE FROM agricultores WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: agricultores.php?msg=Registro excluído com sucesso");
        exit;
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    echo "ID não informado.";
}
