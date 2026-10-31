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
include_once __DIR__ . '/../../controllers/ProdutoController.php';

$controller = new ProdutoController();
$data = $controller->index();
$stmt = $data['stmt'];
$num = $data['num'];

include __DIR__ . '/../../views/includes/header.php';
?>

<h2>Produtos</h2>

<a href="/crud_php/public/index.php?page=produtos&action=create" class="button">Criar Novo Produto</a>

<?php
if($num > 0){
    echo "<table>";
        echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nome</th>";
            echo "<th>Descrição</th>";
            echo "<th>Preço</th>";
            echo "<th>Categoria</th>";
            echo "<th>Ações</th>";
        echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        echo "<tr>";
            echo "<td>{$id}</td>";
            echo "<td>{$nome}</td>";
            echo "<td>{$descricao}</td>";
            echo "<td>R$ " . number_format($preco, 2, ',', '.') . "</td>";
            echo "<td>{$categoria_nome}</td>";
            echo "<td>";
                echo "<a href=\"/crud_php/public/index.php?page=produtos&action=edit&id={$id}\" class=\"button edit\">Editar</a>";
                echo "<a href=\"/crud_php/public/index.php?page=produtos&action=delete&id={$id}\" class=\"button delete\">Deletar</a>";
            echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum produto encontrado.</p>";
}
?>

<?php include __DIR__ . '/../../views/includes/footer.php'; ?>
