# TechStore Admin - Painel de Controle e Gestão da Loja Virtual

Projeto prático desenvolvido para a disciplina de **Linguagem e Técnicas de Programação (LTP)** do curso de **Tecnologia em Análise e Desenvolvimento de Sistemas (ADS)** - Turma **ADS2B**, sob orientação do **Prof. José Carlos Domingues Flores**.

---

## 👥 Componentes do Grupo

| RA | Nome Completo |
| :--- | :--- |
| `26011846-2` | Arthur Vinicius de Freitas Videres |
| `26003401-2` | Matheus Azamur Passos |
| `26006867-2` | Dennis Gabriel de Oliveira |
| `26007484-2` | Murilo da Silva Santos |
| `26003834-2` | Thiago Pereira da Silva |

---

## 🚀 Sobre o Projeto

A aplicação consiste em um **Painel Administrativo para Gestão de Catálogo e Estoque de Loja Virtual (E-commerce Merchant Dashboard)** desenvolvido em **PHP puro com MySQL**, implementado sob a arquitetura modular **MVC (Model-View-Controller)**. 

O sistema permite que o lojista/administrador controle em tempo real todos os produtos disponíveis na loja, organize departamentos, gerencie preços de venda e visualize métricas financeiras do inventário.

### 🌟 Funcionalidades e Diferenciais
- **Dashboard de Métricas do Lojista (KPIs)**:
  - Total de produtos ativos no catálogo.
  - Quantidade de departamentos cadastrados.
  - Valor total acumulado do patrimônio em estoque (R$).
  - Ticket médio praticado por item (R$).
- **Visualização em Dois Modos**:
  - 🔲 **Cards da Loja (Vitrine de Gestão)**: Cards visuais modernos com fotos temáticas em alta resolução, código `#ID`, status *🟢 Em Exibição na Loja*, preço de venda, tag de departamento e botões de ação rápida (*Editar Cadastro* e *Excluir*).
  - 📋 **Tabela de Estoque (Inventário Operacional)**: Tabela administrativa completa ideal para conferência rápida de dados com IDs, miniaturas, descrições e ações CRUD.
- **Filtro e Busca Dinâmica em Tempo Real**: Pesquisa instantânea sincronizada no cabeçalho e na barra de ferramentas por nome, código ou descrição, com filtro por departamento e ordenação por preço e nome.
- **Ficha Técnica do Item (Quick Inspect)**: Modal de inspeção administrativa ao clicar na miniatura do produto, exibindo detalhes cadastrais completos e atalho para edição.
- **Integridade Referencial e Segurança**: Proteção contra exclusão de departamentos com produtos vinculados (`ON DELETE RESTRICT`) e confirmação JavaScript antes de remoções.
- **Portabilidade de Rotas**: Construção com URLs relativas dinâmicas (`$baseUrl`), funcionando em qualquer subdiretório do XAMPP sem dependência de caminho fixo.

---

## 🗂️ Arquitetura do Projeto (MVC)

```text
trabalho-flores-Desenvolvimento-de-um-Sistema-CRUD/
│
├── index.php                          # Redirecionamento amigável para o front controller
├── crud_db.sql                        # Script SQL de criação do banco e dados de teste
├── README.md                          # Documentação completa do projeto
│
├── config/
│   └── database.php                   # Conexão PDO segura com MySQL
│
├── controllers/
│   ├── CategoriaController.php        # Controlador de Departamentos/Categorias
│   └── ProdutoController.php          # Controlador de Produtos do Catálogo
│
├── models/
│   ├── Categoria.php                  # Modelo de dados da entidade Categoria
│   └── Produto.php                    # Modelo com JOIN relacional para Produtos
│
├── public/
│   ├── css/
│   │   └── style.css                  # Folha de estilos do Painel Administrativo
│   ├── _.htaccess                     # Configurações de servidor
│   └── index.php                      # Front Controller e roteamento principal
│
└── views/
    ├── categorias/
    │   ├── create_cat.php             # Cadastro de novo departamento
    │   ├── edit_cat.php               # Edição de departamento
    │   └── index_cat.php              # Listagem gerencial de departamentos
    │
    ├── includes/
    │   ├── header.php                 # Topbar administrativa, busca global e status
    │   └── footer.php                 # Rodapé com créditos acadêmicos e scripts JS
    │
    └── produtos/
        ├── create_prod.php            # Formulário de inclusão de produto
        ├── edit_prod.php              # Formulário de edição de produto
        └── index_prod.php             # Painel de controle, KPIs, cards e tabela
```

---

## 🛠️ Como Executar a Aplicação Localmente

### Pré-requisitos
- **XAMPP** (Apache e MySQL ativos) ou ambiente PHP 8.x + MySQL.

### Passo 1: Copiar para o XAMPP
Mantenha a pasta no diretório padrão do Apache:
```bash
c:\xampp\htdocs\trabalho-flores-Desenvolvimento-de-um-Sistema-CRUD
```

### Passo 2: Importar o Banco de Dados no MySQL
1. Abra o **XAMPP Control Panel** e inicialize o **Apache** e o **MySQL**.
2. Acesse o phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Na aba **Importar**, selecione o arquivo `crud_db.sql` e clique em **Executar**.
   - Serão criadas as tabelas `categorias` e `produtos` com dados de demonstração.

### Passo 3: Acessar o Painel no Navegador
Abra seu navegador em:
```text
http://localhost/trabalho-flores-Desenvolvimento-de-um-Sistema-CRUD/
```
*(Você será direcionado diretamente para o painel administrativo da loja em `/public/index.php`)*.

---

## 📋 Regras de Entrega e Critérios Acadêmicos
- **Repositório GitHub**: Entrega do link oficial sem modificações posteriores ao prazo (15/11/2026).
- **Assunto do E-mail**: `ADS2B-LTP-2o Bimestre-Trabalho Prático 2`
- **Destinatário**: `jose.flores@unicesumar.edu.br` (enviado exclusivamente pelo representante do grupo).
- **Apresentação**: Sorteio dos alunos para download e demonstração ao vivo em aula.
