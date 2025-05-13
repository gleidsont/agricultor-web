<?php
include 'auth_check.php';

// Permite acesso apenas a Administrador ou Pesquisador Popular
$perfisPermitidos = ['Administrador', 'Pesquisador Popular'];
if (!in_array($_SESSION['usuario_perfil'], $perfisPermitidos)) {
    echo "<h3 style='color: red; text-align: center; margin-top: 50px;'>Acesso não autorizado.</h3>";
    exit;
}
?>