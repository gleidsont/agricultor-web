<?php
include 'auth_check.php';

if ($_SESSION['usuario_perfil'] !== 'Pesquisador Popular') {
    echo "Acesso restrito ao perfil Pesquisador Popular.";
    exit;
}
?>