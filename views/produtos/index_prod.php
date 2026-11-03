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
Descritivo: Painel Administrativo de Gestão do Catálogo da Loja (Cards de Gestão & Tabela de Estoque)
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

// Cálculo de métricas financeiras do estoque da loja
$precoTotal = 0;
foreach ($produtos as $p) {
    $precoTotal += floatval($p['preco']);
}
$precoMedio = $num > 0 ? ($precoTotal / $num) : 0;

// Helper para imagens temáticas dos produtos cadastrados
if (!function_exists('getProductImage')) {
    function getProductImage($nome, $categoria) {
        $nomeLower = mb_strtolower($nome);
        if (str_contains($nomeLower, 'notebook') || str_contains($nomeLower, 'laptop') || str_contains($nomeLower, 'dell')) {
            return 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'teclado') || str_contains($nomeLower, 'keyboard')) {
            return 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'mouse')) {
            return 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'monitor') || str_contains($nomeLower, 'tela')) {
            return 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'cadeira')) {
            return 'https://images.unsplash.com/photo-1580481077195-c22ae982a5c9?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'mesa')) {
            return 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'headset') || str_contains($nomeLower, 'fone')) {
            return 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($nomeLower, 'webcam') || str_contains($nomeLower, 'camera')) {
            return 'https://images.unsplash.com/photo-1588702547919-26089e690ecc?auto=format&fit=crop&w=600&q=80';
        }

        $catLower = mb_strtolower($categoria ?? '');
        if (str_contains($catLower, 'hardware') || str_contains($catLower, 'computador')) {
            return 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($catLower, 'perif')) {
            return 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($catLower, 'móveis') || str_contains($catLower, 'moveis')) {
            return 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=600&q=80';
        } elseif (str_contains($catLower, 'áudio') || str_contains($catLower, 'audio') || str_contains($catLower, 'vídeo') || str_contains($catLower, 'video')) {
            return 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=600&q=80';
        }

        return 'https://images.unsplash.com/photo-1526738549149-8e07eca6c147?auto=format&fit=crop&w=600&q=80';
    }
}

$pageTitle = "Gestão de Catálogo da Loja";
include __DIR__ . '/../../views/includes/header.php';
?>

<!-- ================= CABEÇALHO DO PAINEL ADMINISTRATIVO ================= -->
<div class="admin-page-header">
    <div class="page-title-group">
        <div class="badge-pill-header">
            <i class="fa-solid fa-boxes-packing"></i>
            <span>Módulo de Inventário da Loja</span>
        </div>
        <h2 class="page-main-title">Catálogo de Produtos da Loja</h2>
        <p class="page-subtitle">Controle em tempo real os itens disponíveis na loja, ajuste preços de venda, vincule categorias e gerencie o estoque.</p>
    </div>
    <div class="page-header-actions">
        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Cadastrar Novo Produto</span>
        </a>
        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias&action=create" class="btn btn-secondary">
            <i class="fa-solid fa-folder-plus"></i>
            <span>Novo Departamento</span>
        </a>
    </div>
</div>

<!-- ================= DASHBOARD DE MÉTRICAS DO LOJISTA (STORE KPIS) ================= -->
<section class="admin-kpis-grid">
    <div class="kpi-card">
        <div class="kpi-icon blue">
            <i class="fa-solid fa-cubes"></i>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Produtos no Catálogo</span>
            <div class="kpi-value"><?php echo $num; ?></div>
            <span class="kpi-status-tag green"><i class="fa-solid fa-circle"></i> Disponíveis para Venda</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon purple">
            <i class="fa-solid fa-layer-group"></i>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Departamentos Ativos</span>
            <div class="kpi-value"><?php echo $totalCategorias; ?></div>
            <span class="kpi-status-tag blue"><i class="fa-solid fa-tags"></i> Categorias Mapeadas</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon green">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Valor Total do Estoque</span>
            <div class="kpi-value">R$ <?php echo number_format($precoTotal, 2, ',', '.'); ?></div>
            <span class="kpi-status-tag green"><i class="fa-solid fa-arrow-trend-up"></i> Patrimônio em Produtos</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon orange">
            <i class="fa-solid fa-calculator"></i>
        </div>
        <div class="kpi-info">
            <span class="kpi-label">Preço Médio por Item</span>
            <div class="kpi-value">R$ <?php echo number_format($precoMedio, 2, ',', '.'); ?></div>
            <span class="kpi-status-tag orange"><i class="fa-solid fa-chart-line"></i> Ticket Médio</span>
        </div>
    </div>
</section>

