<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Formulário de cadastro de novo Produto com validação e layout moderno
*******************************************************************************/

include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$categorias_stmt = $controller->getCategorias();
$categorias = $categorias_stmt->fetchAll(PDO::FETCH_ASSOC);

$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$baseUrl = $baseDir;
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = trim($_POST['preco'] ?? '');
    $categoria_id = trim($_POST['categoria_id'] ?? '');

    if (empty($nome) || empty($preco) || empty($categoria_id)) {
        $errorMessage = "Preencha todos os campos obrigatórios marcados com *.";
    } else {
        if ($controller->create($nome, $descricao, $preco, $categoria_id)) {
            header("Location: " . $baseUrl . "/index.php?page=produtos&msg=created");
            exit();
        } else {
            $errorMessage = "Erro ao salvar o produto no banco de dados.";
        }
    }
}

$pageTitle = "Novo Produto";
include __DIR__ . '/../../views/includes/header.php';
?>

<div class="card form-card">
    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-circle-plus"></i>
            <span>Cadastrar Novo Produto</span>
        </div>
        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" class="btn btn-secondary btn-sm">
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

        <?php if (empty($categorias)): ?>
            <div class="alert alert-danger">
                <div class="alert-content">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><strong>Atenção:</strong> Nenhuma categoria cadastrada. Cadastre uma categoria antes de inserir produtos.</span>
                </div>
            </div>
            <div style="text-align: center; margin-top: 15px;">
                <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-tags"></i>
                    <span>Cadastrar Categoria Agora</span>
                </a>
            </div>
        <?php else: ?>
            <form action="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" method="POST">
                <div class="form-grid">
                    <div class="form-group col-full">
                        <label for="nome">Nome do Produto <span class="required">*</span></label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Ex: Teclado Mecânico RGB" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="categoria_id">Categoria <span class="required">*</span></label>
                        <select id="categoria_id" name="categoria_id" class="form-control" required>
                            <option value="">Selecione uma categoria...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo htmlspecialchars($cat['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preco">Preço Unitário (R$) <span class="required">*</span></label>
                        <input type="number" id="preco" name="preco" step="0.01" min="0" class="form-control" placeholder="Ex: 199.90" required>
                    </div>

                    <div class="form-group col-full">
                        <label for="descricao">Descrição Detalhada</label>
                        <textarea id="descricao" name="descricao" class="form-control" placeholder="Informe detalhes ou especificações do produto..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Salvar Produto</span>
                    </button>
                    <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" class="btn btn-secondary">
                        <i class="fa-solid fa-xmark"></i>
                        <span>Cancelar</span>
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
