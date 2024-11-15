<?php include 'principal_controller.php'; ?>
<?php include 'header.php'; ?>

<div class="flex-grow-1">
        <!-- Conteúdo da página vai aqui -->
        <h2>Olá, <?php echo htmlspecialchars($nome); ?>!</h2>

        <form method="POST" action="">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>


<?php include 'footer.php'; ?>