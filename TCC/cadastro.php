<?php include 'php/conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Flora</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

        <h1>Cadastro de Flora</h1>

        <form action="php/salvar.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id_adm" value="1">

            <label for="nome_popu">Nome Popular</label>
            <input type="text" id="nome_popu" name="nome_popu" maxlength="50" required>

            <label for="nome_cien">Nome Científico</label>
            <input type="text" id="nome_cien" name="nome_cien" maxlength="50" required>

            <label for="nome_familia">Família</label>
            <input type="text" id="nome_familia" name="nome_familia" maxlength="100" placeholder="Digite o nome da família" required>

            <label for="nome_genero">Gênero</label>
            <input type="text" id="nome_genero" name="nome_genero" maxlength="100" placeholder="Digite o nome do gênero" required>

            <label for="quantidade">Quantidade</label>
            <input type="number" id="quantidade" name="quantidade" min="0">

            <label for="alt_media">Altura Média (m)</label>
            <input type="number" step="0.01" id="alt_media" name="alt_media">

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="5" placeholder="Digite informações sobre a árvore..."></textarea>

            <label for="imagem">Foto da Planta</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">

            <button type="submit">Salvar</button>

        </form>

    </body>
</html>