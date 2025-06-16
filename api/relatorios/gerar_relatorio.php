<?php
require_once '../../includes/conexao.php';

$tipo = $_GET['tipo'] ?? 'CONSUMO';
$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

$allowed = ['CONSUMO','TROCA','DOAÇÃO','VENDA'];
if (!in_array(strtoupper($tipo), $allowed)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Tipo inválido']);
    exit;
}

$stmt = $pdo->prepare("SELECT produto, quantidade, valor, data, observacoes FROM caderneta WHERE tipo_cadastro = ? AND data BETWEEN ? AND ? ORDER BY data");
$stmt->bind_param('sss', $tipo, $data_inicio, $data_fim);
$stmt->execute();
$result = $stmt->get_result();
$dados = [];
while ($row = $result->fetch_assoc()) {
    $row['quantidade'] = (float)$row['quantidade'];
    $row['valor'] = (float)$row['valor'];
    $dados[] = $row;
}
header('Content-Type: application/json');
echo json_encode($dados);