<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Cabeçalho padrão (Header) com navbar moderna, ícones e assets
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
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Sistema de Gestão CRUD - LTP</title>
    
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS Customizado -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="navbar">
            <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" class="brand">
                <div class="brand-icon">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
                <div class="brand-text">
                    <h1>EstoqueMaster</h1>
                    <span>LTP - Prof. Flores | ADS2B</span>
                </div>
            </a>
            <nav>
                <ul class="nav-menu">
                    <li>
                        <a href="<?php echo $baseUrl; ?>/index.php?page=produtos" 
                           class="nav-link <?php echo ($currentPage === 'produtos') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-box-open"></i>
                            <span>Produtos</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $baseUrl; ?>/index.php?page=categorias" 
                           class="nav-link <?php echo ($currentPage === 'categorias') ? 'active' : ''; ?>">
                            <i class="fa-solid fa-tags"></i>
                            <span>Categorias</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
