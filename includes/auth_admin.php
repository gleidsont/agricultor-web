<?php
include 'auth_check.php';

if ($_SESSION['usuario_perfil'] !== 'Administrador') {
    echo "Acesso restrito ao perfil Administrador.";
    exit;
}
?>