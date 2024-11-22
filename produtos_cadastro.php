<?php
include 'produtos_controller.php';

session_start();

// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Pega todos os produtos para preencher os dados da tabela
$produtos = getProdutos();

// Variável que guarda o ID do produto que será editado
$produtoToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e se há um ID para edição de produto
if (isset($_GET['edit'])) {
    $produtoToEdit = getProduto($_GET['edit']);
}
?>

<?php include 'header.php'; ?> 

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Produtos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('valorunitario').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('url_img').value = '';
            document.getElementById('ativo').checked = true;
            document.getElementById('id').value = '';
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Cadastro de Produtos</h2>
        
        <form method="POST" action="" class="mb-4">
            <input type="hidden" id="id" name="id" value="<?php echo $produtoToEdit['id'] ?? ''; ?>">

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $produtoToEdit['nome'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required><?php echo $produtoToEdit['descricao'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" value="<?php echo $produtoToEdit['marca'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" value="<?php echo $produtoToEdit['modelo'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="valorunitario">Valor Unitário:</label>
                <input type="number" step="0.01" id="valorunitario" name="valorunitario" class="form-control" value="<?php echo $produtoToEdit['valorunitario'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" value="<?php echo $produtoToEdit['categoria'] ?? ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="url_img">URL da Imagem:</label>
                <input type="url" id="url_img" name="url_img" class="form-control" value="<?php echo $produtoToEdit['url_img'] ?? ''; ?>" required>
            </div>

            <div class="form-check">
                <input type="checkbox" id="ativo" name="ativo" class="form-check-input" <?php echo isset($produtoToEdit['ativo']) && $produtoToEdit['ativo'] == 0 ? '' : 'checked'; ?>>
                <label class="form-check-label" for="ativo">Ativo</label>
            </div>

            <div class="form-group text-center mt-3">
                <button type="submit" name="save" class="btn btn-success">Salvar</button>
                <button type="submit" name="update" class="btn btn-warning">Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-secondary">Novo</button>
            </div>
        </form>

        <h2 class="text-center mb-4">Produtos Cadastrados</h2>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Valor Unitário</th>
                    <th>Categoria</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Faz um loop FOR no resultset de produtos e preenche a tabela -->
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['descricao']; ?></td>
                        <td><?php echo $produto['marca']; ?></td>
                        <td><?php echo $produto['modelo']; ?></td>
                        <td>R$ <?php echo number_format($produto['valorunitario'], 2, ',', '.'); ?></td>
                        <td><?php echo $produto['categoria']; ?></td>
                        <td><?php echo $produto['ativo'] ? 'Sim' : 'Não'; ?></td>
                        <td>
                            <a href="?edit=<?php echo $produto['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="?delete=<?php echo $produto['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php include 'footer.php'; ?>