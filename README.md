# Sistema de Gestão CRUD em PHP & MySQL (EstoqueMaster)

Projeto prático desenvolvido para a disciplina de **Linguagem e Técnicas de Programação (LTP)** do curso de **Tecnologia em Análise e Desenvolvimento de Sistemas (ADS)** - Turma **ADS2B**, sob orientação do **Prof. José Carlos Domingues Flores**.

---

## 👥 Componentes do Grupo

| RA | Nome Completo |
| :--- | :--- |
| `25000000-1` | [Nome do Aluno 1] |
| `25000000-2` | [Nome do Aluno 2] |
| `25000000-3` | [Nome do Aluno 3] |
| `25000000-4` | [Nome do Aluno 4] |
| `25000000-5` | [Nome do Aluno 5] |

---

## 🚀 Sobre o Projeto

A aplicação consiste em um **Sistema CRUD completo em PHP puro com MySQL**, implementado segundo o padrão de arquitetura modular **MVC (Model-View-Controller)**. O sistema gerencia duas entidades relacionais: **Categorias** e **Produtos** (onde cada produto pertence a uma categoria).

### 🌟 Diferenciais e Funcionalidades Implementadas
- **Dashboard / Painel de Métricas (KPIs)**: Exibe em tempo real o total de produtos cadastrados, quantidade de categorias ativas e cálculo automático do preço médio.
- **Filtro e Busca Dinâmica**: Barra de pesquisa com filtragem em tempo real (sem recarregar a página) por nome/descrição e dropdown para filtrar por categoria.
- **Interface Moderna e Responsiva**: Design limpo com fontes do Google Fonts (*Inter*), ícones do *FontAwesome 6*, tabelas estilizadas, badges de categorias e feedback visual.
- **Notificações e Feedback Visual**: Alertas interativos de confirmação para criação, atualização e exclusão de itens.
- **Segurança e Integridade Referencial**: Confirmação JavaScript antes de exclusões (`confirm`) e tratamento de integridade referencial com bloqueio amigável caso o usuário tente excluir categorias que possuem produtos vinculados.
- **Portabilidade de Rotas**: URLs dinâmicas e relativas, funcionando em qualquer pasta do XAMPP ou servidor embutido do PHP.

---

## 🗂️ Arquitetura do Projeto

```text
trabalho-flores-Desenvolvimento-de-um-Sistema-CRUD/
│
├── index.php                          # Redirecionamento amigável para o front controller
├── crud_db.sql                        # Script SQL de criação do banco e dados de teste
├── README.md                          # Documentação completa do projeto
│
└── crud_php/
    ├── config/
    │   └── database.php               # Conexão PDO segura com MySQL
    │
    ├── controllers/
    │   ├── CategoriaController.php    # Lógica de controle para Categorias
    │   └── ProdutoController.php      # Lógica de controle para Produtos
    │
    ├── database/
    │   └── crud_db.sql                # Cópia do script SQL para backup
    │
    ├── models/
    │   ├── Categoria.php              # Modelo e operações SQL de Categorias
    │   └── Produto.php                # Modelo e operações SQL com JOIN de Produtos
    │
    ├── public/
    │   ├── css/
    │   │   └── style.css              # Folha de estilo moderna e responsiva
    │   ├── _.htaccess                 # Regras de rewrite opcionais
    │   └── index.php                  # Front Controller e roteamento principal
    │
    └── views/
        ├── categorias/
        │   ├── create_cat.php         # Tela de cadastro de categoria
        │   ├── edit_cat.php           # Tela de edição de categoria
        │   └── index_cat.php          # Listagem com busca de categorias
        │
        ├── includes/
        │   ├── header.php             # Navbar, links ativos e cabeçalho HTML
        │   └── footer.php             # Rodapé, créditos e scripts JavaScript
        │
        └── produtos/
            ├── create_prod.php        # Tela de cadastro de produto
            ├── edit_prod.php          # Tela de edição de produto
            └── index_prod.php         # Listagem, dashboard e filtros
```

---

## 🛠️ Como Executar a Aplicação Localmente

### Pré-requisitos
- **XAMPP** (com Apache e MySQL habilitados) ou ambiente PHP 8.x + MySQL.

### Passo 1: Clonar ou Copiar para o XAMPP
Copie a pasta do projeto para o diretório `htdocs` do seu XAMPP:
```bash
c:\xampp\htdocs\trabalho-flores-Desenvolvimento-de-um-Sistema-CRUD
```

### Passo 2: Importar o Banco de Dados no MySQL
1. Abra o **XAMPP Control Panel** e inicie os módulos **Apache** e **MySQL**.
2. Abra o navegador e acesse o phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Clique na aba **Importar** (ou **SQL**).
4. Selecione o arquivo `crud_db.sql` localizado na raiz do projeto e clique em **Executar**.
   - O script criará o banco de dados `crud_db`, as tabelas `categorias` e `produtos`, e já inserirá registros iniciais de teste.

### Passo 3: Acessar no Navegador
Abra seu navegador em:
```text
http://localhost/trabalho-flores-Desenvolvimento-de-um-Sistema-CRUD/
```
*(Você será automaticamente direcionado para o catálogo de produtos e dashboard)*.

---

## 📋 Regras de Entrega e Critérios Acadêmicos
- **Repositório GitHub**: Entrega do link oficial sem modificações posteriores ao prazo (15/11/2026).
- **Assunto do E-mail**: `ADS2B-LTP-2o Bimestre-Trabalho Prático 2`
- **Destinatário**: `jose.flores@unicesumar.edu.br` (enviado exclusivamente pelo representante do grupo).
- **Apresentação**: Sorteio dos alunos para download e demonstração ao vivo em aula.
