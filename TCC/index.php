<?php
include 'php/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Catálogo de Árvores</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

    <h1>Catálogo de Árvores</h1>

    <div class="grid">

    <?php
    $sql = "SELECT id_flora, nome_popu, caminho_imagem FROM flora";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {

        $nome = $row['nome_popu'];
        
        // Verifica se a planta tem uma imagem salva no banco de dados.
        if (!empty($row['caminho_imagem'])) {
            $img = $row['caminho_imagem'];
        } else {
            // Caso não, utiliza o template de erro.
            $img = 'img/arvoreTemplate.png';
        }

        echo "
        <a href='detalhe.php?id={$row['id_flora']}' class='card'>
            <img src='$img' alt='$nome'>
            <h3>$nome</h3>
        </a>
        ";
    }
    ?>

    </div>

    <div class="area-botao">
        <a href="cadastro.php" class="btn">
            Cadastrar Nova Árvore
        </a>
    </div>

    </body>
</html>