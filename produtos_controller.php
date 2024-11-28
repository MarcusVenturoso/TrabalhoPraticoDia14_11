<?php
include 'db.php'; // Certifique-se de que sua conexão com o banco está aqui

// Função para salvar um novo produto
function saveProduto($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;

    // Verifica se uma imagem foi enviada
    if (isset($_FILES['url_img']) && $_FILES['url_img']['error'] == 0) {
        // Diretório de upload
        $upload_dir = 'img/'; // Certifique-se de que a pasta "img" exista e tenha permissões de escrita
        $upload_file = $upload_dir . basename($_FILES['url_img']['name']);
        
        // Verifica o tipo e tamanho do arquivo (você pode adicionar mais verificações, como a extensão do arquivo)
        if (move_uploaded_file($_FILES['url_img']['tmp_name'], $upload_file)) {
            // Arquivo foi movido com sucesso
            $url_img = $upload_file; // Armazena o caminho completo do arquivo
        } else {
            // Se falhar no upload, pode retornar um erro ou usar uma imagem padrão
            $url_img = 'img/default.png'; // Imagem padrão
        }
    }

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorunitario, categoria, url_img, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdssi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo);
    return $stmt->execute();
}

// Função para buscar todos os produtos
function getProdutos() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Função para buscar um produto pelo ID
function getProduto($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Função para atualizar um produto existente
function updateProduto($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;
    
    // Verifica se uma imagem foi enviada
    if (isset($_FILES['url_img']) && $_FILES['url_img']['error'] == 0) {
        $upload_dir = 'img/';
        $upload_file = $upload_dir . basename($_FILES['url_img']['name']);
        
        if (move_uploaded_file($_FILES['url_img']['tmp_name'], $upload_file)) {
            $url_img = $upload_file; // Atualiza o caminho da imagem
        } else {
            $url_img = 'img/default.png'; // Usar imagem padrão
        }
    }

    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorunitario = ?, categoria = ?, url_img = ?, ativo = ? WHERE id = ?");
    $stmt->bind_param("ssssdssii", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo, $id);
    return $stmt->execute();
}

// Função para deletar um produto pelo ID
function deleteProduto($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processamento do formulário para salvar ou atualizar produto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        saveProduto(
            $_POST['nome'],
            $_POST['descricao'],
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['valorunitario'],
            $_POST['categoria'],
            '', // Não é necessário passar a URL da imagem, pois o upload é tratado dentro da função
            isset($_POST['ativo']) ? 1 : 0
        );
    } elseif (isset($_POST['update'])) {
        updateProduto(
            $_POST['id'],
            $_POST['nome'],
            $_POST['descricao'],
            $_POST['marca'],
            $_POST['modelo'],
            $_POST['valorunitario'],
            $_POST['categoria'],
            '', // Não é necessário passar a URL da imagem, pois o upload é tratado dentro da função
            isset($_POST['ativo']) ? 1 : 0
        );
    }
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteProduto($_GET['delete']);
}

// Obter todos os produtos para exibição
$produtos = getProdutos(); // Aqui você garante que a variável $produtos é definida
?>
