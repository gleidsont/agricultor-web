<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../../config/db_connection.php';
require_once '../../config/auth_check.php';

verificarAutenticacao();

$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnection();

$query = "INSERT INTO consumo 
          (usuario_id, produto, quantidade, valor, data, observacoes) 
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $db->prepare($query);
$success = $stmt->execute([
    $_SESSION['usuario_id'],
    $data->produto,
    $data->quantidade,
    $data->valor,
    $data->data,
    $data->observacoes
]);

if ($success) {
    echo json_encode(["success" => true, "message" => "Registro criado com sucesso"]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Erro ao criar registro"]);
}
?>