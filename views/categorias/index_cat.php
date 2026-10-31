<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Visão de Listagem de Categorias com busca em tempo real e ações de gerenciamento
*******************************************************************************/

include_once __DIR__ . '/../../controllers/CategoriaController.php';

$controller = new CategoriaController();
$data = $controller->index();
$stmt = $data['stmt'];
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num = count($categorias);

$pageTitle = "Gestão de Categorias";
include __DIR__ . '/../../views/includes/header.php';
?>

<!-- Mensagens de Feedback (Alerts) -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Categoria cadastrada com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Categoria atualizada com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Categoria removida com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'has_products'): ?>
        <div class="alert alert-danger">
            <div class="alert-content">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Não é possível excluir esta categoria porque existem produtos vinculados a ela!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'error'): ?>
        <div class="alert alert-danger">
            <div class="alert-content">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Erro: Não foi possível realizar a operação na categoria.</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Painel Principal de Categorias -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-tags"></i>
            <span>Categorias Cadastradas</span>
        </div>
        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=create" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Nova Categoria</span>
        </a>
    </div>

    <div class="card-body">
        <!-- Barra de Busca -->
        <div class="action-bar">
            <div class="search-filter-group">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="tableSearchInput" placeholder="Pesquisar categoria por nome...">
                </div>
            </div>
        </div>

        <?php if ($num > 0): ?>
            <div class="table-responsive">
                <table id="crudDataTable">
                    <thead>
                        <tr>
                            <th class="td-id">#ID</th>
                            <th>Nome da Categoria</th>
                            <th class="td-actions">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $cat): ?>
                            <tr>
                                <td class="td-id"><?php echo htmlspecialchars($cat['id']); ?></td>
                                <td class="td-name">
                                    <span class="badge" style="font-size: 0.9rem; padding: 6px 14px;">
                                        <i class="fa-solid fa-tag"></i>
                                        <?php echo htmlspecialchars($cat['nome']); ?>
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=edit&id=<?php echo $cat['id']; ?>" 
                                           class="btn btn-sm btn-edit" 
                                           title="Editar Categoria">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Editar</span>
                                        </a>
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=delete&id=<?php echo $cat['id']; ?>" 
                                           class="btn btn-sm btn-delete" 
                                           onclick="return confirm('Deseja realmente excluir a categoria &quot;<?php echo htmlspecialchars(addslashes($cat['nome'])); ?>&quot;?');"
                                           title="Excluir Categoria">
                                            <i class="fa-solid fa-trash"></i>
                                            <span>Excluir</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <h3>Nenhuma categoria cadastrada</h3>
                <p>Categorias ajudam a organizar os produtos no estoque.</p>
                <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    <span>Cadastrar Primeira Categoria</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
