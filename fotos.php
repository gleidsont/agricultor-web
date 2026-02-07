<?php
session_start();

require_once 'includes/conexao.php';

$id_agricultor = $_SESSION['agricultor_selecionado'] ?? null;
if (!$id_agricultor) {
    header('Location: selecionar_agricultor.php');
    exit;
}
include 'includes/header.php';

// Busca nome do agricultor
$stmt = $conexao->prepare("SELECT nome FROM agricultores WHERE id = ?");
$stmt->bind_param("i", $id_agricultor);
$stmt->execute();
$result = $stmt->get_result();
$nome_agricultor = $result->fetch_assoc()['nome'] ?? '';

// Processa upload
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fotos'])) {
    $pastaDestino = 'uploads/agricultores/' . $id_agricultor . '/';

    // Cria diretório se não existir
    if (!file_exists($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    // Processa cada arquivo
    foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
        $nomeArquivo = basename($_FILES['fotos']['name'][$key]);
        $caminhoCompleto = $pastaDestino . $nomeArquivo;

        // Verifica se é uma imagem
        $tipo = mime_content_type($tmp_name);
        if (strpos($tipo, 'image/') === 0) {
            if (move_uploaded_file($tmp_name, $caminhoCompleto)) {
                // Insere no banco de dados
                $stmt = $conexao->prepare("INSERT INTO fotos_agricultor (agricultor_id, caminho, nome_arquivo) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $id_agricultor, $caminhoCompleto, $nomeArquivo);
                $stmt->execute();
                $mensagem = 'Fotos enviadas com sucesso!';
            }
        }
    }
}

// Busca fotos existentes
$stmt = $conexao->prepare("SELECT id, caminho, nome_arquivo, data_upload FROM fotos_agricultor WHERE agricultor_id = ? ORDER BY data_upload DESC");
$stmt->bind_param("i", $id_agricultor);
$stmt->execute();
$fotos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<header class="bg-success text-white py-3">
    <div class="container d-flex center-content-between align-items-center">
        <h5 class="mb-0 me-3">Agricultor selecionado: <?= htmlspecialchars($nome_agricultor) ?></h5>
        <a href="selecionar_agricultor.php" class="btn btn-light btn-sm">
            <i class="fas fa-exchange-alt"></i> Trocar Agricultor
        </a>
    </div>
</header>

<div class="container my-5">
    <h2 class="mb-4">Insira aqui as fotos da caderneta</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?= $mensagem ?></div>
    <?php endif; ?>

    <!-- Formulário de Upload -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Enviar Novas Fotos</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fotos" class="form-label">Selecione as fotos</label>
                    <input class="form-control" type="file" id="fotos" name="fotos[]" multiple accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary">Enviar Fotos</button>
            </form>
        </div>
    </div>

    <!-- Galeria de Fotos -->
    <div class="card">
        <div class="card-header">
            <h5>Fotos da Caderneta</h5>
        </div>
        <div class="card-body">
            <?php if (empty($fotos)): ?>
                <p class="text-muted">Nenhuma foto cadastrada ainda.</p>
            <?php else: ?>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php foreach ($fotos as $foto): ?>
                        <div class="col">
                            <div class="card h-100">
                                <img src="<?= htmlspecialchars($foto['caminho']) ?>" class="card-img-top img-thumbnail" alt="<?= htmlspecialchars($foto['nome_arquivo']) ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <small class="text-muted d-block mb-2">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        <?= date('d/m/Y H:i', strtotime($foto['data_upload'])) ?>
                                    </small>
                                </div>
                                <div class="card-body text-center">
                                    <a href="<?= htmlspecialchars($foto['caminho']) ?>" target="_blank" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-expand"></i> Ampliar
                                    </a>
                                    <a href="excluir_foto.php?id=<?= $foto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir esta foto?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>