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
Descritivo: Cabeçalho do Painel Administrativo de Controle da Loja (E-commerce Merchant Dashboard)
*******************************************************************************/

$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$baseUrl = $baseDir;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'produtos';
$currentAction = isset($_GET['action']) ? $_GET['action'] : 'index';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Painel do Lojista - TechStore Admin</title>
    
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS Customizado do Painel Administrativo -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/style.css">
</head>
<body>
    <!-- Barra Superior de Controle Administrativo -->
    <header class="admin-header">
        <div class="admin-nav-container">
            <!-- Brand / Logo do Painel -->
            <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" class="admin-brand">
                <div class="admin-brand-icon">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div class="admin-brand-text">
                    <h1>TechStore <span class="badge-role">ADMIN</span></h1>
                    <span>Painel de Gestão da Loja &bull; LTP ADS2B</span>
                </div>
            </a>

            <!-- Barra de Busca Rápida no Catálogo -->
            <div class="admin-search-wrapper">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" id="headerGlobalSearch" placeholder="Pesquisar produto no estoque por nome, código ou descrição...">
            </div>

            <!-- Navegação e Atalhos Rápidos -->
            <nav class="admin-nav-links">
                <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" 
                   class="admin-nav-item <?php echo ($currentPage === 'produtos') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Catálogo de Produtos</span>
                </a>

                <a href="<?php echo $baseUrl; ?>/index.php?page=categorias" 
                   class="admin-nav-item <?php echo ($currentPage === 'categorias') ? 'active' : ''; ?>">
                    <i class="fa-solid fa-tags"></i>
                    <span>Departamentos</span>
                </a>

                <a href="<?php echo $baseUrl; ?>/index.php?page=produtos&action=create" class="btn-create-item">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Cadastrar Produto</span>
                </a>
            </nav>
        </div>

        <!-- Sub-barra de Status do Sistema -->
        <div class="admin-subbar">
            <div class="admin-subbar-container">
                <div class="admin-status-indicator">
                    <span class="status-dot online"></span>
                    <span>Modo Lojista: <strong>Controle de Catálogo & Estoque Ativo</strong></span>
                </div>
                <div class="admin-meta-info">
                    <span><i class="fa-solid fa-database"></i> MySQL: <strong>crud_db</strong></span>
                    <span><i class="fa-solid fa-user-shield"></i> LTP - Prof. Flores</span>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
