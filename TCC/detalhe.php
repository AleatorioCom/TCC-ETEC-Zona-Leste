<?php

include 'php/conexao.php';

$id = intval($_GET['id']);

// Busca única que traz TODOS os dados necessários
$sql = "
SELECT 
    fl.nome_popu,
    fl.nome_cien,
    fl.quantidade,
    fl.alt_media,
    fl.caminho_imagem,
    fa.nome_familia,
    g.genero,
    d.descricao
FROM flora fl
LEFT JOIN familia fa ON fl.id_familia = fa.id_familia
LEFT JOIN genero g ON fl.id_genero = g.id_genero
LEFT JOIN descricao d ON fl.id_flora = d.id_flora
WHERE fl.id_flora = $id
";

$dados = $conn->query($sql)->fetch_assoc();

$nome = $dados['nome_popu'];

if (!empty($dados['caminho_imagem'])) {
    $img = $dados['caminho_imagem']; // Pega a foto que o usuário subiu
} else {
    $img = 'img/arvoreTemplate.png';
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($dados['nome_popu']) ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

    <a href="index.php" class="btn-voltar">
    ← Voltar
    </a>

    <div class="detalhe">

        <h1><?= htmlspecialchars($dados['nome_popu']) ?></h1>

        <img src="<?= $img ?>" alt="<?= $nome ?>" class="img-detalhe">

        <p>
            <strong>Nome científico:</strong> 
            <?= htmlspecialchars($dados['nome_cien']) ?>
        </p>

        <p>
            <strong>Família:</strong> 
            <?= htmlspecialchars($dados['nome_familia']) ?>
        </p>

        <p>
            <strong>Gênero:</strong> 
            <?= htmlspecialchars($dados['genero']) ?>
        </p>

        <p>
            <strong>Quantidade:</strong> 
            <?= $dados['quantidade'] ?? 0 ?>
        </p>

        <p>
            <strong>Altura média:</strong> 
            <?= $dados['alt_media'] ? number_format($dados['alt_media'], 2) . ' m' : 'Não informada' ?>
        </p>

        <h2>Descrição</h2>

        <p>
            <?= $dados['descricao'] ? htmlspecialchars($dados['descricao']) : 'Nenhuma descrição cadastrada para esta espécie.' ?>
        </p>
        

    </div>

    </body>
</html>