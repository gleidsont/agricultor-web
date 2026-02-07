<?php
session_start();
include 'includes/conexao.php';

if (empty($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}
include 'includes/header.php';
echo "<h1>Bem-vindo, {$_SESSION['usuario_nome']}!</h1>";
echo "<p>Seu perfil: {$_SESSION['usuario_perfil']}</p>";

if ($_SESSION['usuario_perfil'] === 'Administrador') {
    echo "<a href='admin/usuarios.php'>Gerenciar usuários</a>";
} elseif ($_SESSION['usuario_perfil'] === 'Pesquisador Popular') {
    echo "<a href='lancamentos.php'>Cadastrar lançamentos</a>";
} else {
    echo "<a href='relatorios.php'>Ver relatórios</a>";
}
?>
<a href='logout.php'>Sair</a>