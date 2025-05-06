<?php
require_once '../../config/db_connection.php';
require_once '../../config/auth_check.php';
require_once '../../libs/PHPSpreadsheet/vendor/autoload.php';

verificarAutenticacao();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$database = new Database();
$db = $database->getConnection();

$tipo = $_GET['tipo'] ?? 'consumo';
$data_inicio = $_GET['data_inicio'] ?? date('Y-m-01');
$data_fim = $_GET['data_fim'] ?? date('Y-m-t');

$allowed_types = ['consumo', 'doacao', 'troca', 'venda'];
if (!in_array($tipo, $allowed_types)) {
    die("Tipo de relatório inválido");
}

$query = "SELECT * FROM $tipo 
          WHERE usuario_id = :usuario_id 
          AND data BETWEEN :data_inicio AND :data_fim
          ORDER BY data";

$stmt = $db->prepare($query);
$stmt->execute([
    'usuario_id' => $_SESSION['usuario_id'],
    'data_inicio' => $data_inicio,
    'data_fim' => $data_fim
]);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Cabeçalhos
$sheet->setCellValue('A1', 'Produto');
$sheet->setCellValue('B1', 'Quantidade');
$sheet->setCellValue('C1', 'Valor (R$)');
$sheet->setCellValue('D1', 'Data');
$sheet->setCellValue('E1', 'Observações');

// Dados
$row = 2;
while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sheet->setCellValue('A'.$row, $data['produto']);
    $sheet->setCellValue('B'.$row, $data['quantidade']);
    $sheet->setCellValue('C'.$row, $data['valor']);
    $sheet->setCellValue('D'.$row, $data['data']);
    $sheet->setCellValue('E'.$row, $data['observacoes']);
    $row++;
}

// Formatar cabeçalho
$sheet->getStyle('A1:E1')->getFont()->setBold(true);

// Auto-size columns
foreach(range('A','E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Gerar arquivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="relatorio_'.$tipo.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>