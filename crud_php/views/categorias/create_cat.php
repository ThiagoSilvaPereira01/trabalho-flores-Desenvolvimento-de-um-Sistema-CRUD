<?php
include_once __DIR__ . '/../../controllers/CategoriaController.php';

$controller = new CategoriaController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    if ($controller->create($nome)) {
        header('Location: /crud_php/public/index.php?page=categorias');
        exit();
    } else {
        echo "<p class='error'>Não foi possível criar a categoria.</p>";
    }
}

include __DIR__ . '/../../views/includes/header.php';
?>

<h2>Criar Categoria</h2>

<form action="/crud_php/public/index.php?page=categorias&action=create" method="POST">
    <label for="nome">Nome da Categoria:</label>
    <input type="text" id="nome" name="nome" required>
    <button type="submit" class="button">Salvar</button>
    <a href="/crud_php/public/index.php?page=categorias" class="button">Cancelar</a>
</form>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
