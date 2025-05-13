<?php
include 'includes/auth_check.php';
echo '<pre>'; print_r($_SESSION); echo '</pre>';
$perfisPermitidos = ['Administrador', 'Pesquisador Popular', 'Agricultor'];
if (!in_array($_SESSION['usuario_perfil'], $perfisPermitidos)) {
    echo "<h3 style='color: red; text-align: center; margin-top: 50px;'>Acesso não autorizado.</h3>";
    exit;
}
?>