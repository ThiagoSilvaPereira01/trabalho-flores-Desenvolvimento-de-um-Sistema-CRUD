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
Descritivo: Rodapé do Painel Administrativo de Controle da Loja com créditos acadêmicos e scripts
*******************************************************************************/
?>
    </main>

    <!-- ================= RODAPÉ DO PAINEL ADMINISTRATIVO ================= -->
    <footer class="admin-footer">
        <div class="admin-footer-container">
            <!-- Coluna 1: Informações do Sistema -->
            <div class="footer-col">
                <div class="footer-brand">
                    <i class="fa-solid fa-store"></i>
                    <span>TechStore Admin</span>
                </div>
                <p class="footer-desc">
                    Módulo de Gestão de Catálogo e Estoque para Lojas Virtuais desenvolvido com arquitetura MVC em PHP e MySQL.
                </p>
                <div class="footer-academic-meta">
                    <span><strong>Disciplina:</strong> Linguagem e Técnicas de Programação (LTP)</span>
                    <span><strong>Professor:</strong> José Carlos Domingues Flores</span>
                    <span><strong>Turma:</strong> ADS2B &bull; 2º Bimestre</span>
                </div>
            </div>

            <!-- Coluna 2: Equipe de Desenvolvimento -->
            <div class="footer-col">
                <h4 class="footer-heading"><i class="fa-solid fa-users"></i> Desenvolvedores do Projeto</h4>
                <ul class="admin-team-list">
                    <li><span class="ra">26011846-2</span> Arthur Vinicius de Freitas Videres</li>
                    <li><span class="ra">26003401-2</span> Matheus Azamur Passos</li>
                    <li><span class="ra">26006867-2</span> Dennis Gabriel de Oliveira</li>
                    <li><span class="ra">26007484-2</span> Murilo da Silva Santos</li>
                    <li><span class="ra">26003834-2</span> Thiago Pereira da Silva</li>
                </ul>
            </div>

            <!-- Coluna 3: Status Técnico do Sistema -->
            <div class="footer-col">
                <h4 class="footer-heading"><i class="fa-solid fa-server"></i> Informações do Ambiente</h4>
                <div class="admin-tech-badges">
                    <div class="tech-badge"><i class="fa-brands fa-php"></i> PHP 8.x MVC</div>
                    <div class="tech-badge"><i class="fa-solid fa-database"></i> MySQL PDO</div>
                    <div class="tech-badge"><i class="fa-solid fa-shield-halved"></i> Sanitização PDO</div>
                    <div class="tech-badge"><i class="fa-solid fa-layer-group"></i> CRUD Completo</div>
                </div>
                <div class="admin-support-box">
                    <i class="fa-solid fa-circle-check" style="color: #10b981;"></i>
                    <span>Sistema Operacional &bull; Banco de Dados Sincronizado</span>
                </div>
            </div>
        </div>

        <!-- Linha Inferior de Direitos -->
        <div class="admin-bottom-bar">
            <div class="admin-bottom-container">
                <p>&copy; <?php echo date("Y"); ?> <strong>TechStore Admin &bull; EstoqueMaster</strong> &bull; Todos os direitos reservados.</p>
                <p class="footer-disclaimer">Trabalho Prático Acadêmico &bull; Engenharia de Software / ADS</p>
            </div>
        </div>
    </footer>

    <!-- ================= SCRIPTS DE CONTROLE DO PAINEL ================= -->
    <script>
        // Modal de Ficha Técnica / Inspeção Administrativa do Produto
        function openProductModal(prod) {
            const modal = document.getElementById('productModal');
            const backdrop = document.getElementById('productModalBackdrop');
            if (!modal || !backdrop) return;

            document.getElementById('modalProductImage').src = prod.imagem;
            document.getElementById('modalProductTitle').innerText = prod.nome;
            document.getElementById('modalProductPrice').innerText = prod.preco;
            document.getElementById('modalProductPricePix').innerText = 'R$ ' + prod.precoPix;
            document.getElementById('modalProductCategory').innerHTML = '<i class="fa-solid fa-tag"></i> ' + prod.categoria;
            document.getElementById('modalProductDescription').innerText = prod.descricao;

            const baseUrl = '<?php echo $baseUrl; ?>';
            document.getElementById('modalBtnEdit').href = baseUrl + '/index.php?page=produtos&action=edit&id=' + prod.id;

            modal.classList.add('open');
            backdrop.classList.add('open');
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            const backdrop = document.getElementById('productModalBackdrop');
            if (modal && backdrop) {
                modal.classList.remove('open');
                backdrop.classList.remove('open');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Fechamento de Alertas
            const closeButtons = document.querySelectorAll('.alert-close');
            closeButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const alert = this.closest('.alert');
                    if (alert) {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-8px)';
                        setTimeout(() => alert.remove(), 200);
                    }
                });
            });

            // Alternador de Visualização (Cards de Gestão x Tabela de Estoque)
            const btnGrid = document.getElementById('btnViewGrid');
            const btnTable = document.getElementById('btnViewTable');
            const gridSection = document.getElementById('storeProductGrid');
            const tableSection = document.getElementById('storeProductTable');

            function setViewMode(mode) {
                if (!gridSection || !tableSection) return;
                if (mode === 'table') {
                    gridSection.style.display = 'none';
                    tableSection.style.display = 'block';
                    if (btnTable) btnTable.classList.add('active');
                    if (btnGrid) btnGrid.classList.remove('active');
                    localStorage.setItem('techstore_admin_view', 'table');
                } else {
                    gridSection.style.display = 'grid';
                    tableSection.style.display = 'none';
                    if (btnGrid) btnGrid.classList.add('active');
                    if (btnTable) btnTable.classList.remove('active');
                    localStorage.setItem('techstore_admin_view', 'grid');
                }
            }

            if (btnGrid) btnGrid.addEventListener('click', () => setViewMode('grid'));
            if (btnTable) btnTable.addEventListener('click', () => setViewMode('table'));

            const savedMode = localStorage.getItem('techstore_admin_view') || 'grid';
            setViewMode(savedMode);

            // Filtro e Busca em Tempo Real (Sincronizado entre Header e Barra de Ferramentas)
            const headerSearch = document.getElementById('headerGlobalSearch');
            const tableSearch = document.getElementById('tableSearchInput');
            const categoryFilter = document.getElementById('tableCategoryFilter');
            const sortSelect = document.getElementById('storeSortSelect');

            const productCards = document.querySelectorAll('#storeProductGrid .catalog-manage-card');
            const tableRows = document.querySelectorAll('#crudDataTable tbody tr');

            function syncAndFilter(searchTerm) {
                const term = searchTerm.toLowerCase().trim();
                const selectedCat = categoryFilter ? categoryFilter.value.toLowerCase().trim() : '';

                // Filtra Cards de Gestão
                productCards.forEach(card => {
                    const cardName = card.getAttribute('data-name') ? card.getAttribute('data-name').toLowerCase() : '';
                    const cardCat = card.getAttribute('data-category') ? card.getAttribute('data-category').toLowerCase() : '';
                    const cardText = card.innerText.toLowerCase();

                    const matchesSearch = term === '' || cardName.includes(term) || cardText.includes(term);
                    const matchesCategory = selectedCat === '' || cardCat === selectedCat;

                    card.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
                });

                // Filtra Linhas da Tabela de Estoque
                tableRows.forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    const rowCategory = row.getAttribute('data-category') ? row.getAttribute('data-category').toLowerCase() : '';

                    const matchesSearch = term === '' || rowText.includes(term);
                    const matchesCategory = selectedCat === '' || rowCategory === selectedCat;

                    row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
                });
            }

            if (headerSearch) {
                headerSearch.addEventListener('input', function() {
                    if (tableSearch) tableSearch.value = this.value;
                    syncAndFilter(this.value);
                });
            }

            if (tableSearch) {
                tableSearch.addEventListener('input', function() {
                    if (headerSearch) headerSearch.value = this.value;
                    syncAndFilter(this.value);
                });
            }

            if (categoryFilter) {
                categoryFilter.addEventListener('change', function() {
                    const currentSearch = tableSearch ? tableSearch.value : (headerSearch ? headerSearch.value : '');
                    syncAndFilter(currentSearch);
                });
            }

            // Ordenação dos Itens
            if (sortSelect && gridSection) {
                sortSelect.addEventListener('change', function() {
                    const mode = this.value;
                    const cardsArray = Array.from(productCards);

                    cardsArray.sort((a, b) => {
                        const priceA = parseFloat(a.getAttribute('data-price') || 0);
                        const priceB = parseFloat(b.getAttribute('data-price') || 0);
                        const nameA = (a.getAttribute('data-name') || '').toLowerCase();
                        const nameB = (b.getAttribute('data-name') || '').toLowerCase();

                        if (mode === 'price-asc') return priceA - priceB;
                        if (mode === 'price-desc') return priceB - priceA;
                        if (mode === 'name-asc') return nameA.localeCompare(nameB);
                        return 0;
                    });

                    cardsArray.forEach(card => gridSection.appendChild(card));
                });
            }

            // Filtro por Parâmetro URL cat
            const urlParams = new URLSearchParams(window.location.search);
            const catParam = urlParams.get('cat');
            if (catParam && categoryFilter) {
                for (let option of categoryFilter.options) {
                    if (option.value.toLowerCase().includes(catParam.toLowerCase())) {
                        categoryFilter.value = option.value;
                        syncAndFilter('');
                        break;
                    }
                }
            }
        });
    </script>
</body>
</html>
