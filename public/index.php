<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
             26011846-2 -  Arthur Vinicius de Freitas Videres
             26003401-2 -  Matheus Azamur Passos
             26006867-2 -  Dennis Gabriel de Oliveira
             26007484-2 -  Murilo da Silva Santos
             26003834-2 -  Thiago Pereira da Silva
Data: 31 de outubro de 2026
Descritivo: 
Desenvolver um sistema CRUD 
 *******************************************************************************/
?>
<?php

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
                    header("Location: /crud_php/public/index.php?page=produtos");
                    exit();
                } else {
                    echo "<p class=\'error\'>Não foi possível deletar o produto.</p>";
                }
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
                if ($controller->delete($id)) {
                    header("Location: /crud_php/public/index.php?page=categorias");
                    exit();
                } else {
                    echo "<p class=\'error\'>Não foi possível deletar a categoria.</p>";
                }
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

?>