<!-- Mensagens de Feedback (Alerts) -->
<?php if (isset($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Novo produto cadastrado com sucesso no catálogo da loja!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Dados e preços do produto atualizados com sucesso!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">
            <div class="alert-content">
                <i class="fa-solid fa-circle-check"></i>
                <span>Produto removido com sucesso do inventário!</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php elseif ($_GET['msg'] === 'error'): ?>
        <div class="alert alert-danger">
            <div class="alert-content">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>Erro: Não foi possível processar a operação no banco de dados.</span>
            </div>
            <button type="button" class="alert-close">&times;</button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- ================= BARRA DE FERRAMENTAS DO CATÁLOGO ================= -->
<div class="admin-toolbar">
    <div class="toolbar-search-filter">
        <div class="admin-search-input-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="tableSearchInput" placeholder="Buscar por nome do produto, código ID ou especificações...">
        </div>
        <select id="tableCategoryFilter" class="admin-select-filter">
            <option value="">Todos os Departamentos</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['nome']); ?>">
                    <?php echo htmlspecialchars($cat['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select id="storeSortSelect" class="admin-select-filter">
            <option value="default">Classificar: Padrão</option>
            <option value="price-desc">Maior Preço</option>
            <option value="price-asc">Menor Preço</option>
            <option value="name-asc">Nome do Produto (A-Z)</option>
        </select>
    </div>

    <!-- Alternador de Visualização (Cards de Gestão vs Tabela Operacional) -->
    <div class="view-mode-toggle">
        <span class="view-label">Modo:</span>
        <button type="button" class="btn-view-toggle active" id="btnViewGrid" title="Visualização em Cards de Gestão">
            <i class="fa-solid fa-table-cells-large"></i>
            <span>Cards da Loja</span>
        </button>
        <button type="button" class="btn-view-toggle" id="btnViewTable" title="Visualização em Tabela de Estoque">
            <i class="fa-solid fa-list-check"></i>
            <span>Tabela de Estoque</span>
        </button>
    </div>
</div>

<!-- ================= MODO 1: CARDS DE GESTÃO DO CATÁLOGO ================= -->
<section class="admin-catalog-grid" id="storeProductGrid">
    <?php if ($num > 0): ?>
        <?php foreach ($produtos as $prod): ?>
            <?php 
                $precoNum = floatval($prod['preco']);
                $precoPix = $precoNum * 0.90;
                $imageUrl = getProductImage($prod['nome'], $prod['categoria_nome'] ?? '');
            ?>
            <article class="catalog-manage-card"
                     data-name="<?php echo htmlspecialchars($prod['nome']); ?>"
                     data-category="<?php echo htmlspecialchars($prod['categoria_nome'] ?? ''); ?>"
                     data-price="<?php echo $precoNum; ?>"
                     data-id="<?php echo $prod['id']; ?>">
                
                <!-- Topo com ID e Status -->
                <div class="card-admin-top">
                    <span class="product-id-badge">#<?php echo $prod['id']; ?></span>
                    <span class="stock-active-badge">
                        <i class="fa-solid fa-circle"></i> Em Exibição na Loja
                    </span>
                </div>

                <!-- Foto do Item com Ficha Técnica Rápida -->
                <div class="card-image-box" onclick="openProductModal(<?php echo htmlspecialchars(json_encode([
                    'id' => $prod['id'],
                    'nome' => $prod['nome'],
                    'descricao' => $prod['descricao'] ?? 'Sem descrição cadastrada.',
                    'preco' => number_format($precoNum, 2, ',', '.'),
                    'precoPix' => number_format($precoPix, 2, ',', '.'),
                    'categoria' => $prod['categoria_nome'] ?? 'Sem categoria',
                    'imagem' => $imageUrl
                ])); ?>)">
                    <img src="<?php echo $imageUrl; ?>" 
                         alt="<?php echo htmlspecialchars($prod['nome']); ?>" 
                         loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1526738549149-8e07eca6c147?auto=format&fit=crop&w=600&q=80'">
                    <span class="quick-inspect-hint">
                        <i class="fa-solid fa-magnifying-glass-plus"></i> Ver Ficha do Item
                    </span>
                </div>

                <!-- Informações Cadastrais do Produto -->
                <div class="card-details-box">
                    <div class="product-dept-tag">
                        <i class="fa-solid fa-tag"></i>
                        <span><?php echo htmlspecialchars($prod['categoria_nome'] ?? 'Geral'); ?></span>
                    </div>

                    <h3 class="product-catalog-name" title="<?php echo htmlspecialchars($prod['nome']); ?>">
                        <?php echo htmlspecialchars($prod['nome']); ?>
                    </h3>

                    <p class="product-catalog-desc">
                        <?php echo !empty($prod['descricao']) ? htmlspecialchars($prod['descricao']) : '<span style="color:#94a3b8; font-style:italic;">Sem descrição detalhada cadastrada.</span>'; ?>
                    </p>

                    <!-- Preço de Venda Definido no Estoque -->
                    <div class="catalog-price-container">
                        <div class="price-header-label">Preço de Venda na Loja:</div>
                        <div class="price-highlight">
                            <span class="currency">R$</span>
                            <span class="value"><?php echo number_format($precoNum, 2, ',', '.'); ?></span>
                        </div>
                        <div class="price-pix-reference">
                            Preço à vista c/ 10% desc: <strong>R$ <?php echo number_format($precoPix, 2, ',', '.'); ?></strong>
                        </div>
                    </div>

                    <!-- Botões de Ação Administrativa (CRUD) -->
                    <div class="card-manage-actions">
                        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=edit&id=<?php echo $prod['id']; ?>" 
                           class="btn-manage btn-manage-edit" title="Editar dados e preço deste item">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>Editar Cadastro</span>
                        </a>
                        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=delete&id=<?php echo $prod['id']; ?>" 
                           class="btn-manage btn-manage-delete" 
                           onclick="return confirm('ATENÇÃO: Deseja realmente remover o produto &quot;<?php echo htmlspecialchars(addslashes($prod['nome'])); ?>&quot; do catálogo da loja?');"
                           title="Excluir produto do catálogo">
                            <i class="fa-solid fa-trash"></i>
                            <span>Excluir</span>
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-boxes-packing"></i></div>
            <h3>Nenhum produto cadastrado na loja</h3>
            <p>Cadastre os produtos que você deseja disponibilizar no catálogo do e-commerce.</p>
            <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i>
                <span>Cadastrar Primeiro Produto</span>
            </a>
        </div>
    <?php endif; ?>
