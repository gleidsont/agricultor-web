<?php
session_start();
require_once 'includes/conexao.php';

$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    header('Location: selecionar_agricultor.php');
    exit;
}

if (isset($_GET['id'])) {
    $foto_id = $_GET['id'];
    
    // Busca informações da foto
    $stmt = $conexao->prepare("SELECT caminho FROM fotos_agricultor WHERE id = ? AND agricultor_id = ?");
    $stmt->bind_param("ii", $foto_id, $id_agricultor);
    $stmt->execute();
    $foto = $stmt->get_result()->fetch_assoc();
    
    if ($foto) {
        // Remove o arquivo
        if (file_exists($foto['caminho'])) {
            unlink($foto['caminho']);
        }
        
        // Remove do banco de dados
        $stmt = $conexao->prepare("DELETE FROM fotos_agricultor WHERE id = ?");
        $stmt->bind_param("i", $foto_id);
        $stmt->execute();
    }
}

header('Location: fotos.php');
exit;
?>