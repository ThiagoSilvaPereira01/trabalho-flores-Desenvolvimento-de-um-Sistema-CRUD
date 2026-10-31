<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Roteador principal da aplicação (Front Controller) para Produtos e Categorias
*******************************************************************************/

$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$baseUrl = $baseDir;

$page = isset($_GET["page"]) ? $_GET["page"] : "produtos";
$action = isset($_GET["action"]) ? $_GET["action"] : "index";
$id = isset($_GET["id"]) ? $_GET["id"] : null;

switch ($page) {
    case "produtos":
        switch ($action) {
            case "index":
                include __DIR__ . '/../views/produtos/index_prod.php';
                break;
            case "create":
                include __DIR__ . '/../views/produtos/create_prod.php';
                break;
            case "edit":
                include __DIR__ . '/../views/produtos/edit_prod.php';
                break;
            case "delete":
                include_once __DIR__ . '/../controllers/ProdutoController.php';
                $controller = new ProdutoController();
                if ($controller->delete($id)) {
                    header("Location: " . $baseUrl . "/index.php?page=produtos&msg=deleted");
                } else {
                    header("Location: " . $baseUrl . "/index.php?page=produtos&msg=error");
                }
                exit();
                break;
            default:
                include __DIR__ . '/../views/produtos/index_prod.php';
                break;
        }
        break;

    case "categorias":
        switch ($action) {
            case "index":
                include __DIR__ . '/../views/categorias/index_cat.php';
                break;
            case "create":
                include __DIR__ . '/../views/categorias/create_cat.php';
                break;
            case "edit":
                include __DIR__ . '/../views/categorias/edit_cat.php';
                break;
            case "delete":
                include_once __DIR__ . '/../controllers/CategoriaController.php';
                $controller = new CategoriaController();
                try {
                    if ($controller->delete($id)) {
                        header("Location: " . $baseUrl . "/index.php?page=categorias&msg=deleted");
                    } else {
                        header("Location: " . $baseUrl . "/index.php?page=categorias&msg=has_products");
                    }
                } catch (\Exception $e) {
                    header("Location: " . $baseUrl . "/index.php?page=categorias&msg=has_products");
                }
                exit();
                break;
            default:
                include __DIR__ . '/../views/categorias/index_cat.php';
                break;
        }
        break;

    default:
        include __DIR__ . '/../views/produtos/index_prod.php';
        break;
}