</section>

<!-- ================= MODO 2: TABELA DE INVENTÁRIO (TABELA OPERACIONAL CRUD) ================= -->
<section class="card" id="storeProductTable" style="display: none;">
    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-list-check"></i>
            <span>Inventário Detalhado em Tabela</span>
        </div>
        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i>
            <span>+ Novo Produto</span>
        </a>
    </div>

    <div class="card-body">
        <?php if ($num > 0): ?>
            <div class="table-responsive">
                <table id="crudDataTable">
                    <thead>
                        <tr>
                            <th class="td-id">#ID</th>
                            <th>Foto</th>
                            <th>Produto no Catálogo</th>
                            <th>Descrição / Especificações</th>
                            <th>Preço Unitário</th>
                            <th>Departamento</th>
                            <th class="td-actions">Ações de Gestão</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $prod): ?>
                            <?php $imageUrl = getProductImage($prod['nome'], $prod['categoria_nome'] ?? ''); ?>
                            <tr data-category="<?php echo htmlspecialchars($prod['categoria_nome'] ?? ''); ?>">
                                <td class="td-id"><strong>#<?php echo htmlspecialchars($prod['id']); ?></strong></td>
                                <td style="width: 55px;">
                                    <img src="<?php echo $imageUrl; ?>" alt="" class="table-thumb">
                                </td>
                                <td class="td-name">
                                    <strong><?php echo htmlspecialchars($prod['nome']); ?></strong>
                                    <div style="font-size: 0.75rem; color: #10b981; margin-top: 2px;">
                                        <i class="fa-solid fa-circle" style="font-size: 6px;"></i> Ativo na loja
                                    </div>
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
                                           title="Editar cadastro do produto">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span>Editar</span>
                                        </a>
                                        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=delete&id=<?php echo $prod['id']; ?>" 
                                           class="btn btn-sm btn-delete" 
                                           onclick="return confirm('Deseja realmente excluir o produto &quot;<?php echo htmlspecialchars(addslashes($prod['nome'])); ?>&quot;?');"
                                           title="Excluir produto">
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
                <div class="empty-icon"><i class="fa-solid fa-box-open"></i></div>
                <h3>Inventário vazio</h3>
                <p>Nenhum produto cadastrado no banco de dados.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= MODAL: FICHA TÉCNICA ADMINISTRATIVA DO PRODUTO ================= -->
<div class="modal-backdrop" id="productModalBackdrop" onclick="closeProductModal()"></div>
<div class="product-modal" id="productModal">
    <button type="button" class="modal-close" onclick="closeProductModal()">&times;</button>
    <div class="modal-grid">
        <div class="modal-image-col">
            <img id="modalProductImage" src="" alt="Produto">
        </div>
        <div class="modal-info-col">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 8px;">
                <span class="badge" id="modalProductCategory">Departamento</span>
                <span class="stock-active-badge"><i class="fa-solid fa-circle"></i> Ativo no Sistema</span>
            </div>
            <h2 id="modalProductTitle" class="modal-title">Nome do Produto</h2>
            
            <div class="modal-price-area">
                <span style="font-size:0.75rem; color:#64748b; text-transform:uppercase; font-weight:700;">Preço de Venda Praticado:</span>
                <div class="price-current">
                    <span class="currency">R$</span>
                    <span class="amount" id="modalProductPrice">0,00</span>
                </div>
                <div class="price-pix">
                    Referência à vista no Pix (10% off): <strong id="modalProductPricePix">R$ 0,00</strong>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <span style="font-size:0.8rem; font-weight:700; color:#1e293b; display:block; margin-bottom:4px;">Descrição Completa do Cadastro:</span>
                <p id="modalProductDescription" class="modal-desc"></p>
            </div>

            <div class="modal-actions" style="margin-top:auto;">
                <a href="#" id="modalBtnEdit" class="btn btn-primary" style="flex:1;">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Editar Cadastro Deste Produto</span>
                </a>
                <button type="button" class="btn btn-secondary" onclick="closeProductModal()">
                    <span>Fechar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
