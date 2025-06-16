<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se está logado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_perfil'])) {
    header("Location: /agricultor-web/login.php");
    exit;
}

// Permite admin ou pesquisador
$perfisPermitidos = ['Administrador', 'Pesquisador Popular'];
if (!in_array($_SESSION['usuario_perfil'], $perfisPermitidos)) {
    echo "<h3 style='color: red; text-align: center; margin-top: 50px;'>Acesso não autorizado.</h3>";
    exit;
}