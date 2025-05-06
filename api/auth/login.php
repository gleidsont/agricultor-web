<?php
header("Content-Type: application/json; charset=UTF-8");
require_once '../../config/db_connection.php';
require_once '../../config/auth_check.php';

$data = json_decode(file_get_contents("php://input"));
$cpf = preg_replace('/[^0-9]/', '', $data->cpf);
$data_nascimento = $data->data_nascimento;

if (!validarCPF($cpf)) {
    http_response_code(400);
    echo json_encode(["message" => "CPF inválido"]);
    exit();
}

$database = new Database();
$db = $database->getConnection();

$query = "SELECT id, nome, data_nascimento FROM usuarios WHERE cpf = ?";
$stmt = $db->prepare($query);
$stmt->execute([$cpf]);

if ($stmt->rowCount() == 1) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($data_nascimento == $row['data_nascimento']) {
        session_start();
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['usuario_nome'] = $row['nome'];
        
        echo json_encode([
            "success" => true,
            "message" => "Login bem-sucedido",
            "nome" => $row['nome']
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Data de nascimento incorreta"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["message" => "CPF não cadastrado"]);
}
?>