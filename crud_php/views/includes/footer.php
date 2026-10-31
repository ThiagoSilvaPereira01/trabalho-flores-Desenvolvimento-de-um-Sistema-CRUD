<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Rodapé padrão (Footer) com copyright, créditos e scripts interativos
*******************************************************************************/
?>
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-info">
                <strong>Sistema CRUD PHP & MySQL &bull; Trabalho Bimestral 2</strong>
                <span>Disciplina: Linguagem e Técnicas de Programação (LTP) &bull; Prof. Flores</span>
            </div>
            <div>
                <span>Turma ADS2B &copy; <?php echo date('Y'); ?></span>
            </div>
        </div>
    </footer>

    <!-- Script de Interatividade e Busca em Tempo Real -->
    <script>
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

            // Filtro em tempo real para a tabela de produtos e categorias
            const searchInput = document.getElementById('tableSearchInput');
            const categoryFilter = document.getElementById('tableCategoryFilter');
            const dataTable = document.getElementById('crudDataTable');

            if (dataTable && (searchInput || categoryFilter)) {
                const rows = dataTable.querySelectorAll('tbody tr');

                function applyFilter() {
                    const term = searchInput ? searchInput.value.toLowerCase().trim() : '';
                    const selectedCat = categoryFilter ? categoryFilter.value.toLowerCase().trim() : '';

                    rows.forEach(row => {
                        const rowText = row.innerText.toLowerCase();
                        const rowCategory = row.getAttribute('data-category') ? row.getAttribute('data-category').toLowerCase() : '';

                        const matchesSearch = term === '' || rowText.includes(term);
                        const matchesCategory = selectedCat === '' || rowCategory === selectedCat;

                        if (matchesSearch && matchesCategory) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                if (searchInput) {
                    searchInput.addEventListener('input', applyFilter);
                }
                if (categoryFilter) {
                    categoryFilter.addEventListener('change', applyFilter);
                }
            }
        });
    </script>
</body>
</html>
