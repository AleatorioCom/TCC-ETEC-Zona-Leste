<?php
include 'conexao.php'; 

$id_adm       = $_POST['id_adm'];
$nome_popu    = $_POST['nome_popu'];
$nome_cien    = $_POST['nome_cien'];
$nome_familia = trim($_POST['nome_familia']); 
$nome_genero  = trim($_POST['nome_genero']);
$descricao    = trim($_POST['descricao']); // Recebe a descrição do formulário

$quantidade = !empty($_POST['quantidade']) ? $_POST['quantidade'] : null;
$alt_media  = !empty($_POST['alt_media'])  ? $_POST['alt_media']  : null;

// verifica se a familia inserida já está cadastrada, caso não salva no banco de dados
$stmtFam = $conn->prepare("SELECT id_familia FROM familia WHERE nome_familia = ?");
$stmtFam->bind_param("s", $nome_familia);
$stmtFam->execute();
$resFam = $stmtFam->get_result();

if ($rowFam = $resFam->fetch_assoc()) {
    $id_familia = $rowFam['id_familia']; 
} else {
    $stmtInFam = $conn->prepare("INSERT INTO familia (nome_familia) VALUES (?)");
    $stmtInFam->bind_param("s", $nome_familia);
    $stmtInFam->execute();
    $id_familia = $stmtInFam->insert_id;
    $stmtInFam->close();
}
$stmtFam->close();

// verifica se o gênero inserido já está cadastrado, caso não salva no banco de dados
$stmtGen = $conn->prepare("SELECT id_genero FROM genero WHERE genero = ?");
$stmtGen->bind_param("s", $nome_genero);
$stmtGen->execute();
$resGen = $stmtGen->get_result();

if ($rowGen = $resGen->fetch_assoc()) {
    $id_genero = $rowGen['id_genero']; 
} else {
    $stmtInGen = $conn->prepare("INSERT INTO genero (genero) VALUES (?)");
    $stmtInGen->bind_param("s", $nome_genero);
    $stmtInGen->execute();
    $id_genero = $stmtInGen->insert_id;
    $stmtInGen->close();
}
$stmtGen->close();

// Upload da imagem
$caminho_imagem = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir('../img')) {
        mkdir('../img', 0777, true);
    }
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $novo_nome_img = uniqid() . "." . $extensao;
    $destino = "../img/" . $novo_nome_img;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        $caminho_imagem = "img/" . $novo_nome_img; 
    }
}

//Salva a flora inserida
$sql = "INSERT INTO flora (id_adm, id_familia, id_genero, quantidade, alt_media, nome_cien, nome_popu, caminho_imagem) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiidsss", $id_adm, $id_familia, $id_genero, $quantidade, $alt_media, $nome_cien, $nome_popu, $caminho_imagem);

if ($stmt->execute()) {
    
    // Pega o ID da árvore que acabou de ser cadastrada
    $id_flora_nova = $conn->insert_id;
    
    // Salva a descrição colocada pelo usuário
    if (!empty($descricao)) {
        $sqlDesc = "INSERT INTO descricao (id_flora, descricao) VALUES (?, ?)";
        $stmtDesc = $conn->prepare($sqlDesc);
        $stmtDesc->bind_param("is", $id_flora_nova, $descricao); // 'i' para id (inteiro), 's' para string
        $stmtDesc->execute();
        $stmtDesc->close();
    }
    
    // Cadastro completo, redireciona para a página principal
    header("Location: ../index.php");
    exit();
    
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>