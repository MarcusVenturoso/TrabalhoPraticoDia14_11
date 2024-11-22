<?php include 'principal_controller.php'; ?>
<?php include 'produtos_controller.php'; ?>
<?php include 'header.php'; ?>

<div class="flex-grow-1">
        <!-- Conteúdo da página vai aqui -->
        <h2>Olá, <?php echo htmlspecialchars($nome); ?>!</h2>

        <form method="POST" action="">
            <input type="submit" name="logout" value="Logout">
        </form>
        <h2 class="text-center mb-4">Produtos Cadastrados</h2>

<div class="row">
    <!-- Faz um loop FOR no resultset de produtos e preenche os cards -->
    <?php foreach ($produtos as $produto): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $produto['nome']; ?></h5>
                    <p class="card-text"><strong>Descrição:</strong> <?php echo $produto['descricao']; ?></p>
                    <p class="card-text"><strong>Marca:</strong> <?php echo $produto['marca']; ?></p>
                    <p class="card-text"><strong>Modelo:</strong> <?php echo $produto['modelo']; ?></p>
                    <p class="card-text"><strong>Valor Unitário:</strong> R$ <?php echo number_format($produto['valorunitario'], 2, ',', '.'); ?></p>
                    <p class="card-text"><strong>Categoria:</strong> <?php echo $produto['categoria']; ?></p>
                    <p class="card-text"><strong>Ativo:</strong> <?php echo $produto['ativo'] ? 'Sim' : 'Não'; ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="?edit=<?php echo $produto['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="?delete=<?php echo $produto['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    </div>


<?php include 'footer.php'; ?>