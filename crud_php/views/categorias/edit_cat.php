<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Formulário de edição de Categoria existente
*******************************************************************************/

include_once __DIR__ . '/../../controllers/CategoriaController.php';

$controller = new CategoriaController();

$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$baseUrl = $baseDir;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: " . $baseUrl . "/index.php?page=categorias");
    exit();
}

$categoria = $controller->readOne($id);
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');

    if (empty($nome)) {
        $errorMessage = "Informe o nome da categoria.";
    } else {
        if ($controller->update($id, $nome)) {
            header("Location: " . $baseUrl . "/index.php?page=categorias&msg=updated");
            exit();
        } else {
            $errorMessage = "Erro ao atualizar a categoria no banco de dados.";
        }
    }
}

$pageTitle = "Editar Categoria #" . $id;
include __DIR__ . '/../../views/includes/header.php';
?>

<div class="card form-card">
    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Editar Categoria <span class="badge">#<?php echo $id; ?></span></span>
        </div>
        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Voltar</span>
        </a>
    </div>

    <div class="card-body">
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <div class="alert-content">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span><?php echo htmlspecialchars($errorMessage); ?></span>
                </div>
                <button type="button" class="alert-close">&times;</button>
            </div>
        <?php endif; ?>

        <form action="<?php echo $baseUrl; ?>/index.php?page=categorias&action=edit&id=<?php echo $id; ?>" method="POST">
            <div class="form-group col-full">
                <label for="nome">Nome da Categoria <span class="required">*</span></label>
                <input type="text" id="nome" name="nome" class="form-control" 
                       value="<?php echo htmlspecialchars($categoria->nome ?? '', ENT_QUOTES); ?>" required autofocus>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-check"></i>
                    <span>Atualizar Categoria</span>
                </button>
                <a href="<?php echo $baseUrl; ?>/index.php?page=categorias" class="btn btn-secondary">
                    <i class="fa-solid fa-xmark"></i>
                    <span>Cancelar</span>
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
