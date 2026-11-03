<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
             26011846-2 - Arthur Vinicius de Freitas Videres
             26003401-2 - Matheus Azamur Passos
             26006867-2 - Dennis Gabriel de Oliveira
             26007484-2 - Murilo da Silva Santos
             26003834-2 - Thiago Pereira da Silva
Data: 15 de Novembro de 2026
Descritivo: Painel Administrativo de Gestão de Departamentos e Categorias da Loja
*******************************************************************************/

include_once __DIR__ . '/../../controllers/CategoriaController.php';

$controller = new CategoriaController();
$data = $controller->index();
$stmt = $data['stmt'];
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num = count($categorias);

$pageTitle = "Gestão de Departamentos";
include __DIR__ . '/../../views/includes/header.php';
?>

<!-- ================= CABEÇALHO DO MÓDULO ================= -->
<div class="admin-page-header">
    <div class="page-title-group">
        <div class="badge-pill-header">
            <i class="fa-solid fa-tags"></i>
            <span>Módulo de Estrutura da Loja</span>
        </div>
        <h2 class="page-main-title">Departamentos & Categorias</h2>
        <p class="page-subtitle">Gerencie os departamentos em que os produtos são organizados para exibição e filtragem no catálogo da loja.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=create" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Cadastrar Novo Departamento</span>
        </a>
        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Voltar ao Catálogo</span>
        </a>
    </div>
</div>

<!-- Mensagens de Feedback (Alerts) -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Novo departamento cadastrado com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Departamento atualizado com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Departamento removido com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'has_products'): ?>
        <div class="alert alert-danger">
            <div class="alert-content">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><strong>Atenção:</strong> Não é possível excluir este departamento porque existem produtos vinculados a ele no inventário! Remova ou altere os produtos antes de excluir.</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'error'): ?>
        <div class="alert alert-danger">
            <div class="alert-content">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Erro: Não foi possível processar a operação na categoria.</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Painel Principal de Categorias -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-layer-group"></i>
            <span>Departamentos Ativos na Loja (<?php echo $num; ?>)</span>
        </div>
        <div class="admin-search-input-box" style="max-width: 320px;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="tableSearchInput" placeholder="Filtrar departamento por nome...">
        </div>
    </div>

    <div class="card-body">
        <?php if ($num > 0): ?>
            <div class="table-responsive">
                <table id="crudDataTable">
                    <thead>
                        <tr>
                            <th class="td-id">#ID</th>
                            <th>Nome do Departamento</th>
                            <th>Visualização no Catálogo</th>
                            <th class="td-actions">Ações de Gestão</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $cat): ?>
                            <tr>
                                <td class="td-id"><strong>#<?php echo htmlspecialchars($cat['id']); ?></strong></td>
                                <td class="td-name">
                                    <span class="badge" style="font-size: 0.88rem; padding: 6px 14px;">
                                        <i class="fa-solid fa-tag"></i>
                                        <?php echo htmlspecialchars($cat['nome']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&cat=<?php echo urlencode($cat['nome']); ?>" class="btn btn-sm btn-secondary" style="font-size: 0.78rem;">
                                        <i class="fa-solid fa-filter"></i>
                                        <span>Filtrar Itens Deste Departamento</span>
                                    </a>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=edit&id=<?php echo $cat['id']; ?>" 
                                           class="btn btn-sm btn-edit" 
                                           title="Editar Departamento">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Editar</span>
                                        </a>
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=delete&id=<?php echo $cat['id']; ?>" 
                                           class="btn btn-sm btn-delete" 
                                           onclick="return confirm('Deseja realmente excluir o departamento &quot;<?php echo htmlspecialchars(addslashes($cat['nome'])); ?>&quot;?');"
                                           title="Excluir Departamento">
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
                <div class="empty-icon"><i class="fa-solid fa-tags"></i></div>
                <h3>Nenhum departamento cadastrado</h3>
                <p>Crie departamentos para categorizar os produtos da sua loja virtual.</p>
                <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    <span>Cadastrar Primeiro Departamento</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
