<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Visão de Listagem de Produtos com painel de métricas, busca em tempo real e filtros
*******************************************************************************/

include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$data = $controller->index();
$stmt = $data['stmt'];
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$num = count($produtos);

// Busca categorias para filtro e estatísticas
$categorias_stmt = $controller->getCategorias();
$categorias = $categorias_stmt->fetchAll(PDO::FETCH_ASSOC);
$totalCategorias = count($categorias);

// Cálculo de métricas
$precoTotal = 0;
foreach ($produtos as $p) {
    $precoTotal += floatval($p['preco']);
}
$precoMedio = $num > 0 ? ($precoTotal / $num) : 0;

$pageTitle = "Gestão de Produtos";
include __DIR__ . '/../../views/includes/header.php';
?>

<!-- Painel de Métricas (Dashboard) -->
<section class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value"><?php echo $num; ?></div>
            <div class="stat-label">Produtos Cadastrados</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fa-solid fa-tags"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value"><?php echo $totalCategorias; ?></div>
            <div class="stat-label">Categorias Ativas</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fa-solid fa-calculator"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">R$ <?php echo number_format($precoMedio, 2, ',', '.'); ?></div>
            <div class="stat-label">Preço Médio dos Itens</div>
        </div>
    </div>
</section>

<!-- Mensagens de Feedback (Alerts) -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Produto cadastrado com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Produto atualizado com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Produto removido com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'error'): ?>
        <div class="alert alert-danger">
            <div class="alert-content">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Erro: Não foi possível realizar a operação.</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Painel Principal de Produtos -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-cubes"></i>
            <span>Catálogo de Produtos</span>
        </div>
        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Novo Produto</span>
        </a>
    </div>

    <div class="card-body">
        <!-- Barra de Busca e Filtro em Tempo Real -->
        <div class="action-bar">
            <div class="search-filter-group">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="tableSearchInput" placeholder="Pesquisar por nome ou descrição...">
                </div>
                <select id="tableCategoryFilter" class="filter-select">
                    <option value="">Todas as Categorias</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat['nome']); ?>">
                            <?php echo htmlspecialchars($cat['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if ($num > 0): ?>
            <div class="table-responsive">
                <table id="crudDataTable">
                    <thead>
                        <tr>
                            <th class="td-id">#ID</th>
                            <th>Produto</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            <th class="td-actions">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $prod): ?>
                            <tr data-category="<?php echo htmlspecialchars($prod['categoria_nome'] ?? ''); ?>">
                                <td class="td-id"><?php echo htmlspecialchars($prod['id']); ?></td>
                                <td class="td-name">
                                    <strong><?php echo htmlspecialchars($prod['nome']); ?></strong>
                                </td>
                                <td>
                                    <?php 
                                    $desc = !empty($prod['descricao']) ? htmlspecialchars($prod['descricao']) : '<span style="color:var(--text-muted); font-style:italic;">Sem descrição</span>';
                                    echo $desc;
                                    ?>
                                </td>
                                <td class="td-price">
                                    R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?>
                                </td>
                                <td>
                                    <span class="badge">
                                        <i class="fa-solid fa-tag"></i>
                                        <?php echo htmlspecialchars($prod['categoria_nome'] ?? 'Sem categoria'); ?>
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <div class="action-buttons">
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=edit&id=<?php echo $prod['id']; ?>" 
                                           class="btn btn-sm btn-edit" 
                                           title="Editar Produto">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Editar</span>
                                        </a>
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=delete&id=<?php echo $prod['id']; ?>" 
                                           class="btn btn-sm btn-delete" 
                                           onclick="return confirm('Deseja realmente excluir o produto &quot;<?php echo htmlspecialchars(addslashes($prod['nome'])); ?>&quot;?');"
                                           title="Excluir Produto">
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
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3>Nenhum produto cadastrado</h3>
                <p>Comece adicionando seu primeiro produto ao catálogo do sistema.</p>
                <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    <span>Cadastrar Primeiro Produto</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
