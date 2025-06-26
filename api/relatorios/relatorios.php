<?php
session_start();
require '../../includes/conexao.php';

// Força o cabeçalho para JSON
header('Content-Type: application/json');

// Verifica se o agricultor está logado
$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    http_response_code(401);
    die(json_encode(['error' => 'Agricultor não selecionado']));
}

try {
    // Seus parâmetros de filtro
    $tipo = $_GET['tipo'] ?? null;
    $dataInicio = $_GET['data_inicio'] ?? null;
    $dataFim = $_GET['data_fim'] ?? null;

    // Consulta ao banco de dados
    $query = "SELECT produto, SUM(quantidade) as total_quantidade, 
              SUM(valor) as total_valor, DATE_FORMAT(data, '%Y-%m') as mes 
              FROM caderneta WHERE usuario_id = ?";
    
    $params = [$id_agricultor];
    $types = "i";

    if ($tipo) {
        $query .= " AND tipo_cadastro = ?";
        $params[] = $tipo;
        $types .= "s";
    }

    if ($dataInicio && $dataFim) {
        $query .= " AND data BETWEEN ? AND ?";
        $params[] = $dataInicio;
        $params[] = $dataFim;
        $types .= "ss";
    }

    $query .= " GROUP BY produto, mes ORDER BY mes, produto";

    $stmt = $conexao->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [
        'labels' => [],
        'quantidades' => [],
        'valores' => [],
        'detalhes' => []
    ];

    while ($row = $result->fetch_assoc()) {
        $data['labels'][] = $row['produto'] . ' (' . $row['mes'] . ')';
        $data['quantidades'][] = (float)$row['total_quantidade'];
        $data['valores'][] = (float)$row['total_valor'];
        $data['detalhes'][] = $row;
    }

    echo json_encode($data);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erro no servidor',
        'message' => $e->getMessage()
    ]);
}